<?php 
    $facultad=$_POST['idFacultad'];

	require_once "./config/configDB.php";

    $conexion = new PDO(SGBD,USER,PASS);

    /*CONSULTA*/
    $consulta = "SELECT idEscuela ,EscuelaDescripcion 
    FROM escuela
    WHERE idFacultad = $facultad
    ORDER BY EscuelaDescripcion ASC";

    /**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);

    $html="";
    while($rowM = $resultado->fetch())
    {
        $html.= "<option value='".$rowM['idEscuela']."'>".$rowM['EscuelaDescripcion']."</option>";
    }
    
    echo $html;
?>