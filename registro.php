<?php
session_start();
include('funciones.php');
try {
	$pdo = conectar();
    $username = $_POST["name"];
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];
    $ocupacion = $_POST["ocupacion"];
    $passwd = sha1($_POST["password"]);
    $fotoperfil = $_FILES["fotoperfil"]["name"];
	if(isset($_FILES["fotoperfil"])){
		
		move_uploaded_file($_FILES["fotoperfil"]["tmp_name"], "fotoperfil/".$_FILES["fotoperfil"]["name"]);
		
		
	}
	$query = "INSERT INTO users (name, edad, sex, ocupacion, pic, passwd) VALUES ('$username', '$edad', '$sexo', '$ocupacion', '$fotoperfil', '$passwd')";
	$result = $pdo->query($query);
    header("Location: formulario-login.php");
?>
<?php
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
};

?>
