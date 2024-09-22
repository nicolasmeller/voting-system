


@extends('layouts.app')
@section('title', 'Surveys')
  
@section('content')
    @auth
        <!-- Tjek om der er nogen surveys -->
        <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
            <div class="pt-5 pb-5">
            <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Surveys List</p>


            <form class="pt-5" action="{{ route('survey') }}" method="GET">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-cyan-700 rounded-lg hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                  Create survey
              </button>
              </form>


            </div>
            @if(session('success'))
            <div class="text-green-500 text-center mt-4 p-5">
                {{ session('success') }}
             </div>
            @endif

        @if($surveys->isEmpty())
            <p>No surveys available.</p>
        @else
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Survey name
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Description
                        </th>
                    
                        <th scope="col" class="px-6 py-3">
                            Action
                        </th>
                    </tr>
                </thead>
                @foreach($surveys as $survey)
                <tbody>
                    <form class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" action="{{ route('survey_show', ['id'=>$survey->id]) }}" method="GET">
                    @csrf
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                           {{ $survey->name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $survey->description }}
                        </td>
                       
                        <td class="px-6 py-4">
                            <button type="submit" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                Update
                                </button>
                        </td>
                        </tr>
                    </form>
                </tbody>
                @endforeach
            </table>
        </div>
        @endif
    </div>
    </div>
    @endauth

@endsection