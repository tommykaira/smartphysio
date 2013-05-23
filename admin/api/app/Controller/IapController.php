<?php
App::uses('AppController', 'Controller');

class IapController extends AppController
{
	
	
	
	
	
	public function index()
	{
		
	}




	/**
	 * Method that handles verifying of receipts
	 * 
	 *	json format
	 *	{
	 * 		"receipt-data" : "(base64 encoded receipt data)",
	 * 		"pin"   : "12345"
	 *  }
	 * 
	 */
	public function verify_receipt()
	{
		$this->layout 	= 'ajax';
		$result 		= '';
		
		if($this->request->is('post'))
		{
			//-- get raw json post data --//
			$raw_data 	= $this->request->input();
			
			//-- Load Model --//
			$this->loadModel('IapReceipt');
			
			$result = $this->IapReceipt->verifyReceipt($raw_data);
        }
        
        $this->set(compact('result'));
	}

    public function test(){
        $this->loadModel('IapReceipt');
        $this->IapReceipt->checkAllReceipts();
        die();
    }
}