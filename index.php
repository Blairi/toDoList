<?php
	require 'includes/funciones.php';


	//Importar conexion
    require 'includes/config/database.php';
    $db = conectarDB();

    // echo "<pre>";
    // var_dump($db);
    // echo "</pre>";

    //Escribir query
    $query = "SELECT * FROM tareas";
    // echo $query;

    //Consultar db
    $resultadoConsulta = mysqli_query($db, $query);


    //Arreglo con mensajes de error
	$errores = [];

	$titulo = '';
	$descripcion = '';


	//Incluye un template
    incluirTemplate('header');

    //Ejecutar el código despues de que el usuario mande el formulario
	if($_SERVER['REQUEST_METHOD'] === 'POST'){
    	echo "<pre>";
    	var_dump($_POST);
    	echo "</pre>";

    	if($_POST['editar'] === "si"){
    		$tituloActualizado = mysqli_real_escape_string( $db, $_POST['titulo_actualizado']);
			$descripcionActualizada = mysqli_real_escape_string( $db, $_POST['descripcion_actualizada']);
			$id = mysqli_real_escape_string( $db, $_POST['tareaId']);

			$query = " UPDATE tareas SET titulo_tarea = '${tituloActualizado}', descripcion_tarea = '${descripcionActualizada}' WHERE id = ${id}";
			//Actualizar en la base de datos

			$resultado = mysqli_query($db, $query);
			// echo $resultado;

			if($resultado){
				header('Location: /');
			}

		}

		if($_POST['editar'] === "no"){
			$titulo = mysqli_real_escape_string( $db, $_POST['titulo']);
			$descripcion = mysqli_real_escape_string( $db, $_POST['descripcion']);

			$query = " INSERT INTO tareas (titulo_tarea, descripcion_tarea) VALUES ('$titulo', '$descripcion')";
			//echo $query;
			$resultado = mysqli_query($db, $query);
			// echo $resultado;

			if($resultado){
				header('Location: /');
			}
		}

		if($_POST['borrar'] ==='si'){
			$id = mysqli_real_escape_string( $db, $_POST['id']);
			$query = "DELETE FROM tareas WHERE id = ${id}";

            $resultado = mysqli_query($db, $query);

            if($resultado){
                header('Location: /');
            }
		}
	}

?>
	<main class="contenedor tareas">
		<h2>Tus Tareas</h2>
		<div class="contenedor-tareas">
			<?php while($tarea = mysqli_fetch_assoc($resultadoConsulta)): ?>
			<div class="borde-tarea">
				<div class="tarea">
					<div class="vista-tarea">
						<div class="tarea-acciones">
							<div class="contenedor-titulo">
								<p class="titulo-tarea"><?php echo $tarea['titulo_tarea']; ?></p>
							</div>
							<div class="contenedor-acciones">
								<i class="fa fa-pencil boton-naranja btn-editar" aria-hidden="true"></i>
								<i class="fa fa-check boton-verde eliminar-tarea" aria-hidden="true"></i>
							</div>
						</div>
						<div class="tarea-info">
							<p class="descripcion"><?php echo $tarea['descripcion_tarea']; ?></p>
						</div>
					</div>
					<div class="editar-tarea ocultar">
						<form action="" class="formulario" method="POST">
							<input type="hidden" name="editar" value="si">
							<input type="hidden" name="tareaId" value="<?php echo $tarea['id']; ?>">
							<div class="campo">
								<label for="tarea">Tarea</label>
								<input name="titulo_actualizado" type="text" id="tarea" placeholder="Min. 5 caracteres" value="<?php echo $tarea['titulo_tarea']; ?>">
							</div>

							<div class="campo">
								<label for="tarea-descripcion">Descripcion</label>
								<textarea id="tarea-descripcion" placeholder="Min. 16 caracteres" name="descripcion_actualizada"><?php echo $tarea['descripcion_tarea']; ?></textarea>
							</div>

							<div class="mostrar-alertas"></div>

							<div class="controles alinear-derecha">
								<input type="submit" value="Guardar" class="boton-verde guardar deshabilitado" disabled="">
								<input type="reset" value="Cancelar" class="boton-rojo cancelar">
							</div>
						</form>
					</div>
					<div class="confirmar-tarea ocultar">
						<h3>¿Has terminado esta Tarea?</h3>
						<form action="" method="POST">
							<div class="campo">
								<input type="reset" value="&#xf00d;" class="boton-rojo no-confirmar fa fa-times">
								<input type="hidden" name="id" value="<?php echo $tarea['id']; ?>">
								<input type="hidden" name="borrar" value="si">
								<input type="submit" 
								class="fa fa-check boton-verde" name="" value="&#xf00c;">
							</div>
						</form>
					</div>
				</div>
			</div>
		<?php endwhile; ?>
		</div><!-- CONTENEDOR TAREAS -->
	</main>

	<i class="fa fa-plus btn-nueva-tarea" aria-hidden="true"></i>
	
	<div class="crear-tarea ocultar">
		<div class="tarea ventana-crear">
			<div class="editar-tarea">
				<form action="" class="formulario" method="POST">
					<input type="hidden" name="editar" value="no">
					<div class="campo">
						<label for="tarea">Tarea</label>
						<input type="text" id="tarea" placeholder="Min. 5 caracteres"  name="titulo">
					</div>

					<div class="campo">
						<label for="tarea-descripcion">Descripcion</label>
						<textarea id="tarea-descripcion" placeholder="Min. 16 caracteres" name="descripcion"></textarea>
					</div>

					<div class="mostrar-alertas"></div>

					<div class="controles alinear-derecha">
						<input type="submit" value="Guardar" class="boton-verde guardar deshabilitado" disabled="">
						<input type="reset" value="Cancelar" class="boton-rojo cancelar" id="boton-cancelar">
					</div>
				</form>
			</div>
		</div>
	</div>

	<script src="https://use.fontawesome.com/65f05820fe.js"></script>
	<script src="build/js/bundle.min.js"></script>
</body>
</html>