<?php
App::uses('AppModel', 'Model');

class IapReceipt extends AppModel 
{
	public $useTable = 'iap_receipts';
    public $belongsTo = array('User');

	//-- sandbox --//
	public $url = 'https://sandbox.itunes.apple.com/verifyReceipt';

	//-- production --//
	//  public $url = 'https://buy.itunes.apple.com/verifyReceipt';

    public $pass = '483736fe0ff04c90a9081313f65b4981';

	public function verifyReceipt($data)
	{
		$data_arr = json_decode($data,TRUE);

		if(!$data_arr || !isset($data_arr['receipt-data']) || !isset($data_arr['pin']))
		{
			return array('msg'=>'error','error_msg'=>'malformed json');
		}
		
		/**
		 * 1. Check if PIN exists in the system
		 * 1.1 YES - Proceed
		 * 1.2 NO - Halt, return error
		 * 
		 */
		 
		//-- Get Client Details --//
		$client = $this->User->ClientPin->findByPin($data_arr['pin']);
		
		if($client)
		{
			App::uses('HttpSocket', 'Network/Http');
			$post_data 	= '{"receipt-data" : "' . $data_arr['receipt-data'] . '" , "password": "' . $this->pass . '"}';
			$http 		= new HttpSocket();
			$result 	= $http->post($this->url,$post_data);
			
			//-- save records --//
			$iap_data = array(
				'pin'       => $data_arr['pin'],
                'user_id'   => $client['ClientPin']['user_id'],
                'receipt'   => $data_arr['receipt-data'],
				'raw_rcv'   => $data,
				'raw_reply' => $result->body,
            );
			
			$this->save($iap_data);
			
			$result = json_decode($result->body,TRUE);

            switch($result['status']){
                case "0":
                    $return = $this->setExpiry(
                        $client['ClientPin']['user_id'],
                        $result['latest_receipt_info']['expires_date_formatted']
                    );
                    break;
                //-- Valid Receipt but expired --//
                case "21006":
                    $return = $this->setExpiry(
                        $client['ClientPin']['user_id'],
                        $result['latest_expired_receipt_info']['expires_date_formatted'],
                        'Subscription Expired'
                    );
                    break;
                default:
                    $return = array('msg'=>'error','status' => $result['status']);
                    break;

            }

		}
		else
		{
			$return = array('msg'=>'error','status' => 'Invalid PIN.');
		}
        return $return;
    }

    public function setExpiry($user_id,$expiry_date,$msg = 'success'){
        //-- Get Expiry Details --//
        $expiry = $this->User->ExpiryDate->findByUserId($user_id);

        //-- Update expiry date --//
        $newExpiryDate				= strtotime(date("Y-m-d H:i:s", strtotime($expiry_date)));
        $expiryData['ExpiryDate'] 	= array('expiry' => date('Y-m-d H:i:s', $newExpiryDate));

        $this->User->ExpiryDate->id 		= $expiry['ExpiryDate']['id'];
        $this->User->ExpiryDate->save($expiryData);

        return array('msg' => $msg);
    }

    public function checkAllReceipts(){
        $this->User->Behaviors->load('Containable');
        $this->User->bindModel(array('hasMany' => array('IapReceipt')));


        $users_receipt = $this->User->find('all',array(
            'fields' => array('User.id'),
            'contain' => array(
                'IapReceipt' => array(
                    'fields' => array('IapReceipt.id','IapReceipt.pin','IapReceipt.user_id','IapReceipt.receipt'),
                    'order' => 'IapReceipt.id DESC',
                    'limit' => 1,
                )
            )
        ));
        $ret = "";
        foreach($users_receipt as $u){
            if(empty($u['IapReceipt'])) continue;
            $data_str = '{"receipt-data" : "' . $u['IapReceipt']['0']['receipt'] . '" , "pin": "' . $u['IapReceipt']['0']['pin'] . '"}';
            $result = $this->verifyReceipt($data_str);
            $ret = json_encode($result) . "\n";
        }

        return $ret;
    }
}