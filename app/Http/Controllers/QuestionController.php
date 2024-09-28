<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Exception;
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
 
    public function delete ($survey_id, $id){
        try{

            Survey::where('id', $survey_id)->where('user_id', Auth::User()->id)->first()->questions->where('id', $id)->first()->delete();
            return redirect()->route('survey_show', ['id'=> $survey_id])
            ->with('success', 'Question deleted!')->http_response_code("400");
        }catch(Exception $e){
            return redirect()->route('survey_show', ['id'=> $survey_id])
            ->with('error', 'Question are not deleted! Error: ' . $e  );
        }

    }
}
