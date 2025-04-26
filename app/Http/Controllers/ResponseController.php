<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\Questions;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ResponseController extends Controller
{
    public function index()
    {
        $responses = Response::all();
        return response()->json($responses, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'doctor_id' => 'required|exists:users,id',
            'response_text' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $response = Response::create([
            'question_id' => $request->question_id,
            'doctor_id' => $request->doctor_id,
            'response_text' => $request->response_text
        ]);

        $question = Questions::find($request->question_id);
        if ($question) {
            $question->update(['status' => 'answered']);
        }

        return response()->json(['message' => 'Response sent successfully!', 'data' => $response], 200);
    }

    public function show($id)
    {

        $response = Response::find($id);

        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        return response()->json($response, 200);
    }

    public function update(Request $request, $id)
    {
        $response = Response::find($id);

        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        $response->update($request->all());

        return response()->json(['message' => 'Response updated successfully', 'data' => $response], 200);
    }

    public function destroy($id)
    {
        $response = Response::find($id);

        if (!$response) {
            return response()->json(['message' => 'Response not found'], 404);
        }

        $response->delete();

        return response()->json(['message' => 'Response deleted successfully'], 200);
    }

    public function getResoureformdoctor(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'question_id' => 'required|exists:questions,id',
            'doctor_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $responses = Response::where('question_id', $request->question_id)
            ->where('doctor_id', $request->doctor_id)
            ->get();

        if ($responses->isEmpty()) {
            return response()->json(['message' => 'No responses found'], 404);
        }

        return response()->json(['Answer' => $responses], 200);
    }
}
