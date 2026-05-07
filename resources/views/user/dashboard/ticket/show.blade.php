<head>
    <link rel="stylesheet" href="{{ URL::asset('style/ticket-style.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{URL::asset('script/ckeditor/ckeditor.js')}}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

@extends('user.user-dashboard')
@section('section-content')


    <div class="ticket-wrapper">


        <div class="messages-container">
        </div>
        <textarea name="body" id="msgBody" class="ckeditor"></textarea>
        <button style="padding: 10px 30px;" class="send-btn" onclick="sendMessage()">Enovoyer</button>
    </div>

    <script>
        

        const editorItem = document.querySelector( '.ckeditor' );
        ClassicEditor
            .create( editorItem, {
                licenseKey: '',
            })
            .then( editor => {
                window.editor = editor; 
            });


        function sendMessage() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });
            var formData = {
                body: editor.getData(),
            }
        
            console.log(formData);
            $.ajax({
                type: "POST",
                url: '{{route("userSendMessage", $ticket)}}',
                data: formData,
                dataType: 'json',
                success:function(data) {
                    var msg = '<div class="message-container right"><strong>'+ data.sender_name +'</strong><p>' + data.created_at.replace('T', ' ').replace('.000000Z', '') +'</p><div class="msg-body">'+ data.body +'</div></div>';
                    $('.messages-container').append(msg);
                    editor.setData('');
                    $('.messages-container').scrollTop($('.messages-container')[0].scrollHeight - $('.messages-container')[0].clientHeight);
                }

            });
        }
    </script>

    <script>
        function updatePage() {
            $.ajax({
                url: "{{route('updateMessageData', $ticket)}}",
                type: 'GET',
                dataType: 'json',
                success: function (data) {

                    $('.messages-container').empty();
                    if(!jQuery.isEmptyObject(data)){

                        var firstUser = data[0].sender_name;
                        var mainSide = '';
                        var secondSide = '';
                        

                        if(firstUser == "{{Auth::user()->fname.' '.Auth::user()->lname}}")
                        {   
                            mainSide = 'right';
                            secondSide = 'left';
                        }else{
                            mainSide = 'left';
                            secondSide = 'right';
                        }

                        for (i = 0; i < data.length; i++) {
                            if(firstUser == data[i].sender_name)
                            {

                                var msg = '<div class="message-container '+ mainSide +'"><strong><p>'+ data[i].sender_name +'</p></strong><p>' + data[i].created_at.replace('T', ' ').replace('.000000Z', '') +'</p><div class="msg-body">'+ data[i].body +'</div></div>';
                            }else{
                                var msg = '<div class="message-container '+ secondSide +'"><strong><p>'+ data[i].sender_name +'</p></strong><p>' + data[i].created_at.replace('T', ' ').replace('.000000Z', '') +'</p><div class="msg-body">'+ data[i].body +'</div></div>';
                            }
                            $('.messages-container').append(msg);
                        }
                        
                    }
                }
            });
        }

        updatePage();
        
        setInterval(() => {
            updatePage();
        }, 5000);
    </script>
    <script>
        const elem = document.querySelector('.messages-container');
        elem.scrollTop = elem.scrollHeight;
    </script>
@endsection