<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=publications">Publicaciones</a></li>
		  <li class="current"><a href="#">Blogs</a></li>
		</ul>
	</div>
	<div class = "row">
		<div class = "large-12 columns"><a href="?program=panel&menu=new_mtlart" class="button success">Nuevo Trabajo</a></div>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<?php 
		$enum = "blog";
		$controller = $_SESSION['SO']->getController();
		$controller->setEnum($enum);
		$collection = $controller->selectAllElements();
		$article = $collection->getArray();
		foreach ($article as $k => $v) {
			echo '
			<a href="?program=panel&menu=new_'.$enum.'&id='.$v->getId().'">
				<div class = "medium-4 columns">
					<div class = "medium-12 columns panel text-center">
						<dl>
						  <dt><div class = "card_title_middle"><span class = "marker">'. $v->get('name').'</dt>
						  <dd>'. $v->get('month_views').'</dd>
						  <dd><img src = "'.$program->getDir().'img/'.$enum.'.png" width = "50px;"></dd>
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