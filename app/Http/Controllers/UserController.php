<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = $this->validateRegister($request);
            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => $validator->errors(),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $newUser = User::create([
                "name" => $request->input("name"),
                "surname" => $request->input("surname"),
                "username" => $request->input("username"),
                "email" => $request->input("email"),
                "password" => bcrypt($request->input("password")),

            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "User created successfully",
                    "data" => $newUser,
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating new user",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
