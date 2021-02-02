@auth
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('{{ config('broadcasting.connections.pusher.key') }}', {
            cluster: '{{ env('PUSHER_APP_CLUSTER') }}',
            forceTLS: true,
            authEndpoint: '/broadcasting/auth',
            auth: {
                headers: {
                    'X-CSRF-Token': "{{ csrf_token() }}"
                }
            }
        });

        var user = <?php echo auth()->user() ; ?>;
        var channel = pusher.subscribe('private-App.Models.User.' + user.id);
        channel.bind('Illuminate\\Notifications\\Events\\BroadcastNotificationCreated', function(data) {
            if (window.Notification) {
                Notification.requestPermission( permission => {
                    let notification = new Notification(data.title, {
                        // body: post.title, // content for the alert
                        // icon: "https://pusher.com/static_logos/320x320.png" // optional image url
                    });

                    // link to page on clicking the notification
                    notification.onclick = () => {
                        window.open(window.location.href);
                    };
                });
                // alert(JSON.stringify(data));
            } else {
                alert('Notifications aren\'t supported on your browser! :(');
            }
        });
    </script>
    <script src="https://unpkg.com/@pusher/chatkit-client@1/dist/web/chatkit.js"></script>
    <script>
        const tokenProvider = new Chatkit.TokenProvider({
            url: "{{ env('CHATKIT_TEST_TOKEN_PROVIDER') }}"
        });

        const chatManager = new Chatkit.ChatManager({
            instanceLocator: "{{ env('CHATKIT_INSTANCE_LOCATOR') }}",
            userId: "{{ auth()->user()->name }}",
            tokenProvider: tokenProvider
        });
        chatManager.connect()
            .then(currentUser => {
                let on_room_clicked = function () {
                    let username = $(this).attr('data-username');
                    $('#selected-username').html(username);
                    if (!$(this).hasClass('active-message')) {
                        $('#rooms-list li').removeClass('active-message');
                        $(this).addClass('active-message');
                    }
                    let roomId = $(this).attr('data-roomid');
                    window.roomId = roomId;
                    currentUser.fetchMultipartMessages({
                        roomId: roomId,
                    })
                        .then(messages => {
                            $('.message-content-inner').html('');
                            $('.message-reply').show();
                            messages.forEach(function (message, index) {
                                currentUser.setReadCursor({
                                    roomId: roomId,
                                    position: message.id,
                                })
                                    .then(() => {
                                        // console.log('Success!');
                                    });
                                message.parts.forEach(function (part, index) {
                                    let me = '';
                                    if (message.sender.id === currentUser.id) {
                                        me = 'me';
                                    }
                                    let messageHtml =
                                        '<div class="message-bubble ' + me + '">\n' +
                                        '   <div class="message-bubble-inner">\n' +
                                        '       <div class="message-avatar"><img src="' + message.sender.avatarURL + '" alt="" /></div>\n' +
                                        '       <div class="message-text"><p>' + part.payload.content + '</p></div>\n' +
                                        '   </div>\n' +
                                        '   <div class="clearfix"></div>\n' +
                                        '</div>';
                                    $('.message-content-inner').append(messageHtml);
                                });
                            });
                        })
                        .catch(err => {
                            console.log(`Error fetching messages: ${err}`)
                        })
                };
                let totalUnreadCount = 0;
                let roomsListHtml = '';
                $('#rooms-list').html('');
                currentUser.rooms.forEach(function(room, index) {
                    currentUser.subscribeToRoomMultipart({
                        roomId: room.id,
                        hooks: {
                            onMessage: message => {
                                message.parts.forEach(function (part, index) {
                                    let me = '';
                                    if (message.sender.id === currentUser.id) {
                                        me = 'me';
                                    }
                                    let messageHtml =
                                        '<div class="message-bubble ' + me + '">\n' +
                                        '   <div class="message-bubble-inner">\n' +
                                        '       <div class="message-avatar"><img src="' + message.sender.avatarURL + '" alt="" /></div>\n' +
                                        '       <div class="message-text"><p>' + part.payload.content + '</p></div>\n' +
                                        '   </div>\n' +
                                        '   <div class="clearfix"></div>\n' +
                                        '</div>';
                                    $('.message-content-inner').append(messageHtml);
                                });
                            },
                            onMessageDeleted: messageId => {
                                // TODO
                                console.log("onMessageDeleted: ", messageId)
                            },
                            onUserStartedTyping: user => {
                                let typingIndicatorHtml =
                                    '    <div class="message-bubble" id="typing-indicator">\n' +
                                    '        <div class="message-bubble-inner">\n' +
                                    '            <div class="message-avatar"><img src="' + user.avatarURL +'" alt="" /></div>\n' +
                                    '            <div class="message-text">\n' +
                                    '                <!-- Typing Indicator -->\n' +
                                    '                <div class="typing-indicator">\n' +
                                    '                    <span></span>\n' +
                                    '                    <span></span>\n' +
                                    '                    <span></span>\n' +
                                    '                </div>\n' +
                                    '            </div>\n' +
                                    '        </div>\n' +
                                    '        <div class="clearfix"></div>\n' +
                                    '    </div>\n';
                                $('.message-content-inner').append(typingIndicatorHtml);
                            },
                            onUserStoppedTyping: user => {
                                $('#typing-indicator').remove();
                            },
                            onUserJoined: user => {
                                // TODO
                                console.log("onUserJoined: ", user)
                            },
                            onUserLeft: user => {
                                // TODO
                                console.log("onUserLeft: ", user)
                            },
                            onPresenceChanged: (state, user) => {
                                $('#rooms-list li').each(function () {
                                    let userId = $(this).attr('data-userid');
                                    if (userId === user.id) {
                                        let className = 'status-icon status-' + state.current;
                                        $("#item").removeAttr('class');
                                        $(this).find('i').addClass(className);
                                    }
                                });
                            },
                            onNewReadCursor: cursor => {
                                // TODO
                                console.log("onNewReadCursor: ", cursor);
                            },
                        },
                        messageLimit: 0
                    }).then(room => {
                        room.users.forEach(function(user, index) {
                            if (currentUser.id !== user.id) {
                                let roomHtml =
                                    '<li data-roomid="'+ room.id +'" data-userid="'+ user.id + '" data-username="' + user.name + '">\n' +
                                    '    <a href="#">\n' +
                                    '       <div class="message-avatar">' +
                                    '           <i></i>' +
                                    '           <img src="' + user.avatarURL + '" alt="" />' +
                                    '       </div>\n' +
                                    '       <div class="message-by">\n' +
                                    '           <div class="message-by-headline">\n' +
                                    '               <h5>' + user.name + '</h5>\n' +
                                    '               <span></span>\n' +
                                    '           </div>\n' +
                                    '           <p></p>\n' +
                                    '        </div>\n' +
                                    '    </a>\n' +
                                    '</li>';
                                $('#rooms-list').append(roomHtml);
                                $('#rooms-list li').click(on_room_clicked);
                            }
                        });
                    });

                    //Send Message Button Click Event
                    $('#send-message').unbind('click').click(function () {
                        if (window.roomId) {
                            currentUser.sendSimpleMessage({
                                roomId: window.roomId,
                                text: $('#message-content').val(),
                            })
                                .then(messageId => {
                                    $('#message-content').val('');
                                })
                                .catch(err => {
                                    console.log(`Error adding message to ${window.roomId}: ${err}`)
                                });
                        }
                    });

                    $('#message-content').on('input propertychange', function () {
                        currentUser.isTypingIn({ roomId: window.roomId })
                            .then(() => {
                                // TODO
                                console.log('Success!')
                            })
                            .catch(err => {
                                console.log(`Error sending typing indicator: ${err}`)
                            })
                    });
                });
                if (document.getElementById('total-unread-count')) {
                    $('#total-unread-count').html(totalUnreadCount);
                }
                if (document.getElementById('total-unread-count2')) {
                    $('#total-unread-count2').html(totalUnreadCount);
                }
            })
            .catch(err => {
                console.log('Error on connection', err);
                $.ajax({
                    url: "{{ route('chat.create-user') }}",
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function (data) {
                        // TODO
                    },
                    error: function (xhr, error) {
                        console.log(error);
                    }
                })
            })
    </script>
@endauth
