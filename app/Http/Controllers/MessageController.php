<?php

namespace App\Http\Controllers;

use App\Models\Mensaje;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class MessageController extends Controller
{
    public function createMessage(Request $request)
    {
        Log::info('Create Message');
        try {
            $userId=auth()->id();
            $salasId = $request->input('salas_id');
            $message = $request->input('message');
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


        return 'Create Message';
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
}
