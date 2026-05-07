@extends('admin.layouts.main')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{ URL::asset('style/ticket-style.css')}}">
    <script src="{{ URL::asset('script/ckeditor/ckeditor.js')}}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<div class="ticket-wrapper">

    <!-- =========================
         MESSAGES AREA
    ========================== -->
    <div class="messages-container">
        @foreach ($messages as $msg)

            <div class="message-container {{ $msg->sender_name == 'Admin' ? 'right' : 'left' }}">

                <strong>{{ $msg->sender_name }}</strong>

                <p class="time">
                    {{ $msg->created_at }}
                </p>

                <div class="msg-body">
                    {!! $msg->body !!}
                </div>

            </div>

        @endforeach
    </div>

    <!-- =========================
         INPUT AREA
    ========================== -->

    <textarea name="body" id="msgBody" class="ckeditor"></textarea>

    <button onclick="sendMessage()">Envoyer</button>

</div>

<!-- =========================
     CKEDITOR INIT
========================== -->
<script>
let editor;

ClassicEditor
    .create(document.querySelector('.ckeditor'))
    .then(ed => {
        editor = ed;
    });
</script>

<!-- =========================
     SEND MESSAGE (AJAX)
========================== -->
<script>
function sendMessage(){

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    let formData = {
        body: editor.getData()
    };

    $.ajax({
        type: "POST",
        url: "{{ route('adminSendMessage', $ticket) }}",
        data: formData,
        success: function(data){

            let msg = `
                <div class="message-container right">
                    <strong>${data.sender_name}</strong>
                    <p class="time">${data.created_at}</p>
                    <div class="msg-body">${data.body}</div>
                </div>
            `;

            $('.messages-container').append(msg);

            editor.setData('');

            scrollBottom();
        }
    });
}

function scrollBottom(){
    let box = $('.messages-container');
    box.scrollTop(box[0].scrollHeight);
}
</script>

<!-- =========================
     AUTO UPDATE MESSAGES
========================== -->
<script>
function updatePage(){

    $.ajax({
        url: "{{ route('updateMessageData', $ticket) }}",
        type: 'GET',
        success: function(data){

            $('.messages-container').empty();

            data.forEach(msg => {

                let side = (msg.sender_name == "Admin") ? "right" : "left";

                let html = `
                    <div class="message-container ${side}">
                        <strong>${msg.sender_name}</strong>
                        <p class="time">${msg.created_at}</p>
                        <div class="msg-body">${msg.body}</div>
                    </div>
                `;

                $('.messages-container').append(html);
            });

            scrollBottom();
        }
    });
}

updatePage();
setInterval(updatePage, 5000);
</script>

@endsection