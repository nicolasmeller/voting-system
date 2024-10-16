<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Survey;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Validator;

class QuestionController
{
    public function create(Request $request){


        $validator = Validator::make($request->all(), [
            'survey_id'=> 'required',
            'question' => 'required|max:255',
            'answer' => 'nullable|max:255',
            'type' => 'nullable|max:255',
        ]);
        
        if ($validator->fails()) { 
            $response = $validator->errors();
            return response()->json(['error' =>$response], 400);   
        }   

        if(!$survey = Survey::where('id', $request->survey_id)->where('user_id', $request->user()->id)->first()){
            return response()->json(['error'=> 'Could not add question to this survey!'], 400);
        }

        $survey->questions()->create([
            'question' => $request->get('question'),
            'answer' => $request->get('answer'),
            'type' => $request->get('type'),
        ])->save();

            return response()->json(['success'=> 'Question add to survey']);

    }
    public function update(Request $request, Int $id){


        $question = Question::findOrFail($id);

        if(!$question->surveys()->where('user_id', $request->user()->id)->first()){
            return response()->json(['error'=> 'Could not update question to this survey!'], 400);
        }
  
        $question->update($request->only(['question', 'answer', 'type']));

        return response()->json(['success'=> 'Question updated!']);
    }
 
    public function delete (Request $request, $id){
        try{
            $question = Question::findOrFail($id);
            $survey = $question->surveys()->where('user_id', $request->user()->id)->first();
            if($survey){
                $question->delete();
                return response()->json(['success'=> 'Question deleted!']);
            }
            return response()->json(['error'=> 'Could not delete the Question'], 400);

        }catch(Exception $e){
            return response()->json(['error'=> 'Could not delete the Question!'], 400);

        }

    }
}
