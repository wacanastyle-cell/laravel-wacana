<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class MemberJoinController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'whatsapp' => 'required|string|max:255',
            'motor_type' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            Member::create([
                'name' => $request->name,
                'whatsapp' => $request->whatsapp,
                'motor_type' => $request->motor_type,
                'city' => $request->city,
                'status' => 'pending', // Default status for new registrations
            ]);
            return response()->json(['message' => 'Pendaftaran berhasil dikirim!'], 200);
        } catch (\Exception $e) {
            Log::error('Failed to save new member: ' . $e->getMessage());
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data. Silakan coba lagi.'], 500);
        }
    }
}