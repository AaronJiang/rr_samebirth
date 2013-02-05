<?php

if (! defined('BASEPATH'))
	exit('No direct script access allowed');

/**
 * Get app authority from Renren
 */
class Auth extends CI_Controller
{

	public function index()
	{
		require_once LIBRARYPATH . 'rr_api/class/config.inc.php';
		$data = array (
				'scope' => $config->scope,
				'APIKey' => $config->APIKey,
				'redirecturi' => $config->redirecturi 
		);
		$this->load->view('auth', $data);
	}
}
