<!-- Menu settings -->

<div class = "large-12 columns panel">
	<div class = "row text-center">
		<div class = "large-12 columns">
			<div class = "large-1 small-1 columns">
				<div class = "row text-center"><span><a href="/<?php echo $info->get('domain'); ?>" target = "_blank"><img alt="jobteep" src="<?php echo $program->getDir() . "/img/view.png" ?>" width = "80%"></a></span></div>
				<div class = "row text-center"><small>Visualizar</small></div>
			</div>
			<div class = "large-4 small-8 columns">
				<div class = "row text-center">
					<div class = "small-6 columns"><span><a href="<?php echo $url ?>"><img alt="facebook" src="<?php echo $program->getDir() . "/img/logo_facebook.png" ?>" width = "80%"></a></span></div>
					<div class = "small-6 columns"><span><a href = "#"><img onclick = "instertData()" alt="linkedin" src="<?php echo $program->getDir() . "/img/logo_linkedin.png" ?>" width = "80%"></a></span></div>
				</div>
				<div class = "row text-center"><small>Importar datos</small></div>
			</div>
			<div class = "large-2 small-2 columns">
				<div class = "row"><span><a href="?program=panel&menu=settings"><img alt="jobteep" src="<?php echo $program->getDir() . "/img/settings.png" ?>" width = "40%"></a></span></div>
				<div class = "row"><small>Settings</small></div>
			</div>
			<div class = "large-2 small-2 columns">
				<div class = "row"><span><a href="#" data-reveal-id="shareModal"><img alt="jobteep" src="<?php echo $program->getDir() . "/img/share.png" ?>" width = "35%"></a></span></div>
				<div class = "row"><small>Compartir</small></div>
			</div>
			<div class = "large-2 small-2 columns">
				<div class = "row"><span><a href="/<?php echo $info->get('domain'); ?>/PDF" target = "_blank"><img alt="jobteep" src="<?php echo $program->getDir() . "/img/print.png" ?>" width = "40%"></a></span></div>
				<div class = "row"><small>Imprimir</small></div>
			</div>
			<div class = "large-1 small-1 columns end">
				<div class = "row"><span><a href="?action=logout"><img alt="jobteep" src="<?php echo $program->getDir() . "/img/erase.png" ?>" width = "80%"></a></span></div>
				<div class = "row"><small>Salir</small></div>
			</div>
		</div>
	</div>
</div>

<!-- Menu lateral -->
<li><a href="?program=panel&menu=info"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/info_white.png" width = "30px"></span>&nbsp;&nbsp; Datos Personales</a></li>
      	<li><a href="?program=panel&menu=experience"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/experience_white.png" width = "30px"></span>&nbsp;&nbsp; Trabajos</a></li>
      	<li><a href="?program=panel&menu=education"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/education_white.png" width = "30px"></span>&nbsp;&nbsp; Formación</a></li>
        <li><a href="?program=panel&menu=language"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/languages_white.png" width = "30px"></span>&nbsp;&nbsp; Idiomas</a></li>
        <li><a href="?program=panel&menu=skill"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/skills_white.png" width = "30px"></span>&nbsp;&nbsp; Habilidades</a></li>
        <li><a href="?program=panel&menu=proyect"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/proyect_white.png" width = "30px"></span>&nbsp;&nbsp; Proyectos</a></li>
        <li><a href="?program=panel&menu=activity"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/activity_white.png" width = "30px"></span>&nbsp;&nbsp; Actividades</a></li>
        <li><a href="?program=panel&menu=travel"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/countries_white.png" width = "30px"></span>&nbsp;&nbsp; Mis Viajes</a></li>
        <li><a href="?program=panel&menu=publications"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/publications_white.png" width = "30px"></span>&nbsp;&nbsp; Publicaciones</a></li>
        <li><a href="?program=panel&menu=mtl"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/hobbies_white.png" width = "30px"></span>&nbsp;&nbsp; Mi tiempo libre</a></li>
        <li><a href="?program=panel&menu=upgrade"><span><img alt = "the jobfeel" src = "Programs/Panel/img/menu/upgrade_white.png" width = "30px"></span>&nbsp;&nbsp; Mi Futuro</a></li>
      	<li><a href="?action=logout"><span><img src = "Programs/Panel/img/close.png" width = "30px"></span>&nbsp;&nbsp; Salir</a></li>
      	
<!-- Afrontar situación Upgrade -->

			<div class = "row">
				<div class = "large-12 columns">
					<h3>¿Cómo afrontarías la situación?</h3>
				</div>
			</div>
			<div class="row">
		   		<div class="large-12 columns">
			      <label>Tienes que dar una mala notica a alguien
			        <textarea rows = "10" id = "ck_description2" name = "badnew"><?php echo $upgrade->get('badnew') ?></textarea>
			      </label>
			    </div>
			</div>
			<br>
			<div class="row">
		   		<div class="large-12 columns">
			      <label>Estás muy agobiado porque tienes mucho trabajo
			        <textarea rows = "10" id = "ck_description3" name = "overloaded"><?php echo $upgrade->get('overloaded') ?></textarea>
			      </label>
			    </div>
			</div>
			<br>