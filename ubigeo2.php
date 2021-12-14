<?php 
    $provincia=$_POST['idProvincia'];

    require_once "./config/configDB.php";

    $conexion = new PDO(SGBD,USER,PASS);

    /*CONSULTA*/
    $consulta = "SELECT idDistrito ,DistritoDescripcion 
    FROM distrito
    WHERE idProvincia = $provincia
    ORDER BY DistritoDescripcion ASC";

    /**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);
    $html="";
    while($rowM = $resultado->fetch())
    {   
        $id = $rowM['idDistrito'];
        $html.= "<option value='".$id."'>".$rowM['DistritoDescripcion']."</option>";
    }
    
    echo $html;
?>