<?php

namespace App\Mail;
  
use Spatie\Mjml\Mjml;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Attachment;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
  
class Mailer extends Mailable
{
    use Queueable, SerializesModels;
  
    public $mail_data;
  
    /**
     * Create a new message instance.
     */
    public function __construct($mail_data)
    {
        $this->mail_data = $mail_data;
    }
  
    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $from = $this->mail_data["sender"] ?? [
            "email" => config("mail.from.address"),
            "name" => config("mail.from.name")
        ];
        
        $to = [];
        $cc = [];
        $bcc = [];
        $reply_to = [];
        
        if(!empty($this->mail_data["reply_to"])){
            $reply_to[] = new Address($this->mail_data["reply_to"]["email"], $this->mail_data["reply_to"]["name"] ?? null);
        }
        
        foreach($this->mail_data["receivers"] ?? [] as $recipient){
            if(empty($recipient["email"])) continue;
            
            $to[] = new Address($recipient["email"], $recipient["name"] ?? null);
        }
        
        foreach($this->mail_data["cc"] ?? [] as $recipient){
            if(empty($recipient["email"])) continue;
            
            $cc[] = new Address($recipient["email"], $recipient["name"] ?? null);
        }
        
        foreach($this->mail_data["bcc"] ?? [] as $recipient){
            if(empty($recipient["email"])) continue;
            
            $bcc[] = new Address($recipient["email"], $recipient["name"] ?? null);
        }
        
        return new Envelope(
            from: new Address($from["email"], $from["name"] ?? null),
            to: $to,
            cc: $cc,
            bcc: $bcc,
            replyTo: $reply_to,
            subject: $this->mail_data["subject"] ?? "",
        );
    }
    
    public function build()
    {
        $mjml = view($this->mail_data["body"]["view"], ["parameters" => $this->mail_data["body"]["parameters"] ?? null])->render();
        
        return $this->html(Mjml::new()->toHtml($mjml));
    }
  
    /**
     * Get the attachments for the message.
     *
     * @return array

     */
    public function attachments(): array
    {
        $attachments = [];
        
        foreach($this->mail_data["attachments"] ?? [] as $attachment){
            $file = Attachment::fromPath($attachment["path"]);
            if(!empty($attachment["name"])) $file->as($attachment["name"]);
            
            $attachments[] = $file;
        }
        
        return $attachments;
    }
}