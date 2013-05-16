//public_html/admin/api/app/Controller/Component/

<?php
class MailSmartyComponent extends Component{
	private $_from = 'support@smartphysio.com.au';
	private $_to = null;
	private $_subject = 'Lost Password';
	private $_message = 'null';
	
	public function to($to){
		$this->_to = $to;
	}
		
	public function send($to, $data, $type){
		if($to){
			$this->_to = $to;
		}
		$headers = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		/*if ($type == "register") {
			$message = $this->_registerMessage($data);
			$this->_subject = 'Registration Complete';
		}
		else{
			$this->_subject = 'Lost Password';
			$message = $this->_lostPasswordMessage($data);
		}*/
		
		if ($type == "register") {
                    if($data){
			$message = $this->_registerMessage($data);
			$this->_subject = 'Registration Complete';
                    }
		}
		else{
                    if($data){
			$this->_subject = 'Lost Password';
			$message = $this->_lostPasswordMessage($data);
                    }
		}
		
		
		mail($this->_to, $this->_subject, $message,$headers);
	}
	
	
	public function sendPassword($to,$practicePIN,$patientPIN,$clientName){
            if($to){
		$this->_to = $to;
            }	
            	
            	$this->_subject = 'Lost Password';
            	
                $rangePIN1 = substr($practicePIN,0,1);
		$rangePIN2 = substr($practicePIN,1,1);
                $rangePIN3 = substr($practicePIN,2,1);
                $rangePIN4 = substr($practicePIN,3,1);
                
                $Pin1 = substr($patientPIN, 0, 1);
                $Pin2 = substr($patientPIN, 1, 1);
                $Pin3 = substr($patientPIN, 2, 1);
                $Pin4 = substr($patientPIN, 3, 1);
                
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
             
                $message  = '<html><head>';
                $message .= '<title>Smart Physio</title></head>';
                $message .= '<body style="margin: 0px;">';
                $message .= '<form style="margin-bottom: 0;" id="Page3" name="Page3" method="post">';
                $message .= '<div class="image" style="position: relative; width: 100%;">';
                $message .= '<img src="http://smartphysio.codemagnus.com/admin/app/webroot/smartphy.png" width: height:>';
                $message .= '<h2 class="name" style="left: 270px; position: absolute; top: 178px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">';
                $message .= "Hi ". $clientName . ",</span>";
                $message .= '</h2>';
                $message .= '<h2 class="adminpin1" style="left: 280px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN1 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="adminpin2" style="left: 335px; position: absolute; top: 465px; width: 100%;">';                    
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN2 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="adminpin3" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN3 . '</span>';
                $message .= '</h2>';
                $message .= '<h2 class="adminpin4" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN4 . '</span>';
                $message .= '</h2>';
                $message .= '<h2 class="patientpin1" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin1 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin2" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin2 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin3" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin3 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin4" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin4 . '</span>';
		$message .= '</h2>';
                $message .= '</div>';
                $message .= ' </form></body></html>';
                
                mail($this->_to, $this->_subject, $message, $headers);
        }
        
        
        public function sendRegistration($to,$firstNameValue,$lastNameValue,$tmpAdminPin,$tmpClientPin){
            
                if($to){
			$this->_to = $to;
                }
                
                $rangePIN1 = substr($tmpAdminPin,0,1);
		$rangePIN2 = substr($tmpAdminPin,1,1);
                $rangePIN3 = substr($tmpAdminPin,2,1);
                $rangePIN4 = substr($tmpAdminPin,3,1);
                
                $Pin1 = substr($tmpClientPin, 0, 1);
                $Pin2 = substr($tmpClientPin, 1, 1);
                $Pin3 = substr($tmpClientPin, 2, 1);
                $Pin4 = substr($tmpClientPin, 3, 1);
                
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
                
                
                $message  = '<html><head>';
                $message .= '<title>Smart Physio</title></head>';
                $message .= '<body style="margin: 0px;">';
                $message .= '<form style="margin-bottom: 0;" id="Page3" name="Page3" method="post">';
                $message .= '<div class="image" style="position: relative; width: 100%;">';
                $message .= '<img src="http://smartphysio.codemagnus.com/admin/app/webroot/smartphy.png" width: height:>';
                $message .= '<h2 class="name" style="left: 270px; position: absolute; top: 178px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">';
                $message .= "Hi MyName: ". $firstNameValue .' '. $lastNameValue . ",</span>";
                $message .= '</h2>';
                $message .= '<h2 class="adminpin1" style="left: 280px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN1 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="adminpin2" style="left: 335px; position: absolute; top: 465px; width: 100%;">';                    
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN2 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="adminpin3" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN3 . '</span>';
                $message .= '</h2>';
                $message .= '<h2 class="adminpin4" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $rangePIN4 . '</span>';
                $message .= '</h2>';
                $message .= '<h2 class="patientpin1" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin1 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin2" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin2 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin3" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin3 . '</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin4" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;">'. $Pin4 . '</span>';
		$message .= '</h2>';
                $message .= '</div>';
                $message .= ' </form></body></html>';
                
                
                $this->_subject = 'Registration Complete';
                
                mail($this->_to, $this->_subject, $message, $headers);
                
        }
        
        
	
