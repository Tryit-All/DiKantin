<?php

namespace App\Http\Controllers;

use App\Service\NotificationService;
use Illuminate\Http\Request;

class NotificationCotroller extends Controller
{
    //
    private NotificationService $service;
    public function __construct()
    {
        $this->service = new NotificationService();
    }

 
}
