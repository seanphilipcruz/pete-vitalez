<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request) {
        $page = $request->get('page', 1);
        $per_page = $request->get('per_page', 5);
        $search = $request->get('search');
        $column_name = $request->get('column', 'id');
        $direction = $request->get('direction', 'asc');

        $messages = Message::whereNull('deleted_at')
            ->latest()
            ->paginate($per_page, ['*'], 'page', $page);

        if ($search) {
            $messages = Message::whereNull('deleted_at')
                ->latest()
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('content', 'like', '%'.$search.'%')
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($column_name) {
            $messages = Message::whereNull('deleted_at')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if ($search && $column_name && $direction) {
            $messages = Message::whereNull('deleted_at')
                ->where('name', 'like', '%'.$search.'%')
                ->orWhere('email', 'like', '%'.$search.'%')
                ->orWhere('content', 'like', '%'.$search.'%')
                ->orderBy($column_name, $direction)
                ->paginate($per_page, ['*'], 'page', $page);
        }

        if (sizeof($messages->items()) > 0) {
            return response()->json($messages);
        } else {
            return response()->json(false);
        }
    }

    public function show($id) {
        $message = Message::findOrFail($id);

        $message->update([
            'is_read' => 1
        ]);

        return response()->json($message);
    }
}
