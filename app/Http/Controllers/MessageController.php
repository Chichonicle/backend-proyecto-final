<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Sala;
use App\Models\Sala_user;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function createMessage(Request $request)
    {
        try {
            $user = auth()->user();
            $salas_id = $request->input('salas_id');
            $sala_user = Sala_user::query()->where('user_id', $user->id)->where('salas_id', $salas_id)->first();

            if (!$sala_user) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "You are not a member of this chat"
                    ],
                    Response::HTTP_OK
                );
            }

            $message = Mensaje::query()->create([
                'user_id' => $user->id,
                'salas_id' => $salas_id,
                'message' => $request->input('message')
            ]);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Message created succesfully",
                    "data" => $message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining a chat room"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


   

    public function deleteMessage(Request $request)
    {
        try {
            $user = auth()->user();
            $salas_id = $request->input('salas_id');
            $message = $request->input('message');

            $sala_user = Mensaje::query()->where('user_id', $user->id)->where('salas_id', $salas_id)->where('message', $message)->first();

            if (!$sala_user) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "This message does not exist"
                    ],
                    Response::HTTP_OK
                );
            }

            Mensaje::destroy($sala_user->id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Message deleted succesfully",
                    "data" => $message
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining a chat sala"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getAllMessages(Request $request)
    {
        try {
            $messages = Mensaje::query()->get();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Get message successfully",
                    "data" => $messages
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error gettin messages"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function getMessage(Request $request)
    {
        try {

            $user = auth()->user();
            $sala_id = $request->input('salas_id');
            $user_sala = Sala::query()->where('user_id', $user->id)->where('series_id', $sala_id)->first();

            if (!$user_sala) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "You are not a member of this chat"
                    ],
                    Response::HTTP_OK
                );
            }

            $salaChat = Mensaje::query()->where('salas_id', $sala_id)->get();

            if ($salaChat->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "This chat is void"
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Room chat obtained succesfully",
                    "data" =>  $salaChat
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining a chat room"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function updateMessageById(Request $request, $id)
    {
        try {
            $messages = Mensaje::query()->find($id);

            if (!$messages) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "Message doesnt exists"
                    ],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $newMessage = $request->input('message');

            if ($request->has('message')) {
                $messages->message = $newMessage;
            }

            $messages->save();

            return response()->json(
                [
                    "success" => true,
                    "message" => "Message updated"
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error updating message"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }

    public function salaChat(Request $request)
    {
        try {

            $user = auth()->user();
            $salas_id = $request->input('salas_id');
            $sala_user = Sala_user::query()->where('user_id', $user->id)->where('salas_id', $salas_id)->first();

            if (!$sala_user) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "You are not a member of this chat"
                    ],
                    Response::HTTP_OK
                );
            }

            $salaChat = Mensaje::query()->where('salas_id', $salas_id)->get();

            if ($salaChat->isEmpty()) {
                return response()->json(
                    [
                        "success" => true,
                        "message" => "This chat is void"
                    ],
                    Response::HTTP_OK
                );
            }

            return response()->json(
                [
                    "success" => true,
                    "message" => "Sala chat obtained succesfully",
                    "data" =>  $salaChat
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error obtaining a chat sala"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
}
