<div class = "row modulo">	
	<div class = "row">
		<div class = "medium-12 columns">
			<div class = "medium-8 columns datos modulo">
				<div class = "centrado">
					<h1><?php echo $info['name'].' '.$info['surname']; ?></h1>
					<h3><?php echo $info['profession']; ?></h3>
					<h3>"<?php echo $info['slogan']; ?>"</h3>
				</div>
			</div>
			<div class = "medium-4 columns">
				<div class = "row conocimientos modulo">
					<img alt = "conocimientos" src = "<?php echo $program->getDir(); ?>img/graficos/conocimientos.png">
				</div>
				<div class = "row vivencias modulo">
					<img alt = "conocimientos" src = "<?php echo $program->getDir(); ?>img/graficos/vivencias.png">
				</div>
			</div>
		</div>
	</div>
	<div class = "row">
		<div class = "medium-12 columns">
			<div class = "medium-4 columns inspiracion modulo">
				<img alt = "conocimientos" src = "<?php echo $program->getDir(); ?>img/graficos/inspiracion.png">
			</div>
			<div class = "medium-4 columns creaciones modulo">
				<img alt = "conocimientos" src = "<?php echo $program->getDir(); ?>img/graficos/creaciones.png">
			</div>
			<div class = "medium-4 columns deseos modulo">
				<img alt = "conocimientos" src = "<?php echo $program->getDir(); ?>img/graficos/deseos.png">
			</div>
		</div>
	</div>
</div>