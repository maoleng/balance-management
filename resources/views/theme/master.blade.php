<!doctype html>
<html class="no-js" lang="en" dir="ltr">
@include('theme.head_tag')
<body>
<div id="cryptoon-layout" class="theme-orange">
    @include('theme.sidebar')
    <div class="main px-lg-4 px-md-4">
        @include('theme.header')

        @yield('body')

        @include('theme.setting')
    </div>

</div>
<script src="{{ asset('assets/bundles/libscripts.bundle.js') }}"></script>
@yield('script')
</body>
</html>
