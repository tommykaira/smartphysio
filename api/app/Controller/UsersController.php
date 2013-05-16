<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController{
	public $components = array('RequestHandler','FileUpload','MailSmarty');
	
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
					'Address' => $admin['User']['street'],
					'Street' => $admin['User']['street'],
					'Country' => $admin['User']['country'],
					'State' => $admin['User']['state'],
					'Suburb' => $admin['User']['suburb'],
					'PostalCode' => $admin['User']['postcode'],
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
			$data = array(
				'User' => array(
					'id' => $client['User']['id'],
					'PracticName' => $client['User']['practice_name'],
					'Services' => $admin['User']['services'],
					'FirstName' => $client['User']['first_name'],
					'LastName' => $client['User']['last_name'],
					'Telephone' => $client['User']['number'],
					'Email' => $client['User']['email'],
					'Website' => $client['User']['website'],
					'Address' => $client['User']['street'],
					'Street' => $client['User']['street'],
					'Country' => $client['User']['country'],
					'State' => $client['User']['state'],
					'Suburb' => $client['User']['suburb'],
					'PostalCode' => $client['User']['postcode'],
					'AdminPin' => $client['User']['AdminPin']['pin'],
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
                'patient_pin' => $client['ClientPin']['pin']
			);
			$this->MailSmarty->send($user['User']['email'], $dataSend);
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
                'patient_pin' => $client['ClientPin']['pin']
			);
			$this->Mail->MailSmarty($user['User']['email'], $dataSend);
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
				
				$this->MailSmarty->send($user['User']['email'], $data);
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
	public function saveExpiry()
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
	public function getExpiry()
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
	
}