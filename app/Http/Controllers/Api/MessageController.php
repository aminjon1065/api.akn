<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use http\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function newMessage(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'title' => 'required|string|min:4',
            'description' => 'required',
            'files_link' => 'nullable',
            'user_id' => 'required',
            'from' => 'required',
            'to' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'data' => $validator->messages()
            ], 500);
        }
        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'files_link' => $request->files_link,
            'opened' => $request->opened,
            'user_id' => auth()->id(),
            'from' => $request->from,
            'to' => $request->to,
        ];
        $message = \App\Models\Message::create($data);
        return response()->json([
            'success' => true,
            'data' => $message
        ]);
    }
}
