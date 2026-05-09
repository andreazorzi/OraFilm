<?php

namespace App\Http\Controllers;

use App\Models\FormRequest;
use Illuminate\Http\Request;
use AdvancedModel\Traits\AlertResponse;
use AdvancedModel\Traits\BaseController;
use SearchTable\Traits\SearchController;

class FormRequestController extends Controller
{
    use BaseController, SearchController, AlertResponse;
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        return self::search_table($request, new FormRequest);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request){
        return $this->modal_data("form-request");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request){
        $response = FormRequest::createFromRequest($request);
        return $this->alert($response);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, FormRequest $form_request){
        return $this->modal_data("form-request", ["form_request" => $form_request]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FormRequest $form_request){
        $response = $form_request->updateFromRequest($request);
        return $this->alert($response);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, FormRequest $form_request){
        $response = $form_request->deleteFromRequest();
        return $this->alert($response);
    }
}
