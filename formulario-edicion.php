        <?php
        include('funciones.php');
        session_start();
        try {
            $pdo = conectar();
            $id = $_SESSION['id'];
        
            $query = "SELECT * FROM users WHERE id = $id";
            $result = $pdo->query($query);
            $line = $result->fetch(PDO::FETCH_ASSOC);
            $sex = $line['sex'];
			
			$querycontador = "SELECT COUNT(*) FROM movie";
			$resultcontador = $pdo->query($querycontador);
			$numero = $resultcontador->fetchColumn();
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
				<?php if (isset($_SESSION['name'])) {
					echo '<li><a href="recomendar.php">Mis Recomendaciones</a></li>';
				} ?>
				
			</ul>
		</nav>
		
		<div class="perfil">
			
		<?php if(file_exists("fotoperfil/".$line['pic'])) {echo "<img class='fotoperfil' src=fotoperfil/".$line['pic'].">"; } 
		  else  {echo "<img class='fotoperfil' src='fotoperfil/defecto.png'>"; }
		 ?>
		</div>
	</header>
    


    <section class="form">
    <h2 class = "titulo">
        EDITAR PERFIL
    </h2>
        <form action = "edicion.php" method = "POST" enctype="multipart/form-data">
            <table class="tabla">
                <tr>
                    <td>
                        <input class="texto" type = "text" name = "name" value="<?php echo $line['name'] ?>" placeholder="Nombre">
                    </td>
                </tr>
                <tr>
                    <td>
                        <input class="texto" type = "number" name = "edad" value="<?php echo $line['edad'] ?>" placeholder="Edad">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label class="letras">Sexo: </label>
                        <input type = "radio" name = "sexo" value = "M" <?php echo ($sex == 'M') ? "checked" : ""; ?> >
                        <label class="letras">Hombre</label>
                        <input type = "radio" name = "sexo" value = "F" <?php echo ($sex == 'F') ? "checked" : ""; ?> >
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
                        <input class="texto" type = "password" name = "password" placeholder="Contraseña">
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
                        <input type = "submit" class="enviar">
                    </td>
                </tr>
            </table>
        </form>
        </section>
        <?php
            } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            };
    

        ?>
    
    </body>
</html>