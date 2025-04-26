<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = User::where('usertype', 'doctor')->get();
        return response()->json($doctors, 200);
    }

    public function show($id)
    {
        $doctor = User::where('id', $id)->where('usertype', 'doctor')->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        return response()->json($doctor, 200);
    }

    public function update(Request $request, $id)
    {
        $doctor = User::where('id', $id)->where('usertype', 'doctor')->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor->update($request->all());

        return response()->json(['message' => 'Doctor updated successfully', 'data' => $doctor], 200);
    }

    public function destroy($id)
    {
        $doctor = User::where('id', $id)->where('usertype', 'doctor')->first();

        if (!$doctor) {
            return response()->json(['message' => 'Doctor not found'], 404);
        }

        $doctor->delete();

        return response()->json(['message' => 'Doctor deleted successfully'], 200);
    }
}
