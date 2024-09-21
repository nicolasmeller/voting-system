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
                  @csrf
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        <button type="submit" class="text-cyan-500">Logout</button>
                    </form>
                    @csrf
                @endauth

                @guest

                    <form action="{{ route('login') }}" method="GET" class="inline">
                        <button type="submit" class="text-cyan-500">Log In</button>
                    </form>

                    <form action="{{ route('register') }}" method="GET" class="inline">
                        <button type="submit" class="text-cyan-500">Register</button>
                    </form>
                @endguest
            </div>
        </div>
    </nav>
    @auth
    <div class="container">
        <h1>Surveys List</h1>
    
        <!-- Tjek om der er nogen surveys -->
        @if($surveys->isEmpty())
            <p>No surveys available.</p>
        @else
            <ul>
                <!-- Iterér over hver survey og vis data -->
                @foreach($surveys as $survey)
                    <li>
                    <form class="space-y-4 md:space-y-6" action="{{ route('survey_show', ['id'=>$survey->id]) }}" method="GET">
                    @csrf
                    <h3>{{ $survey->name }}</h3>
                    <p>{{ $survey->description }}</p>
                    <p><strong>Created at:</strong> {{ $survey->created_at->format('d-m-Y') }}</p>
                                                        
                        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            Update survey</button>
                    </form>
                </li>

                @endforeach
            </ul>
        @endif
    </div>
    @endauth
</body>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</html>
