<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;


class SurveyController extends Controller
{
    public function create(Request $request){

        $request->validate([
            'survey_name' => 'required|max:255',
            'survey_description' => 'nullable|max:255',
        ]);

        $survey = Survey::create([
            'name' => $request->get('survey_name'),
            'description' => $request->get('survey_description'),
           ]);
           return redirect()->route('survey_show', ['id'=> $survey->id])->with('success', 'Survey is created successfully!');

    }

    
    public function update(Request $request, $id){

        $request->validate([
            'survey_name' => 'required|max:255',
            'survey_description' => 'nullable|max:255',
        ]);
        $survey = Survey::find($id);

        $survey->update([
            'name' => $request->get('survey_name'),
            'description' => $request->get('survey_description'),
           ]);

           return view('surveys.survey', ['survey' => $survey ]);

    }
    public function show (Request $request, $id){
        $survey = Survey::find($id ||$request->id );
        return view('surveys.survey', ['survey' => $survey ]);
    }

    public function get(){
        
        return view('surveys.survey', ['survey' => null ]);
    }
}
