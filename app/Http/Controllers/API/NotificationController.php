<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use Illuminate\Http\JsonResponse;
class NotificationController extends BaseController
{
    public function index(): JsonResponse
    {
        $user = \Auth::user();
        $notifications = $user->unreadNotifications;
        return $this->sendResponse($notifications, 'Notifikasi Telah diambil.');
    }
    //read at edit request
}
