<?php
class MailComponent extends Component{
	private $_from = 'support@smartphysio.com.au';
	private $_to = null;
	private $_subject = 'Lost Password';
	private $_message = 'null';
	
	public function to($to){
		$this->_to = $to;
	}
		
	public function send($to = null, $data = null){
		if($to){
			$this->_to = $to;
		}	
		$headers  = 'MIME-Version: 1.0' . "\r\n";
		$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		
		$message = $this->_lostPasswordMessage($data);
		mail($this->_to, $this->_subject, $message, $headers);
	}
	
	private function _lostPasswirdMessage($data){
		return "<html>
			<body>
				<p>This is your PIN {$data['pin']}.</p>
			</body>
		</html>";
	}
}