import Alpine from 'alpinejs'
import persist from '@alpinejs/persist'
import Echo from 'laravel-echo'

Alpine.plugin(persist)
window.Alpine = Alpine
Alpine.start()


// ✅ Configure Laravel Echo with Reverb
window.Echo = new Echo({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: window.location.hostname,
    wsPort: 8080,
    wssPort: 8080,
    forceTLS: false,
    disableStats: true,
    enabledTransports: ['ws', 'wss'],
})

// ✅ Check connection and listen for notifications
console.log('Echo connected:', window.Laravel.userId)

window.Echo.private(`App.Models.User.${window.Laravel.userId}`)
    .notification((notification) => {
        console.log('🔔 New Notification:', notification)

        const bell = document.querySelector('#notification-bell')
        if (bell) bell.classList.add('animate-pulse')

        const list = document.querySelector('#notif-list')
        if (list) {
            const li = document.createElement('li')
            li.className = 'px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700'
            li.innerHTML = `
                <a href="${notification.url || '#'}" class="block">
                    <div class="font-bold text-gray-800 dark:text-white">${notification.title}</div>
                    <div class="text-gray-600 dark:text-gray-400">${notification.body}</div>
                    <div class="text-xs text-right text-gray-400 mt-1">Just now</div>
                </a>`
            list.prepend(li)
        }
    })
