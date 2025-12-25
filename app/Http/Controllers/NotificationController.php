<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Carbon\Carbon;

class NotificationController extends Controller
{
    public function index()
    {
        // Get real notifications from the database
        $notifications = auth()->user()->notifications;

        return Inertia::render('Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }
}
