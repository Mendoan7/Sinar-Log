<!DOCTYPE html>
<html lang="en">

<head>

    @include('includes.backsite.meta')

    <title>@yield('title') | Sinar Cell Backoffice</title>

    <link rel="shortcut icon" href="{{ asset('/assets/backsite/images/favicon.ico') }}">

    @stack('before-style')
    @include('includes.backsite.style')
    @stack('after-style')

</head>

<body data-sidebar="dark" data-layout-mode="light">

    <!-- Page wrapper -->
    <div id="layout-wrapper">

        @include('sweetalert::alert')

        @include('components.backsite.header')
        @include('components.backsite.menu')

        @yield('content')

        @include('components.backsite.footer')

    </div>

    @stack('before-script')
        @include('includes.backsite.script')
    @stack('after-script')

</body>

</html>
