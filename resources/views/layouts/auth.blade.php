<!DOCTYPE html>
<html lang="en">
    <head>

        @include('includes.frontsite.meta')

        <title>@yield('title') | Sinar Cell</title>

        @stack('before-style')
            @include('includes.frontsite.style')
        @stack('after-style')

    </head>
    <body class="font-inter antialiased bg-white text-gray-900 tracking-tight">
        <div class="flex flex-col min-h-screen overflow-hidden">

            @include('sweetalert::alert')

            @yield('content')

            @stack('before-script')
                @include('includes.frontsite.script')
            @stack('after-script')

            {{-- modals --}}
            {{-- if you have a modal, create here --}}
            
        </div>
    </body>
</html>
