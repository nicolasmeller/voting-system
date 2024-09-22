@extends('layouts.app')
@if ($survey)
    @section('title', 'Survey')
@else
    @section('title', 'Create an Survey')
@endif

@section('content')
    @auth
        @if (!$survey)
            <div class="flex flex-col items-center justify-center px-6 py-8 mx-auto md:h-screen lg:py-0">
                <div
                    class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                    <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                        <h1
                            class="text-xl font-bold leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white text-center">
                            Create an Survey
                        </h1>
                        @if ($survey)
                            <form class="space-y-4 md:space-y-6" action="{{ route('survey_update', ['id' => $survey->id]) }}"
                                method="post">
                            @else
                                <form class="space-y-4 md:space-y-6" action="{{ route('survey') }}" method="POST">
                        @endif
                        @csrf
                        <div>
                            <label for="survey_name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                            <input type="survey_name" name="survey_name" id="survey_name" value="{{ $survey->name ?? null }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Denmark citys" required="">
                            @error('survey_name')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="survey_description"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <span
                                    class="inline text-gray-400 dark:text-white">(optional)</span></label>
                            <input type="survey_description" name="survey_description" id="survey_description"
                                value="{{ $survey->description ?? null }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Geography of Denmark">
                            @error('survey_description')
                                <span style="color: red;">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            @if ($survey)
                                Update Survay
                            @else
                                Create Survay
                            @endif
                        </button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div class="py-8 px-4 mx-auto max-w-screen-xl lg:py-16 lg:px-6">
                <div class="pt-5 pb-5">
                    <p class="mt-2 text-3xl font-bold tracking-tight text-gray-900 dark:text-white sm:text-4xl">Survey</p>
                    @if (session('success'))
                        <div class="text-green-500 text-center mt-4 p-5">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('survey_update', ['id' => $survey->id]) }}" method="POST">
                        @csrf
                        <div class="grid gap-2 sm:grid-cols-3 sm:gap-3 pt-4">
                            <div class="sm:col-span-1">
                                <label for="survey_name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="survey_name" id="survey_name" value="{{ $survey->name ?? null }}"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Denmark citys" required="">
                                @error('survey_name')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="sm:col-span-1">
                                <label for="survey_description"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Description <span
                                        class="inline text-gray-400 dark:text-white">(optional)</span></label>
                                <input type="text" name="survey_description" value="{{ $survey->description ?? null }}"
                                    id="survey_description"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    placeholder="Geography of Denmark">
                                @error('survey_description')
                                    <span style="color: red;">{{ $message }}</span>
                                @enderror
                            </div>

                            <button type="submit"
                                class=" w-full inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                                Update Survey
                            </button>
                            
                    </form>
                    
                </div>
            </div>
            <form action="{{ route('questions', ['survey' => $survey]) }}" method="get">
                @csrf
                <button type="submit"
                    class="  inline-flex items-center px-5 py-2.5 text-sm font-medium text-center text-white bg-primary-700 rounded-lg focus:ring-4 focus:ring-primary-200 dark:focus:ring-primary-900 hover:bg-primary-800">
                    Add question
                </button>
            </form>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Question
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Answer
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Type
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    @foreach ($survey->questions as $question)
                        <tbody>
                            <form
                                class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700"
                                action="{{ route('survey_show', ['id' => $survey->id]) }}" method="GET">
                                @csrf
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row"
                                        class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $question->question }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $question->answer }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $question->type }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <button type="submit"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Update
                                        </button>
                                    </td>
                                </tr>
                            </form>
                        </tbody>
                    @endforeach
                </table>
            </div>


            </div>
        @endif

    @endauth

@endsection
