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

                if (data.type === 'App\\Notifications\\RideCancelled') {
                    window.location.href = '/rides'
                } else if (data.type === 'App\\Notifications\\RideAccepted') {
                    window.location.href = '/rides/' + data.ride.id + '/show';
                }

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
            let totalUnreadCount = 0;
            currentUser.rooms.forEach(function(room, index) {
                currentUser.subscribeToRoomMultipart({
                    roomId: room.id,
                    hooks: {
                        onMessage: message => {
                            // TODO
                        },
                        onMessageDeleted: messageId => {
                            // TODO
                        },
                        onUserStartedTyping: user => {
                            // TODO
                        },
                        onUserStoppedTyping: user => {
                            // TODO
                        },
                        onUserJoined: user => {
                            // TODO
                        },
                        onUserLeft: user => {
                            // TODO
                        },
                        onPresenceChanged: (state, user) => {
                            // TODO
                        },
                        onNewReadCursor: cursor => {
                            // TODO
                        },
                    },
                    messageLimit: 0
                }).then(room => {
                    // TODO
                });

                if (room.unreadCount) {
                    totalUnreadCount += room.unreadCount;
                }
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
                    console.log(data);
                }
            })
        })
</script>
@endauth
