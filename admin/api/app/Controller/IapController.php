<?php
App::uses('AppController', 'Controller');

class IapController extends AppController{	

    public function index(){

    }

    public function verify_receipt(){
        $this->layout = 'ajax';
        $result = '';
        if($this->request->is('post')){
            $raw_data = $this->request->input(); //get raw json post data
            $this->loadModel('IapReceipt');
            $result = $this->IapReceipt->verifyReceipt($raw_data);
        }
        $this->set(compact('result'));
    }

    public function _update_expiry(){

    }
}

/*
 json format
 {
    "receipt-data" : "(base64 encoded receipt data)",
    "pin"   : "12345"
 }
 */