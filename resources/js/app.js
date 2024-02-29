import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic/build/ckeditor';
window.ClassicEditor = ClassicEditor;

$(document).ready(function () {

    let user_id = $('#user_id').val();
    let chat_room_id = $('#chat_room_id').val();
    $(document).on('click', '#send_message', function (e) {
        e.preventDefault();



        if (window.ckEditorInstance) {
            let receiver_id = $('#receiver_id').val();
            // let message = $('#message').val();
            let message = window.ckEditorInstance.getData();
            let imagesInput = $('#images')[0];
            let chat_room_id = $('#chat_room_id').val();

            if (!message && !imagesInput.files.length) {
                alert('Please enter a message or select an image.');
                return;
            }


            let formData = new FormData();
            formData.append('receiver_id', receiver_id);
            formData.append('message', message);
            formData.append('chat_room_id', chat_room_id);
            formData.append('images', imagesInput.files[0]);



            $.ajax({
                method: 'post',
                url: '/en/doctor/pusher/send-message',
                data: formData,
                contentType: false,
                processData: false,
                success: function (result) {
                    if (result.response_code == 1) {
                        // Assuming '.direct-chat-messages' is the container for messages
                        var messageContainer = $('.direct-chat-messages');

                        // Scroll to the bottom with animation
                        messageContainer.animate({ scrollTop: messageContainer.prop("scrollHeight") }, 3000);
                        alert("Message has been sent");
                    } else {
                        alert("Fail to send message");
                    }
                },
                error: function () {
                    alert("Something went wrong, please try again later");
                }
            });
        } else {
            console.error('CKEditor is not defined.');
        }


    });

    $(document).ready(function () {
        function setScrollbarToBottom() {
            var messageContainer = $('.direct-chat-messages');
            messageContainer.scrollTop(messageContainer.prop("scrollHeight"));
        }
    
        setScrollbarToBottom(); // Call the function when the document is ready
    });
    


    

    // window.Echo.channel('laravel-chat-development-' + chat_room_id)
    //     .listen('.message', (e) => {
    //         console.log(e.message.user_id == user_id);
    //         let messageHtml = '<div class="' + (e.message.user_id == user_id ? 'sender' : 'receiver') + '">';
    //         messageHtml += '<p><strong>' + e.message.user_id + '</strong>:' + e.message.message;
    //         messageHtml += '<button type="button" class="btn btn-sm btn-primary" onclick="chatDelete(' + e.message.id + ')">Delete</button>';

    //         messageHtml += '</p></div>';
    //         $('#messages').append(messageHtml);
    //         $('#message').val('');
    //     });



    window.Echo.channel('laravel-chat-development-' + chat_room_id)
        .listen('.message', (e) => {
            console.log(e.message.user_id == user_id);
            let messageHtml = '<div class="' + (e.message.user_id == user_id ? 'sender' : 'receiver') + '">';
            messageHtml += '<strong>' + e.message.user_id + ':</strong>' + e.message.message;

            if (e.message.images) {
                const baseUrl = 'http://example-app.test/storage/file/';
                const imageUrl = baseUrl + e.message.images;
                messageHtml += '<br><img src="' + imageUrl + '"  width="50px" height="50px" alt="Image">';
            }

            messageHtml += '<button type="button" class="btn btn-sm btn-primary" onclick="chatDelete(' + e.message.id + ')">Delete</button>';
            messageHtml += '</div>';


            $('#messages').append(messageHtml);
            $('#message').val('');

        });
    });


