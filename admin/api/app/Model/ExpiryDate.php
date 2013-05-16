<?php
App::uses('AppModel', 'Model');
/**
 * AdminPin Model
 *
 * @property ExpiryDate $ExpiryDate
 */
class ExpiryDate extends AppModel {

	public $actsAs = array('Containable');
	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
