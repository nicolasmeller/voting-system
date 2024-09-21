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
    <section>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
                        @if ($survey)
                        Update an Survey
                        @else
                        Create an Survey
                        @endif
                    </h1>
                    @if ($survey)
                        <form class="space-y-4 md:space-y-6" action="{{$survey->id}}" method="PUT">
                    @else
                        <form class="space-y-4 md:space-y-6" action="{{ route('survey') }}" method="POST">
                    @endif
                    @csrf
                        <div>
                            <label for="survey_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="survey_name" name="survey_name" id="survey_name" value="{{$survey->name ?? null}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Denmark citys" required="">
                            @error('survey_name')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="survey_description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <span class="inline text-gray-400 dark:text-white">(optional)</span></label>
                            <input type="survey_description" name="survey_description" id="survey_description" value="{{$survey->description ?? null}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Geography of Denmark">
                            @error('survey_description')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>                                               
                        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Create survey</button>
                        @if(session('success'))
                            <div class="text-green-500 text-center mt-4">
                                {{ session('success') }}
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </section>
    @endauth
</body>
<script src="../path/to/flowbite/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
</html>
