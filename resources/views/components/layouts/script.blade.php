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
                    _token: '{{ csrf_token() }}',
                    subscription: subscription.toJSON(),
                }
            })
        } else {
            subscription = sub
        }
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
    @if (\Illuminate\Support\Facades\Auth::check())
        init()
    @endif
</script>

<script>
    @if (Cache::get('screen-mode') === 'auto')
        if (window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            $('body').addClass('dark-mode')
        } else {
            $('body').removeClass('dark-mode')
        }
    @endif
</script>

<script>
    function showErrorDialog(msg)
    {
        const modal = $('#errorDialog')
        modal.find('.modal-body').text(msg)
        modal.modal('toggle')
    }
    function showSuccessDialog(msg)
    {
        const modal = $('#successDialog')
        modal.find('.modal-body').text(msg)
        modal.modal('toggle')
    }
    function showSuccessToast(msg)
    {
        $('#successToast').find('.text').text(msg)
        toastbox('successToast')
    }
</script>

<div id="modal-confirm" class="modal fade dialogbox" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Xóa</h5>
            </div>
            <div class="modal-body">
                Bạn chắc chứ?
            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn btn-text-secondary" data-bs-dismiss="modal">Hủy</a>
                    <button class="btn btn-text-primary" data-bs-dismiss="modal">Xóa</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function confirmDelete(url)
    {
        const modal = $('#modal-confirm')
        modal.modal('toggle')

        return modal.find('button').off('click').on('click', async function () {
            await $.ajax({
                url: url,
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function () {
                    showSuccessToast('Xóa hóa đơn thành công.')
                }
            })
        })
    }
</script>

<script>
    function typeCharacter(inputElement, text)
    {
        let index = 0;
        function typeNextCharacter() {
            if (index < text.length) {
                inputElement.val(inputElement.val() + text.charAt(index));
                inputElement.trigger('input');
                index++;
                requestAnimationFrame(typeNextCharacter);
            }
        }
        typeNextCharacter();
    }
</script>

<script>
    AddtoHome("2000", "once");
</script>
