
<footer class="bg-white rounded-lg shadow m-4 dark:bg-gray-800">
    <div class="w-full mx-auto max-w-screen-xl p-4 md:flex md:items-center md:justify-between">
      <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2024 <a href="https://flowbite.com/" class="hover:underline"></a>
    </span>
    <div class="flex flex-wrap items-center mt-3 text-sm font-medium text-gray-500 dark:text-gray-400 sm:mt-0">
        @auth
        <form action="{{ route('profile') }}"  method="GET" class="inline">
            @csrf
          <button type="submit" class="hover:underline me-4 md:me-6">Profile</button>
        </form>
        <form action="{{ route('surveys') }}" method="GET" class="inline">
          @csrf
          <button type="submit" class="hover:underline me-4 md:me-6">Surveys</button>
      </form>
        <form action="{{ route('logout') }}" method="POST" class="inline">
              @csrf
              <button type="submit" class="hover:underline me-4 md:me-6">Logout</button>
          </form>


      @endauth

    @guest

    <form action="{{ route('login') }}" method="GET" class="inline">
        @csrf
        <button type="submit" class="hover:underline me-4 md:me-6">Log In</button>
    </form>

    <form action="{{ route('register') }}" method="GET" class="inline">
        @csrf
        <button type="submit" class="hover:underline me-4 md:me-6">Register</button>
    </form>
    @endguest
    
    
    </ul>
    </div>
</footer>

