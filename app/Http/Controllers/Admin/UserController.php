<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'role'     => 'required|in:admin,dosen,mahasiswa',
            // Polymorphic validation
            'nim'      => 'required_if:role,mahasiswa|unique:mahasiswa,nim',
            'nidn'     => 'required_if:role,dosen|unique:dosen,nidn',
            'prodi_id' => 'required_if:role,mahasiswa,dosen|exists:prodi,id',
            'angkatan' => 'required_if:role,mahasiswa|numeric',
        ]);

        try {
            $user = $this->userService->createUser($validated);
            return response()->json(['message' => 'User created', 'data' => $user], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        }
    }
}
