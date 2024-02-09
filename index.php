<?php 
	include('funciones.php');
	$pdo = conectar();
	session_start();


	
	$querygeneral = "SELECT COUNT(DISTINCT(id_movie)) AS N_TOTAL, ROUND(AVG(score),4) AS MEDIATOTAL FROM user_score";
	$resultgeneral = $pdo->query($querygeneral);
	$arraygeneral[] = $resultgeneral->fetch(PDO::FETCH_ASSOC);


	$querypelis = "
	SELECT movie.*,user_score.id_movie, ROUND(AVG(user_score.score),2) AS media, COUNT(user_score.score) AS num_puntuaciones,
	ROUND(((".$arraygeneral[0]['N_TOTAL'].")*(".$arraygeneral[0]['MEDIATOTAL'].")+(ROUND(AVG(user_score.score),4))*(COUNT(user_score.score)))
	/((".$arraygeneral[0]['N_TOTAL'].")+(COUNT(user_score.score))),4) AS Bayesian
	FROM user_score
	INNER JOIN movie ON user_score.id_movie=movie.id
	GROUP BY user_score.id_movie
	ORDER BY id"
	;
	$resultpelis = $pdo->query($querypelis);
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
				
				<?php if (isset($_SESSION['name'])) {  
				echo '<li><a href="recomendar.php">Mis Recomendaciones</a></li>';
				} ?>
				
			</ul>
		</nav>
		<div class="boton-login">
			<?php if (isset($_SESSION['name'])) { 
				$var = $_SESSION['name'];
				$var2 = $_SESSION['id'];
			?>
				<!-- Si el usuario ha iniciado sesión -->
				<a href="destroy.php" class="boton">Cerrar sesión</a>
				<a href="formulario-edicion.php" class="boton">Editar perfil</a>
			<?php } else { ?>
				<!-- Si el usuario no ha iniciado sesión -->
				<a href="formulario-login.php" class="boton">Iniciar sesión</a>
				<a href="formulario-registro.php" class="boton">Crear cuenta</a>
			<?php } ?>
		</div>
	</header>

	<main>
		<section class="table-intro">
			<?php if (isset($_SESSION['name'])) { ?>
				<!-- Si el usuario ha iniciado sesión -->
				<h2> ¡Bienvenido <?php echo $var . '  #' . $var2; ?>!  Aqui tienes tu catálogo de películas </h2>
			<?php } else { ?>
			<h2>Catálogo de películas</h2>
			<?php }?>
		</section>
		<section class="table">
			<table id="datatable"> 
				<thead>
					<tr>
						<th>Portada</th>
						<th>Detalles</th>
						<th>Puntuación media</th>
						<th>Puntuación ponderada</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($peli = $resultpelis->fetch(PDO::FETCH_ASSOC)) { ?>
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
								<div class="movie-description"><br><?php echo $peli['desc']; ?></div>
								<div class="release-date">Fecha de estreno: <?php echo $peli['date']; ?></div>
								<a href="<?php echo $peli['url_imdb']; ?>" class="more-details">Más detalles aquí</a>
							</td>
							<td><?php echo $peli['media']; ?> de <?php echo $peli['num_puntuaciones']; ?> usuarios</td>
							<td><?php echo $peli['Bayesian']; ?></td>
						</tr>
					<?php }?>
				</tbody>
			</table>
		</section>
	</main>
</body>

</html>
