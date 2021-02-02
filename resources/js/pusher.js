window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

import Echo from 'laravel-echo';

window.Pusher = require('pusher-js');

window.Echo = new Echo({
    broadcaster: 'pusher',
    key: process.env.MIX_PUSHER_APP_KEY,
    cluster: process.env.MIX_PUSHER_APP_CLUSTER,
    encrypted: true,
    auth: {
        headers: {
            'X-CSRF-Token': window.Laravel.csrfToken
        }
    }
});

window.Echo.private('App.Models.User.${Laravel.userId}')
    .notification((notification) => {
        console.log(notification.type);
    });
