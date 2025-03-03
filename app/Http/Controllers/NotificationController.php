<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Récupérer toutes les notifications de l'utilisateur authentifié.
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'all' => Auth::user()->notifications,
            'read' => Auth::user()->readNotifications,
            'unread' => Auth::user()->unreadNotifications,
            'archived' => Auth::user()->notifications()->whereNotNull('archived_at')->get(),
            'unread_count' => Auth::user()->unreadNotifications->count(),
        ]);
    }

    /**
     * Supprimer une notification.
     */
    public function destroy(DatabaseNotification $notification): JsonResponse
    {
        if ($notification && $notification->notifiable_id === Auth::id()) {
            $notification->delete();
            return response()->json(['success' => 'Notification supprimée.']);
        }

        return response()->json(['fail' => 'Notification introuvable ou non autorisée.'], 403);
    }

    /**
     * Marquer une notification comme lue.
     */
    public function markAsRead(DatabaseNotification $notification): JsonResponse
    {
        if ($notification->notifiable_id === Auth::id()) {
            $notification->markAsRead();
            return response()->json(['success' => 'Notification marquée comme lue.']);
        }

        return response()->json(['fail' => 'Notification introuvable ou non autorisée.'], 403);
    }

    /**
     * Marquer toutes les notifications comme lues.
     */
    public function readAll(): JsonResponse
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json([
            'success' => "Toutes les notifications ont été marquées comme lues",
        ]);
    }

    /**
     * Archiver une notification.
     */
    public function archiveAll(): JsonResponse
    {
        Auth::user()->notifications()->update(['archived_at' => now()]);

        return response()->json(['success' => 'Notifications archivées.']);
    }
}
