<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Vivencias</a></li>
		</ul>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<div class = "medium-4 columns">
			<div class = "medium-12 columns panel text-center">
				<img src = "<?php echo $program->getDir(); ?>img/graficos/vivencias_frase_rec.png" width = "100%">
			</div>
		</div>
  		<?php 
  		$categories = array("Viajes", "Trabajos");
  		$page = array("travel", "experience");
  		for ($i = 0; $i < count($categories); $i++) {
			switch ($page[$i]) {
				case "travel":
					$img = "countries.png";
					break;
				case "experience":
					$img = "experience.png";
					break;
			}
			echo '
			<a href="?program=panel&menu='.$page[$i].'">
				<div class = "medium-4 columns">
					<div class = "medium-12 columns panel text-center">
						<dl>
						  <dt><span class = "marker">'. $categories[$i].'</span></dt>
						  <dd><div class = "card_img"><img src = "'.$program->getDir().'img/menu/'.$img.'"></div></dd>
						</dl>
						<a href="?program=panel&menu=new_'.$page[$i].'" class="button expand">NUEVA</a>
					</div>
				</div>
			</a>
			';
		}
  		?>
	</div>
</div>