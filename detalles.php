<?php
include('funciones.php');
$pdo = conectar();
session_start();

$querypeli = "SELECT * FROM movie WHERE id=" . $_GET["id"];
$resultpeli = $pdo->query($querypeli);
$arraypeli[0] = $resultpeli->fetch(PDO::FETCH_ASSOC);

$querygenero = "
	SELECT id_genre, genre.name, movie_id
	FROM (
		SELECT movie_id, genre AS id_genre FROM moviegenre WHERE movie_id=" . $_GET["id"] . "
	) AS GENEROS
	INNER JOIN genre
	ON ID_GENRE = genre.id
";
$resultgenero = $pdo->query($querygenero);

$querycomments = "SELECT user_id, comment, users.name
	FROM (
		SELECT user_id, comment FROM moviecomments WHERE movie_id=" . $_GET["id"] . "
	) AS COMMENTS
	INNER JOIN users
	ON user_id = users.id";
$resultcomments = $pdo->query($querycomments);

$querycontador = "SELECT COUNT(*) FROM movie";
$resultcontador = $pdo->query($querycontador);
$numero = $resultcontador->fetchColumn();

if (isset($_SESSION['id'])) {
	$var = $_SESSION['id'];
	$queryvaloracion = "SELECT score FROM user_score WHERE (id_movie=" . $_GET["id"] . " AND id_user=" . $var . ")";
	$resultvaloracion = $pdo->query($queryvaloracion);
	$arrayvaloracion[0] = $resultvaloracion->fetch(PDO::FETCH_ASSOC);
	$var = $_SESSION['id'];
}
?>

<html>
<head>
	<link rel="icon" href="imagen.png">
	<meta charset="UTF-8">
	<title>MyWatchList</title>
	<link rel="stylesheet" href="hojaestilosv2.css">
	<link rel="stylesheet" href="hojaestilodetalles.css">
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
	<h1><?php echo $arraypeli[0]['title']; ?></h1> <br>
		<div class="container">
			<div>
				<?php if (file_exists("images/" . $arraypeli[0]['url_pic'])) { ?>
					<img class="portada" src="images/<?php echo $arraypeli[0]['url_pic']; ?>" alt="Portada">
				<?php } else { ?>
					<img class="portada" src="images/zimages.jpg" alt="Portada">
				<?php } ?>
			</div>
			<div>
				<div class="descripcion">
					<h3>Descripción</h3>
					<p><?php echo $arraypeli[0]['desc']; ?></p>
				</div>
				<div>
			<?php
				echo '<h3> Géneros </h3>';
				while($arraygenero=$resultgenero->fetch(PDO::FETCH_ASSOC)){
					echo '<ul class="generos">';
					echo "<li class='generos'>".$arraygenero['name']." </li>";
					echo "</ul>";
				}
			?>
				</div>
			</div>
		</div>
		<?php if (isset($var)) { ?>
		<div class="valoracion">
			<div>
				<h3>Tu puntuación</h3>
				<?php if (isset($var)) {
					if ($arrayvaloracion[0] != null) {
						echo "<p>Número de estrellas: " . $arrayvaloracion[0]["score"] . "</p>";
					} else {
						echo "<p>¿Aún no la has puntuado? Hazlo ahora :)</p>";
					}
				?>
					<form action="gestionarpuntuacion.php" method="POST">
						<label for="puntuacion">Puntuación:</label>
						<input type="radio" id="uno" name="puntuacion" value="1">1
						<input type="radio" id="dos" name="puntuacion" value="2">2
						<input type="radio" id="tres" name="puntuacion" value="3">3
						<input type="radio" id="cuatro" name="puntuacion" value="4">4
						<input type="radio" id="cinco" name="puntuacion" value="5">5
						<input type="hidden" id="idmovie" name="idmovie" value="<?php echo $_GET['id']; ?>">
						<input type="hidden" id="valor" name="valor" value="<?php echo $arrayvaloracion[0]["score"]; ?>">
						<input type="submit" name="submitpuntuacion" value="Enviar">
					</form>
				<?php } ?>
			</div>
			<?php } ?>
			<div>
				<div>
					<h3>Comentarios</h3>
					<table id="datatable">
						<thead>
						
							<th>Usuario</th>
							<th>Comentario</th>
						
						</thead>
						<tbody>
							<?php
							while ($arraycomments = $resultcomments->fetch(PDO::FETCH_ASSOC)) {
								echo "<tr>
									<td>" . $arraycomments['name'] . "</td>
									<td>" . $arraycomments['comment'] . "</td>
								</tr>";
							}
							?>
						</tbody>
					</table>
				</div>	
				<?php if (isset($var)) { ?>
					<form action="procesarcomentario.php" method="POST">
						<label>Escribe tu comentario:</label>
						<input type="text" name="comentario">
						<input type="hidden" name="idmovie" value="<?php echo $_GET['id']; ?>">
						<input type="submit" value="Enviar">
					</form>
				<?php } ?>
			</div>
		</div>
	</main>
</body>
</html>
