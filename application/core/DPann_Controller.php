<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class DPann_Controller extends CI_Controller {

	public $language = null;
	public $is_install = false;
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

		// check install
		$this->load->model('_common/Install_Model');
		$install_model = new Install_Model();
		$this->is_install = $install_model->checkInstall();

		$this->load->helper('language');

		if ( !empty($_GET['lang']) ){
			$this->language = $_GET['lang'];
			$this->config->set_item('language', $this->language);
			$this->lang->is_loaded = array();
			$this->lang->load('install');
		} else if(!empty($_POST['lang'])) {
			$this->language = $_POST['lang'];
			$this->config->set_item('language', $this->language);
			$this->lang->is_loaded = array();
			$this->lang->load('install');
		}
	}

	function index() {

		$this->output->enable_profiler(TRUE);
	}

}
