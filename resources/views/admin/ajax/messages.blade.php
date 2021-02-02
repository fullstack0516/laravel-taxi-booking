<div class="messages-container-inner">

    <!-- Messages -->
    <div class="messages-inbox">
        <div class="messages-headline">
            <div class="input-with-icon">
                <input id="autocomplete-input" type="text" placeholder="Search">
                <i class="icon-material-outline-search"></i>
            </div>
        </div>

        <ul>
            @foreach($rooms as $room)
                @php
                $driver = \App\Models\User::query()->where('name', $room['member_user_ids'][1])->first();
                $avatar = $driver->profile->avatar;
                @endphp
            <li class="chat-room" data-room-id="{{ $room['id'] }}">
                <a href="#">
                    <div class="message-avatar"><i class="status-icon status-online"></i><img src="@if($avatar) {{ $avatar }} @else {{ asset('images/user-avatar-placeholder.png') }} @endif" alt="" /></div>

                    <div class="message-by">
                        <div class="message-by-headline">
                            <h5>{{ $room['member_user_ids'][1] }}</h5>
                        </div>
                        <p>Thanks for reaching out. I'm quite busy right now on many</p>
                    </div>
                </a>
            </li>
            @endforeach
        </ul>
    </div>
    <!-- Messages / End -->

    <!-- Message Content -->
    <div class="message-content">

    </div>
    <!-- Message Content -->

</div>

<script>
    $('.chat-room').click(function () {
        $( this ).parent().find( 'li.active-message' ).removeClass( 'active-message' );
        $(this).addClass('active-message');
        let roomId = $(this).attr('data-room-id');
        $.ajax({
            url: '/messages/' + roomId,
            success: function (data) {
                $('.message-content').html(data);
            }
        })
    });
</script>
