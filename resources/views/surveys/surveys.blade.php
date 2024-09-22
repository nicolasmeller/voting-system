


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
            <ul role="list" class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">

                        @foreach($surveys as $survey)

                    @csrf
   
                        <li class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center shadow">
                        <form class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700" action="{{ route('survey_show', ['id'=>$survey->id]) }}" method="GET">

                          <div class="flex flex-1 flex-col p-3">
                            <h3 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white truncate text-left	">{{ $survey->name }}</h3>
                            <dl class="mt-1 flex flex-grow flex-col justify-between text-left	">
                            
                              <dd class="text-sm text-gray-500">  <span>Description: </span>{{ $survey->description }}</dd>
                            </dl>
                          </div>

                          <button type="submit" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-cyan-700 rounded-lg hover:bg-cyan-800 focus:ring-4 focus:outline-none focus:ring-cyan-300 dark:bg-cyan-600 dark:hover:bg-cyan-700 dark:focus:ring-cyan-800">
                            Update survey
                        </button>
                        </form>

                        </li>
                      
                        <!-- More people... -->




                @endforeach

            </ul>
            </div>
        </div>
            </div>
        @endif
    </div>
    </div>
    @endauth

@endsection