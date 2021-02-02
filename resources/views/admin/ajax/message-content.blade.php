<div class="messages-headline">
    <h4>Sindy Forest</h4>
    <a href="javascript:;" class="message-action delete" data-room-id="{{ $room_id }}"><i class="icon-feather-trash-2"></i> Delete Conversation</a>
</div>

<!-- Message Content Inner -->
<div class="message-content-inner">
    @foreach($messages as $message)
    <div class="message-bubble @if($message['user_id'] == auth()->user()->name) me @endif">
        <div class="message-bubble-inner">
            <div class="message-avatar"><img src="images/user-avatar-small-01.jpg" alt="" /></div>
            <div class="message-text"><p>{{ $message['parts'][0]['content'] }}</p></div>
        </div>
        <div class="clearfix"></div>
    </div>
    @endforeach
</div>
<!-- Message Content Inner / End -->

<!-- Reply Area -->
<div class="message-reply">
    <textarea cols="1" rows="1" placeholder="Your Message" data-autoresize></textarea>
    <button class="button ripple-effect" data-room-id="{{ $room_id }}">Send</button>
</div>

<script>
    $('.message-reply button').click(function () {
        let roomId = $(this).attr('data-room-id');
        $.ajax({
            type: 'POST',
            url: '/message/send',
            data: {
                room_id: roomId,
                message: $('#message-box').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {

            }
        })
    });
    $('.message-action.delete').click(function () {
        let roomId = $(this).attr('data-room-id');
        $.ajax({
            type: 'POST',
            url: '/rooms/delete',
            data: {
                room_id: roomId,
                _token: '{{ csrf_token() }}'
            },
            success: function (data) {
                window.location.reload();
            }
        })
    })
</script>
