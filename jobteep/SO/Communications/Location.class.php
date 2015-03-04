<?php
class Location {
	private $dir;
	
	function Location() {
		$this->dir = array(
			"latitude" => "",
			"longitude" => "",
			"code" => "",
			"address" => "",
			"town" => "",
			"city" => "",
			"country" => ""
		);
	}
	
	public function setParams ($direction) {
		$direccion_google = $direction;
  		$resultado = file_get_contents(sprintf('https://maps.googleapis.com/maps/api/geocode/json?sensor=false&address=%s', urlencode($direccion_google)));
  		$resultado = json_decode($resultado, TRUE);
  		
  		$this->dir['city'] =  $resultado['results'][0]['address_components']['3']['long_name'];
  		$this->dir['country'] =  "España";/*$resultado['results'][0]['address_components']['5']['long_name'];*/
  		if ($this->dir['country'] == 'Spain')
  			$this->dir['country'] = 'España';
  		$this->dir['latitude'] = $result['results'][0]['geometry']['location']['lat'];
		$this->dir['longitude'] = $result['results'][0]['geometry']['location']['lng'];
		/*$this->dir['code'] = $result['results'][0]['address_components']['6']['long_name'];
		$this->dir['address'] = $result['results'][0]['address_components']['1']['long_name'];
		$this->dir['town'] = $result['results'][0]['address_components']['2']['long_name'];
		$this->dir['city'] = $result['results'][0]['address_components']['3']['long_name'];
		$this->dir['country'] = $result['results'][0]['address_components']['5']['long_name'];*/
	}
	
	public function get ($param) {
		return $this->dir[$param];
	}
}
?>