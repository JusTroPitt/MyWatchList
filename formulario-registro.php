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

    <section class="form-registro">
    <h2 class= "titulo">REGISTRO</h2>
        <form action = "registro.php" method = "POST" enctype="multipart/form-data">
            <table class="tabla">
                <tr>
                    <td>
                        <input class="texto" type = "text" name = "name"required placeholder="Nombre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="texto" type = "number" name = "edad" required placeholder="Edad">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="letras">Sexo: </label>
                        <input type = "radio" name = "sexo" value = "M" required>
                        <label class="letras">Hombre</label>
                        <input type = "radio" name = "sexo" value = "F" required>
                        <label class="letras">Mujer</label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="letras">Ocupación: </label>
                        <select class="form-control" id="ocupacion" name="ocupacion" required>
							<option value="artist">Artista</option>
							<option value="doctor">Doctor</option>
		    				<option value="educator">Profesor</option>
							<option value="engineer">Ingeniero</option>
							<option value="entertainment">Productor</option>
							<option value="executive">Ejecutivo</option>
							<option value="healthcare">Medico</option>
							<option value="homemaker">Amo de casa</option>
							<option value="lawyer">Abogado</option>
							<option value="librarian">Bibliotecario</option>
							<option value="marketing">Marketing</option>
							<option value="programmer">Programador</option>
							<option value="retired">Jubilado</option>
							<option value="salesman">Comerciante</option>
						    <option value="scientist">Cientifico</option>
							<option value="student">Estudiante</option>
							<option value="technician">Tecnico</option>
							<option value="writer">Escritor</option>
							<option value="none">Ninguno</option>
							<option value="other">Otro</option>
						</select>
                    </td>
                </tr>
                <tr>
                    <td>
                        <input type = "password" name = "password" required placeholder="Contraseña">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="letras">Foto de perfil: </label>
                        <input type = "file" name = "fotoperfil">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="enviar" type = "submit">
                    </td>
                </tr>
            </table>
        </form>
    
    </body>
</html>