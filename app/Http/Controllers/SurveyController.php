<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'survey_name' => 'required|max:255',
            'survey_description' => 'nullable|max:255',
        ]);

        $user_id =   Auth::user()->id;
        $survey = Survey::create([
            'user_id'=>  $user_id,
            'name' => $request->get('survey_name'),
            'description' => $request->get('survey_description'),
        ]);
        
        return redirect()->route('survey_show', ['id'=>  $survey->id])->with('success', 'Survey is created successfully!');
    }

    
    public function update(Request $request, $id){

        $request->validate([
            'survey_name' => 'required|max:255',
            'survey_description' => 'nullable|max:255',
        ]);
        $survey = Survey::where('id', $id)->where('user_id', Auth::user()->id)->first();
  
        $survey->update([
            'name' => $request->get('survey_name'),
            'description' => $request->get('survey_description'),
        ]);
        $survey->save();
        return redirect()->route('survey_show', ['id'=> $survey->id])->with('success', 'Survey is created successfully!');

    }
    public function show ( $id){
        
        $survey = Survey::where('id', $id)->where('user_id', Auth::user()->id)->first();

        return view('surveys.survey', ['survey' => $survey ]);
    }

    public function get(){
        return view('surveys.survey', ['survey' => null ]);
    }    

    public function list(){
        $surveys = Survey::where("user_id",  Auth::user()->id)->get();
        return view('surveys.surveys', ['surveys' =>  $surveys ]);
    }
}
