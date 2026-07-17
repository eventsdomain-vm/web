<?php

namespace App\Http\Controllers;

use App\Rules\ValidGstin;
use App\Services\Gst\GstVerifier;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class GstCaptchaController extends Controller
{
    public function captcha(GstVerifier $verifier): JsonResponse
    {
        $data = $verifier->fetchCaptchaData();

        return response()->json($data);
    }

    public function verify(Request $request, GstVerifier $verifier): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'gstin' => ['required', 'string', 'size:15', new ValidGstin],
            'session_id' => ['required', 'string', 'uuid'],
            'captcha' => ['required', 'string', 'max:20'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'verified' => false,
                'errors' => $validator->errors(),
            ], 422);
        }

        $gstin = strtoupper(trim($request->input('gstin')));
        $sessionId = $request->input('session_id');
        $captcha = $request->input('captcha');

        $result = $verifier->verifyWithCaptcha($gstin, $sessionId, $captcha);

        if ($result['verified'] && $user = Auth::user()) {
            $profile = $user->profile()->firstOrNew([]);
            if (! $profile->exists && ! $profile->role_type) {
                $profile->role_type = $user->role_name ?: 'sponsor';
            }
            $profile->fill([
                'gst_number' => $gstin,
                'gst_verified' => true,
                'gst_verified_at' => now(),
                'gst_legal_name' => $result['legal_name'],
            ]);
            $user->profile()->save($profile);
        }

        return response()->json($result);
    }
}
