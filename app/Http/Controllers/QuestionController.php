<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Questions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Questions::all();
        return response()->json($questions, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_text' => 'required|string',
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $question = Questions::create([
            'question_text' => $request->question_text,
            'patient_id' => $request->patient_id,
            'doctor_id' => $request->doctor_id,
            'status' => 'pending',
        ]);

        return response()->json(['message' => 'Question sent successfully!', 'data' => $question], 200);
    }

    public function show($id)
    {
        $question = Questions::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        return response()->json($question, 200);
    }

    public function update(Request $request, $id)
    {
        $question = Questions::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $question->update($request->all());

        return response()->json(['message' => 'Question updated successfully', 'data' => $question], 200);
    }

    public function destroy($id)
    {
        $question = Questions::find($id);

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $question->delete();

        return response()->json(['message' => 'Question deleted successfully'], 200);
    }

    public function getPatientDoctorQuestions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'patient_id' => 'required|exists:users,id',
            'doctor_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $questions = Questions::where('patient_id', $request->patient_id)
            ->where('doctor_id', $request->doctor_id)
            ->get();

        return response()->json(['questions' => $questions], 200);
    }
}
