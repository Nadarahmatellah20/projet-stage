<?php
namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class TicketController extends Controller
{

    public function NewTicketForm()
    {
        return view('user.dashboard.ticket.new');
    }


    public function NewTicket(Request $request)
    {
        $valid = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $ticket = new Ticket;
        $ticket->user_id = Auth::user()->id;
        $ticket->title = $valid['title'];
        $ticket->type = $valid['type'];
        $ticket->status = 'ongoing';
        $ticket->save();

        return redirect()->route('userShowTicket', $ticket->id);
    }

   
    public function UserShowTicket(Ticket $ticket)
    {
        // FIX: تحقق أن الـ ticket ديال المستخدم الحالي
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $messages = $ticket->Messages()->orderBy('created_at', 'asc')->get();
        return view('user.dashboard.ticket.show', compact('ticket', 'messages'));
    }

    public function UserSendMessage(Request $request, Ticket $ticket)
    {
        // FIX: تحقق أن الـ ticket ديال المستخدم الحالي
        if ($ticket->user_id !== Auth::id()) {
            abort(403);
        }

        $valid = $request->validate([
            'body' => 'required|string',
        ]);

        $message = new Message;
        $message->body = $valid['body'];
        $message->ticket_id = $ticket->id;
        $message->sender_name = Auth::user()->fname . ' ' . Auth::user()->lname;
        $message->save();

        return Response::json($message);
    }

 
    public function UserIndexOngoingTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)
            ->where('status', 'ongoing')
            ->get();

        return view('user.dashboard.ticket.ongoing', compact('tickets'));
    }


    public function UserIndexClosedTickets()
    {
        $tickets = Ticket::where('user_id', Auth::user()->id)
            ->whereNotNull('closed_at')
            ->get();

        return view('user.dashboard.ticket.closed', compact('tickets'));
    }

 
    public function AdminIndexOngoingTickets()
    {
        $tickets = Ticket::where('status', 'ongoing')->get();
        return view('admin.ticket.ongoing', compact('tickets'));
    }

    
    public function AdminIndexClosedTickets()
    {
        $tickets = Ticket::whereNotNull('closed_at')->get();
        return view('admin.ticket.closed', compact('tickets'));
    }

    public function AdminIndexArchivedTickets()
    {
        $tickets = Ticket::where('status', 'archived')->get();
        return view('admin.ticket.archived', compact('tickets'));
    }


    public function AdminShowTicket(Ticket $ticket)
    {
        $messages = $ticket->Messages()->orderBy('created_at', 'asc')->get();
        return view('admin.ticket.show', compact('ticket', 'messages'));
    }

    public function AdminSendMessage(Request $request, Ticket $ticket)
    {
        $valid = $request->validate([
            'body' => 'required|string',
        ]);

        $message = new Message;
        $message->body = $valid['body'];
        $message->ticket_id = $ticket->id;
        $message->sender_name = 'Admin';
        $message->save();

        return Response::json($message);
    }

    
    public function UpdateTicketStatus(Request $request, Ticket $ticket)
    {
        $valid = $request->validate([
            'status' => 'required|string|in:ongoing,resolved,not resolved',
        ]);

        $ticket->status = $valid['status'];
        $ticket->save();

        return response()->json(['success' => true]);
    }

  
    public function ArchiveTicket(Ticket $ticket)
    {
        $ticket->closed_at  = now();
        $ticket->status     = 'archived';
        $ticket->isArchived = true;
        $ticket->save();

        return redirect()->route('adminIndexOngoingTickets');
    }

    public function UpdateMessageData(Ticket $ticket)
    {
        $messages = $ticket->Messages()->orderBy('created_at', 'asc')->get();
        return Response::json($messages);
    }

    // FIX: كانت هاد الـ method ناقصة — الـ view كتستعملها
    public function UnarchiveTicket(Ticket $ticket)
    {
        $ticket->isArchived = false;
        $ticket->status     = 'ongoing';
        $ticket->closed_at  = null;
        $ticket->save();
        return redirect()->route('adminIndexArchivedTickets')->with('success', 'Ticket désarchivé');
    }
}