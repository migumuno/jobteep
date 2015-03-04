<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Mi Tiempo Libre</a></li>
		</ul>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
  		<?php 
  		$categories = array("Arte", "Cultura", "Friki", "Deporte");
  		$page = array("mtlart", "mtlculture", "mtlgeek", "mtlsport");
  		for ($i = 0; $i < count($categories); $i++) {
			switch ($page[$i]) {
				case "mtlart":
					$img = "camara.png";
					break;
				case "mtlculture":
					$img = "claqueta.png";
					break;
				case "mtlgeek":
					$img = "geek.png";
					break;
				case "mtlsport":
					$img = "ball.png";
					break;
			}
			echo '
			<a href="?program=panel&menu='.$page[$i].'">
				<div class = "medium-4 columns">
					<div class = "medium-12 columns panel text-center">
						<dl>
						  <dt><span class = "marker">'. $categories[$i].'</span></dt>
						  <dd><div class = "card_img"><img src = "'.$program->getDir().'img/'.$img.'"></div></dd>
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