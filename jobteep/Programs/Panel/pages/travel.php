<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Viajes</a></li>
		</ul>
	</div>
	<div class = "row">
		<div class = "large-12 columns"><a href="?program=panel&menu=new_travel" class="button">Nuevo Viaje</a></div>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<div id = "sortable">
		<?php
		$enum = 'travel';
		$controller = $_SESSION['SO']->getController();
		$controller->setEnum($enum);
		$collection = $controller->selectAllElements();
		$travel = $collection->getArray();
		foreach ($travel as $k => $v) {
			//FORMATO FECHA
			$start_date = $controller->getDateElement($v->get('start_date'));
			$end_date = $controller->getDateElement($v->get('end_date'));
			if ($start_date != '&nbsp' && $end_date == '&nbsp')
				$end_date = 'Actualidad';
			
			echo '
				<a href="?program=panel&menu=new_travel&id='.$v->getId().'"">
					<div class = "medium-4 columns">
						<div class = "medium-12 columns panel text-center">
							<dl>
							  <dt><div class = "card_title_middle"><span class = "marker">'.$v->get('title').'</span></div></dt>
							  <dd><div class = "card_title_middle"><img src = "'.$program->getDir().'img/marcador.png" width = "30px;">'.$v->get('location').'</div></dd>
							  <dd>'.$start_date.' - '.$end_date.'</dd>
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