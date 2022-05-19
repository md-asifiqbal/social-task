<?php
namespace App\Traits;

trait Message{
    
    protected $status = false;
    protected $message = '';   
    protected $api_token = "";
    protected $data = [];
    protected $code = 200;
    

    
   
   

    /**
     * Success  Function For API
     * Set api response status as Success
     * This Method is responsible all API Response
     */
    protected function apiSuccess($message = Null, $data = Null){
        $this->status = true;
        $this->message = !empty($message) ? $message : 'Successfully';
        if( !is_null($data) ){
            $this->data = $data;
        }
    }

    /**
     * Return Default API Output Message
     * This Method for API Response
     */
    protected function apiOutput($message = Null){
        $output = ['status'    => $this->status,       'message'   => is_null($message) ? $this->message : $message];
        if( !is_null($this->api_token) && isset($this->api_token) && $this->api_token !=""){
            $output['api_token'] = $this->api_token;
        } 
        $output['data'] = $this->data;
        return response()->json($output,$this->code);
    }

    /**
     * Get Error Message
     * If Application Environtment is local then
     * Return Error Message With filename and Line Number
     * else return a Simple Error Message
     */
    protected function getError($e = null){
        if( strtolower(env('APP_ENV')) == 'local' && !empty($e) ){
            $error =  $e->getMessage() . ' On File ' . $e->getFile() . ' on line ' . $e->getLine();
            return str_replace('\\','/', $error);
        }
        return 'Something went wrong!';
    }

    

    /**
     * Get Validation Error
     */
    public function getValidationError($validator){
        if( strtolower(env('APP_ENV')) == 'local' ){
            return $validator->errors()->first();
        }
        return 'Data Validation Error';
    }
}
