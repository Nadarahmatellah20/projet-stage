@extends('user.user-dashboard')
@section('section-content')

<style>
    .invoice-wrapper { max-width: 700px; margin: 30px auto; font-family: 'Segoe UI', sans-serif; }
    .invoice-card { background: #fff; border: 1px solid #e0e0e0; border-radius: 12px; padding: 30px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); }
    .invoice-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #f5f5f5; padding-bottom: 15px; margin-bottom: 20px; }
    .invoice-header h2 { margin: 0; color: #1a237e; }
    .badge-paid { background: #e8f5e9; color: #2e7d32; padding: 6px 14px; border-radius: 20px; font-weight: bold; font-size: 0.9em; }
    .badge-unpaid { background: #fff8e1; color: #f57f17; padding: 6px 14px; border-radius: 20px; font-weight: bold; font-size: 0.9em; }
    .invoice-table { width: 100%; border-collapse: collapse; }
    .invoice-table td { padding: 12px 8px; border-bottom: 1px solid #f0f0f0; }
    .invoice-table .total-row { background: #f5f9ff; font-weight: bold; font-size: 1.1em; }
    .invoice-table .total-row td { border-bottom: none; }
    .payment-box { background: #f8f9ff; border: 1px solid #c5cae9; border-radius: 12px; padding: 25px; margin-top: 20px; }
    .payment-box h3 { margin-top: 0; color: #1a237e; }
    .payment-methods { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; }
    .payment-method { border: 2px solid #e0e0e0; border-radius: 8px; padding: 10px 16px; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.95em; background: white; transition: border-color 0.2s; }
    .payment-method.selected, .payment-method:hover { border-color: #1a237e; background: #e8eaf6; }
    .card-logos { display: flex; gap: 6px; align-items: center; }
    .card-logo { height: 28px; background: #e8eaf6; border-radius: 4px; padding: 3px 8px; font-size: 0.75em; font-weight: bold; color: #1a237e; display: flex; align-items: center; }
    .visa-logo { background: #1a1f71; color: white; font-style: italic; font-weight: 900; }
    .mc-logo { background: linear-gradient(to right, #eb001b 50%, #f79e1b 50%); color: white; }
    .cmi-logo { background: #006633; color: white; }
    .pay-btn { width: 100%; padding: 16px; font-size: 1.1em; background: linear-gradient(135deg, #1a237e, #283593); color: white; border: none; border-radius: 8px; cursor: pointer; font-weight: bold; letter-spacing: 0.5px; transition: opacity 0.2s; }
    .pay-btn:hover { opacity: 0.9; }
    .secure-badge { text-align: center; color: #9e9e9e; font-size: 0.8em; margin-top: 10px; }
    .paid-confirm { background: #e8f5e9; border: 1px solid #a5d6a7; border-radius: 8px; padding: 20px; text-align: center; }
    .paid-confirm .amount { font-size: 2em; color: #2e7d32; font-weight: bold; }
    .alert { padding: 12px 16px; border-radius: 6px; margin-bottom: 15px; }
    .alert-success { background: #e8f5e9; border: 1px solid #a5d6a7; color: #2e7d32; }
    .alert-info { background: #e3f2fd; border: 1px solid #90caf9; color: #1565c0; }
</style>

<div class="invoice-wrapper">

    @if(session('success'))
        <div class="alert alert-success">✅ {{ session('success') }}</div>
    @endif
    @if(session('info'))
        <div class="alert alert-info">ℹ️ {{ session('info') }}</div>
    @endif

    {{-- En-tête Facture --}}
    <div class="invoice-card">
        <div class="invoice-header">
            <div>
                <h2>🧾 Facture N° {{ $order->id }}</h2>
                <p style="margin:4px 0; color:gray; font-size:0.9em;">Commande : {{ $order->title }}</p>
                <p style="margin:4px 0; color:gray; font-size:0.9em;">Date : {{ $order->created_at->format('d/m/Y') }}</p>
            </div>
            @if($invoice)
                @if($invoice->payment_status === 'paid')
                    <span class="badge-paid">✅ Payée</span>
                @else
                    <span class="badge-unpaid">⏳ En attente</span>
                @endif
            @endif
        </div>

        @if($invoice)
        <table class="invoice-table">
            <tr>
                <td>Sous-total (tâches)</td>
                <td style="text-align:right;">{{ number_format($order->Tasks()->sum('cost'), 2) }} MAD</td>
            </tr>
            <tr>
                <td>Remise ({{ $invoice->discount_percentage }}%)</td>
                <td style="text-align:right; color:#c62828;">
                    - {{ number_format($order->Tasks()->sum('cost') * ($invoice->discount_percentage / 100), 2) }} MAD
                </td>
            </tr>
            <tr>
                <td>Frais additionnels</td>
                <td style="text-align:right;">{{ number_format($invoice->fees, 2) }} MAD</td>
            </tr>
            <tr class="total-row">
                <td>Total à payer</td>
                <td style="text-align:right; color:#1a237e; font-size:1.2em;">
                    {{ number_format($invoice->total_price, 2) }} MAD
                </td>
            </tr>
        </table>
        @endif
    </div>

    {{-- Section Paiement --}}
    @if(!$invoice)
        <div class="invoice-card" style="text-align:center; background:#fff8e1; border-color:#ffe082;">
            ⚠️ <strong>Aucune facture disponible pour cette commande.</strong><br>
            <small style="color:gray;">La facture sera générée une fois la commande traitée par l'administrateur.</small><br><br>
            <a href="{{ route('displayAllOrders') }}" style="color:#1a237e;">← Retour aux commandes</a>
        </div>

    @elseif($invoice->payment_status === 'paid')
        <div class="invoice-card">
            <div class="paid-confirm">
                <div style="font-size:2.5em; margin-bottom:10px;">✅</div>
                <div class="amount">{{ number_format($invoice->total_price, 2) }} MAD</div>
                <p style="color:#2e7d32; font-weight:bold; margin:10px 0;">Paiement confirmé</p>
                <p style="color:gray; font-size:0.9em;">
                    Le {{ \Carbon\Carbon::parse($invoice->payment_date)->format('d/m/Y à H:i') }}
                </p>
                <div class="card-logos" style="justify-content:center; margin-top:15px; gap:8px;">
                    <span class="card-logo visa-logo">VISA</span>
                    <span class="card-logo mc-logo">MC</span>
                    <span class="card-logo cmi-logo">CMI</span>
                </div>
            </div>
        </div>

    @else
        <div class="payment-box">
            <h3>💳 Choisir un mode de paiement</h3>

            <div class="payment-methods">
                <div class="payment-method selected" onclick="selectMethod(this, 'cmi')">
                    <span class="card-logo cmi-logo" style="height:22px; font-size:0.8em;">CMI</span>
                    Carte CMI (Maroc)
                </div>
                <div class="payment-method" onclick="selectMethod(this, 'visa')">
                    <span class="card-logo visa-logo" style="height:22px; font-size:0.8em;">VISA</span>
                    Visa / Mastercard
                </div>
                <div class="payment-method" onclick="selectMethod(this, 'virement')">
                    🏦 Virement bancaire
                </div>
            </div>

            <form method="POST" action="{{ route('markInvoicePaid', $order) }}"
                  onsubmit="return confirmPay()">
                @csrf

                {{-- Champs carte (simulation) --}}
                <div id="card-fields" style="margin-bottom:15px;">
                    <div style="margin-bottom:12px;">
                        <label style="font-size:0.85em; color:#555; display:block; margin-bottom:4px;">Numéro de carte</label>
                        <input type="text" placeholder="0000 0000 0000 0000" maxlength="19"
                               oninput="formatCard(this)"
                               style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:1em; box-sizing:border-box;">
                    </div>
                    <div style="display:flex; gap:12px;">
                        <div style="flex:1;">
                            <label style="font-size:0.85em; color:#555; display:block; margin-bottom:4px;">Date d'expiration</label>
                            <input type="text" placeholder="MM/AA" maxlength="5"
                                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:1em; box-sizing:border-box;">
                        </div>
                        <div style="flex:1;">
                            <label style="font-size:0.85em; color:#555; display:block; margin-bottom:4px;">CVV</label>
                            <input type="text" placeholder="123" maxlength="3"
                                   style="width:100%; padding:10px; border:1px solid #ccc; border-radius:6px; font-size:1em; box-sizing:border-box;">
                        </div>
                    </div>
                </div>

                <div id="virement-fields" style="display:none; background:#f5f5f5; padding:15px; border-radius:8px; margin-bottom:15px;">
                    <p style="margin:0 0 8px;"><strong>Détails du virement :</strong></p>
                    <p style="margin:4px 0; font-size:0.9em;">RIB : <strong>007 780 0001234567890012 35</strong></p>
                    <p style="margin:4px 0; font-size:0.9em;">Banque : <strong>CIH Bank</strong></p>
                    <p style="margin:4px 0; font-size:0.9em;">Montant : <strong>{{ number_format($invoice->total_price, 2) }} MAD</strong></p>
                    <p style="margin:4px 0; font-size:0.9em; color:gray;">Référence : CMD-{{ $order->id }}</p>
                </div>

                <button type="submit" class="pay-btn">
                    🔒 Confirmer le paiement — {{ number_format($invoice->total_price, 2) }} MAD
                </button>

                <div class="secure-badge">
                    🔐 Paiement sécurisé via CMI &nbsp;|&nbsp;
                    <span class="card-logo visa-logo" style="display:inline; height:auto; padding:1px 5px; font-size:0.8em;">VISA</span>
                    <span class="card-logo mc-logo" style="display:inline; height:auto; padding:1px 5px; font-size:0.8em;">MC</span>
                    <span class="card-logo cmi-logo" style="display:inline; height:auto; padding:1px 5px; font-size:0.8em;">CMI</span>
                </div>
            </form>
        </div>
    @endif

    <div style="text-align:center; margin-top:15px;">
        <a href="{{ route('displayAllOrders') }}" style="color:#1a237e; text-decoration:none;">← Retour aux commandes</a>
    </div>

</div>

<script>
function selectMethod(el, method) {
    document.querySelectorAll('.payment-method').forEach(m => m.classList.remove('selected'));
    el.classList.add('selected');
    document.getElementById('card-fields').style.display = (method === 'virement') ? 'none' : 'block';
    document.getElementById('virement-fields').style.display = (method === 'virement') ? 'block' : 'none';
}

function formatCard(input) {
    let val = input.value.replace(/\D/g, '').substring(0, 16);
    input.value = val.replace(/(.{4})/g, '$1 ').trim();
}

function confirmPay() {
    return confirm('Confirmer le paiement de {{ $invoice ? number_format($invoice->total_price, 2) : 0 }} MAD ?');
}
</script>

@endsection