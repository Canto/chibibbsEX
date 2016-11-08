<?php

class DPann_Model extends CI_Model {

	public function __construct()
	{
		parent::__construct();

		// Declaration helper
		$this->load->helper('url');
	}

	/**
	 * Check Install
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 * @return bool
	 */
	public function checkInstall(){

		if ( is_file(STORAGE.'config/db.config.php') ) {
			$config = file_get_contents(STORAGE.'config/db.config.php');
			$this->setDatabase($config);
			return true;
		} else {
			return false;
		}
	}

	/**
	 * Load DataBase
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param $config
	 */
	public function setDatabase($config) {
		$config = unserialize(base64_decode($config));
		$this->load->database($config);
	}

	/**
	 * Get Database Version
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param $connect
	 *
	 * @return mixed
	 */
	public function getDbVersionInfo($connect) {
		return $connect->server_info;
	}

}
