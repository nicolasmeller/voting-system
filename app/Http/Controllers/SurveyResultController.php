<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\SurveyResult;
use Illuminate\Http\Request;

class SurveyResultController
{
    public function submitAnswer(Request $request)
    {

        $validated = $request->validate([
            'survey_id' => 'required|exists:surveys,id',
            'user_id' => 'required|exists:users,id',
            'question_id' => 'required|exists:questions,id',
            'selected_option' => 'required|integer'
        ]);

        $result = SurveyResult::firstOrCreate(
            [
                'survey_id' => $validated['survey_id'],
                'user_id' => $validated['user_id']
            ],
            [
                'score' => 0,
                'total_questions' => 0,
                'correct_answers' => 0
            ]
        );

        $question = Question::findOrFail($validated['question_id']);

       
        $isCorrect = $question->options()
            ->where('id', $validated['selected_option'])
            ->where('is_correct', true)
            ->exists();

       
        $result->total_questions += 1;  
        if ($isCorrect) {
            $result->correct_answers += 1; 
            $result->score += $question->points; 
        }
        $result->save();

      
        return response()->json([
            'message' => 'Answer recorded successfully.',
            'is_correct' => $isCorrect,
            'current_score' => $result->score,
            'total_questions' => $result->total_questions,
            'correct_answers' => $result->correct_answers
        ]);
    }}
