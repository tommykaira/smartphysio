<?php
App::uses('AppController', 'Controller');
/**
 * Users Controller
 *
 * @property User $User
 */
class UsersController extends AppController {
	public $name = "Users";
	public $uses = array('User','ColorScheme','PracticeLogo','AdminPin','ClientPin','Subscription');
	public $components = array('Upload');
/**
 * index method
 *
 * @return void
 */
	public function index() {
		// Add filter
		$this->FilterResults->addFilters(
			array(
				'filter1' => array(
					'OR' => array(
						'User.id'     => array('operator' => 'LIKE'),
						'User.practice_name'     => array('operator' => 'LIKE'),
						'User.email'     => array('operator' => 'LIKE'),
						'User.first_name'     => array('operator' => 'LIKE'),
						'User.last_name'     => array('operator' => 'LIKE'),
						'User.number' => array('operator' => 'LIKE')
					)
				)
			)
		);

		$this->FilterResults->setPaginate('order', 'User.first_name ASC'); // optional
		$this->FilterResults->setPaginate('limit', 10);              // optional

		// Define conditions
		$this->FilterResults->setPaginate('conditions', $this->FilterResults->getConditions());

		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		$this->set('user', $this->User->read(null, $id));
	}


/**
 * add method
 *
 * @return void
 */
	public function add() {
		if ($this->request->is('post')) {
			$this->User->create();
			if ($this->User->save($this->request->data)) {
				
				$last_id = $this->User->getLastInsertID();
				
				$get_pin = $this->__generate_pins();
				$admin_data = array(
					'user_id' => $last_id,
					'pin' => $get_pin['admin']
				);
				
				$client_data = array(
					'user_id' => $last_id,
					'pin' => $get_pin['client']
				);
				
				$this->AdminPin->save($admin_data);
				$this->ClientPin->save($client_data);
				
				$this->Session->setFlash('<a class="close" data-dismiss="alert">x</a> The user has been saved.','default', array('class' => 'alert alert-success', 'escape' => FALSE));
				$this->redirect(array('action' => 'logo', $last_id));
			} else {
				$this->Session->setFlash('<a class="close" data-dismiss="alert">x</a> The user could not be saved. Please, try again.', 'default', array('class' => 'alert alert-error', 'escape' => FALSE));
			}
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			if ($this->User->save($this->request->data)) {
				$this->Session->setFlash(__('The user has been saved'));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The user could not be saved. Please, try again.'),'default', array('class' => 'alert alert-error'));
			}
		} else {
			$this->request->data = $this->User->read(null, $id);
		}
	}

/**
 * delete method
 *
 * @throws MethodNotAllowedException
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}
		$this->User->id = $id;
		if (!$this->User->exists()) {
			throw new NotFoundException(__('Invalid user'));
		}
		if ($this->User->delete()) {
			$this->Session->setFlash(__('User deleted'));
			$this->redirect(array('action' => 'index'));
		}
		$this->Session->setFlash(__('User was not deleted'));
		$this->redirect(array('action' => 'index'));
	}
	
	/**
	 * add logo
	 * 
	 * @param int $id
	 */
	public function logo($id = null){
		$practice = $this->User->findById($id);
		$schemes = $this->ColorScheme->find('all');
		
		$this->set(compact('practice', 'schemes'));
		if($this->request->is('post')){
			
			$logo = $this->Upload->execute($this->request->data['User']['fileinput'],'uploads');
			if($logo['check'] == 1){
				$data = array(
					'user_id' => $id,
					'logo' => $logo['data'],
					'color_scheme_id' => $this->request->data['User']['color_scheme_id']
				);
			
				if($this->PracticeLogo->save($data)){
					$this->Session->setFlash('<a class="close" data-dismiss="alert">x</a> '.$practice['User']['practice_name'].' logo has been saved.','default', array('class' => 'alert alert-success', 'escape' => FALSE));
					$this->redirect(array('action' => 'index'));
				}else{
					$this->Session->setFlash('<a class="close" data-dismiss="alert">x</a> '.$practice['User']['practice_name'].' logo saving failed. Please try again.','default', array('class' => 'alert alert-error', 'escape' => FALSE));
				}
			}
		}
		
	}
	
	/**
	 * generate PIN for admin and client
	 * 
	 */
	private function __generate_pins(){
		$this->autoRender = false;
		
		return array(
			'admin' => rand(0,9).rand(0,9).rand(0,9).rand(0,9),
			'client' => rand(0,9).rand(0,9).rand(0,9).rand(0,9)
		);
	}
}
