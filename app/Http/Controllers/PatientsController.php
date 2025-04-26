<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PatientsController extends Controller
{
    public function index()
    {
        $patients = User::where('usertype', 'patient')->get();
        return response()->json($patients, 200);
    }

    public function show($id)
    {
        $patient = User::where('id', $id)->where('usertype', 'patient')->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        return response()->json($patient, 200);
    }

    public function update(Request $request, $id)
    {
        $patient = User::where('id', $id)->where('usertype', 'patient')->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient->update($request->all());

        return response()->json(['message' => 'Patient updated successfully', 'data' => $patient], 200);
    }

    public function destroy($id)
    {
        $patient = User::where('id', $id)->where('usertype', 'patient')->first();

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 200);
    }
}
