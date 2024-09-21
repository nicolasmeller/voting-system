<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold mb-4">Welcome to your dashboard</h1>

        <!-- Authenticated user content -->
        @auth
            <p>Hello, {{ Auth::user()->name }}! You are logged in.</p>

            <!-- Log out button -->
            <form action="logout" method="POST">
                @csrf
                <button class="mt-4 px-4 py-2 bg-red-500 text-white rounded" type="submit">Logout</button>
            </form>
        @endauth
    </div>
</body>
</html>
