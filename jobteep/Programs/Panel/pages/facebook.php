<div class = "row">
	<div class = "large-10 large-offset-1 columns">
		<br>
		<div class = "row">
			<h2>Categorías</h2>
			<?php
			$controller = $_SESSION['SO']->getController();
			$likes = $controller->getItemFbk ('likes');
			$categories = array();
			$names = array();
			$d = 0;
			echo 'Empiezo<br>';
			//Hago un while para continuar la paginación de resultados.
			do {
				echo '<br><h3>Página: '.$d.'</h3><br>';
				//Excepto en la primera vuelta, en el resto mando el after.
				if ($d != 0) {
					$after = $likes['paging']['cursors']['after'];
					$likes = $controller->getItemFbk ('likes', $after);
				}
				//Si no está ya en el array introduzco el nuevo dato.
				for ($i = 0; $i < count($likes['data']); $i++) {
					if (!in_array($likes['data'][$i]['category'], $categories)) {
						$category = $likes['data'][$i]['category'];
						$name = $likes['data'][$i]['name'];
						echo 'Categoría: '.$category.', Nombre: '.$name.'<br>';
					}
				}
				$d++;
			} while (isset ($likes['paging']['cursors']['after']) && $likes['paging']['cursors']['after'] != '');
			
			?>
		</div>
		<br>
		<div class = "row">
			<h2>Libros</h2>
			<?php
			$books = array();
			$reads = $controller->getItemFbk ('book_reads');
			for ($i = 0; $i < count($reads['data']); $i++) {
				$books[] = $reads['data'][$i]['data']['book']['title'];
			}
			$wants = $controller->getItemFbk ('book_wants');
			for ($i = 0; $i < count($wants['data']); $i++) {
				$books[] = $wants['data'][$i]['data']['book']['title'];
			}
			for ($i = 0; $i < count($likes['data']); $i++) {
				if ($likes['data'][$i]['category'] == "Book")
					$books[] = $likes['data'][$i]['name'];
			}
			for ($i = 0; $i < count($books); $i++)
				echo $books[$i].', ';
			?>
		</div>
		<br>
		<div class = "row">
			<h2>Películas</h2>
			<?php
			$movies = array();
			$watches = $controller->getItemFbk ('video_watches');
			for ($i = 0; $i < count($watches['data']); $i++) {
				if (isset($watches['data'][$i]['data']['movie']['title']))
					$movies[] = $watches['data'][$i]['data']['movie']['title'];
				else if (isset($watches['data'][$i]['data']['tv_show']['title']))
					$movies[] = $watches['data'][$i]['data']['tv_show']['title'];
				else if (isset($watches['data'][$i]['data']['tv_episode']['title']))
					$movies[] = $watches['data'][$i]['data']['tv_episode']['title'];
				else if (isset($watches['data'][$i]['data']['video']['title']))
					$movies[] = $watches['data'][$i]['data']['viedo']['title'];
			}
			$wants = $controller->getItemFbk ('video_wants');
			for ($i = 0; $i < count($wants['data']); $i++) {
				if (isset($watches['data'][$i]['data']['movie']['title']))
					$movies[] = $watches['data'][$i]['data']['movie']['title'];
				else if (isset($watches['data'][$i]['data']['tv_show']['title']))
					$movies[] = $watches['data'][$i]['data']['tv_show']['title'];
				else if (isset($watches['data'][$i]['data']['tv_episode']['title']))
					$movies[] = $watches['data'][$i]['data']['tv_episode']['title'];
				else if (isset($watches['data'][$i]['data']['video']['title']))
					$movies[] = $watches['data'][$i]['data']['viedo']['title'];
			}
			for ($i = 0; $i < count($likes['data']); $i++) {
				if ($likes['data'][$i]['category'] == "Movie")
					$movies[] = $likes['data'][$i]['name'];
			}
			for ($i = 0; $i < count($movies); $i++)
				echo $movies[$i].', ';
			?>
		</div>
	</div>
</div>