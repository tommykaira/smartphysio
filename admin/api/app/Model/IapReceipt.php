<?php
App::uses('AppModel', 'Model');
class IapReceipt extends AppModel {
    public $useTable = 'iap_receipts';

    public $url = 'https://sandbox.itunes.apple.com/verifyReceipt';  //sandbox
    //public $url = 'https://buy.itunes.apple.com/verifyReceipt'; //prod

    public function verifyReceipt($data){
        $data_arr = json_decode($data,true);
        if(!$data_arr){
            return array('msg'=>'error','error_msg'=>'malformed json');
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
        $result = json_decode($result->body,true);
        if($result['status'] == '0'){
            //update expiry date
            $return = array('msg'=>'success');
        }else{
            $return = array('msg'=>'error','status' => $result['status']);
        }

        return $return;
    }
}