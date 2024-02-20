<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\NotificationResource;
class NotificationController extends BaseController
{
    public function index(): JsonResponse
    {
        $user = \Auth::user();
        $notifications = $user->unreadNotifications;
        return $this->sendResponse(NotificationResource::collection($notifications), 'Notifikasi Telah diambil.');
    }
    public function show($id): JsonResponse
    {
        $user = \Auth::user();
        $notification = $user->notifications->where('id', $id)->first();
        if ($notification) {
            $notification->markAsRead();
            return $this->sendResponse(new NotificationResource($notification), 'Notifikasi Telah dibaca.');
        }
    }
    //read at edit request
}
