<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li class="current"><a href="#">Publicaciones</a></li>
		</ul>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
  		<?php
  		$controller = $_SESSION['SO']->getController();
  		$categories = array("Artículos", "Blogs", "Foros");
  		$page = array("article", "blog", "forum");
  		for ($i = 0; $i < count($categories); $i++) {
			switch ($page[$i]) {
				case "article":
					$img = "article.png";
					break;
				case "blog":
					$img = "blog.png";
					break;
				case "forum":
					$img = "forum.png";
					break;
			}
			echo '
			<a href="?program=panel&menu='.$page[$i].'">
				<div class = "medium-4 columns">
					<div class = "medium-12 columns panel text-center">
						<dl>
						  <dt><span class = "marker">'. $categories[$i].'</span></dt>';
						  $controller->setEnum($page[$i]);
						  $collection = $controller->selectAllElements ();
						  echo '<h2><span id = "num_edu">'.$collection->length ().'</span></h2>
						  <dd><div class = "card_img"><img src = "'.$program->getDir().'img/'.$img.'"></div></dd>
						</dl>
						<a href="?program=panel&menu=new_'.$page[$i].'" class="button expand">NUEVO</a>
					</div>
				</div>
			</a>
			';
		}
  		?>
	</div>
</div>