<?php
include_once 'Controllers/Controller.interface.php';

class AdminController implements Controller {
	
	public function executeAction () {
		$action = $_GET['action'];
		switch ($action) {
			case "applogout":
				$this->applogout();
				break;
		}
	}
	
	public function applogout ($exit = true) {
		$_SESSION['SO']->applogout($exit);
	}
	
	public function numUsers ($type) {
		$numUsers = 0;
		$from = "user";
		$_SESSION['SO']->setBBDD('PANEL');
		if ($type == 'total') {
			$result = $_SESSION['SO']->select ($from, '*');
			$numUsers = $result->num_rows;
		} else {
			$fields = array("date as fecha");
			$result = $_SESSION['SO']->select($from, $fields);
			if ($type == 'week') {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$result->data_seek($i);
					$row = $result->fetch_assoc();
					$date = new DateTime($row['fecha']);
					$monday = new DateTime('last monday');
					if ($date > $monday)
						$numUsers++;
				}
			} else if ($type == 'month') {
				for ($i = 0; $i < $result->num_rows; $i++) {
					$result->data_seek($i);
					$row = $result->fetch_assoc();
					$date = new DateTime($row['fecha']);
					$month = new DateTime('last day of last month');
					if ($date > $month)
						$numUsers++;
				}
			}
		}
		return $numUsers;
	}
	
	private function monthUsers () {
		$from = "user";
		$_SESSION['SO']->setBBDD('PANEL');
		$fields = array("date as fecha");
		$result = $_SESSION['SO']->select($from, $fields);
	}
	
	public function checkSiteMap ($file) {
		$mb = 1048576;
		$max = 8;
		$date = date("Y-m-d");
		$now = date("Y_m_d_h_i_s");
		if (filesize($file) > ($max * $mb)) {
			//Creo el archivo comprimido
			$fp = fopen($file, "r");
			$data = fread ($fp, filesize($file));
			fclose($fp);
			$zp = gzopen('Sitemaps/Usuarios/'.$now.'.xml.gz', "w9");
			gzwrite($zp, $data);
			gzclose($zp);
			//Añado el archivo al index
			$xml = simplexml_load_file("sitemap.xml");
			$sxe = new SimpleXMLElement($xml->asXML());
			$sitemap = $sxe->addChild('sitemap');
			$sitemap->addChild('loc', 'http://www.jobteep.com/Sitemaps/Usuarios/'.$now.'.xml.gz');
			$sitemap->addChild('lastmod', $date);
			$sxe->asXML("sitemap.xml");
			//FORMATEO users.xml
			$users = new SimpleXMLElement('<urlset></urlset>');
			$users->asXML("Sitemaps/Usuarios/users.xml");
		}
	}
	
	
	
	public function genSitemap () {
		$xml = simplexml_load_file("Sitemaps/Usuarios/users.xml");
		$sxe = new SimpleXMLElement($xml->asXML());
		$date = date("Y-m-d");
		
		$from = "info";
		$_SESSION['SO']->setBBDD('PANEL');
		$result = $_SESSION['SO']->select($from, '*');
		for ($i = 0; $i < $result->num_rows; $i++) {
			$result->data_seek($i);
			$row = $result->fetch_assoc();
			$url = $sxe->addChild('url');
			$url->addChild('loc', 'http://www.jobteep.com/'.$row['domain']);
			$url->addChild('lastmod', $date);
			$url->addChild('changefreq', 'daily');
		}
		
		$sxe->asXML("Sitemaps/Usuarios/users.xml");
	}
}