<?php 
	include('funciones.php');
	$pdo = conectar();
	session_start();
    $id = $_SESSION['id'];

	
	$querygeneral = "SELECT movie.id as id, movie.title as title, movie.url_pic as url_pic, movie.date as fecha, movie.desc as descrip, movie.url_imdb as url_imdb, recs.rec_score as score FROM movie,recs WHERE recs.user_id=$id AND movie.id=recs.movie_id ORDER BY recs.rec_score DESC LIMIT 10";
	$resultgeneral = $pdo->query($querygeneral);

    $querycontador = "SELECT COUNT(*) FROM movie";
    $resultcontador = $pdo->query($querycontador);
    $numero = $resultcontador->fetchColumn();
	
?>

<!DOCTYPE html>
<html lang="es">

<head> 
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>MyWatchList</title>
	<link rel="icon" href="imagen.png">
	<link rel="stylesheet" href="hojaestilosv2.css">
	<!--<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/jq-3.6.0/dt-1.13.1/datatables.min.js"></script> -->
	<script src="js/datatable.js"></script>
	<script src="js/funciones.js"></script>


</head>

<body>
	<header class="header">
		<div class="logo">
			<a href="index.php">
				<img src="imagen2.png" alt="logo" class="logo">
			</a>
		</div>
		<nav class="navigation">
			<ul class="nav-list">
				<li><a href="index.php">Inicio</a></li>
				
				<li><a href="#" id="random" onclick="aleatorio(<?php echo $numero; ?>)">Pelicula al azar</a></li>
			</ul>
		</nav>
		<div class="boton-login">
			<?php if (isset($_SESSION['name'])) { 
				$var = $_SESSION['name'];
				$var2 = $_SESSION['id'];}
			?>
				<!-- Si el usuario ha iniciado sesión -->
				<a href="destroy.php" class="boton">Cerrar sesión</a>
				<a href="formulario-edicion.php" class="boton">Editar perfil</a>
            
		</div>
	</header>

	<main>
		<section class="table-intro">
				<h2> Peliculas Recomendadas para <?php echo $var . '  #' . $var2; ?></h2>
		</section>
		<section class="table">
			<table id="datatable"> 
				<thead>
					<tr>
						<th>Portada</th>
						<th>Detalles</th>
						<th>Puntuación calculada de recomendacion</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($peli = $resultgeneral->fetch(PDO::FETCH_ASSOC)) { ?>
						<tr>
							<td>
								<?php if (file_exists("images/".$peli['url_pic'])) { ?>
								<img class="portada" src="images/<?php echo $peli['url_pic']; ?>" alt="Portada">
								<?php 
								} 
								else { ?>
								<img class="portada" src="images/zimages.jpg" alt="Portada">
								<?php } ?>
								
							</td>
							<td>
								<div class="movie-title">
									<a href="detalles.php?id=<?php echo $peli['id']; ?>"><?php echo $peli['title']; ?></a>
								</div>
								<div class="movie-description"><br><?php echo $peli['descrip']; ?></div>
								<div class="release-date">Fecha de estreno: <?php echo $peli['fecha']; ?></div>
								<a href="<?php echo $peli['url_imdb']; ?>" class="more-details">Más detalles aquí</a>
							</td>
                            <td><?php echo $peli['score']; ?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</section>
	</main>
</body>

</html>