import Pusher from 'pusher-js';

// Make sure Pusher is available globally
window.Pusher = Pusher;

// Initialize Pusher and make it global
window.pusher = new Pusher('53d68ad68e706d48d767', {
    cluster: 'ap1'
});