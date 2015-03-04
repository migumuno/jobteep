<?php

class Disk {
	private $checker;
	private $dirs;
	
	function Disk($parser) {
		$this->checker = $parser;
		$this->dirs = new Collection();
		$this->dirs->addItem("../Data/Users/Images/", "Img");
		$this->dirs->addItem("../Data/Users/Pdfs/", "Pdf");
	}
	
	private function upload ($tmp_name, $file_dir) {
		if(!move_uploaded_file($tmp_name, $file_dir))
			throw new Exception("Error de fichero: se hamove producido un error al subir el archivo al servidor.");
	}
	
	private function erase ($file_dir) {
		if (!unlink($file_dir))
			throw new Exception('Error de fichero: no se pudo eliminar el archivo.');
	}
	
	public function uploadElement ($enum, $type, $field, $file, $id_user) {
		$tmp_name = $file[$field]['tmp_name'];
		$file_dir = $this->dirs->getItem($type) . $enum .'_'. $id_user .'_'. $file[$field]['name'];
		$file_name = $enum .'_'. $id_user .'_'. $file[$field]['name'];
		try {
			$this->upload($tmp_name, $file_dir);
			return $file_name;
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
			return "";
		}
	}
	
	public function eraseElement ($enum, $type, $field, $file, $id_user) {
		$file_dir = $this->dirs->getItem($type) . $enum .'_'. $id_user .'_'. $file[$field]['name'];
		try {
			$this->erase ($file_dir);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
	
	public function eraseElementByName ($file_name, $type) {
		$file_dir = $this->dirs->getItem($type) . $file_name;
		try {
			$this->erase ($file_dir);
		} catch (Exception $e) {
			throw new Exception($e->getMessage());
		}
	}
}