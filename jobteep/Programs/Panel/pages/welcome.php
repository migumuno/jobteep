<?php
$controller = $_SESSION['SO']->getController();
$url = $controller->getUrlFbk('panel');
$controller->setEnum('info');
?>
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
	<div class = "large-10 large-offset-1 columns">
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=info">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/iconos/info.png" width = "100%"></p>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href = "?program=panel&menu=experience">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/iconos/trabajos.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('experience');
					$collection = $controller->selectAllElements ();
					echo '<h2><span id = "num_exp">'.$collection->length ().'</span></h2>'*/
					?>
					<a href="?program=panel&menu=new_experience" class="button expand">NUEVO</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=education">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/iconos/formacion.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('education');
					$collection = $controller->selectAllElements ();
					echo '<h2><span id = "num_edu">'.$collection->length ().'</span></h2>'*/
					?>
					<a href="?program=panel&menu=new_education" class="button expand">NUEVA</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=language">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/iconos/idiomas.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('language');
					$collection = $controller->selectAllElements ();
					echo '<h2><span id = "num_lang">'.$collection->length ().'</span></h2>'*/
					?>
					<a href="?program=panel&menu=new_language" class="button expand">NUEVO</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=skill">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/iconos/aptitudes.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('skill');
					$collection = $controller->selectAllElements ();
					echo '<h2><span id = "num_skill">'.$collection->length ().'</span></h2>'*/
					?>
					<a href="?program=panel&menu=new_skill" class="button expand">NUEVA</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=proyect">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "proyectos curriculum" src = "Programs/Panel/img/iconos/proyectos.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('proyect');
					$collection = $controller->selectAllElements ();
					echo '<h2>'.$collection->length ().'</h2>'*/
					?>
					<a href="?program=panel&menu=new_proyect" class="button expand">NUEVO</a>
				</div>
			</a>
		</div>
		<!-- <div class = "medium-4 columns">
			<a href="?program=panel&menu=publications">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<h3>Publicaciones</h3>
					<p><img alt = "publicaciones curriculum" src = "Programs/Panel/img/publications.png" width = "100%"></p>
					<?php 
  					/*$categories = array("article", "blog", "forum");
					$count = 0;
  					for ($i = 0; $i < count($categories); $i++) {
						$controller->setEnum($categories[$i]);
						$collection = $controller->selectAllElements ();
						$count = $count + $collection->length ();
					}
					echo '<h2>'.$count.'</h2>';*/
					?>
					<div class = "space_welcome"></div>
				</div>
			</a>
		</div> -->
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=travel">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/iconos/viajes.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('travel');
					$collection = $controller->selectAllElements ();
					echo '<h2>'.$collection->length ().'</h2>';*/
					?>
					<a href="?program=panel&menu=new_travel" class="button expand">NUEVO</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=activity">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "actividades curriculum" src = "Programs/Panel/img/iconos/actividades.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('activity');
					$collection = $controller->selectAllElements ();
					echo '<h2>'.$collection->length ().'</h2>'*/
					?>
					<a href="?program=panel&menu=new_activity" class="button expand">NUEVA</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=mtlart">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "aficiones curriculum" src = "Programs/Panel/img/iconos/aficiones.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('activity');
					$collection = $controller->selectAllElements ();
					echo '<h2>'.$collection->length ().'</h2>'*/
					?>
					<a href="?program=panel&menu=new_mtlart" class="button expand">NUEVA</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=mtlsport">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "deporte curriculum" src = "Programs/Panel/img/iconos/deporte.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('activity');
					$collection = $controller->selectAllElements ();
					echo '<h2>'.$collection->length ().'</h2>'*/
					?>
					<a href="?program=panel&menu=new_mtlsport" class="button expand">NUEVO</a>
				</div>
			</a>
		</div>
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=mtlculture">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "cultura curriculum" src = "Programs/Panel/img/iconos/cultura.png" width = "100%"></p>
					<?php 
					/*$controller->setEnum('activity');
					$collection = $controller->selectAllElements ();
					echo '<h2>'.$collection->length ().'</h2>'*/
					?>
					<a href="?program=panel&menu=new_mtlculture" class="button expand">NUEVA</a>
				</div>
			</a>
		</div>
		<!-- <div class = "medium-4 columns">
			<a href="?program=panel&menu=mtl">
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<h3>Mi tiempo libre</h3>
					<p><img alt = "experiencias curriculum" src = "Programs/Panel/img/menu/hobbies.png" width = "100%"></p>
					<?php 
  					/*$categories = array("mtlart", "mtlculture", "mtlgeek", "mtlsport");
					$count = 0;
  					for ($i = 0; $i < count($categories); $i++) {
						$controller->setEnum($categories[$i]);
						$collection = $controller->selectAllElements ();
						$count = $count + $collection->length ();
					}
					echo '<h2>'.$count.'</h2>';*/
					?>
					<div class = "space_welcome"></div>
				</div>
			</a>
		</div> -->
		<div class = "medium-4 columns">
			<a href="?program=panel&menu=upgrade">	
				<div class = "large-12 columns panel tarjeta_elemento text-center">
					<p><img alt = "futuro" src = "Programs/Panel/img/iconos/objetivos.png" width = "100%"></p>
				</div>
			</a>
		</div>
	</div>
</div>