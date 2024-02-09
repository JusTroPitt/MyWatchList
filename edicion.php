<?php
include('funciones.php');
session_start();
try {
	$pdo = conectar();
    $username = $_POST["name"];
    $edad = $_POST["edad"];
    $sexo = $_POST["sexo"];
    $ocupacion = $_POST["ocupacion"];
    $fotoperfil = $_FILES["fotoperfil"]["name"];
	if(isset($_FILES["fotoperfil"])){
		
		move_uploaded_file($_FILES["fotoperfil"]["tmp_name"], "fotoperfil/".$_FILES["fotoperfil"]["name"]);
		
		
	}
    $id = $_SESSION['id'];
    if ($_POST['password'] == ""){
        $query = "UPDATE users SET name = '$username', edad = '$edad', sex = '$sexo', ocupacion = '$ocupacion', pic = '$fotoperfil' WHERE id = '$id'";
        $result = $pdo->query($query);
        header("Location: index.php");
    }
    else{
        $passwd = sha1($_POST['password']);
        $query = "UPDATE users SET name = '$username', edad = '$edad', sex = '$sexo', ocupacion = '$ocupacion', pic = '$fotoperfil', passwd = '$passwd' WHERE id = '$id'";
        $result = $pdo->query($query);
        header("Location: index.php");
    }


?>
<?php
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
};

?>