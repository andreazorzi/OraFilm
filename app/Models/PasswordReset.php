<?php

namespace App\Models;

use AdvancedModel\Traits\BaseModel;
use Illuminate\Database\Eloquent\Attributes\Guarded;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;

#[Table(key: 'token', incrementing: false, timestamps: false)]
#[Guarded(['no_key'])]
class PasswordReset extends Model
{
    use BaseModel;
    
    /** Relations **/
    public function user(){
        return $this->belongsTo(User::class);
    }
    
    /** Methods **/
    public static function createResetLink(User $user):self{
        self::disableUserActiveLink($user);
        
        $expiration = date("Y-m-d H:i:s", strtotime("+1 day"));
        $token = self::generateToken($user, $expiration);
        
        $reset_link = self::create([
            "token" => $token,
            "user_username" => $user->username,
            "expiration" => $expiration
        ]);
        
        return $reset_link;
    }
    
    public function getUrl(){
        return route("auth.web.reset-password", [$this->token]);
    }
    
    public function changePassword(Request $request){
        if(!$this->isValid()){
            return ["status" => "danger", "message" => "Il link non è valido o è scaduto"];
        }
        
        $validator = Validator::make($request->all(), [
            "password" => ['required', Password::min(8)->letters()->mixedCase()->numbers()->symbols(), 'confirmed']
        ]);
        
        if($validator->fails()){
            return ["status" => "danger", "message" => implode('\\n', $validator->errors()->all())];
        }
        
        $this->user->update(["password" => Hash::make($request->password)]);
        
        self::disableUserActiveLink($this->user);
        
        return ["status" => "success", "message" => "Password aggiornata", "beforeshow" => '$("form")[0].reset()', "callback" => 'window.location.href = "'.route("backoffice.index").'";'];
    }
    
    public function isValid():bool{
        return strtotime($this->expiration) > time();
    }
    
    private static function generateToken(User $user, string $expiration):string{
        return hash_hmac("sha256", $user->username.$expiration, config("app.key"));
    }
    
    private static function disableUserActiveLink(User $user):void{
        $user->password_reset()->where("expiration", ">=", date("Y-m-d H:i:s"))->update(["expiration" => date("Y-m-d H:i:s")]);
    }
}
