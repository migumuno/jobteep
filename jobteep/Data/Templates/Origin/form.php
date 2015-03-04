<?php
$enum = strtolower($_GET['template']);
$controller = $_SESSION['SO']->getController();
$controller->setEnum($enum);
$collection = $controller->selectTemplate ();
$_SESSION['SO']->setBBDD('PANEL');
$template_array = $collection->getArray();
foreach ($template_array as $k => $v) {
	$template = $v;
}
$_SESSION['imagePicker'] = $_SESSION['SO']->getUserInfo ('dir');
$_SESSION['nameImg'] = $enum.'_template';
$answer = array("Imagen", "Video");
?>
<div class = "large-10 large-offset-1 columns">
	<div class = "row">
		<ul class="breadcrumbs">
		  <li><a href="?program=panel">Inicio</a></li>
		  <li><a href="?program=panel&menu=settings">Settings</a></li>
		  <li class="current"><a href="#">Configuración plantilla</a></li>
		</ul>
	</div>
</div>
<div class = "row">
	<form name = "Intro" data-abide method = "post" action = "?program=panel&menu=template&template=<?php echo $_GET['template'] ?>&action=configTemplate&id=<?php echo $template->getId(); ?>" enctype="multipart/form-data">
	<div class = "medium-10 medium-offset-1 columns panel">
		<div class = "row">
			<div class = "large-12 columns">
				<h3>Colores</h3>
			</div>
		</div>
		<div class = "row">
			<div class = "medium-3 small-6 columns"><label>GAMA JOBTEEP</label><img src = "Data/Templates/<?php echo $_GET['template'] ?>/gamas/jobteep.jpg" width = "100%"></div>
			<div class = "medium-3 small-6 columns"><label>GAMA HAPPY</label><img src = "Data/Templates/<?php echo $_GET['template'] ?>/gamas/happy.jpg" width = "100%"></div>
			<div class = "medium-3 small-6 columns"><label>GAMA BUSINESS</label><img src = "Data/Templates/<?php echo $_GET['template'] ?>/gamas/business.jpg" width = "100%"></div>
			<div class = "medium-3 small-6 columns"><label>GAMA BEACH DAY</label><img src = "Data/Templates/<?php echo $_GET['template'] ?>/gamas/beachday.jpg" width = "100%"></div>
		</div>
		<div class = "row">
			<div class = "medium-4 columns end">
				<br>
				<label>Elige uno:</label>
				<select name = "gama">
	  				<?php 
	  				$colors = array("Jobteep", "Happy", "Business", "Beach Day");
	  				for ($i = 0; $i < count($colors); $i++) {
						echo '<option value = "'.$i.'" ';
						if ($template->get('gama') == $i) echo ' selected';
						echo '>'.$colors[$i].'</option>';
					}
	  				?>
	  			</select>
			</div>
		</div>
		<div class = "row">
			<div class = "large-12 columns">
				<br>
				<h3>Destacados</h3>
			</div>
		</div>
		<div class = "row">
			<div class = "medium-12 columns">
				<div class = "medium-3 columns">
					<h4>Izquierda</h4>
					<label>Imagen</label>
					<div class = "medium-12 columns">
						<?php 
						if ($template->get('imgD1') != '')
							echo '<img src = "Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$template->get('imgD1').'" width = "100%">';
						else 
							echo '<img src = "Data/Templates/'.$_GET['template'].'/img/1.jpg" width = "100%">';
						?>
					</div>
					<label>Texto</label>
					<div class = "medium-12 columns"><?php echo $template->get('txtD1') ?></div>
					<div class = "medium-12 columns"><a href = "?program=panel&menu=template&template=<?php echo $_GET['template'] ?>&destacado=1" class = "button expand">Editar</a></div>
				</div>
				<div class = "medium-3 columns">
					<h4>Centro</h4>
					<label>Imagen</label>
					<div class = "medium-12 columns">
						<?php 
						if ($template->get('imgD2') != '')
							echo '<img src = "Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$template->get('imgD2').'" width = "100%">';
						else 
							echo '<img src = "Data/Templates/'.$_GET['template'].'/img/2.jpg" width = "100%">';
						?>
					</div>
					<label>Texto</label>
					<div class = "medium-12 columns"><?php echo $template->get('txtD2') ?></div>
					<div class = "medium-12 columns"><a href = "?program=panel&menu=template&template=<?php echo $_GET['template'] ?>&destacado=2" class = "button expand">Editar</a></div>
				</div>
				<div class = "medium-6 columns">
					<h4>Derecha</h4>
					<label><?php echo $answer[$template->get('typeD3')] ?></label>
					<?php 
						if ($template->get('typeD3') == 0) {
							echo '
							<div class = "medium-12 columns">';
								if ($template->get('imgD3') != '')
									echo '<img src = "Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$template->get('imgD3').'" width = "100%">';
								else 
									echo '<img src = "Data/Templates/'.$_GET['template'].'/img/3.jpg" width = "100%">';
							echo '</div>
							<label>Texto</label>
							<div class = "medium-12 columns">'.$template->get('txtD3').'</div>';
						} else if ($template->get('typeD3') == 1) {
							echo '<div class = "medium-12 columns"><iframe width="100%" height="100%" src="https://www.youtube.com/embed/'.$template->get('videoD3').'?showinfo=0&controls=0" frameborder="0" allowfullscreen></iframe></div>';
						}
					?>
					
					<div class = "medium-12 columns"><br><a href = "?program=panel&menu=template&template=<?php echo $_GET['template'] ?>&destacado=3" class = "button expand">Editar</a></div>
				</div>
			</div>
			<div class = "medium-12 columns">
		  		<?php 
				if ($template->get('header_img') == '' || is_null($template->get('header_img')))
					$img_url = $program->getDir().'img/img_bg.png';
				else 
					$img_url = 'Data/Users/'.$_SESSION['SO']->getUserInfo ('dir').'/'.$template->get('header_img');
				?>
				<label><h3>Fondo Cabecera</h3>
					<img id = "header_img" src = "<?php echo $img_url; ?>" width = "100%">
					<div class = "row">
						<br>
						<a href="#" data-ip-modal="#headerModal" class="button">Subir</a>
						<a onclick = "document.getElementById('perfil').value = ''; document.getElementById('header_img').src = '<?php echo $program->getDir().'img/img_bg.png' ?>';" class = "button alert">Quitar</a>
						<input type = "hidden" name = "header_img" value = "<?php echo $template->get('header_img'); ?>" id = "perfil">
					</div>
				</label>
		  	</div>
		</div>
		<br>
		<input type = "hidden" name = "enum" value = "<?php echo $enum ?>" />
		<div class = "medium-12 columns">
			  <button class = "button expand" type="submit">GUARDAR</button>
		  </div>
	</div>
	</form>
</div>