@extends('layouts.app')
@if ($question)
    @section('title', 'Question')
@else
    @section('title', 'Add Question')
@endif
  
@section('content')
    @auth

    <section>
        <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto m-5 lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">

                        @if ($question)
                            Update an question
                        @else
                            Add an question
                        @endif
                    </h1>
                    @if ($question)
                        <form class="space-y-4 md:space-y-6" action="{{ route('survey_update', ['id' => $question->id ]) }}" method="POST">
                    @else
                        <form class="space-y-4 md:space-y-6" action="{{ route('question_add', ['survey' => $survey ]) }}" method="POST">
                    @endif
                    @csrf
                        <div>
                            <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="question" name="question" id="question" value="{{$question->name ?? null}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="What is the biggest city in Denmark?" required="">
                            @error('question')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>
                        
                        <div>
                            <label for="answer" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Answer <span class="inline text-gray-400 dark:text-white">(optional)</span></label>
                            <input type="answer" name="answer" id="answer" value="{{$question->answer ?? null}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Copenhagen">
                            @error('answer')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>   
                        <div>
                            <label for="type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Type <span class="inline text-gray-400 dark:text-white">(optional)</span></label>
                            <input type="type" name="type" id="type" value="{{$question->type ?? null}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Copenhagen">
                            @error('type')
                            <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>  
                        <button type="submit" class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            @if ($question)
                                Update question
                            @else
                                Add question
                            @endif
                        </button>
                    
                    </form>
                </div>
            </div>
        </div>
    </section>

    @endauth

@endsection

