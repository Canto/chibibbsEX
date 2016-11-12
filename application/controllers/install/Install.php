<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends DPann_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	function __construct() {
		parent::__construct();

	}

	public function index() {

		$this->load->library(array('form_validation','javascript'));
		$this->load->helper(array('form', 'url'));
		$config = array(
			array(
				'field' => 'host',
				'label' => $this->lang->line('host').' ',
				'rules' => 'required',
				'lang' => 'host',
			),
			array(
				'field' => 'dbname',
				'label' => $this->lang->line('dbname').' ',
				'rules' => 'required',
				'lang' => 'dbname',
			),
			array(
				'field' => 'dbuser',
				'label' => $this->lang->line('dbuser').' ',
				'lang' => 'dbuser',
				'rules' => 'required'
			),
			array(
				'field' => 'dbpass',
				'label' => $this->lang->line('dbpass').' ',
				'lang' => 'dbpass',
				'rules' => 'required'
			),
			array(
				'field' => 'admin_id',
				'label' => $this->lang->line('admin_id').' ',
				'lang' => 'admin_id',
				'rules' => 'required|alpha_numeric'
			),
			array(
				'field' => 'admin_pass',
				'label' => $this->lang->line('admin_pass').' ',
				'lang' => 'admin_pass',
				'rules' => 'required'
			),
			array(
				'field' => 'admin_pass2',
				'lang' => $this->lang->line('admin_pass2').' ',
				//'label' => 'Email',
				'rules' => 'required|matches[admin_pass]'
			)
		);
		$this->form_validation->set_rules($config);

		$install_model = new Install_Model();

		$data = array(
			'permission' => $install_model->isWritableConfig(),
			'lang' => $this->language,
		);

		if ($this->form_validation->run() == FALSE)
		{
			$this->parser->parse('layouts/install/Index', $data);
		}
		else
		{
			$this->check();
		}


	}

	public function check() {

		$install_model = new Install_Model();

		$isPossible = $install_model->isPossibleInstall($_POST);
		$data['server_config'] = $install_model->getServerConfig($_POST);
		if ( empty($data['server_config']['is_connect_error']) || $isPossible == false) {

			$this->parser->parse('layouts/install/Check', $data);
		} else {
			$install_model->createTable($data['server_config']['config_data']);
			$exist_tables = $install_model->checkTableExist();
			$data['exist_tables'] = $exist_tables;

			$this->parser->parse('layouts/install/Installed', $data);
		}

		
		/*
		if ( $isPossible != true ) {
			$data['server_config'] = $this->Install_Model->getServerConfig($_POST);

		} else {
			$do_install = $this->Install_Model->install($_POST);
		}*/


	}
}
