<?php
CroogoNav::add('extensions.children.password_protect', array(
	'title' => __('Password Protect'),
	'url' => array(
		'plugin' => 'passwordprotect',
		'controller' => 'passwordprotect',
		'action' => 'index',
		)
	));