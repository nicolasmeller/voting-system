<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class SurveyController
{
    public function create(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
        ]);

        if ($validator->fails()) {
            $response = $validator->errors();
            return response()->json(['error' => $response], 401);
        }
        $user_id =   Auth::user()->id;

        $survey = Survey::create([
            "user_id" => $user_id,
            "name" => $request->name,
            "description" => $request->description,
            "created_at" => $request->created_at,
            "updated_at" => $request->updated_at,
        ]);


        return response()->json([
            "id" => $survey->id,
            "name" => $survey->name,
            "description" => $survey->description,
            "created_at" => $survey->created_at,
            "updated_at" => $survey->updated_at,
        ], 200);
    }

    public function delete(Request $request, $id)
    {

        if ($id) {

            $survey = Survey::where('id', $id)->where('user_id',  $request->user()->id)->first();

            $survey->delete();
            return response()->json([
              
            ], 200);
        } else {
            return response()->json([
                "error" => "Missing survey id!",
            ], 503);
        }
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'nullable|max:255',
        ]);
        $survey = Survey::where('id', $id)->where('user_id',  $request->user()->id)->first();

        $survey->update([
            'name' => $request->name,
            'description' => $request->description
        ]);
        $survey->save();
        return response()->json($survey);
    }

    public function get(Request $request, $id)
    {
        $survey = Survey::where('id', $id)->where('user_id', $request->user()->id)->with('questions')->first();

        return response()->json($survey);
    }
    public function list()
    {
        $surveys = Survey::where("user_id",  Auth::user()->id)->with('questions')->get();
        return response()->json($surveys);
    }
}
