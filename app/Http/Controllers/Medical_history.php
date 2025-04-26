<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Medical_history;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class Medical_historyController extends Controller
{
    public function index()
    {
        $histories = Medical_history::with('user')->get();
        return response()->json($histories, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name_of_Surgery' => 'required|string|max:255',
            'Description_of_Surgery' => 'nullable|string',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $history = Medical_history::create([
            'Name_of_Surgery' => $request->Name_of_Surgery,
            'Description_of_Surgery' => $request->Description_of_Surgery,
            'user_id' => $request->user_id,
        ]);

        return response()->json(['message' => 'Medical history saved successfully.', 'data' => $history], 201);
    }

    public function show(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::with('medicalHistories')->find($request->user_id);

        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($user->medicalHistories, 200);
    }

    public function update(Request $request, $id)
    {
        $history = Medical_history::find($id);

        if (!$history) {
            return response()->json(['message' => 'Medical history not found'], 404);
        }

        $history->update($request->all());

        return response()->json(['message' => 'Medical history updated', 'data' => $history], 200);
    }

    public function destroy($id)
    {
        $history = Medical_history::find($id);

        if (!$history) {
            return response()->json(['message' => 'Medical history not found'], 404);
        }

        $history->delete();

        return response()->json(['message' => 'Medical history deleted'], 200);
    }
}
