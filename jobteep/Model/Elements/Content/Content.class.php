<?php
include_once 'Model/Elements/Element.interface.php';

abstract class Content implements Element {
	protected $fields;
	protected $checks;
	protected $values = array();
	protected $checker;
	protected $enum;
	protected $order;
	protected $id;
	protected $controller;
	
	
	protected function setBasic () {
		$this->checker = $_SESSION['SO']->getParser('check');
	}
	
	public function setUser ($UID) {
		$this->values["id_user"] = $UID;
	}
	
	
	/**
	 * Devuelve el valor del campo indicado.
	 * @param String $field
	 */
	public function get ($field) {
		if (array_key_exists($field, $this->values) && isset ($this->values[$field]))
			return htmlspecialchars_decode($this->values[$field]);
		else
			return "";
	}
	
	/**
	 * Devuelve el enum del elemento
	 */
	public function getEnum () {
		return $this->enum;
	}
	
	public function getValuesHtml () {
		foreach ($this->values as $k => $v) {
			$this->values[$k] = htmlspecialchars_decode(html_entity_decode($v));
		}
		return $this->values;
	}
	
	public function getValues () {
		return $this->values;
	}
	
	public function getFields () {
		$fields = array();
		foreach ($this->values as $k => $v) {
			$fields[] = $k;
		}
		return $fields;
	}
	
	public function getId () {
		return $this->id;
	}
	
	public function setId ($id) {
		$this->id = $id;
	}
	
	public function getOrder () {
		return $this->order;
	}
	
	public function setOrder ($order) {
		$this->order = $order;
	}
	
	abstract public function setElement ($field, $value);
	
	/**
	 * Rellena el valor del campo indicado.
	 * @param String $field
	 * @param unknown $value
	 * @throws IncorrectValueException
	 * @throws Exception
	 */
	public function set ($field, $value) {
		$value = trim($value);
		$this->setElement($field, $value);
		if ($this->check($field, $value)) {
			$this->values[$field] = htmlspecialchars($value, ENT_QUOTES);
			return true;
		} else 
			return false;
	}
	
	/**
	 * Realiza la operación set N veces.
	 * @param String[] $values
	 * @throws Exception
	 */
	public function setN ($values) {
		for ($i = 0; $i < count($this->fields); $i++) {
			if (isset($values[$this->fields[$i]])) {
				if (!$this->set($this->fields[$i], $values[$this->fields[$i]])) {
					unset($this->values);
					$this->values = array();
					throw new IncorrectValueException("Se ha producido un error al insertar los elementos, revisa que todos los campos sean correctos.");
				}
			}
		}
	}
	
	/**
	 * Comprueba que el valor asociado al campo es correcto.
	 * @param String $field
	 * @param unknown $value
	 * @throws IncorrectValueException
	 * @throws IncorrectCheckException
	 * @return boolean
	 */
	protected function check ($field, $value) {
		$check = $this->checks[array_search($field, $this->fields)];
		if ($check != "none") {
			try {
				$obj = $this->checker->parser($check, $value);
				return $obj->execute($value);
			} catch (ValueEmptyException $e) {
				return true;
			} catch (IncorrectValueException $e) {
				return false;
			} catch (IncorrectCheckException $e) {
				return false;
			} catch (IncorrectValueNullException $e) {
				return false;
			} catch (FailInFileException $e) {
				return false;
			} catch (InvalidFileSizeException $e) {
				return false;
			} catch (InvalidFileTypeException $e) {
				return false;
			} catch (NameFileInUseException $e) {
				return false;
			}
		} else
			return true;
	}
	
	public function isField ($field) {
		if (in_array($field, $this->fields))
			return true;
		else 
			return false;
	}
	
	/*public function isAFile ($field) {
		$check = $this->checks[array_search($field, $this->fields)];
		if (substr($check, 0, 4) == "file")
			return true;
		else 
			return false;
	}
	
	public function getTypeOfFile ($field) {
		$check = $this->checks[array_search($field, $this->fields)];
		return substr($check, 4);
	}*/
}
?>