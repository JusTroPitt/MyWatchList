<?php
function conectar(){
try {
	$pdo = new PDO('mysql:host=localhost;dbname=ai1', 'ai1','ai2023');
	return  $pdo;
	
	} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
}
}	
	?>