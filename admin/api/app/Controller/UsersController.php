<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController{
	public $components = array('RequestHandler','FileUpload','MailSmarty');
	
	private $_from = 'support@smartphysio.com.au';
	private $_to = null;
	private $_subject = 'Lost Password';
	private $_message = 'null';
	private $_clientName = null;
        private $_clientPIN = null;
        private $_adminPIN = null;
        private $_firstName = null;
        private $_lastName = null;
        
        
	
	public function beforeRender(){
		$this->layout = 'ajax';
	}
	public function loginPractice($pin = NULL, $pinValue = NULL){
		$success = false;
		if($this->request->isPost()) {
			$pinValue = $_POST['pinValue'];
		}
		$this->User->AdminPin->recursive = 2;
		$this->User->AdminPin->contain(array(
			'User' => array(
				'ClientPin',
				'PracticeLogo' => array('ColorScheme')
				)
		));		
		
		$admin = $this->User->AdminPin->findByPin($pinValue);
		if ($admin) {
			$expiry = $this->User->ExpiryDate->findByUserId($admin['User']['id']);
			$success = true;
			
			$address = $admin['User']['street'].';;'.$admin['User']['suburb'].';;'.$admin['User']['state'].';;'.$admin['User']['postcode'].';;'.$admin['User']['country'];
			
			$data = array(
				'User' => array(					
					'id' => $admin['User']['id'],
					'PracticName' => $admin['User']['practice_name'],
					'Services' => $admin['User']['services'],
					'FirstName' => $admin['User']['first_name'],
					'LastName' => $admin['User']['last_name'],
					'Telephone' => $admin['User']['number'],
					'Email' => $admin['User']['email'],
					'Website' => $admin['User']['website'],
					'Street' => $admin['User']['street'],
					'Country' => $admin['User']['country'],
					'State' => $admin['User']['state'],
					'Suburb' => $admin['User']['suburb'],
					'PostalCode' => $admin['User']['postcode'],
					'Address' => $address,
					'AdminPin' => $admin['AdminPin']['pin'],
					'ClientPin' => $admin['User']['ClientPin'][0]['pin'],
					'PracticeLogo' => $admin['User']['PracticeLogo'][0]['logo'],
					'ColorScheme' => array(
						'id' => $admin['User']['PracticeLogo'][0]['ColorScheme']['id'],
						'name' => $admin['User']['PracticeLogo'][0]['ColorScheme']['name'],
						'color' => $admin['User']['PracticeLogo'][0]['ColorScheme']['color']
					),
					'Expiry' => ($expiry) ? $expiry['ExpiryDate']['expiry'] : $admin['User']['created'],
					'error' => 0,
					'message' => 'success'
				)
			);
		}
		else {
			$data = array(
				'User' => array(
					'error' => 1,
					'message' => 'No Practice found.'));
		}
		
		if(is_null($pinValue)){
			$data = array(
				'User' => array(
					'error' => 1,
					'message' => 'PIN is empty.'));
		}
		
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
		
	}
	
	public function loginPatient($pin = null, $pinValue = null){
		$success = false;
		if($this->request->isPost()) {
			$pinValue = $_POST['pinValue'];
		}
		$this->User->ClientPin->recursive = 2;
		$this->User->ClientPin->contain(array(
			'User' => array(
				'AdminPin',
				'PracticeLogo' => array('ColorScheme')
				)
		));
		$client = $this->User->ClientPin->findByPin($pinValue);
		if ($client){
			$expiry = $this->User->ExpiryDate->findByUserId($client['User']['id']);
			$success = true;
			
			$address = $client['User']['street'].';;'.$client['User']['suburb'].';;'.$client['User']['state'].';;'.$client['User']['postcode'].';;'.$client['User']['country'];
			
			$data = array(
				'User' => array(
					'id' => $client['User']['id'],
					'PracticName' => $client['User']['practice_name'],
					'Services' => $client['User']['services'],
					'FirstName' => $client['User']['first_name'],
					'LastName' => $client['User']['last_name'],
					'Telephone' => $client['User']['number'],
					'Email' => $client['User']['email'],
					'Website' => $client['User']['website'],
					'Street' => $client['User']['street'],
					'Country' => $client['User']['country'],
					'State' => $client['User']['state'],
					'Suburb' => $client['User']['suburb'],
					'PostalCode' => $client['User']['postcode'],
					'Address' => $address,
					'AdminPin' => $client['User']['AdminPin'],
					'PracticeLogo' => $client['User']['PracticeLogo'][0]['logo'],
					'ColorScheme' => array(
						'id' => $client['User']['PracticeLogo'][0]['ColorScheme']['id'],
						'name' => $client['User']['PracticeLogo'][0]['ColorScheme']['name'],
						'color' => $client['User']['PracticeLogo'][0]['ColorScheme']['color']
					),
					'Expiry' => ($expiry) ? $expiry['ExpiryDate']['expiry'] : $client['User']['created'],
					'error' => 0,
					'message' => 'success'
				)
			);
		}
		else {
			$data = array('User' => array('error' => 1, 'message' => 'No Patient found.'));
		}
		
		if(is_null($pinValue)){
			$data = array(
				'User' => array(
					'error' => 1,
					'message' => 'PIN is empty.'));
		}
		
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function lostPinPractice($email = null, $emailValue = null){
		$success = false;
		
		if($this->request->isPost()) {
			$emailValue = $_POST['emailValue'];
		} debug($_POST);
		$user = $this->User->findByEmail($emailValue);
		if($user){
			$success = true;
			$data = array(
				'User' => array('error' => 0,'message' => 'success')
			);
			$admin = $this->User->AdminPin->findById($user['User']['id']);
			$dataSend = array(
				'practice_pin' => $admin['AdminPin']['pin'],
                'patient_pin' => $client['ClientPin']['pin'],
                 'FirstName' => $client['User']['first_name'],
		'LastName' => $client['User']['last_name']
			);
			//$this->MailSmarty->send($user['User']['email'], $dataSend);
			$fullname = $user['User']['first_name'].' '.$user['User']['last_name'];
                        //$this->MailSmarty->sendPassword($user['User']['email'],$admin['AdminPin']['pin'], $client['ClientPin']['pin'],$fullname);
                        $this->sendPassword($user['User']['email'],$user['AdminPin'][0]['pin'], $user['ClientPin'][0]['pin'],$fullname);
		}
		else{
			$data = array(
				'User' => array('error' => 1, 'message' => 'Email not existed in the database.')
			);
		}
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function lostPinPatient($email = null, $emailValue = null){
		if($this->request->isPost()) {
			$emailValue = $_POST['emailValue'];
		}
		$user = $this->User->findByEmail($emailValue);
		if($user){
			$success = true;
			$data = array(
				'User' => array('error' => 0,'message' => 'success')
			);
			$client = $this->User->ClientPin->findById($user['User']['id']);
			$dataSend = array(
				'practice_pin' => $admin['AdminPin']['pin'],
                'patient_pin' => $client['ClientPin']['pin'],
                 'FirstName' => $client['User']['first_name'],
		'LastName' => $client['User']['last_name']
			);
			//$this->Mail->MailSmarty($user['User']['email'], $dataSend);
			$fullname = $user['User']['first_name'].' '.$user['User']['last_name'];
                        //$this->MailSmarty->sendPassword($user['User']['email'],$admin['AdminPin']['pin'],$client['ClientPin']['pin'],$fullname);
                        $this->sendPassword($user['User']['email'],$user['AdminPin'][0]['pin'],$user['ClientPin'][0]['pin'],$fullname);
		}
		else{
			$data = array(
				'User' => array('error' => 1, 'message' => 'Email not existed in the database.')
			);
		}
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function editPractice($id = null, $idValue = null){
		if($this->request->isPost()){
			$idValue = $_POST['idValue'];
			
			if(isset($_POST['practiceNameValue'])){
				$data['User']['practice_name'] = $_POST['practiceNameValue'];
			}
			if(isset($_POST['firstNameValue'])){
				$data['User']['first_name'] = $_POST['firstNameValue'];
			}
			if(isset($_POST['lastNameValue'])){
				$data['User']['last_name'] = $_POST['lastNameValue'];
			}
			if(isset($_POST['phoneNumberValue'])){
				$data['User']['number'] = $_POST['phoneNumberValue'];
			}
			if(isset($_POST['websiteValue'])){
				$data['User']['website'] = $_POST['websiteValue'];
			}
			if(isset($_POST['servicesValue'])){
				$data['User']['services'] = $_POST['servicesValue'];
			}
			if(isset($_POST['addressValue'])){
				$data['User']['street'] = $_POST['addressValue'];
			}
			if(isset($_POST['streetValue'])){
				$data['User']['street'] = $_POST['streetValue'];
			}
			if(isset($_POST['postalValue'])){
				$data['User']['postcode'] = $_POST['postalValue'];
			}
			if(isset($_POST['countryValue'])){
				$data['User']['country'] = $_POST['countryValue'];
			}
			if(isset($_POST['stateValue'])){
				$data['User']['state'] = $_POST['stateValue'];
			}
			if(isset($_POST['suburbValue'])){
				$data['User']['suburb'] = $_POST['suburbValue'];
			}
			if(isset($_POST['emailValue'])){
				$data['User']['email'] = $_POST['emailValue'];
			}
		}
		
		$this->User->id = $idValue;
			
		$this->User->set($data);
		if($this->User->validates()){
			if ($this->User->save()) {
				$data = array(
					'User' => array('error' => 0, 'message' => 'success')
				);
			}
		}
		else{
			$data = array(
					'User' => array('error' => 1, 'message' => $this->User->validationErrors)
				);
		}
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function editLogo($id = null, $idValue = null){
		if($this->request->isPost()){
			$idValue = $_POST['idValue'];
		}
		$newLogo = $this->FileUpload->doUpload($_FILES['logoValue']);
		if($newLogo != -1){			
			$logo = $this->User->PracticeLogo->findByUserId($idValue);
			if($logo){
				$this->User->PracticeLogo->id = $logo['PracticeLogo']['id'];
				$logoData['PracticeLogo'] = array(
					'logo' => $newLogo
				);
				$this->User->PracticeLogo->set($logoData);
				if($this->User->PracticeLogo->save()){
					$data = array(
						'Logo' => array('error' => 0, 'message' => $newLogo)
					);
				}
			}
			else{
				$data = array(
						'Logo' => array('error' => 1, 'message' => 'Practice cant be found')
				);
			}
		}
		else{
			$data = array(
				'Logo' => array('error' => 1,'message' => 'error')
			);
		}
		
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function editColorScheme($id = null, $idValue = null){
		if($this->request->isPost()){
			$idValue = $_POST['idValue'];
		}
		$logo = $this->User->PracticeLogo->findByUserId($idValue);
		if($logo){
			$this->User->PracticeLogo->id = $logo['PracticeLogo']['id'];
			$logoData['PracticeLogo'] = array(
				'color_scheme_id' => $_POST['colorSchemeValue']
			);
			$this->User->PracticeLogo->set($logoData);
			if($this->User->PracticeLogo->save()){
				$data = array(
					'Logo' => array('error' => 0,'message' => 'success')
				);
			}
		}
		else{
			$data = array(
				'Logo' => array('error' => 1,'message' => 'error')
			);
		}
		
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function register($practiceName  = NULL, $practiceNameValue  = NULL,
							 $email  = NULL, $emailValue  = NULL,
							 $firstName  = NULL, $firstNameValue  = NULL,
							 $lastName  = NULL, $lastNameValue  = NULL,
							 $phoneNumber  = NULL, $phoneNumberValue  = NULL,
							 $logo  = NULL, $logoValue  = NULL,
							 $color  = NULL, $colorValue  = NULL,
							 $adminPin  = NULL, $adminPinValue  = NULL,
							 $clientPin  = NULL, $clientPinValue  = NULL,
							 $website = NULL, $websiteValue = NULL,
							 $services = NULL, $servicesValue = NULL,
							 $address = NULL, $addressValue = NULL){
							 	
		if($this->request->isPost()){
			$practiceNameValue = $_POST['practiceNameValue'];
			$emailValue = $_POST['emailValue'];
			$firstNameValue = $_POST['firstNameValue'];
			$lastNameValue = $_POST['lastNameValue'];
			$phoneNumberValue = $_POST['phoneNumberValue'];
			$logoValue = $_FILES['logoValue'];
                        //$logoValue = $_POST['logoValue'];
			$colorValue = $_POST['colorValue'];
			$adminPinValue = $_POST['adminPinValue'];
			$clientPinValue = $_POST['clientPinValue'];
			$websiteValue = $_POST['websiteValue'];
			$servicesValue = $_POST['servicesValue'];
			$addressValue = $_POST['addressValue'];
			$streetValue = $_POST['streetValue'];
			$suburbValue = $_POST['suburbValue'];
			$stateValue = $_POST['stateValue'];
			$countryValue = $_POST['countryValue'];
			$postalValue = $_POST['postalValue'];
			
			
			echo "Practice Name: $practiceNameValue";
			echo "Email: $emailValue";
			echo "FirstName: $firstNameValue";
			echo "LastName: $lastNameValue";
			echo "Phone: $phoneNumberValue";
			echo "Logo: $logoValue";
			echo "Color: $colorValue";
			echo "Admin PIN: $adminPinValue";
			echo "Client PIN: $clientPinValue";
			echo "Website: $websiteValue";
			echo "Service: $servicesValue";
			echo "Address: $addressValue";
			echo "Street: $streetValue";
			echo "Suburb: $suburbValue";
			echo "State: $stateValue";
			echo "Country: $countryValue";
			echo "Postal: $postalValue";
		}
		
		if (is_null($practiceNameValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Practice name is empty.')
			);
			
			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}		
		
		if (is_null($firstNameValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'First name is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		if (is_null($lastNameValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Last name is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		if (is_null($phoneNumberValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Phone is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		if (is_null($logoValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Logo is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		if (is_null($colorValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Color is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		/*if (is_null($adminPinValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Practice PIN is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		
		// check if pin is already exist
		$checkAdmin = $this->User->AdminPin->findAllByPin($adminPinValue);
		if (count($checkAdmin) > 0) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Practice PIN already exist.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
				*/
		/*if (is_null($clientPinValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Patient is empty.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}		
		// check if pin is already exist
		$checkClient = $this->User->AdminPin->findAllByPin($clientPinValue);
		if (count($checkClient) > 0) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Patient PIN already exist.')
			);

			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		*/
		$success = false;
		if ($this->User->findByEmail($emailValue)) {
			$data = array(
				'User' => array('error' => 1, 'message' => 'Email already exist.')
			);
			
			$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
			$xmlString = $xmlObject->asXML();
			echo $xmlString;
			return true;
		}
		
		$user['User'] = array(
			'practice_name' => $practiceNameValue,
			'email' => $emailValue,
			'first_name' => $firstNameValue,
			'last_name' => $lastNameValue,
			'number' => $phoneNumberValue,
			'website' => $websiteValue,
			'services' => $servicesValue,
			'street' => $streetValue,
			'suburb' => $suburbValue,
			'state' => $stateValue,
			'postcode' => $postalValue,
			'country' => $countryValue
		);
		$this->User->set($user);
		if($this->User->validates()){
			if ($this->User->save()) {
				$userId = $this->User->getLastInsertId();
				// for admin pin
				$tmpAdminPin = null;
				do {
					$tmpAdminPin = rand(1,9).rand(0,9).rand(0,9).rand(0,9);
					$checkAdmin = $this->User->AdminPin->findAllByPin($tmpAdminPin);
				}while (count($checkAdmin) != 0);
				
				$admin['AdminPin'] = array(
					'user_id' => $userId,
					'pin' => $tmpAdminPin
				);
				$this->User->AdminPin->save($admin);
				
				// for client pin
				$tmpClientPin = null;
				do {
					$tmpClientPin = rand(1,9).rand(0,9).rand(0,9).rand(0,9);
					$checkClient = $this->User->AdminPin->findAllByPin($tmpClientPin);
				}while (count($checkClient) != 0);
				
				$client['ClientPin'] = array(
					'user_id' => $userId,
					'pin' => $tmpClientPin
				);
				$this->User->ClientPin->save($client);
				
				// for logo and color
				$newLogo = $this->FileUpload->doUpload($_FILES['logoValue']);
				$logotmp['PracticeLogo'] = array(
					'user_id' => $userId,
					'logo' => $newLogo,
					'color_scheme_id' => $colorValue
				);
				$this->User->PracticeLogo->save($logotmp);
				
				// subscribe to 1month
				// $dateToOneMonth = strtotime(date("Y-m-d", strtotime(date('Y-m-d'))) . "+1 month");
				
				//-- Modified to set the expiry date to yesterday --//

				$dateToYesterday		  = strtotime( '-1 days' );

				$expiryData['ExpiryDate'] = array(
					'user_id' => $userId,
					'expiry' => date('Y-m-d H:i:s', $dateToYesterday)
				);
				$this->User->ExpiryDate->save($expiryData);
				
				$success = true;
				$data = array(
					'User' => array(
						'id' => $userId,
						'PracticName' => $practiceNameValue,
						'Services' => $servicesValue,
						'FirstName' => $firstNameValue,
						'LastName' => $lastNameValue,
						'Telephone' => $phoneNumberValue,
						'Email' => $emailValue,
						'Website' => $websiteValue,
						'Address' => $addressValue,
						'Street' => $streetValue,
						'Suburb' => $suburbValue,
						'State' => $stateValue,
						'PostalCode' => $postalValue,
						'Country' => $countryValue,
						'AdminPin' => $tmpAdminPin,
						'ClientPin' => $tmpClientPin,
						'PracticeLogo' => $newLogo,
						'ColorScheme' => array(
							'id' => $this->User->PracticeLogo->getLastInsertID(),
							'color' => $colorValue
						),
						'error' => 0,
						'message' => 'success'
				));
				
				//$this->MailSmarty->send($user['User']['email'], $data,'register');
				$this->sendRegistration($user['User']['email'],$user['User']['first_name'],$user['User']['last_name'],$tmpAdminPin,$tmpClientPin);
			}	
			else{
				$data = array(
					'User' => array('error' => 1, 'message' => 'Something wrong practice cant be save.')
				);
			}
		}
		else {
			$data = array(
					'User' => array('error' => 1, 'message' => $this->User->validationErrors)
				);
		}
		
		
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
/**
 * expiry set 
 */
	public function saveExpiry($pin= null,$expiry=null)
	{
		$pin = $_POST['pinValue'];
		$expiry = $_POST['expiryValue'];
		$pins = $this->User->AdminPin->findByPin($pin);
		$checkExisting = $this->User->ExpiryDate->findByUserId($pins['User']['id']);
		
		if ($checkExisting) {
			$this->User->ExpiryDate->id = $checkExisting['ExpiryDate']['id'];
		}
		else {
			$this->User->ExpiryDate->create();
		}
		
		$dateToSave['ExpiryDate'] = array(
			'user_id' => $pins['User']['id'],
			'expiry' => $expiry
		);
		$this->User->ExpiryDate->save($dateToSave);
		
		$data = array(
				'User' => array('error' => 0, 'message' => 'Success', 'expiry' => $expiry)
			);
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
		$this->render('register');
	}
	
/**
 * expiry get 
 */
	public function getExpiry($pin=null)
	{
		$pin = $_POST['pinValue'];
		$pins = $this->User->AdminPin->findByPin($pin);
		$expiry = $this->User->ExpiryDate->findByUserId($pins['User']['id']);
		
		$data = array(
				'User' => array('error' => 0, 'message' => 'Success', 'expiry' => $expiry['ExpiryDate']['expiry'])
			);
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
		$this->render('register');
	}
	
	public function testUpload(){
		/*$newLogo = $this->FileUpload->doUpload($_FILES['logoValue']);
		$data = array(
			'Test' => array('message' => $newLogo)
		);
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;*/
		mail('','subject', 'messages');
	}
	
	
	public function to($to){
		$this->_to = $to;
	}
	
	public function sendPassword($to,$practicePIN,$patientPIN,$clientName){
	
	    if($to){
		$this->_to = $to;
            }	
            
            if($practicePIN){
                $this->_adminPIN = $practicePIN;
            }
            
            if($patientPIN){
                $this->_clientPIN = $patientPIN;
            }
            
            if($clientName){
                $this->_clientName = $clientName;
            }
            
            $rangePIN1 = substr($this->_adminPIN,0,1);
			$rangePIN2 = substr($this->_adminPIN,1,1);
            $rangePIN3 = substr($this->_adminPIN,2,1);
            $rangePIN4 = substr($this->_adminPIN,3,1);
            
            $Pin1 = substr($this->_clientPIN, 0, 1);
            $Pin2 = substr($this->_clientPIN, 1, 1);
            $Pin3 = substr($this->_clientPIN, 2, 1);
            $Pin4 = substr($this->_clientPIN, 3, 1);
                
			$headers  = "From: " . $this->_from . "\r\n";
			$headers .= "Reply-To: ". $this->_to . "\r\n";
			$headers .= 'MIME-Version: 1.0' . "\r\n";
			$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			
			$message  = '<html><head>';
			$message  .= '<style type="text/css" media="screen">';
			$message  .= "body
			{
				background-image:url('http://118.127.38.26/~smartphy/admin/app/webroot/paper.jpg');
			}";
			
			$message .='
					td
					{
						color: #3a3a3a;
						text-shadow: 0 2px rgba(255,255,255,.75);
					}
					
					.bar
					{
						color: #ffffff;
						text-shadow: 0px 1px 4px rgba(23,23,23,0.75);
					}
						
					</style>
					
					<title>Smart Physio</title></head>
					
					<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
					<table width="768" height="986" border="0" align="center">
						<tr>
							<td width="47"><!--1st Column--></td>
							<td width="652"> <!-- 2nd Column -->
							<table border="0" width="674" height="930">
								<tr>
									<td height="213">
										<table align="center" width="674" border="0">
											<tr>
												<td height="100"></td>
												<td height="100"width="189"><img src="http://118.127.38.26/~smartphy/admin/app/webroot/logo_medium@2x.png" height="120"/></td><td height="100"></td>
											</tr>
										</table>
										
										<table width="467" height="58" border="0" align="center" style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center" position="absolute">
											<tr><td width="53" height="40"></td></tr>
											<tr>
												<td width="53" height="54"> Hi '.$this->_clientName.',</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td height="495">
										<table align="center" height="495" width="674" " >
											<tr>
												<td>
													<table width="584" height="78" border="0" align="center" style="font-size:22px; font-family:Arial, Helvetica, sans-serif; text-align:center">
														<tr>
																<td>Thanks for signing up and using Smart Physio.<br>Here are your PIN Codes for the App.<br>Please make sure you keep your Administration PIN Code safe, to ensure the security of your App.</td>
														</tr> 
													</table>
												
													<table width="240" height="66" border="0" align="center" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center" position="absolute">
														<tr>
															<td height="20"></td>
														</tr>
														<tr>
															<td align="center" bgcolor="#666666"><font class="bar">Important Account Information </font></td>
														</tr>
													</table>
													
													<table width="240" height="66" border="0" align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center" position="absolute">
														<tr>
															<td height="20"></td>
														</tr>
														
														<tr>
															<td align="center">Your administration PIN code</td>
														</tr>
														<tr>
															<td height="20"></td>
														</tr> 
													</table>
													
													<table width="244" height="75" border="0" align="center" background="http://118.127.38.26/~smartphy/admin/app/webroot/pincode_back.png"  style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center">
														<tr>
															<td align="center" width="53" height="54">'.$rangePIN1.'</td>
															<td align="center" width="9"></td>
															<td align="center" width="38">'.$rangePIN2.'</td>
															<td align="center" width="17"></td>
															<td align="center" width="30">'.$rangePIN3.'</td>
															<td align="center" width="7"></td>
															<td align="center" width="60">'.$rangePIN4.'</td>
														</tr>
													</table>
													
													<table width="240" height="66" border="0" align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center">
														<tr><td height="20"></td></tr>
														<tr>
															<td align="center">Your Patient PIN code</td>
														</tr> 
														<tr>
															<td height="20"></td>
														</tr> 
													</table>
													
													<table width="244" height="75" border="0" align="center"  background="http://118.127.38.26/~smartphy/admin/app/webroot/pincode_back.png" style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center">
														<tr>
															<td align="center" width="53" height="54">'.$Pin1.'</td>
															<td align="center" width="9"></td>
															<td align="center" width="38">'.$Pin2.'</td>
															<td align="center" width="17"></td>
															<td align="center" width="30">'.$Pin3.'</td>
															<td align="center" width="7"></td>
															<td align="center" width="60">'.$Pin4.'</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td height="64">
										<table width="240" height="66" border="0" align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center" position="absolute">
											<tr><td height="20"></td></tr>
										</table>
										<table width="467" height="58" align="center" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; text-align:center" position="absolute">
											<tr>
												<td width="53" height="54">
													Get in touch with us at <a href="mailto:hello@smartphysio.com.au"> hello@smartphysio.com.au</a> <br>ACN 162 610 166. Â© 2013 Smart Physio App Pty Ltd | All Rights Reserved
												</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td><!-- Footer --></td>
								</tr>
							</table>
						</td>
						
						<td width="47"> <!--3rd Column--></td>
					</tr>
					</table>
					</body>
					</html>';
			    $this->_subject = 'Smart Physio - Lost Password';
                
                mail($this->_to, $this->_subject, $message, $headers);
       }
       
   public function retreiveAllEmail(){
   
   		echo json_encode($this->User->find('all'));
   		
   		/*
   		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
		*/
   }
        
   public function sendRegistration($to,$firstNameValue,$lastNameValue,$tmpAdminPin,$tmpClientPin){
   		
   	   if($to){
		$this->_to = $to;
           }
                
           if($tmpAdminPin){
                $this->_adminPIN = $tmpAdminPin;
            }
            
            if($tmpClientPin){
                $this->_clientPIN = $tmpClientPin;
            }
                        
            if($firstNameValue){
                $this->_firstName = $firstNameValue;
            }
            
            if($lastNameValue){
                $this->_lastName = $lastNameValue;
            }  
                
                $rangePIN1 = substr($this->_adminPIN,0,1);
		$rangePIN2 = substr($this->_adminPIN,1,1);
                $rangePIN3 = substr($this->_adminPIN,2,1);
                $rangePIN4 = substr($this->_adminPIN,3,1);
                
                $Pin1 = substr($this->_clientPIN, 0, 1);
                $Pin2 = substr($this->_clientPIN, 1, 1);
                $Pin3 = substr($this->_clientPIN, 2, 1);
                $Pin4 = substr($this->_clientPIN, 3, 1);
                
                $this->_subject = 'Smart Physio - Registration Complete';
                
                $headers  = "From: " . $this->_from . "\r\n";
                $headers .= "Reply-To: ". $this->_to . "\r\n";
				$headers .= 'MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                
				$message  = '<html><head>';
			$message  .= '<style type="text/css" media="screen">';
			$message  .= "body
			{
				background-image:url('http://118.127.38.26/~smartphy/admin/app/webroot/paper.jpg');
			}";
			
			$message .='
					td
					{
						color: #3a3a3a;
						text-shadow: 0 2px rgba(255,255,255,.75);
					}
					
					.bar
					{
						color: #ffffff;
						text-shadow: 0px 1px 4px rgba(23,23,23,0.75);
					}
						
					</style>
					
					<title>Smart Physio</title></head>
					
					<body leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
					<table width="768" height="986" border="0" align="center">
						<tr>
							<td width="47"><!--1st Column--></td>
							<td width="652"> <!-- 2nd Column -->
							<table border="0" width="674" height="930">
								<tr>
									<td height="213">
										<table align="center" width="674" border="0">
											<tr>
												<td height="100"></td>
												<td height="100"width="189"><img src="http://118.127.38.26/~smartphy/admin/app/webroot/logo_medium@2x.png" height="120"/></td><td height="100"></td>
											</tr>
										</table>
										
										<table width="467" height="58" border="0" align="center" style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center" position="absolute">
											<tr><td width="53" height="40"></td></tr>
											<tr>
												<td width="53" height="54"> Hi '.$this->_firstName .' '. $this->_lastName.',</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td height="495">
										<table align="center" height="495" width="674" " >
											<tr>
												<td>
													<table width="584" height="78" border="0" align="center" style="font-size:22px; font-family:Arial, Helvetica, sans-serif; text-align:center">
														<tr>
																<td>Thanks for signing up and using Smart Physio.<br>Here are your PIN Codes for the App.<br>Please make sure you keep your Administration PIN Code safe, to ensure the security of your App.</td>
														</tr> 
													</table>
												
													<table width="240" height="66" border="0" align="center" style="font-size:14px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center" position="absolute">
														<tr>
															<td height="20"></td>
														</tr>
														<tr>
															<td align="center" bgcolor="#666666"><font class="bar">Important Account Information </font></td>
														</tr>
													</table>
													
													<table width="240" height="66" border="0" align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center" position="absolute">
														<tr>
															<td height="20"></td>
														</tr>
														
														<tr>
															<td align="center">Your administration PIN code</td>
														</tr>
														<tr>
															<td height="20"></td>
														</tr> 
													</table>
													
													<table width="244" height="75" border="0" align="center" background="http://118.127.38.26/~smartphy/admin/app/webroot/pincode_back.png"  style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center">
														<tr>
															<td align="center" width="53" height="54">'.$rangePIN1.'</td>
															<td align="center" width="9"></td>
															<td align="center" width="38">'.$rangePIN2.'</td>
															<td align="center" width="17"></td>
															<td align="center" width="30">'.$rangePIN3.'</td>
															<td align="center" width="7"></td>
															<td align="center" width="60">'.$rangePIN4.'</td>
														</tr>
													</table>
													
													<table width="240" height="66" border="0" align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center">
														<tr><td height="20"></td></tr>
														<tr>
															<td align="center">Your Patient PIN code</td>
														</tr> 
														<tr>
															<td height="20"></td>
														</tr> 
													</table>
													
													<table width="244" height="75" border="0" align="center"  background="http://118.127.38.26/~smartphy/admin/app/webroot/pincode_back.png" style="font-size:30px; font-family:Arial, Helvetica, sans-serif; font-weight:bold; text-align:center">
														<tr>
															<td align="center" width="53" height="54">'.$Pin1.'</td>
															<td align="center" width="9"></td>
															<td align="center" width="38">'.$Pin2.'</td>
															<td align="center" width="17"></td>
															<td align="center" width="30">'.$Pin3.'</td>
															<td align="center" width="7"></td>
															<td align="center" width="60">'.$Pin4.'</td>
														</tr>
													</table>
												</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td height="64">
										<table width="240" height="66" border="0" align="center" style="font-size:16px; font-family:Arial, Helvetica, sans-serif; font-weight:bold text-align:center" position="absolute">
											<tr><td height="20"></td></tr>
										</table>
										<table width="467" height="58" align="center" style="font-size:12px; font-family:Arial, Helvetica, sans-serif; text-align:center" position="absolute">
											<tr>
												<td width="53" height="54">
													Get in touch with us at <a href="mailto:hello@smartphysio.com.au"> hello@smartphysio.com.au</a> <br>ACN 162 610 166. Â© 2013 Smart Physio App Pty Ltd | All Rights Reserved
												</td>
											</tr>
										</table>
									</td>
								</tr>
								
								<tr>
									<td><!-- Footer --></td>
								</tr>
							</table>
						</td>
						
						<td width="47"> <!--3rd Column--></td>
					</tr>
					</table>
					</body>
					</html>';
                
                
                mail($this->_to,$this->_subject, $message, $headers);
                
        }

        
        
  }
        