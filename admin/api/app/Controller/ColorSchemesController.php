<?php

class ColorSchemesController extends AppController {
	public $components = array('RequestHandler');
	public function beforeRender(){
		$this->layout = 'ajax';
		
	}
	
	public function getColorScheme($color = null, $colorValue = null){
		
		if($this->request->isPost()){
			$colorValue = $_POST['colorValue'];
		}
		
		$color = $this->ColorScheme->findById($colorValue);
		if($color){
			$data = array(
				'ColorScheme' => array(
					'id' => $color['ColorScheme']['id'],
					'name' => $color['ColorScheme']['name'],
					'color' => $color['ColorScheme']['color'],
					'error' => 0,
					'message' => 'success'
				)
				
			);
		}
		else {
			$data = array(
				'ColorScheme' => array(
					'error' => 1,
					'message' => 'Color ID not exist.'
				)
				
			);
		}
		$xmlObject = Xml::fromArray($data, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function getColorSchemeOptions(){
		$colors = $this->ColorScheme->find('all');
		$tmp = array();
		$x = 1;
		if(count($colors) > 0){
			foreach($colors as $color){
				$tmp['ColorScheme']['color'.$x] = $color['ColorScheme'];
				$x++;
			} 
			$tmp['ColorScheme']['error'] = 0;
			$tmp['ColorScheme']['message'] = 'success';
		}
		else {
			$tmp['ColorScheme'] = array(
				'error' => 1,
				'message' => 'List is empty.'
			);
		}
		$xmlObject = Xml::fromArray($tmp, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
	
	public function addColorScheme($color = null, $colorNameValue = null, $colorHex = null, $colorHexValue = null){
		if ($this->request->isPost()) {
			$colorNameValue = $_POST['colorNameVaue'];
			$colorHexValue = $_POST['colorHexValue'];
		}
		$data['ColorScheme'] = array(
			'name' => $colorNameValue,
			'color' => $colorHexValue
		); 
		$this->ColorScheme->set($data);
		if ($this->ColorScheme->validates()){
			
			$check = $this->ColorScheme->findByColor($colorHexValue);
			if($check){
				$tmp['ColorScheme'] = array(
					'error' => 1,
					'message' => __('%s all ready exist.', $colorHexValue)
				);
				$xmlObject = Xml::fromArray($tmp, array('format' => 'tags')); // You can use Xml::build() too
				$xmlString = $xmlObject->asXML();
				echo $xmlString;
				return true;
			}
			if($this->ColorScheme->save()){
				$tmp['ColorScheme'] = array(
					'error' => 0,
					'message' => 'New color has been added.'
				);
			}
			else {
				$tmp['ColorScheme'] = array(
					'error' => 1,
					'message' => 'Cant be save.'
				);
			}
		}
		else{
			$tmp['ColorScheme'] = array(
					'error' => 0,
					'message' => 'Some parameters are lacking.'
				);
		}
		$xmlObject = Xml::fromArray($tmp, array('format' => 'tags')); // You can use Xml::build() too
		$xmlString = $xmlObject->asXML();
		echo $xmlString;
	}
}