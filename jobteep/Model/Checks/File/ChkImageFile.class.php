<?php
require_once 'ChkFile.class.php';

class ChkImageFile extends ChkFile {
	
	public function check() {
		$this->dir = "../../../Data/Users/Images/";
		$this->file_dir = $this->dir . $this->enum .'_'.$this->id_user.'_'.$this->file[$this->name]['name'];
		$this->allowed_ext = array("gif", "jpeg", "jpg", "png");
		$this->types = array("image/jpeg", "image/jpg", "image/pjpeg", "image/x-png", "image/png", "image/gif");
		$this->max_size = 1024000;
		
		$ok = false;
		if($this->checkName())
			if($this->checkSize())
				if($this->checkError())
					if($this->checkType())
						$ok = true;
					else
						throw new InvalidFileTypeException("Error, el tipo de archivo no está permitido (png, jpg, jpeg, gif)");
				else
					throw new FailInFileException("Error de fichero: hay algún error en el archivo: ". $this->error);
			else {
				throw new InvalidFileSizeException("Error de fichero: el tamaño excede el máximo permitido de ". $tam ." MB.");
				$tam = ($this->max_size / 1000) / 1024;
			}
		else
			throw new NameFileInUseException("Error de fichero: el nombre ya existe.");
		
		if($ok)
			return true;
		else
			return false;
	}
}
?>