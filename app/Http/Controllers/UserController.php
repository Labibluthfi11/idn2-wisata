<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function getUser(Request $request): JsonResponse
    {   
        $user = $request->user();
        $token = $request->bearerToken();
    
        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized'
            ], 401);
        }
    
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'token' => $token
        ]);
    }
    
}