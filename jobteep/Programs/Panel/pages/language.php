<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Idiomas</a></li>
		</ul>
	</div>
	<div class = "row">
		<div class = "large-12 columns"><a href="?program=panel&menu=new_language" class="button">Nuevo Idioma</a></div>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<p><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"> <small>No añadas tu idioma nativo, lo añadiremos nosotros.</small></p>
		<div id = "sortable">
		<?php
		$enum = 'language';
		$controller = $_SESSION['SO']->getController();
		$controller->setEnum('language');
		$collection = $controller->selectAllElements();
		$experience = $collection->getArray();
		foreach ($experience as $k => $v) {
			echo '
				<a href="?program=panel&menu=new_language&id='.$v->getId().'">
					<div class = "medium-4 columns">
						<div class = "medium-12 columns panel text-center">
							<dl>
							  <dt><span class = "marker">'.$v->get('name').'</span></dt>
							  <dd><label>Nivel</label> <span class="label">'; 
							  		switch ($v->get('level')) {
							  			case 0:
							  				echo 'A2';
							  				break;
							  			case 1:
							  				 echo 'B1';
							  				 break;
							  			case 2:
							  				 echo 'B2';
							  				 break;
							  			case 3:
							  				 echo 'C1';
							  				 break;
							  			case 4:
							  				 echo 'C2';
							  				 break;
							  		}
							  echo '</span></dd>
							</dl>
							<a href = "#" onclick = "confirmDelete(\''.$enum.'\', \''.$v->getId().'\',null)"><img src = "'.$program->getDir().'img/erase.png" width = "30px"></a>
						</div>
					</div>
				</a>
			';	
		}
		?>
		</div>
	</div>
</div>