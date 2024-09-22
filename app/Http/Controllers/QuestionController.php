<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function create(Request $request, Survey $survey){

        $request->validate([
            'question' => 'required|max:255',
            'answer' => 'nullable|max:255',
            'type' => 'nullable|max:255',
        ]);

        $survey->questions()->create([
            'question' => $request->get('question'),
            'answer' => $request->get('answer'),
            'type' => $request->get('type'),
        ])->save();

        return redirect()->route('survey_show', ['id'=> $survey->id])
        ->with('success', 'Question are added!');
    }

    public function show($survey){
        return view('questions.question', ['survey' => $survey, 'question' => null ]);
    }
}
