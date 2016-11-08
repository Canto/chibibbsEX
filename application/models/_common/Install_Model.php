<?php
//namespace application\models\install;

/**
 * Class Install_Model
 * @author    Canto (JoonYoung Yoon) <m.canto87@gmail.com>
 * @since     2016/06/26 Canto
 * @version   2016/08/21
 * @copyright 2016 DreamFactory
 */
class Install_Model extends DPann_Model {

	public function __construct() {
		parent::__construct();
		$this->load->helper(array('file'));
	}


	/**
	 * Check writable config file
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public function isWritableConfig($path = '') {

		if ( empty($path) ) {
			$path = STORAGE.'config/db.config.php';
		}
		return is_really_writable(dirname($path));
	}

	/**
	 * check php and mysql is possible install version
	 *
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param $inputData
	 *
	 * @return bool
	 */
	public function isPossibleInstall($inputData) {
		$server_config = $this->getServerConfig($inputData);

		if ( $server_config['is_php_minimum'] == true && $server_config['is_db_minimum'] == true ) {
			return true;
		} else {
			return false;
		}
	}


	/**
	 * Check to the minimum & recommended specifications of the installable php and mysql.
	 *
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param $inputData
	 *
	 * @return array
	 */
	public function getServerConfig($inputData) {

		//Compared to the minimum & recommended specifications of the installable php.
		$php_version = phpversion();
		$is_php_minimum = version_compare($php_version, '5.2.2', '>=');
		$is_php_recommend = version_compare($php_version, '5.5', '>=');

		//Set custom port number.
		if ( empty($inputData['port']) ) {
			$port = 3306;
		} else {
			$port = $inputData['port'];
		}

		$config['default'] = array(
			'dsn'	=> '',
			'hostname' => $inputData['host'],
			'username' => $inputData['dbuser'],
			'password' => $inputData['dbpass'],
			'database' => $inputData['dbname'],
			'port' => $port,
			'dbdriver' => 'mysqli',
			'dbprefix' => '',
			'pconnect' => FALSE,
			'db_debug' => TRUE,
			'cache_on' => FALSE,
			'cachedir' => '',
			'char_set' => 'utf8',
			'dbcollat' => 'utf8_general_ci',
			'swap_pre' => '',
			'encrypt' => FALSE,
			'compress' => FALSE,
			'stricton' => FALSE,
			'failover' => array(),
			'save_queries' => TRUE
		);

		//Load database
		$this->load->database($config['default']);

		//Get Database Information
		$db_version = $this->getDbVersionInfo($this->db->conn_id);

		//Compared to the minimum specifications of the installable mysql.
		$is_mysql_minimum = version_compare($db_version, '5.0', '>=');

		//Getting support information in UTF-8.
		if (empty($this->db->conn_id)) {
			$is_connect = false;
			$encoding = false;
		} else {
			$is_connect = true;
			$query = $this->db->query("SHOW CHARACTER SET WHERE `Charset`='utf8';");
			$result = $query->row_array();
			$encoding = $result['Default collation'];
		}

		//Return server information data.
		$return_data = array(
			'is_connect_error' => $is_connect,
			'php_version' => $php_version,
			'is_php_minimum' => $is_php_minimum,
			'is_php_recommend' => $is_php_recommend,
			'db_version' => $db_version,
			'is_db_minimum' => $is_mysql_minimum,
			'is_utf8' => $encoding,
			'config_data' => $config
		);

		return $return_data;
	}


