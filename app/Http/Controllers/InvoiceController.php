<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Order;

class InvoiceController extends Controller
{
    public function store(Request $request, Order $order)
    {
        if ($order->Invoice()->exists()) {
            return redirect()->route('showOrder', $order)->with('info', 'Facture déjà existante');
        }

        $request->validate([
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'fees'                => 'nullable|numeric|min:0',
        ]);

        $discount    = $request->discount_percentage ?? 0;
        $fees        = $request->fees ?? 0;
        $subtotal    = $order->Tasks()->sum('cost');
        $discountAmt = $subtotal * ($discount / 100);
        $total       = $subtotal - $discountAmt + $fees;

        Invoice::create([
            'order_id'            => $order->id,
            'discount_percentage' => $discount,
            'fees'                => $fees,
            'total_price'         => $total,
            'payment_status'      => 'not paid',
            'payment_date'        => null,
        ]);

        return redirect()->route('showOrder', $order)->with('success', 'Facture créée avec succès');
    }

    public function markAsPaid(Request $request, Order $order)
    {
        $invoice = $order->Invoice()->first();

        if (!$invoice) {
            return redirect()->back()->with('error', 'Aucune facture pour cette commande');
        }

        if ($invoice->payment_status === 'paid') {
            return redirect()->back()->with('info', 'Facture déjà payée');
        }

        $invoice->payment_status = 'paid';
        $invoice->payment_date   = now();
        $invoice->save();

        return redirect()->back()->with('success', 'Paiement confirmé avec succès');
    }

    // ✅ NEW — Liste toutes les factures pour l'admin
    public function indexInvoices()
    {
        $invoices = Invoice::with(['Order.Client'])
            ->orderByRaw("FIELD(payment_status, 'not paid', 'paid')")
            ->orderBy('created_at', 'desc')
            ->get();

        $totalPaid   = $invoices->where('payment_status', 'paid')->sum('total_price');
        $totalUnpaid = $invoices->where('payment_status', 'not paid')->sum('total_price');

        return view('admin.invoices.index', compact('invoices', 'totalPaid', 'totalUnpaid'));
    }
}