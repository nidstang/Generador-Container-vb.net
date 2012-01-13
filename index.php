<?php
$comodines = array(
		'Integer' => 'i',
		'String' => 's',
		'Double' => 'd',
		'VariantType' => 'v',
		'Object' => 'o'
	);
if($_POST && !empty($_POST['datos'])){
	$lineas = explode("\n", $_POST['datos']);
	$result = array();

	foreach($lineas as $key => $value){
		$datos = explode(" ", $value);
		$datos[1] = trim($datos[1]);
		if($i = array_search($datos[1], $comodines)){
			$datos[1] = $i;
		}
		$result[] = "	Private _".$datos[0]." As ".ucfirst($datos[1]);
	}
	$nombres = array();
	$datos = implode("\n", $result); 
	$datos = str_replace("Private", "Public Property", $datos);
	$datos = str_replace("As", "() As", $datos);
	$datos = str_replace("_", "", $datos);
	$datos = explode("\n", $datos);
	$property = "";

	foreach ($datos as $key => $valor) {
		unset($nombres);
		$nombres = array();
		$nombres = explode(" ", $datos[$key]);
		for($i=0;$i<count($nombres);$i++){
			if($nombres[$i] == ""){
				unset($nombres[$i]);
			}
		}
		$nombres = array_values($nombres);

		$property .= $valor."\n	 	Get
			Return Me._".$nombres[2]."
        	End Get\n
        	Set(ByVal value As ".$nombres[5].")
       			Me._".$nombres[2]." = value
        	End Set
        End Property\n\n";
	}
}



?>
<html>
<head>
	<title>Generator</title>
	<link rel="stylesheet" href="estilos.css">
	<meta name="name" charset="utf-8" />	
</head>	
<body>
	<div id="content" class="center">
	<?php if(!$_POST){ ?>
	<div id="ejemplo" class="naranja">
		<h2>Y esto pá que vale?</h2>
		<p>Ejemplo de sintaxis: nombre_variable tipo_datos</p>
		<p>Tambien se genera su Property correspondiente</p>
	</div>
	<form action="index.php" method="post" accept-charset="utf-8">
		<div><input type="text" name="clase_name" placeholder="Nombre de la clase"></div>
		<div><textarea name="datos" placeholder="Se generaran los atributos y los Property" size="50" class="datos"></textarea></div>
		<div><input type="submit" value="Generar" /></div>
	</form>
	<?php } ?>
	<?php
		if($_POST){
			echo '<form action="#" accept-charset="utf-8">';
			echo "<textarea class='datos' name='cajatexto'>";
			echo "Public Class c".ucfirst($_POST['clase_name'])."\n	'Atributos\n";
			foreach($result as $key => $valor){
				echo $valor."\n";
			}
			echo "\n\n	'Metodos Property\n";
			echo $property;
			echo "\nEnd Class";
			echo "</textarea>";
			echo '<div>';
			echo '<input type="button" onclick="javascript:this.form.cajatexto.focus();this.form.cajatexto.select();"';
			echo 'value="Seleccionar Todo" /></div></form>';
			echo '<div><a href="index.php"><button>Volver</button></a></div>';
		}
	?>
		<div id="leyenda" class="center">
			<h4>Tipos de datos</h4>
			<?php 
				foreach($comodines as $key => $valor){
					echo "<p>".$key." => ".$valor."</p>";
				}
			?>
		</div>
		<footer>
			<p>Realizado por tu amigo KeIbOl!! :D</p>
			<p>Porque programar nunca fue tan divertido..</p>
		</footer>
	</div>
</body>
</html>