	private function _lostPasswordMessage($data){
		/*return "<html>
			<body>
				<p>This is your PIN {$data['practice_pin']}.</p>
                <p>Your client PIN {$data['patient_pin']}.</p>
			</body>
		</html>";*/

                $rangePIN1 = substr($data['practice_pin'],0,1);
		$rangePIN2 = substr($data['practice_pin'],1,1);
                $rangePIN3 = substr($data['practice_pin'],2,1);
                $rangePIN4 = substr($data['practice_pin'],3,1);
                
                $Pin1 = substr($data['patient_pin'], 0, 1);
                $Pin2 = substr($data['patient_pin'], 1, 1);
                $Pin3 = substr($data['patient_pin'], 2, 1);
                $Pin4 = substr($data['patient_pin'], 3, 1);
		
		$message  = '<html><head>';
                $message .= '<title>Smart Physio</title></head>';
                $message .= '<body style="margin: 0px;">';
                $message .= '<form style="margin-bottom: 0;" id="Page3" name="Page3" method="post">';
                $message .= '<div class="image" style="position: relative; width: 100%;">';
                $message .= '<img src="http://smartphysio.codemagnus.com/admin/app/webroot/smartphy.png" width: height:>';
                $message .= '<h2 class="name" style="left: 270px; position: absolute; top: 178px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> Hi {$data["FirstName"]} {$data["LastName"] },</span>';
                $message .= '</h2>';
                $message .= '<h2 class="adminpin1" style="left: 280px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["AdminPin"]},0,1) </span>';
		$message .= '</h2>';
                $message .= '<h2 class="adminpin2" style="left: 335px; position: absolute; top: 465px; width: 100%;">';                    
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["AdminPin"]},1,1)</span>';
		$message .= '</h2>';
                $message .= '<h2 class="adminpin3" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["AdminPin"]},2,1)</span>';
                $message .= '</h2>';
                $message .= '<h2 class="adminpin4" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["AdminPin"]},3,1)</span>';
                $message .= '</h2>';
                $message .= '<h2 class="adminpin3" style="left: 390px; position: absolute; top: 465px; width: 100%;">';
                $message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["AdminPin"]},2,1)</span>';
                $message .= '</h2>';
                $message .= '<h2 class="patientpin1" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["ClientPin"]}, 0, 1)</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin2" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["ClientPin"]}, 1, 1)</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin3" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["ClientPin"]}, 2, 1)</span>';
		$message .= '</h2>';
                $message .= '<h2 class="patientpin4" style="left: 280px; position: absolute; top: 575px; width: 100%;">';
		$message .= '<span style="color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;"> substr({$data["ClientPin"]}, 3, 1)</span>';
		$message .= '</h2>';
                $message .= '</div>';
                $message .= ' </form></body></html>';
                
     return $message;
                
                /*return "<html>
		        <head>
		        <title>Smart Physio</title>
		        </head>
		        <body style='margin: 0px;'>
		        <form style='margin-bottom: 0;' id='Page3' name='Page3' method='post'>
		         <div class='image' style='position: relative; width: 100%;'>
		         <img src='http://smartphysio.codemagnus.com/admin/app/webroot/smartphy.png' width: height:>
		                
		            <h2 class='name' style='left: 270px; position: absolute; top: 178px; width: 100%;'>
		                   <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> Hi {$data['FirstName']} {$data['LastName'] },</span>
		              </h2>
		
		                    <h2 class='adminpin1' style='left: 280px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> substr({$data["AdminPin"]},0,1) </span>
		                    </h2>
		                    <h2 class='adminpin2' style='left: 335px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> substr({$data['AdminPin']},1,1)</span>
		                    </h2>
		                    <h2 class='adminpin3' style='left: 390px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> substr({$data['AdminPin']},2,1)</span>
		                    </h2>
		                     <h2 class='adminpin4' style='left: 445px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>           substr({$data['AdminPin']},3,1)</span>
		                    </h2>
                                        
		                    <h2 class='patientpin1' style='left: 280px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> substr({$data['ClientPin']}, 0, 1)</span>
		                    </h2>
		                    <h2 class='patientpin2' style='left: 335px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['ClientPin']}, 1, 1)</span>
		                    </h2>
		                    <h2 class='patientpin3' style='left: 390px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['ClientPin']}, 2, 1)</span>
		                    </h2>
		                     <h2 class='patientpin4' style='left: 445px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['ClientPin']}, 3, 1)</span>
		                    </h2>
		
		
		                </div>
		        </form>
		        </body>
		        </html>";*/
	}
	
	private function _registerMessage($data){
		return "<html>
			<body>
				<p>Below is your details.</p>
				<h3>{$data['PracticeName']}</h3>
				<pre>
				Name: {$data['FirstName']} {$data['LastName']}.
				Email: {$data['Email']}.
				Address: {$data['Address']}.
				Street: {$data['Street']}.
				Suburb: {$data['Suburb']}.
				State: {$data['State']}.
				PostalCode: {$data['PostalCode']}.
				Country: {$data['Country']}.
				Contact Number: {$data['Telephone']}.
				Website: {$data['Website']}.
				Services: {$data['Services']}.
				This is your PIN {$data['AdminPin']}.
                Your client PIN {$data['ClientPin']}.
                </pre>
			</body>
		</html>";
		
		/*$rangePIN1 = substr($data['AdminPin'],0,1);
		$rangePIN2 = substr($data['AdminPin'],1,1);
                $rangePIN3 = substr($data['AdminPin'],2,1);
                $rangePIN4 = substr($data['AdminPin'],3,1);
                
                $Pin1 = substr($data['ClientPin'], 0, 1);
                $Pin2 = substr($data['ClientPin'], 1, 1);
                $Pin3 = substr($data['ClientPin'], 2, 1);
                $Pin4 = substr($data['ClientPin'], 3, 1);
		
		return "<html>
		        <head>
		        <title>Smart Physio</title>
		        </head>
		        <body style='margin: 0px;'>
		        <form style='margin-bottom: 0;' id='Page3' name='Page3' method='post'>
		         <div class='image' style='position: relative; width: 100%;'>
		         <img src='http://smartphysio.codemagnus.com/admin/app/webroot/smartphy.png' width: height:>
		                
		            <h2 class='name' style='left: 270px; position: absolute; top: 178px; width: 100%;'>
		                   <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> Hi Alvin S. Roasol,</span>
		              </h2>
		
		                    <h2 class='adminpin1' style='left: 280px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> substr({$data['AdminPin']},0,1) </span>
		                    </h2>
		                    <h2 class='adminpin2' style='left: 335px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['AdminPin']},1,1)</span>
		                    </h2>
		                    <h2 class='adminpin3' style='left: 390px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['AdminPin']},2,1)</span>
		                    </h2>
		                     <h2 class='adminpin4' style='left: 445px; position: absolute; top: 465px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['AdminPin']},3,1)</span>
		                    </h2>
		
		                    <h2 class='patientpin1' style='left: 280px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'> substr({$data['ClientPin']}, 0, 1)</span>
		                    </h2>
		                    <h2 class='patientpin2' style='left: 335px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['ClientPin']}, 1, 1)</span>
		                    </h2>
		                    <h2 class='patientpin3' style='left: 390px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['ClientPin']}, 2, 1)</span>
		                    </h2>
		                     <h2 class='patientpin4' style='left: 445px; position: absolute; top: 575px; width: 100%;'>
		                    <span style='color: #000; line-height: 45px; font-size: 30px; font-weight: bold; font-style: normal; font-variant: normal; padding: 10px; font-family: Helvetica, Sans-Serif; letter-spacing: -1px;'>substr({$data['ClientPin']}, 3, 1)</span>
		                    </h2>
		
		
		                </div>
		        </form>
		        </body>
		        </html>";*/
		
	}
}