<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use AdvancedModel\Traits\BaseModel;
use App\Http\Controllers\RouteController;
use App\Mail\SendEmail;
use App\Models\PasswordReset;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use SearchTable\Traits\SearchModel;
    
#[Table(key: 'username', incrementing: false, timestamps: false)]
#[Guarded(['no_key'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    use HasFactory, Notifiable, BaseModel, SearchModel;
    
    /** Settings **/
    protected static $table_fields = [
        "username" => [
            "filter" => true,
            "sort" => "asc"
        ],
        "name" => [
            "filter" => true,
        ],
        "email" => [
            "filter" => true,
        ],
        "type" => [
            "filter" => true,
            "custom-label" => "Tipo",
        ],
        "status" => [
            "filter" => true,
            "custom-value" => "getStatusText",
            "custom-filter" => "CASE WHEN enabled = 1 THEN 'attivo' ELSE 'disattivo' END",
        ],
    ];
    
    public function getTableActions($model_name, $key):array{
        return [
            User::current()->isAdmin() && User::current()->username != $this->username ? [
                "attributes" => 'hx-post="'.route($model_name.".impersonate", [$key ?? 0]).'"',
                "content" => '
                    <button class="btn btn-warning btn-sm">
                        <i class="fa-solid fa-masks-theater"></i>
                    </button>
                '
            ] : null,
            
            // Default action
            [
                "attributes" => 'hx-get="'.route($model_name.".show", [$key ?? 0]).'" hx-target="#modal .modal-content"',
                "content" => '<i class="table-search-preview fa-solid fa-pen"></i>'
            ]
        ];
    }
    
    /** Relations **/
    public static function current():?self{
        $user = Auth::user();
        
        if(!empty(session("auth.impersonate"))){
            $user = self::find(session("auth.impersonate"));
        }
        
        return $user;
    }
    
    public function password_reset(){
        return $this->hasMany(PasswordReset::class);
    }
    
    /** Scopes **/
    
    /** Methods **/
    public function getStatusText():string{
        return '<span class="text-'.($this->enabled ? "success" : "danger").'">'.($this->enabled ? "Attivo" : "Disattivo").'</span>';
    }
    
    public function getAvatar():string{
        return "https://ui-avatars.com/api/?background=random&name=".Str::slug($this->name ?? "");
    }
    
    public function belongsToGroup($groups):bool{
        $belonging_groups = array_intersect($this->groups ?? [], $groups);
        
        return count($belonging_groups) > 0;
    }
    
    public function isAdmin():bool{
        return $this->belongsToGroup(explode(",", config("auth.administrators")));
    }
    
    public function canAccessRoute(Route $route):bool{
        $can_access = true;
        
        foreach($route->action["middleware"] ?? [] as $middleware){
            if(!in_array($middleware, ["web"]) && !RouteController::passesMiddleware($this,$middleware)){
                $can_access = false;
                break;
            }
        }
        
        return $can_access;
    }
    
    public function sendResetPasswordEmail($force = false):bool{
        if($this->enabled == 0) return false;
        
        $reset_link = PasswordReset::createResetLink($this);
        
        $mail_data = [
            "receivers" => [["email" => $this->email]],
            "subject" => config("app.name").": resetta la password dell'account",
            "email" => "reset-password",
            "parameters" => [
                "user" => $this,
                "reset-link" => $reset_link->getUrl()
            ],
        ];
        
        return SendEmail::send($mail_data);
    }
    
    /** Update, delete and validation functions **/
    public function updateFromRequest(Request $request, bool $update = true):array{
        $validation = self::validate($request, $update);
        if ($validation["status"] == "danger") {
            return $validation;
        }
        
        if(!$this->incrementing && !$update){
            $request->merge(['groups' => ["local"]]);
        }
        
        // Fill the model with the request
        $this->fill($request->all());
        
        // If the model is dirty, save it
        if($this->isDirty()){
            $this->save();
        }
        
        return ["status" => "success", "message" => __('advanced-model::actions.'.($update ? "updated" : "created"), ["model" => "User"]), "model" => $this, "beforeshow" => 'modal.hide(); htmx.trigger("#page", "change");'];
    }
    
    public function deleteFromRequest():array{
        $username = $this->username;
        $this->delete();
        
        return ["status" => "success", "message" => __('advanced-model::actions.deleted', ["model" => "User"]), "beforeshow" => 'modal.hide(); htmx.trigger("#page", "change");'];
    }
    
    public static function validate(Request $request, bool $update):array{
        $validator = Validator::make($request->all(), [
            self::getModelKey() => [($update ? "prohibited" : "required"), "unique:App\Models\\".class_basename(new self).",".self::getModelKey()],
            "enabled" => ['required', Rule::in([0, 1])],
            "name" => ['required'],
            "email" => ['required', 'email:rfc,dns'],
        ]);

        if ($validator->fails()) {
            return ["status" => "danger", "message" => implode("\\n", $validator->errors()->all())];
        }

        return ["status" => "success"];
    }

    /** Attributes casting **/
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'groups' => 'array',
        ];
    }
}
