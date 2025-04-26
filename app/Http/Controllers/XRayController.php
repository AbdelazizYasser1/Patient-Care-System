<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\XRay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class XRayController extends Controller
{
    public function index()
    {
        $xrays = XRay::all();
        return response()->json($xrays, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'Name_of_XRay' => 'required|string|max:255',
            'Description_of_XRay' => 'nullable|string',
            'Result_of_XRay' => 'required|string',
            'type_of_XRay' => 'required|string',
            'image_of_XRay' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        if ($request->hasFile('image_of_XRay')) {
            $imagePath = $request->file('image_of_XRay')->store('xrays', 'public');
        } else {
            return response()->json(['error' => 'Image upload failed'], 500);
        }

        $xray = new XRay();
        $xray->Name_of_XRay = $request->Name_of_XRay;
        $xray->Description_of_XRay = $request->Description_of_XRay;
        $xray->Result_of_XRay = $request->Result_of_XRay;
        $xray->type_of_XRay = $request->type_of_XRay;
        $xray->image_of_XRay = $imagePath;
        $xray->user_id = $request->user_id;
        $xray->save();

        return response()->json($xray, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'Name_of_XRay' => 'required|string|max:255',
            'Description_of_XRay' => 'nullable|string',
            'Result_of_XRay' => 'required|string',
            'type_of_XRay' => 'required|string',
            'image_of_XRay' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $xray = XRay::find($id);

        if (!$xray) {
            return response()->json(['message' => 'XRay not found'], 404);
        }

        $xray->Name_of_XRay = $request->Name_of_XRay;
        $xray->Description_of_XRay = $request->Description_of_XRay;
        $xray->Result_of_XRay = $request->Result_of_XRay;
        $xray->type_of_XRay = $request->type_of_XRay;

        if ($request->hasFile('image_of_XRay')) {
            if (file_exists(storage_path('app/public/' . $xray->image_of_XRay))) {
                unlink(storage_path('app/public/' . $xray->image_of_XRay));
            }

            $imagePath = $request->file('image_of_XRay')->store('xrays', 'public');
            $xray->image_of_XRay = $imagePath;
        }

        $xray->save();

        return response()->json(['message' => 'XRay updated successfully!', 'data' => $xray], 200);
    }

    public function show(Request $request)
    {
        $id = $request->user_id;
        $XRay_of_patient = User::with('XRay')->find($id);

        if (!$XRay_of_patient) {
            return response()->json(['message' => 'User not found'], 404);
        }

        return response()->json($XRay_of_patient, 200);
    }

    public function destroy(XRay $xRay)
    {
        $xRay->delete();
        return response()->json(['message' => 'XRay deleted successfully'], 200);
    }

    public function Unique_XRay(Request $request)
    {
        $id = $request->XRay_id;

        $XRay = XRay::findOrFail($id);
        return response()->json($XRay, 200);
    }
}
