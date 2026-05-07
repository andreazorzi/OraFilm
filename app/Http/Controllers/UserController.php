<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\PasswordReset;
use AdvancedModel\Traits\AlertResponse;
use AdvancedModel\Traits\BaseController;
use SearchTable\Traits\SearchController;

class UserController extends Controller
{
    use BaseController, SearchController, AlertResponse;
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        return self::search_table($request, new User);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(){
        return $this->modal_data("user");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $response = User::createFromRequest($request);
        return $this->alert($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user){
        return $this->modal_data("user", ["user" => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user){
        $response = $user->updateFromRequest($request);
        return $this->alert($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user){
        $response = $user->deleteFromRequest();
        return $this->alert($response);
    }
    
    public function impersonate(Request $request, User $user){
        session(["auth.impersonate" => $user->username]);
        
        return response(headers: ["HX-Redirect" => route("backoffice.index")]);
    }
    
    public function stop_impersonate(Request $request){
        session()->forget("auth.impersonate");
        
        return response(headers: ["HX-Redirect" => route("backoffice.index")]);
    }
    
    public function send_reset_password(Request $request, User $user){
        $send_email = $user->sendResetPasswordEmail();
        
        return $this->alert(["status" => $send_email ? "success" : "danger", "message" => "Email ".($send_email ? "inviata" : "non inviata")]);
    }
    
    public function change_password(Request $request, PasswordReset $reset_link){
        return $this->alert($reset_link->changePassword($request));
    }
}
