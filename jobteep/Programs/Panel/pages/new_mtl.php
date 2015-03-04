<div class = "row">
	<div class = "small-10 small-offset-1 columns">
		<div class = "large-3 columns"><a href="?program=panel&menu=mtl" class="button"><img src = "<?php echo $program->getDir() ?>img/return.png" width = "20px;"> VOLVER</a></div>
		<div class = "large-6 columns"><h1 class = "subheader text-center">Añade una Ficha</h1></div>
		<div class = "large-3 columns"></div>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 columns panel">
		<div class = "row">
			<div class = "large-4 columns">
				<label>Elige la categoría <small>Importante</small>
					<select id = "mtl_category" onchange = "selectMtlCategory()">
		  				<?php 
		  				$categories = array("...", "Arte", "Cultura", "Friki", "Deporte");
		  				for ($i = 0; $i < count($categories); $i++) {
							echo '<option value = "'.$i.'" ';
							echo '>'.$categories[$i].'</option>';
						}
		  				?>
		  			</select>
				</label>
			</div>
		</div>
	</div>
</div>
<div id = "mtl_content">

</div>