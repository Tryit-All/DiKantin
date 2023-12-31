<?php


namespace App\Service;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification;

class NotificationService
{

    private $messaging;

    public function __construct()
    {


        $serviceAccountPath = storage_path(env('FIREBASE_CREDENTIALS', 'app/firebase/dikantin-a64ad-firebase-adminsdk-a5ew5-fe6bd89a2a.json'));


        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath);


        $this->messaging = $factory->createMessaging();
    }




    public function sendNotifToSpesidicToken($token, Notification $data, $content)
    {
        try {
            //code...
            $message = CloudMessage::new()
                ->withTarget('token', $token) // Replace with the recipient's FCM token
                ->withNotification($data)
                ->withData($content);
            $this->messaging->send($message);
            return;
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
        }
    }


}