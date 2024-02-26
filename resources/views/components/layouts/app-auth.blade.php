<!DOCTYPE html>
<html lang="en" class="{{ Auth::check() && Auth::user()->is_dark_mode ? 'dark-mode' : '' }}">
@include('components.layouts.head-tag')
<body>
{{ $slot }}
@stack('page-script')
<script src="{{ asset('assets/js/custom.js') }}"></script>
<link rel="stylesheet" href="{{ asset('assets/css/res.css') }}">
<script data-navigate-once src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</body>
</html>
