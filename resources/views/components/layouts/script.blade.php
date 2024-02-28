<script data-navigate-once>
    let serviceWorkerRegistration = null
    let subscription = null

    async function init()
    {
        serviceWorkerRegistration = await navigator.serviceWorker.ready
        const sub = await serviceWorkerRegistration.pushManager.getSubscription()
        if (sub === null) {
            const result = await Notification.requestPermission()
            if (result !== 'granted') return
            subscription = await createSubscription()
            await $.ajax({
                url: '{{ route('subscription') }}',
                method: 'POST',
                data: {
                    subscription: subscription.toJSON(),
                }
            })
            showNotification()
        } else {
            subscription = sub
            showNotification()
        }
    }

    function showNotification()
    {
        serviceWorkerRegistration.showNotification('Notifications granted', {
            body: 'Here is a first notification',
            vibrate: [300, 200, 300],
        })
    }

    async function createSubscription()
    {
        const registration = serviceWorkerRegistration || await navigator.serviceWorker.ready;
        const vapidPublicKey = '{{ env('VAPID_PUBLIC_KEY') }}'
        const convertedVapidPublicKey = urlBase64ToUint8Array(vapidPublicKey)

        return registration.pushManager.subscribe({
            userVisibleOnly: true,
            applicationServerKey: convertedVapidPublicKey
        })
    }

    function urlBase64ToUint8Array(base64String)
    {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding)
            .replace(/\-/g, '+')
            .replace(/_/g, '/');
        const rawData = window.atob(base64);
        let outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }

</script>
<script>
    @if (authed())
        init()
    @endif
</script>
