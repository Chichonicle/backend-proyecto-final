<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use App\Models\Sala;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function createMessage(Request $request)
    {
        $request->validate([
            'series_id' => 'required|string',
            'message' => 'required|string',
            'salas_id' => 'required|string',
        ]);
        
        Log::info('Create Message');
        try {
            $userId=auth()->id();
            $seriesId = $request->input('series_id');
            $message = $request->input('message');
            $salasId = $request->input('salas_id');
    
            $isMember = DB::table('salas')
                ->where('user_id', $userId)
                ->where('series_id', $seriesId)
                ->exists();

            if (!$isMember) {
                return response()->json(
                    [
                        "success" => false,
                        "message" => "User is not a member of the room"
                    ],
                    Response::HTTP_FORBIDDEN
                );
            }
    
            $newMessage = Mensaje::create([
                "user_id" => $userId,
                "salas_id" => $salasId,
                "message" => $message
            ]);
    
            return response()->json(
                [
                    "success" => true,
                    "message" => "Message created",
                    "data" => $newMessage
                ],
                Response::HTTP_CREATED
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            dd($th);
            return response()->json(
                [
                    "success" => false,
                    "message" => "Error creating message"
                ],
                Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }


   

    public function deleteMessageById(Request $request, $id)
    {
        try {
            $deleteMessage = Mensaje::destroy($id);

            return response()->json(
                [
                    "success" => true,
                    "message" => "Message deleted",
                    "data" => $deleteMessage
                ],
                Response::HTTP_OK
            );
        } catch (\Throwable $th) {
            Log::error($th->getMessage());

            return response()->json(
                [
                    "success" => false,
                    "message" => "Error deleting message"
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
}
