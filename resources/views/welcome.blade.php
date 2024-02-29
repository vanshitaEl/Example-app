<x-app-layout>
    {{-- <x-section name="content"> --}}
    {{-- <x-slot name="content"> --}}
    <!doctype html>
    <html lang="en">

    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <x-slot name='title'>Live Chat</x-slot>
        {{-- <title>Live Chat</title> --}}
    </head>

    <body>

        <div class="app">
            <div class="row">

                {{-- @dd() --}}
                <div class="col-sm-6 offset-sm-3 my-2">

                    {{-- <input type="text" class="form-control" name="receiver_id" id="receiver_id" value="{{ $id }}" placeholder="Enter a user .........." />

                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}" />
                <input type="hidden" name="chat_room_id" id="chat_room_id" value="{{ $chatRoom->id }}" /> --}}
                    <x-input type="text" name="receiver_id" id="receiver_id" value="{{ $id }}" placeholder="Enter a user .........." readonly="true" class="mt-1" />
                    <input type="hidden" name="user_id" id="user_id" value="{{ Auth::id() }}" />
                    <input type="hidden" name="chat_room_id" id="chat_room_id" value="{{ $chatRoom->id }}" />
                </div>



                <div class="col-sm-6 offset-sm-3">

                    <div class="box box-primary direct-chat direct-chat-primary">

                        <div class="box-body">
                        </div>
                        <div class="direct-chat-messages" id="messages">
                            @foreach ($messages as $message)
                                <div class="message-container" id="message_{{ $message->id }}">
                                    <div class="{{ $message->user_id == Auth::id() ? 'sender' : 'receiver' }}">
                                        <b>{{ $message->user_id }}:</b>{!! html_entity_decode($message->message) !!}
                                        @if ($message->images)
                                            <img src="{{ asset('storage/file/' . $message->images) }}" width="50px" height="50px" alt="Image">
                                        @endif
                                        {{-- <input type="hidden" id="id" name="id" value="{{ $message->id }}" /> --}}
                                        {{-- <button type="button" class="btn btn-sm btn-primary" onclick="chatDelete({{ $message->id }})">Delete</button> --}}
                                        <x-secondary-button type="button" id="" onclick="chatDelete({{ $message->id }})">Delete</x-secondary-button>
                                    </div>


                                </div>
                            @endforeach
                        </div>
                        <div class="box-footer">

                            <form action="#" method="post" id="message_form">

                                <div class="input-group">

                                    <x-input type="file" name="images" id="images" value="" placeholder="" class="form-control" />

                                    {{-- <input type="text" name="message" id="message" placeholder="Type Message ..." class="form-control"> --}}
                                    {{-- <x-input type="text" name="message" id="message" value="" placeholder="Type Message ..." /> --}}
                                    <textarea id="message" name="message" rows="4" cols="50" placeholder="Type Message ..."></textarea>
                                    <span class="input-group-btn">
                                        {{-- <button type="submit" id="send_message" class="btn btn-primary btn-flat">Send</button><br /> --}}
                                        <x-button type="submit" id="send_message" onclick="">SEND</x-button>

                                    </span>
                                </div><br />



                            </form>
                            {{-- <center>
                            <textarea id="editor" name="w3review" rows="4" cols="50"></textarea>
                        </center> --}}


                        </div>

                    </div>
                </div>

            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="deleteChatModal" tabindex="-1" role="dialog" aria-labelledby="deleleChatModelLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleleChatModelLabel">Delete Chat</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="" id="delete-chat-form">
                        <div class="modal-body">
                            <input type="hidden" name="id" id="delete-chat-id">
                            <p>Are you sure you want to delete message?</p>
                            {{-- <p><b>{{ $message->message }}</b></p> --}}
                            <p><b id="delete-message"></b></p>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function chatDelete(id) {
                $('#deleteChatModal').modal('show');

                var url = "{{ route('doctor.chatdelete', ['id' => ':id', 'lang' => ':lang']) }}".replace(':id', id).replace(':lang', '{{ app()->getLocale() }}');

                $.ajax({
                    method: 'post',
                    url: url,
                    data: {
                        id: id,

                    },
                    success: function(result) {
                        console.log(result);
                        console.log('message deleted successfully');
                    },

                    error: function() {

                        console.log('Failed to delete chat');
                    }
                });
            }
        </script>


        <script>
            document.addEventListener("DOMContentLoaded", function() {
                ClassicEditor
                    .create(document.querySelector('#message'), {
                        ckfinder: {
                            uploadUrl: "{{ route('doctor.upload', ['lang' => app()->getLocale()]) .'?_token=' . csrf_token() }}",
                        }
                    })
                    .then(message => {
                        console.log(message);
                        window.ckEditorInstance = message;

                    })
                    .catch(error => {
                        console.error(error);
                    });
            })
        </script> 


        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }

            });
        </script>


    </body>

    </html>
    {{-- </x-slot> --}}

</x-app-layout>
