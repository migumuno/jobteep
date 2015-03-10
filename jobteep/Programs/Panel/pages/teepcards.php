<div class = "row">
	<div class = "small-10 small-offset-1 columns">
		<form method="post" action="?program=panel&menu=teepcard">
			<div class = "small-12 columns"><input type = "text" name = "valor" value = ""></div>
			<div class = "small-12 columns text-center">
		      <input type="radio" name="filtro" value="domain" id="domain"><label for="domain">Dominio</label>
		      <input type="radio" name="filtro" value="name" id="name"><label for="name">Nombre</label>
			</div>
			<div class = "small-12 columns text-center"><button class = "button" type = "submit">Buscar</button></div>
		</form>
	</div>
</div>
<div class = "row">
	<div class = "small-10 small-offset-1 column">
		<?php
		if ($_SESSION['SO']->getUID() == 1) {
			$controller = $_SESSION['SO']->getController();
			if (isset($_POST['filtro']) && isset($_POST['valor']) && $_POST['valor'] != "")
				$controller->getTeepcards ($_POST['filtro'], $_POST['valor']);
			else 
				$controller->getTeepcards ();
		}
		?>
	</div>
</div>