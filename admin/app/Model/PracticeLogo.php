<?php
App::uses('AppModel', 'Model');
/**
 * PracticeLogo Model
 *
 * @property User $User
 * @property ColorScheme $ColorScheme
 */
class PracticeLogo extends AppModel {


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
		),
		'ColorScheme' => array(
			'className' => 'ColorScheme',
			'foreignKey' => 'color_scheme_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
