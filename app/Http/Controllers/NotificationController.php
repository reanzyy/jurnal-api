<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{

    public function index()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $notifications = $user->notifications;

            return response()->json(['message' => 'Notifications fetched successfully', 'data' => $notifications]);
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function show($id)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $notification = $user->notifications()->find($id);

            if (!$notification) {
                return response()->json(['message' => 'Notification not found'], 404);
            }

            if (!$notification->is_read) {
                $notification->is_read = true;
                $notification->save();
            }

            return response()->json(['message' => 'Notification retrieved successfully', 'data' => $notification]);
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }

    public function markAllAsRead()
    {
        if (auth()->check()) {
            $user = auth()->user();

            $notification = Notification::where('user_id', $user->id)->get();

            foreach ($notification as $notif) {
                $notif->update(['is_read' => true]);
            }

            return response()->json(['message' => 'All notifications marked as read', 'data' => $notification]);
        } else {
            return response()->json(['message' => 'User not authenticated.']);
        }
    }
}
