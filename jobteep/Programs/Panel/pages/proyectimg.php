<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=proyect">Proyectos</a></li>
		  <li class="current"><a href="#">Imágenes Proyecto</a></li>
		</ul>
	</div>
	<div class = "row">
		<div class = "large-12 columns"><a href="?program=panel&menu=new_proyectimg&idproy=<?php echo $_GET['idproy']; ?>" class="button">Nueva Imagen</a></div>
	</div>
</div>
<div class = "row" data-equalizer>
	<div class = "large-10 large-offset-1 columns">
		<?php
		$enum = 'proyectimg';
		$controller = $_SESSION['SO']->getController();
		$controller->setEnum($enum);
		$enum = 'proyectimg';
		$cond = 'id_proyect = '.$_GET['idproy'];
		$result = $controller->getElements($enum, $cond);
		while($row = $result->fetch_assoc()) {
			echo '
			<a href="?program=panel&menu=new_proyectimg&id='.$row['id_proyectimg'].'&idproy='.$_GET['idproy'].'">
				<div class = "large-3 medium-4 columns">
					<div class = "medium-12 columns panel text-center">
						<dl>
							<dt><div class = "card_img">';
							if (isset($row['file']) && $row['file'] != '')
								echo '<img src = "Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$row['file'].'">';
							echo '</div></dt>
							<dd>'.$row['name'].'</dd>
							<a href = "#" onclick = "confirmDelete(\''.$enum.'\', \''.$row['id_proyectimg'].'\',\''.$_GET['idproy'].'\')"><img src = "'.$program->getDir().'img/erase.png" width = "30px"></a>
						</dl>
					</div>
				</div>
			</a>
			';
		}
		?>
	</div>
</div>