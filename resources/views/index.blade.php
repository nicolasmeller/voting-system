<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <nav class="bg-white shadow-md dark:bg-gray-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="/" class="text-xl font-bold">Voting-System</a>
            
            <div>
                @auth
                    <form action="{{ route('profile') }}" class="inline">
                        <button type="submit" class="text-cyan-500 mr-4">Profile</button>
                    </form>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="text-cyan-500  mr-4">Logout</button>
                    </form>
                @endauth

                @guest

                <form action="{{ route('register') }}" method="GET"  class="inline">
                    <button type="submit" class="text-cyan-500 mr-4">Register</button>
                </form>
                <form action="{{ route('login') }}" method="GET" class="inline">
                    <button type="submit" class="text-cyan-500  mr-4">Login</button>
                </form>
                
                @endguest
            </div>
        </div>
    </nav>

    <main class="container mx-auto p-4">
        @yield('content')
    </main>
</body>
</html>