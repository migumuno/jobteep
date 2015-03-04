<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Aptitudes</a></li>
		</ul>
	</div>
	<div class = "row">
		<div class = "large-12 columns"><a href="?program=panel&menu=new_skill" class="button">Nueva Aptitud</a></div>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<div id = "sortable">
		<?php
		$enum = 'skill';
		$controller = $_SESSION['SO']->getController();
		$controller->setEnum('skill');
		$collection = $controller->selectAllElements();
		$experience = $collection->getArray();
		foreach ($experience as $k => $v) {
			echo '
				<a href="?program=panel&menu=new_skill&id='.$v->getId().'">
					<div class = "medium-4 columns">
						<div class = "medium-12 columns panel text-center">
							<dl>
							  <dt><div class = "card_title_middle"><span class = "marker">'.$v->get('name').'</span></div></dt>
							  <dd><label>Nivel</label> <span class="label">'; 
							  		switch ($v->get('level')) {
							  			case 0:
							  				echo 'Aprendiz';
							  				break;
							  			case 1:
							  				 echo 'Junior';
							  				 break;
							  			case 2:
							  				 echo 'Especialista';
							  				 break;
							  			case 3:
							  				 echo 'Maestro';
							  				 break;
							  			case 4:
							  				 echo 'Gurú';
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