<?php
class DB
{
	private static $_instance = null;
	private $_pdO,
		$_error = false,
		$_query,
		$_results,
		$_count = 0;

	// connect to database
	private function __construct()
	{
		try {
			$this->_pdO = new PDO('mysql:host=' . Config::get('mysql/host') . '; dbname=' . Config::get('mysql/db'), Config::get('mysql/username'), Config::get('mysql/password'));
		} catch (PDOException $e) {
			die($e->getMessage());
		}
	}

	public static function getInstance()
	{
		// check if already instantiated
		if (!isset(self::$_instance)) {
			// set it
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	// database query methods
	public function query($sql, $params = array())
	{
		// empty the error variable
		$this->_error = false;
		// check if query has been prepared properly
		if ($this->_query = $this->_pdO->prepare($sql)) {
			if (count($params)) {
				$x = 1;
				foreach ($params as $param) {
					$this->_query->bindValue($x, $param);
					$x++;
				}
			}
			if ($this->_query->execute()) {
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}
		return $this;
	}
	private function action($action, $table, $where = array())
	{
		if (count($where) === 3) {
			$operators = array('=', '>', '<', '>=', '<=');
			$field = $where[0];
			$operator = $where[1];
			$value = $where[2];

			if (in_array($operator, $operators)) {
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				if (!$this->query($sql, array($value))->error()) {
					return $this;
				}
			}
		}
		return false;
	}
	public function get($table, $where)
	{
		return $this->action('SELECT *', $table, $where);
	}
	public function delete($table, $where)
	{
		return $this->action('DELETE', $table, $where);
	}

	public function error()
	{
		return $this->_error;
	}

	public function count()
	{
		return $this->_count;
	}
}
