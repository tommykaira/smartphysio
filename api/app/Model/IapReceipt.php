<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 * @property AdminPin $AdminPin
 * @property ClientPin $ClientPin
 * @property PracticeLogo $PracticeLogo
 */
class IapReceipt extends AppModel {
    public $useTable = 'iap_receipts';

    public $url = 'https://sandbox.itunes.apple.com/verifyReceipt';  //sandbox
    //public $url = 'https://buy.itunes.apple.com/verifyReceipt'; //prod

    public function verifyReceipt($data){
        $data_arr = json_decode($data,true);
        if($data_arr){

        }else{
            return json_encode(array('error'=>'1','error_msg'=>'malformed json'));
        }

        $post_data = '{"receipt-data" : "'.$data_arr['receipt-data'].'"}';
        App::uses('HttpSocket', 'Network/Http');
        $http = new HttpSocket();
        $result = $http->post($this->url,$post_data);

        //save records
        $iap_data = array(
            'pin'       => $data_arr['pin'],
            'raw_rcv'   => $data,
            'raw_reply' => $result->body
        );
        $this->save($iap_data);
        return $result->body;
    }
}