<?php
include_once 'Model/Exceptions/BBDD/DeleteFailBBDDException.exception.php';
include_once 'Model/Exceptions/BBDD/FailConnectionBBDDException.exception.php';
include_once 'Model/Exceptions/BBDD/InsertFailBBDDException.exception.php';
include_once 'Model/Exceptions/BBDD/UpdateFailBBDDException.exception.php';
include_once 'Model/Exceptions/BBDD/SelectFailBBDDException.exception.php';

class BBDD {
	private $host;
	private $database;
	private $user;
	private $password;
	private $mysqli;
	
	function BBDD($bbdd) {
		$this->setBBDD($bbdd);
	}
	
	public function setBBDD ($bbdd) {
		switch ($bbdd) {
			case "panel":
				$this->host = "localhost";
				$this->database = "jobteep_users";
				$this->user = "jobfeel";
				$this->password = "626tgblingJOB";
				break;
			case "data":
				$this->host = "localhost";
				$this->database = "jobteep_data";
				$this->user = "jobfeel";
				$this->password = "626tgblingJOB";
				break;
			case "admin":
				$this->host = "localhost";
				$this->database = "jobteep_admin";
				$this->user = "jobfeel";
				$this->password = "626tgblingJOB";
				break;
			case "template":
				$this->host = "localhost";
				$this->database = "jobteep_templates";
				$this->user = "jobfeel";
				$this->password = "626tgblingJOB";
				break;
			default:
				echo 'Error, no conozco esa base de datos.<br>';
		}
	}
		
	private function makeSafe ($var) {
		$var = addslashes(trim($var));
			
		return $var;
	}
	
	private function connect() {
		$this->mysqli = new mysqli($this->host, $this->user, $this->password, $this->database, 3306);
		if ($this->mysqli->connect_errno)
			throw new Exception('Error BBDD: ha sido imposible conectarse a la base de datos.');
	}
	
	private function extractFields ($fields) {
		$tam = count($fields);
		$string = '';
		for ($i = 0; $i < $tam; $i++) {
			$temp = $this->makeSafe($fields[$i]);
			if ($i != $tam-1)
				$string = $string . $temp . ', ';
			else
				$string = $string . $temp;
		}
	
		return $string;
	}
	
	private function extractValues ($values) {
		$tam = count($values);
		$string = '';
		for ($i = 0; $i < $tam; $i++) {
			$temp = $this->makeSafe($values[$i]);
			if ($i != $tam-1)
				$string = $string . '"' . $temp . '", ';
			else
				$string = $string . '"' . $temp . '"';
		}
			
		return $string;
	}
	
	private function extractElements ($fields, $values) {
		$tam = count($fields);
		$elements = '';
		for ($i = 0; $i < $tam; $i++) {
			$temp_fields = $this->makeSafe($fields[$i]);
			$temp_values = $this->makeSafe($values[$i]);
			if ($i != $tam-1) {
				$elements = $elements . $temp_fields . ' = "' . $temp_values . '", ';
			} else {
				$elements = $elements . $temp_fields . ' = "' . $temp_values . '"';
			}
		}
			
		return $elements;
	}
	
	public function select ($from, $fields = "*", $where = null, $group = null, $having = null, $order = null) {
		try {
			$this->connect();
			$fields = $this->extractFields($fields);
			
			$query = 'SELECT '. $fields .'
					FROM '.$from;
			if (!is_null($where))
				$query = $query . ' WHERE '. $where;
			if (!is_null($group))
				$query = $query . ' GROUP BY '. $group;
			if (!is_null($having))
				$query = $query . ' HAVING '. $having;
			if (!is_null($order))
				$query = $query . ' ORDER BY '. $order;
			
			$result = $this->mysqli->query($query);
			$this->mysqli->close();
			return $result;
			
		} catch (FailConnectionBBDDException $e) {
			$this->mysqli->close();
			throw new FailConnectionBBDDException($e->getMessage());
			return null;
		}
	}
	
	public function insert ($from, $fields, $values) {
		try {
			$this->connect();
			$fields = $this->extractFields($fields);
			$values = $this->extractValues($values);
			
			$query = 'INSERT INTO '. $from .'
					('. $fields .') VALUES ('. $values .')';
			
			$this->mysqli->query($query);
			if ($this->mysqli->insert_id == 0) {
				$query = "ALTER TABLE ".$from." AUTO_INCREMENT = 1";
				$this->mysqli->query($query);
				$this->mysqli->close();
				throw new InsertFailBBDDException("Error, revisa que todos los campos estén correctos.");
			} else {
				$id = $this->mysqli->insert_id;
				$this->mysqli->close();
				return $id;
			}
		} catch (FailConnectionBBDDException $e) {
			$this->mysqli->close();
			throw new FailConnectionBBDDException($e->getMessage());
			return 0;
		}
	}
	
	public function update ($from, $fields, $values, $where) {
		try {
			$this->connect();
			$elements = $this->extractElements($fields, $values);
			
			$query = 'UPDATE '. $from .' SET 
					'. $elements .'
					WHERE '. $where;
			
			if (!$this->mysqli->query($query)) {
				$this->mysqli->close();
				throw new UpdateFailBBDDException("Error, revisa que todos los campos estén correctos.");
				return false;
			} else {
				$this->mysqli->close();
				return true;
			}
			
		} catch (FailConnectionBBDDException $e) {
			$this->mysqli->close();
			throw new FailConnectionBBDDException($e->getMessage());
			return false;
		}
	}
	
	public function delete ($from, $where) {
		try {
			$this->connect();
			
			$query = 'DELETE FROM '. $from .'
					WHERE '. $where;
			
			if (!$this->mysqli->query($query)) {
				$this->mysqli->close();
				throw new DeleteFailBBDDException("Error BBDD: ha fallado la eliminación del elemento.");
				return false;
			} else {
				$this->mysqli->close();
				return true;
			}
		} catch (FailConnectionBBDDException $e) {
			$this->mysqli->close();
			throw new FailConnectionBBDDException($e->getMessage());
			return false;
		}
	}
}
?>