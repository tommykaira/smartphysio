<?php
$apiKey = 'd0346079f1efa26f96e8e558c1e1c611-us5';
$listId = '1d89df688f';
$double_optin=true;
$send_welcome=false;
$email_type = 'html';
$email = $_POST['email'];
//replace us2 with your actual datacenter
$submit_url = "http://us5.api.mailchimp.com/1.3/?method=listSubscribe";
$data = array(
    'email_address'=>$email,
    'apikey'=>$apiKey,
    'id' => $listId,
    'double_optin' => $double_optin,
    'send_welcome' => $send_welcome,
    'email_type' => $email_type
);
$payload = json_encode($data);
 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $submit_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($payload));
 
$result = curl_exec($ch);
curl_close ($ch);
$data = json_decode($result);
if ($data->error){
    echo $data->error;
} else {
    echo "success";
}
?>