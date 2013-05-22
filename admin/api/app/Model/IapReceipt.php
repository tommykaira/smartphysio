<?php
App::uses('AppModel', 'Model');

class IapReceipt extends AppModel 
{
	public $useTable = 'iap_receipts';

	//-- sandbox --//
	public $url = 'https://sandbox.itunes.apple.com/verifyReceipt';
	
	//-- production --//
	//  public $url = 'https://buy.itunes.apple.com/verifyReceipt';

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
		$User 	= ClassRegistry::init('User');
		$client = $User->ClientPin->findByPin($data_arr['pin']);
		
		if($client)
		{
			App::uses('HttpSocket', 'Network/Http');
			$post_data 	= '{"receipt-data" : "'.$data_arr['receipt-data'].'"}';
			$http 		= new HttpSocket();		
			$result 	= $http->post($this->url,$post_data);
			
			//-- save records --//
			$iap_data = array(
				'pin'       => $data_arr['pin'],
				'raw_rcv'   => $data,
				'raw_reply' => $result->body);
			
			$this->save($iap_data);
			
			$result = json_decode($result->body,TRUE);
			
			if($result['status'] == '0')
			{
				//-- Get Expiry Details --//
				$expiry = $User->ExpiryDate->findByUserId($client['ClientPin']['user_id']);

	            // Get subscription type based on receipt
                App::uses('IapProduct', 'Model');
                $iap = new IapProduct();
                $product = $iap->findByAppleProductId($result['receipt']['product_id']);

				//-- Update expiry date --//
				$newExpiryDate				= strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . "+". $product['IapProduct']['duration']);
				$expiryData['ExpiryDate'] 	= array('expiry' => date('Y-m-d H:i:s', $newExpiryDate));
	
				$User->ExpiryDate->id 		= $expiry['ExpiryDate']['id'];
				$User->ExpiryDate->save($expiryData);
	
				$return = array('msg'=>'success');
			}
			else
			{
				$return = array('msg'=>'error','status' => $result['status']);
			}
		}
		else
		{
			$return = array('msg'=>'error','status' => 'Invalid PIN.');
		}
		
		

        return $return;
    }
}