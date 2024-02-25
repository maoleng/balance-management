<!doctype html>
<html lang="en">
@include('components.layouts.head-tag')
<body>
@include('components.layouts.header')
{{ $slot }}
@include('components.layouts.bottom-menu')
<script src="{{ asset('assets/js/lib/bootstrap.bundle.min.js') }}"></script>
<script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="{{ asset('assets/js/plugins/splide/splide.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/apexcharts/apexcharts.min.js') }}"></script>
<script src="{{ asset('assets/js/base.js') }}"></script>
<script>
    AddtoHome("2000", "once");
</script>
@stack('script')
</body>
</html>
