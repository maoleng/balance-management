@php use \Illuminate\Support\Facades\Cache; @endphp
<!doctype html>
<html lang="en">
@include('components.layouts.head-tag')
<body class="{{ Cache::get('dark-mode') }} @yield('bg-class')">

{{ $slot }}
@include('components.layouts.bottom-menu')
<div class="modal fade dialogbox" id="errorDialog" data-bs-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-icon text-danger">
                <ion-icon name="close-circle"></ion-icon>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Lỗi</h5>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn" data-bs-dismiss="modal">ĐÓNG</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade dialogbox" id="successDialog" data-bs-backdrop="static" tabindex="-1"
     role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-icon text-success">
                <ion-icon name="checkmark-circle"></ion-icon>
            </div>
            <div class="modal-header">
                <h5 class="modal-title">Thành công</h5>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <div class="btn-inline">
                    <a href="#" class="btn" data-bs-dismiss="modal">ĐÓNG</a>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="successToast" class="toast-box toast-top bg-success">
    <div class="in"><div class="text"></div></div>
    <button type="button" class="btn btn-sm btn-text-light close-button">OK</button>
</div>
<script data-navigate-once src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<script data-navigate-once type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script data-navigate-once src="{{ asset('assets/js/plugins/splide/splide.min.js') }}"></script>
<script data-navigate-once src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="{{ asset('assets/js/base.js') }}"></script>
@include('components.layouts.script')
</body>
</html>
