<?php
include('funciones.php');

try {
	$pdo = conectar();
	session_start();

	if (isset($_POST['puntuacion'])) {
		$valor = $_POST['valor'];
		$input = $_POST['puntuacion'];
		$iduser = $_SESSION['id'];
		$idmovie = $_POST["idmovie"];

		if ($valor > 5 || $valor < 0) {
			$querypunt = "INSERT INTO user_score (id_user, id_movie, score, time) VALUES ('$iduser', '$idmovie', '$input', CURRENT_TIMESTAMP)";
			$resultpunt = $pdo->query($querypunt);
		} else {
			$querypunt = "UPDATE user_score SET score = '$input', time = CURRENT_TIMESTAMP WHERE id_user = '$iduser' AND id_movie = '$idmovie'";
			$resultpunt = $pdo->query($querypunt);
		}
	}

	header("Location: detalles.php?id=" . $idmovie);
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
?>
