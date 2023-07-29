<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return response()->json(["error" => false, "message" => "success", "data" => $notifications]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "date" => "required|date",
            "title" => "required|string|max:255",
            "description" => "required|string",
        ]);

        if (auth()->check()) {
            auth()->user()->id;
            $notification = Notification::create($data);

            return response()->json(["error" => false, "message" => "Notification created successfully", "data" => $notification]);
        } else {
            return response()->json(["error" => true, "message" => "User not authenticated"]);
        }
    }

    public function show($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(["error" => true, "message" => "Notification not found"], 404);
        }

        return response()->json(["error" => false, "message" => "success", "data" => $notification]);
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            "date" => "date",
            "title" => "string|max:255",
            "description" => "string",
        ]);

        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(["error" => true, "message" => "Notification not found"], 404);
        }

        $notification->update($data);

        return response()->json(["error" => false, "message" => "Notification updated successfully", "data" => $notification]);
    }

    public function destroy($id)
    {
        $notification = Notification::find($id);

        if (!$notification) {
            return response()->json(["error" => true, "message" => "Notification not found"], 404);
        }

        $notification->delete();

        return response()->json(["error" => false, "message" => "Notification deleted successfully"]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return response()->json(['message' => 'Notification marked as read.']);
    }

    public function markAllRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['message' => 'All notifications marked as read.']);
    }
}
