
        @extends('layouts.app')

        @section('title', 'Log in')
        
        @section('content')
        @auth

                <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto mt-5 lg:py-0">
                    <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                            <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
                                Update account
                            </h1>
                            
                            <form class="space-y-4 md:space-y-6" action="{{ route('update') }}" method="POST">
                                @method('PUT')

                                <div>
                                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                    <input type="name" name="name" id="name" value="{{ Auth::user()->name }}"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required="">
                                    @error('name')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div>
                                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Name</label>
                                    <input type="last_name" name="last_name" id="last_name" value="{{ Auth::user()->last_name }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Johnson" required="">
                                    @error('lastname')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="email"  id="disabled-input" aria-label="disabled input" value="{{ Auth::user()->email }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" disabled>
                                </div>
        
                                <div>
                                    <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                    <input type="password" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
        
                                <div>
                                    <label for="password_confirmation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm password</label>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" >
                                    @error('password')
                                    <span style="color: red;">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Update account</button>
                                
                                @if(session('success'))
                                    <div class="text-green-500 text-center mt-4">
                                        {{ session('success') }}
                                    </div>
                                @endif
                            </form>
                        </div>
                    </div>
                </div>

        @endauth
        @endsection
        
        