<?php
class Competences {
	private $sectors;
	public $name_sectors;
	private $user;
	
	function Competences() {
		$this->sectors = array();
		$this->name_sectors = array();
		$_SESSION['SO']->setBBDD('DATA');
		$where = 'state = 1';
		$result = $_SESSION['SO']->select('sector', '*', $where);
		for($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$this->name_sectors[$row['id_sector']] = $row['name'];
		}
	}
	
	private function educationSectors () {
		$education = array();
		$from = "education";
		$where = 'id_user = '.$this->user;
		$fields = array("sector", "subsector", "qualification", "certificate");
		$result = $_SESSION['SO']->select ($from, $fields, $where);
		for ($i = 0; $i < $result->num_rows; $i++) {
			$certificate = 0;
			$level = 0;
			$type = 0;
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			//CERTIFICADO
			if ($row['certificate'] != '' && isset($row['certificate']))
				$certificate = 10;
			//NIVEL
			switch ($row['qualification']) {
				case 2:
					$level = 2;
					break;
				case 3:
					$level = 3;
					break;
				case 4:
					$level = 4;
					break;
				case 5:
					$level = 4;
					break;
				case 6:
					$level = 5;
					break;
				case 7:
					$level = 10;
					break;
			}
			//TIPO
			if ($row['sector'] != 'none' && isset($row['sector'])) {
				if (array_key_exists($row['sector'], $this->name_sectors)) {
					if (!array_key_exists($row['sector'], $education)) {
						$education[$row['sector']] = ($level * 0.7) + (10 * 0.2) + ($certificate * 0.1);
					} else {
						$aux = ($level * 0.7) + (10 * 0.2) + ($certificate * 0.1);
						$education[$row['sector']] = $education[$row['sector']] + $aux;
					}
				}
			}
			if ($row['sector'] != $row['subsector']) {
				if ($row['subsector'] != 'none' && isset($row['subsector'])) {
					if (array_key_exists($row['subsector'], $this->name_sectors)) {
						if (!array_key_exists($row['subsector'], $education)) {
							$education[$row['subsector']] = ($level * 0.7) + (5 * 0.2) + ($certificate * 0.1);
						} else {
							$aux = ($level * 0.7) + (5 * 0.2) + ($certificate * 0.1);
							$education[$row['subsector']] = $education[$row['subsector']] + $aux;
						}
					}
				}
			}
		}
		foreach ($education as $k => $v) {
			if ($education[$k] >= 10)
				$value = 10;
			else
				$value = $education[$k];
			if (array_key_exists($k, $this->sectors))
				$this->sectors[$k] = $this->sectors[$k] + ($value * 0.3);
			else 
				$this->sectors[$k] = $value * 0.3;
		}
	}
	
	public function sectors ($user) {
		$this->user = $user;
		$this->educationSectors();
		return $this->sectors;
	}
}
?>