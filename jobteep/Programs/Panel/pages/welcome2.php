<?php
$controller = $_SESSION['SO']->getController();
$url = $controller->getUrlFbk('panel');
$controller->setEnum('info');
?>
<div id="modalLinkedin" class="reveal-modal" data-reveal>
  <h2>Linkedin</h2>
  <p class="lead">Necesitamos que te conectes a tu cuenta de Linkedin para copiar los datos a tu perfil.</p>
  <script type="IN/Login" data-onAuth="onAuthLinkedin"></script>
</div>
<div id="connected" class="reveal-modal" data-reveal>
  <h2>Linkedin</h2>
  <p class="lead">Ya estás conectado/a! Ahora ya puedes importar tus datos.</p>
  <button onclick = "instertData()" class = "button">Linkedin</button>
</div>
<div id="inventado" class="reveal-modal" data-reveal>
  <h2>Error</h2>
  <p class="lead">Auth false.</p>
</div>
<div class = "row">
	<div class = "large-10 large-offset-1 columns">
		<?php
			/*$category = $controller->getItemFbk ('likes');
			print_r($category);*/
			
			if (isset($_GET['action']) && $_GET['action'] == "facebook") {
				if ($controller->getFbkId() != 0) {
					$fbk = $controller->getFacebook();
					/*print_r($fbk);*/
					$controller->extractContentFbk ($fbk);
					$controller->insertFbkId($fbk['id']);
					$result = $controller->getFriends();
					$num_friends = $result['summary']['total_count'];
					echo $num_friends;
				}
			}
		?>
		<!-- <div class = "row text-center">
			<div id = "demo"></div>
			<div class = "large-12 columns">
				<p><img alt="The Jobfeel" src="Programs/Panel/img/question.png" width = "20px"> <small>Podemos cargar tus datos desde Facebook o desde Linkedin para que te sea más fácil.</small></p>
			</div>
		</div> -->
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns text-center panel">
		<img src = "<?php echo $program->getDir(); ?>img/graficos/welcome.png" width = "80%">
	</div>
</div>
<br>
<div class = "row">
	<div class = "large-10 large-offset-1 columns">
		<div id = "firstStop" class = "medium-4 columns">
			<a href="?program=panel&menu=info">	
				<div class = "large-12 columns panel text-center">
					<h3>Datos Personales</h3>
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/menu/info.png" width = "100px"></p>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=knowledge">	
				<div class = "large-12 columns panel text-center">
					<p><img alt = "conocimientos curriculum" src = "Programs/Panel/img/graficos/conocimientos.png" width = "100%"></p>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=experiences">	
				<div class = "large-12 columns panel text-center">
					<p><img alt = "vivencias curriculum" src = "Programs/Panel/img/graficos/vivencias.png" width = "100%"></p>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=inspiration">	
				<div class = "large-12 columns panel text-center">
					<p><img alt = "inspiracion curriculum" src = "Programs/Panel/img/graficos/inspiracion.png" width = "100%"></p>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=creations">	
				<div class = "large-12 columns panel text-center">
					<p><img alt = "creaciones curriculum" src = "Programs/Panel/img/graficos/creaciones.png" width = "100%"></p>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=upgrade">	
				<div class = "large-12 columns panel text-center">
					<p><img alt = "deseos curriculum" src = "Programs/Panel/img/graficos/deseos.png" width = "100%"></p>
				</div>
			</a>
		</div>
	</div>
</div>