<?php

namespace App\Http\Controllers;

use AdvancedModel\Traits\AlertResponse;
use App\Mail\SendEmail;
use App\Models\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RyanChandler\LaravelCloudflareTurnstile\Rules\Turnstile;

class FrontendController extends Controller
{
    use AlertResponse;
    
    public function send_project_request(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'phone' => ['required'],
            'request' => ['required'],
            'privacy' => ['required', 'accepted'],
            'cf-turnstile-response' => ['required', new Turnstile],
        ]);
        
        if($validator->fails()){
            return $this->sweetAlert(["status" => "danger", "message" => implode('<br>', $validator->errors()->all())]);
        }
        
        $request->merge(['type' => 'project']);
        
        $form_request = FormRequest::create($request->all());
        
        $mail_data = [
            "receivers" => [["email" => config("mail.from.address")]],
            "subject" => config("app.name").": richiesta di progetto",
            "email" => "project-request",
            "parameters" => [
                "request" => $request->all(),
            ],
        ];
        
        if(!SendEmail::send($mail_data)){
            return $this->sweetAlert(["status" => "danger", "message" => tolgee("widgets.contact-form.error", force_plain_text: true)]);
        }
        
        return $this->sweetAlert(["status" => "success", "message" => tolgee("widgets.contact-form.success", force_plain_text: true), "beforeshow" => '
            modal_your_project.hide()
            document.querySelector("#modal-your-project form").reset();
            window.turnstile.reset(".cf-turnstile");
            dataLayer.push({"event": "Interazione", "Categoria": "Contatti", "Azione": "Invio modulo", "Etichetta": "Richiesta Progetto"});
            dataLayer.push({"event": "InterazioneADS", "EtichettaConversione": ""});
        ']);
    }
    
    public function send_location_request(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'email:rfc,dns'],
            'phone' => ['required'],
            'address' => ['required'],
            'city' => ['required'],
            'province' => ['required'],
            'request' => ['required'],
            'photos' => ['required', 'array', 'min:1'],
            'photos.*' => ['image', 'max:2048'],
            'privacy' => ['required', 'accepted'],
            'cf-turnstile-response' => ['required', new Turnstile],
        ], [
            'photos.*.image' => __("validation.image", ["attribute" => __("validation.attributes.photo")." :position"]),
            'photos.*.max' => __("validation.max.file", ["attribute" => __("validation.attributes.photo")." :position"]),
        ]);
        
        if($validator->fails()){
            return $this->sweetAlert(["status" => "danger", "message" => implode('<br>', $validator->errors()->all())]);
        }
        
        $request->merge([
            'type' => 'location',
            'data' => [
                'address' => $request->address,
                'city' => $request->city,
                'province' => $request->province,
                'photos' => count($request->photos)
            ]
        ]);
        
        $form_request = FormRequest::create($request->all());
        
        $mail_data = [
            "receivers" => [["email" => config("mail.from.address")]],
            "subject" => config("app.name").": richiesta di progetto",
            "email" => "location-request",
            "parameters" => [
                "request" => $request->all(),
            ],
            "attachments" => []
        ];
        
        foreach($request->photos as $photo){
            $mail_data["attachments"][] = [
                "path" => $photo->path(),
                "name" => $photo->getClientOriginalName(),
            ];
        }
        
        if(!SendEmail::send($mail_data)){
            return $this->sweetAlert(["status" => "danger", "message" => tolgee("widgets.contact-form.error", force_plain_text: true)]);
        }
        
        return $this->sweetAlert(["status" => "success", "message" => tolgee("widgets.contact-form.success", force_plain_text: true), "beforeshow" => '
            modal_propose_location.hide()
            document.querySelector("#modal-propose-location form").reset();
            window.turnstile.reset(".cf-turnstile");
            dataLayer.push({"event": "Interazione", "Categoria": "Contatti", "Azione": "Invio modulo", "Etichetta": "Proponi Location"});
            dataLayer.push({"event": "InterazioneADS", "EtichettaConversione": ""});
        ']);
    }
}
