<?php
App::uses('AppController', 'Controller');
/**
 * WebAdmins Controller
 *
 * @property WebAdmin $WebAdmin
 */
class WebAdminsController extends AppController {

	public function login(){ 
		$this->autoLayout = false;
		$this->layout = 'ajax';
		if($this->request->is('post')){
			$check = $this->WebAdmin->find('first', array(
				'conditions' => array(
					'username' => $this->request->data('username'),
					'password' => md5($this->request->data('password')),
					'status' => 1
				)
			));
			
			if($check){
				$this->Session->write('admin_id', $check['WebAdmin']['id']);
				$this->Session->write('admin_username', $check['WebAdmin']['username']);
				
				$this->redirect(array('controller' => 'Users', 'action' => 'index'));
			}else{
				$this->Session->setFlash('Incorrect credentials', 'default', array('class' => "alert alert-info alert-login"));
				$this->redirect("/");
			}
		
		}		
	}
	
	public function logout(){
		$this->autoRender = false;
		$this->Session->destroy();
		$this->redirect("/");
	}
}
