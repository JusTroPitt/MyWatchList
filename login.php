<?php
session_start();
include('funciones.php');
try {
	$pdo = conectar();
    $username = $_POST["name"];
    $passwd = $_POST["password"];
	$query = "SELECT * FROM users WHERE name='$username'";
	$result = $pdo->query($query);
    
?>

<?php
try{
	if($result->rowCount()<=0){  header("Location: formulario-login.php?fallo=true");}
	while ($line = $result->fetch(PDO::FETCH_ASSOC)) {
       
            if($line["passwd"]==sha1($passwd)){
                $_SESSION["id"]=$line["id"];
                $_SESSION["name"]=$line["name"];
                header("Location: index.php");
            }
            else{
                header("Location: formulario-login.php?fallo=true");
				
            }
        
        
    }
}
catch (PDOException $e){
    echo 'Login failed: ' . $e->getMessage();
}

?>

<?php
} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
};

?>
