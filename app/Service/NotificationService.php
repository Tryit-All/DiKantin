<?php


namespace App\Service;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;

class NotificationService
{

    private $messaging;

    public function __construct()
    {


        $serviceAccountPath = storage_path(env('FIREBASE_CREDENTIALS'));
        // dd($serviceAccountPath);


        $factory = (new Factory)
            ->withServiceAccount($serviceAccountPath);


        $this->messaging = $factory->createMessaging();
    }


    public function sendAll()
    {
        try {
            //code...
            $message = CloudMessage::new()
                ->withTarget('token', 'cnb7CuaSRVi-vAhSlXDOIo:APA91bFo0GXdDVUVZ9UARgXZ7J8Qew29pbIUm-mjtXD-NBXx_JT1dGX9hzlUB_xlwU5MQSFotVGQcHnG1gCNyocZiZU8xckk0zy3k80ihAcEugyp8Xhj9WVP1M3l--Y8eF0BojSMeJSC') // Replace with the recipient's FCM token
                ->withNotification([
                    'title' => 'coba',
                    'body' => "yaaa",
                ])
                ->withData(['type' => 'quisioner']);
            $this->messaging->send($message);
            dd("ya");
        } catch (\Throwable $th) {
            //throw $th;
            dd($th->getMessage());
        }
    }


    public function sendNotifToSpesidicToken($token, $data, $content)
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
            dd($th->getMessage());
        }
    }


}