	/**
	 * create admin,post,comment,log,skin tables
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param $config_data
	 */
	public function createTable($config_data){

		$create_admin = "CREATE TABLE IF NOT EXISTS chibi_admin (
		  chibi_admin_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  cid varchar(255) NOT NULL,
		  skin_name varchar(255) NOT NULL,
		  board_title varchar(255) NOT NULL,
		  options longtext NOT NULL,
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (chibi_admin_idx),
		  UNIQUE KEY board_id (cid,logical_flag)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$create_comment = "CREATE TABLE IF NOT EXISTS chibi_comment (
		  chibi_comment_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  chibi_admin_idx int(11) unsigned NOT NULL,
		  chibi_post_idx int(11) unsigned NOT NULL,
		  comment_no int(11) unsigned NOT NULL DEFAULT '0',
		  comment_depth int(11) unsigned NOT NULL DEFAULT '0',
		  name varchar(255) NOT NULL,
		  password varchar(255) NOT NULL,
		  memo varchar(255) NOT NULL,
		  comment longtext NOT NULL,
		  hp_url varchar(255) NOT NULL,
		  ip_address int(11) unsigned NOT NULL,
		  options longtext NOT NULL,
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (chibi_comment_idx),
		  UNIQUE KEY comment (chibi_admin_idx,chibi_post_idx,comment_no,comment_depth,logical_flag)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$create_log = "CREATE TABLE IF NOT EXISTS chibi_log (
		  chibi_log_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  chibi_admin_idx int(11) unsigned NOT NULL,
		  cid varchar(255) NOT NULL,
		  ip_address int(11) unsigned NOT NULL,
		  session_id varchar(255) NOT NULL,
		  device varchar(255) NOT NULL,
		  country varchar(255) NOT NULL,
		  browser varchar(255) NOT NULL,
		  residence_time int(11) unsigned DEFAULT '0',
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (chibi_log_idx)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$create_member = "CREATE TABLE IF NOT EXISTS chibi_member (
		  chibi_member_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  user_id varchar(255) NOT NULL,
		  nickname varchar(255) NOT NULL,
		  password varchar(255) NOT NULL,
		  permission int(11) unsigned NOT NULL,
		  profile text,
		  point int(11) unsigned NOT NULL DEFAULT '0',
		  post_count int(11) unsigned NOT NULL DEFAULT '0',
		  comment_count int(11) unsigned DEFAULT '0',
		  options longtext NOT NULL,
		  last_login datetime NOT NULL,
		  session_id varchar(255) NOT NULL,
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) DEFAULT '0',
		  PRIMARY KEY (chibi_member_idx),
		  UNIQUE KEY user_id (user_id),
		  KEY point (point),
		  KEY post_count (post_count),
		  KEY comment_count (comment_count),
		  KEY last_login (last_login)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$create_post = "CREATE TABLE IF NOT EXISTS chibi_post (
		  chibi_post_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  chibi_admin_idx int(11) unsigned NOT NULL,
		  post_no int(11) unsigned NOT NULL,
		  post_type int(11) unsigned NOT NULL,
		  post_data longtext NOT NULL,
		  password varchar(255) NOT NULL,
		  user_agent varchar(255) NOT NULL,
		  ip_adress int(11) unsigned NOT NULL,
		  options longtext NOT NULL,
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (chibi_post_idx),
		  UNIQUE KEY post (chibi_admin_idx,post_no,logical_flag)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$create_skin = "CREATE TABLE IF NOT EXISTS chibi_skin (
		  chibi_skin_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  chibi_admin_idx int(11) unsigned NOT NULL,
		  skin_name varchar(255) NOT NULL,
		  options longtext NOT NULL,
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (chibi_skin_idx),
		  KEY chibi_admin (chibi_admin_idx)
		) ENGINE=InnoDB DEFAULT CHARSET=utf8;";

		$create_emoticon = "CREATE TABLE IF NOT EXISTS chibi_emoticon (
		  chibi_emoticon_idx int(11) unsigned NOT NULL AUTO_INCREMENT,
		  chibi_admin_idx int(11) unsigned NOT NULL,
		  emoticon_name varchar(255) NOT NULL,
		  emoticon_file varchar(255) NOT NULL,
		  create_time datetime NOT NULL,
		  update_time datetime NOT NULL,
		  logical_flag tinyint(4) NOT NULL DEFAULT '0',
		  PRIMARY KEY (chibi_emoticon_idx),
		  KEY emoticon (chibi_admin_idx,emoticon_name)
		) ENGINE=InnoDB DEFAULT  CHARSET=utf8;";


		$this->db->query($create_admin);
		$this->db->query($create_comment);
		$this->db->query($create_log);
		$this->db->query($create_member);
		$this->db->query($create_post);
		$this->db->query($create_skin);
		$this->db->query($create_emoticon);

		//Create config file
		$is_wriate = $this->_createConfigFile($config_data);


	}

	/**
	 * check exist tables
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 * @return array
	 */
	public function checkTableExist() {

		$admin_table = $this->db->table_exists('chibi_admin');
		$comment_table = $this->db->table_exists('chibi_comment');
		$log_table = $this->db->table_exists('chibi_log');
		$member_table = $this->db->table_exists('chibi_member');
		$post_table = $this->db->table_exists('chibi_post');
		$skin_table = $this->db->table_exists('chibi_skin');
		$emoticon_table = $this->db->table_exists('chibi_emoticon');

		$exist_tables = array(
			'admin' => $admin_table,
			'comment' => $comment_table,
			'log' => $log_table,
			'member' => $member_table,
			'post' => $post_table,
			'skin' => $skin_table,
			'emoticon' => $emoticon_table,
		);

		return $exist_tables;
	}

	/**
	 * create config file
	 * @author  Canto (JoonYoung Yoon) <m.canto87@gmail.com>
	 * @since   2016/08/21 Canto
	 * @version 2016/08/21
	 *
	 * @param $config_data
	 *
	 * @return bool
	 */
	private function _createConfigFile($config_data) {

		//Serialize the config data array, and then encode in base64.
		$config['default'] = base64_encode(serialize($config_data['default']));

		//Load file helper
		$this->load->helper('file');

		if ( ! write_file( STORAGE.'config/db.config.php', $config['default']))
		{
			return false;
		}
		else
		{
			return true;
		}

	}

}