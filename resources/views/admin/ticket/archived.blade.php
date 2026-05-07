@extends('admin.layouts.main')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{ URL::asset('style/ticket-style.css')}}">
</head>

<div class="index-wrapper">

    <table>

        <thead>
            <tr>
                <th>Date</th>
                <th>Titre</th>
                <th>Type</th>
                <th>Statut</th>
                <th>Option</th>
            </tr>
        </thead>

        <tbody>

        @foreach ($tickets as $ticket)

        <tr>

            <td>
                {{ $ticket->created_at }}
            </td>

            <td>
                {{ $ticket->title }}
            </td>

            <td>
                {{ $ticket->type }}
            </td>

            <td>
                <select class="status-select"
                        onchange="updateStatus(this.value, '{{route('updateTicketStatus', $ticket)}}')">

                    <option value="ongoing" {{ $ticket->status == 'ongoing' ? 'selected' : '' }}>
                        Ongoing
                    </option>

                    <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>
                        Resolved
                    </option>

                    <option value="not resolved" {{ $ticket->status == 'not resolved' ? 'selected' : '' }}>
                        Not Resolved
                    </option>

                </select>
            </td>

            <td class="actions">

                <a href="{{route('adminShowTicket', $ticket)}}" class="btn view">
                    Afficher
                </a>

                <a href="{{route('archiveTicket', $ticket)}}" class="btn archive">
                    Archiver
                </a>

            </td>

        </tr>

        @endforeach

        </tbody>

    </table>

</div>

<script>
function updateStatus(statusVal, route){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'POST',
        url: route,
        data: { status: statusVal },
        success: function () {
            console.log('status updated');
        }
    });
}
</script>

@endsection