<?php
session_start();
include('funciones.php');
try {
    $pdo = conectar();
	$querycontador = "SELECT COUNT(*) FROM movie";
    $resultcontador = $pdo->query($querycontador);
    $numero = $resultcontador->fetchColumn();
    

} catch (PDOException $e) {
	echo 'Connection failed: ' . $e->getMessage();
};

?>

<html>
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="hojaestilosv2.css">
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
	</header>
    <section class="form-login">
    <h2 class= "titulo">LOGIN</h2>
        <form action = "login.php" method = "POST">
            <table class ="tabla">
                <tr>
                    <td>
                        <input class = "texto" type = "text" name = "name" placeholder="Nombre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class = "texto" type = "password" name = "password" placeholder="Contraseña">
                    </td>
                </tr>
                <tr>
                    <td class="enviar">
                        <input class = "enviar" type = "submit">
                    </td>
                </tr>
            </table>
            <?php
                if(isset($_GET["fallo"]) && $_GET["fallo"] == 'true')
                {
                    echo "<div style='color:red'>Nombre o contraseña invalido </div>";
                }
            ?>
        </form>
    </section>
    </body>
</html>
