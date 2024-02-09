<?php
	include('funciones.php');
	
try{	
$pdo= conectar();

	session_start();
			 if(isset($_POST['comentario'])){ 
			 
			 $idmovie = $_POST["idmovie"];
			 $iduser =$_SESSION['id'];
			 $input = $_POST['comentario']; 
			 
			 
			 $querycomment="
			 INSERT INTO moviecomments (movie_id,user_id,comment)
			 VALUES ('$idmovie','$iduser','$input')
			 ";
			 $resultcomment = $pdo->query($querycomment);
			 }
			  header("Location: detalles.php?id=".$idmovie."");  
			 }
			 
			 catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
};
			?>
