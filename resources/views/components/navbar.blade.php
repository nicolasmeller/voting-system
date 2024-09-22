
<nav class="bg-white shadow-md dark:bg-gray-800 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <a href="/" class="text-xl font-bold">Voting-System</a>
        
        <div>
            @auth
              <form action="{{ route('profile') }}"  method="GET" class="inline">
                  @csrf
                <button type="submit" class="text-cyan-500 mr-4">Profile</button>
              </form>
              <form action="{{ route('surveys') }}" method="GET" class="inline">
                @csrf
                <button type="submit" class="text-cyan-500  mr-4">Surveys</button>
            </form>
              <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-cyan-500  mr-4">Logout</button>
                </form>


            @endauth

            @guest

                <form action="{{ route('login') }}" method="GET" class="inline">
                    @csrf
                    <button type="submit" class="text-cyan-500  mr-4">Log In</button>
                </form>

                <form action="{{ route('register') }}" method="GET" class="inline">
                    @csrf
                    <button type="submit" class="text-cyan-500  mr-4">Register</button>
                </form>
            @endguest
        </div>
    </div>
</nav>

