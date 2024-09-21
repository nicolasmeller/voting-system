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

                <form action="{{ route('profile') }}"  method="GET" class="inline">
                  <button type="submit" class="text-cyan-500 mr-4">Profile</button>
                </form>


                <form action="{{ route('surveys') }}"  method="GET" class="inline">
                  <button type="submit" class="text-cyan-500 mr-4">Survey</button>
                </form>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    <button type="submit" class="text-cyan-500  mr-4">Logout</button>
                </form>
            @endauth


        </div>
    </div>
</nav>

    <div class="container mx-auto p-4">
        <!-- Authenticated user content -->
        @auth
            <p>Hello, {{ Auth::user()->name }}! You are logged in.</p>
                @csrf
        @endauth
    </div>
</body>
</html>
