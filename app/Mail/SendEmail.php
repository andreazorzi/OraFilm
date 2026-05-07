<?php

namespace App\Mail;

use Illuminate\Support\Facades\Mail;

class SendEmail{
    public static function send($data){
        // Change the receivers for local env
        if(config("app.env") == "local"){
            $data["receivers"] = [
                [
                    "email" => config("mail.mail-test"),
                ]
            ];
            $data["cc"] = [];
            $data["bcc"] = [];
        }
        
        $mail_data = [
            "receivers" => $data["receivers"],
            "subject" => $data["subject"],
            "reply_to" => $data["reply_to"] ?? null,
            "body" => [
                "view" => "emails.".$data["email"],
                "parameters" => $data["parameters"] ?? [],
            ],
        ];
        
        return !is_null(Mail::send(new Mailer($mail_data)));
    }
}