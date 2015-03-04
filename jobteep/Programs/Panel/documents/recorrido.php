<!-- Recorrido -->
<div id = "recorrido">
	<ol class="joyride-list" data-joyride>
		<li class = "text-center" data-button="OK" data-text="Next" data-options="prev_button: false">
			<h4>Bienvenido!</h4>
			<br>
			<p>Voy a enseñarte la oficina.</p>
		</li>
		<li data-id="firstStop" data-text="Siguiente" data-options="tip_location: top; prev_button: false">
			<p>Estas son las tarjetas, aquí es donde añades la info de tu curriculum.</p>
		</li>
		<li data-id="secondStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
			<p>Si pinchas en The JOBFeel, siempre te traerá a esta pantalla, la principal.</p>
		</li>
		<li data-id="thirdStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: bottom;">
			<p>Pinchando aquí puedes acceder al menú de opciones.</p>
			<p><a href = "#" onclick = "openMenu()">Pincha aquí.</a></p>
		</li>
		<li data-id="fourthStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: right;">
			<p>Aquí puedes visualizar tu curriculum público.</p>
		</li>
		<li data-id="fifthStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: right;">
			<p>Sincroniza tus datos con Linkedin, te ahorrarás mucho trabajo.</p>
		</li>
		<li data-id="sixthStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: right;">
			<p>Configura opciones como: privacidad, diseño, plantillas, versiones.</p>
			<p><a href = "#" onclick = "closeMenu()">Pincha aquí.</a></p>
		</li>
		<li data-id="seventhStop" data-text="Siguiente" data-prev-text="Anterior" data-options="tip_location: left;">
			<p>Desde aquí podrás volver a ver este recorrido.</p>
		</li>
		<li class = "text-center" data-button="OK" data-text="Next" data-options="prev_button: false">
			<h4>Ya está!</h4>
			<br>
			<p>Ahora importa desde Linkedin o añade algo de información, investiga si quieres y ve a ver como queda tu curriculum.</p>
			<br>
			<p>Hasta pronto!</p>
		</li>
	</ol>
</div>