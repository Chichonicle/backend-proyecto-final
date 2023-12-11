<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

    private function validateRegister(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|min:3|max:60|string",
            "surname" => "required|min:3|max:200|string",
            "username" => "required|string|unique:users",
            "email" => "required|email",
            "password" => "required|min:8|max:80|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/",
        ]);
        return $validator;
    }

    public function login(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    "username" => "required|string",
                    "password" => "required|min:8|max:80|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/",
                ]
            );
            if ($validator->fails()) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Error to login",
                        "error" => $validator->errors(),
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }
            $username = $request->input("username");
            $password = $request->input("password");
            $user = User::query()->where("username", $username)->first();

            if (!$user || !Hash::check($password, $user->password)) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "Email or password are incorrect",
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            }

            $token = $user->createToken("token")->plainTextToken;

            return response()->json(
                [
                    "success" => true,
                    "message" => "User logged successfully",
                    "token" => $token,
                    "user" => $user,

                ]
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error to login",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function profile(Request $request)
    {
        try {
            $user = auth()->user();

            return response()->json(
                [
                    "success" => true,
                    "message" => "User profile",
                    "data" => $user,
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error to get user profile",
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
