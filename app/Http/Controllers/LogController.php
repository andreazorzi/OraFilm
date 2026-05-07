<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AdvancedModel\Traits\AlertResponse;
use Illuminate\Support\Facades\Storage;

class LogController extends Controller
{
    use AlertResponse;
    
    public function clear(Request $request){
        Storage::disk('logs')->delete("laravel.log");
        
        return $this->alert(["status" => "success", "message" => "Logs cleared successfully", "beforeshow" => '$("#logs").html("");']);
    }
}