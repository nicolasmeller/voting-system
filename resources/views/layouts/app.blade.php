<html>
    <head>
        <title>@yield('title')</title>
        @vite('resources/css/app.css')
    </head>
    <body class="bg-gray-50 dark:bg-gray-900 ">
        @section('navbar')
            <x-navbar></x-navbar>
        @show
        <div class="mx-auto">

        @yield('content')
        </div>
    <script src="../path/to/flowbite/dist/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
            
    </body>
</html>