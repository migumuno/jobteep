<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Actividades</a></li>
		</ul>
	</div>
	<div class = "row">
		<div class = "large-12 columns"><a href="?program=panel&menu=new_activity" class="button">Nueva Actividad</a></div>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<?php
		$enum = 'activity';
		$controller = $_SESSION['SO']->getController();
		$controller->setEnum('activity');
		$collection = $controller->selectAllElements();
		$activity = $collection->getArray();
		foreach ($activity as $k => $v) {
			/*$language = $controller->selectRelation($v->getId(), 'language');
			$skill = $controller->selectRelation($v->getId('id_user'), 'skill');
			$travel = $controller->selectRelation($v->getId(), 'travel');*/
			
			//FORMATO FECHA
			$start_date = $controller->getDateElement($v->get('start_date'));
			$end_date = $controller->getDateElement($v->get('end_date'));
			if ($start_date != '&nbsp' && $end_date == '&nbsp')
				$end_date = 'Actualidad';
			
			
			echo '
				<a href="?program=panel&menu=new_activity&id='.$v->getId().'">
					<div class = "medium-4 columns">
						<div class = "medium-12 columns panel text-center">
							<dl>
							  <dt><div class = "card_title_middle"><span class = "marker">'.$v->get('title').'</span></div></dt>
							  <dd>';
								$categories = array("Evento", "Voluntariado", "Hablar en público", "Innovación/Emprendimiento", "Otro");
								echo '<span class = "label">'.$categories[$v->get('category')].'</span>';
							  echo '</dd>
							  <dd>'.$start_date.'</dd>';
							  /*echo '<dd>Idiomas</dd>
							  <dd>';
								foreach ($language as $lng) {
									echo ' <span class="label">'.$lng.'</span> ';
								}
						echo '</dd>
							  <dd>Habilidades</dd>
							  <dd>';
								foreach ($skill as $sk) {
									echo ' <span class="label">'.$sk.'</span> ';
								}
						echo '</dd>
							  <dd>Viajes</dd>
							  <dd>';
								foreach ($travel as $tr) {
									echo ' <span class="label">'.$tr.'</span> ';
								}
						echo '</dd>';*/
							echo '</dl>
							<a href = "#" onclick = "confirmDelete(\''.$enum.'\', \''.$v->getId().'\',null)"><img src = "'.$program->getDir().'img/erase.png" width = "30px"></a>
						</div>
					</div>
				</a>
			';	
		}
		?>
	</div>
</div>