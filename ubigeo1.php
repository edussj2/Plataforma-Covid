<?php 
    $departamento=$_POST['idDepartamento'];

	require_once "./config/configDB.php";

    $conexion = new PDO(SGBD,USER,PASS);

    /*CONSULTA*/
    $consulta = "SELECT idProvincia ,ProvinciaDescripcion 
    FROM provincia
    WHERE idDepartamento = $departamento
    ORDER BY ProvinciaDescripcion ASC";

    /**-----CONECTAMOS Y GUARDAMOS LOS DATOS----**/
    $resultado = $conexion->query($consulta);
    
    $html="";
    while($rowM = $resultado->fetch())
    {
        $html.= "<option value='".$rowM['idProvincia']."'>".$rowM['ProvinciaDescripcion']."</option>";
    }
    
    echo $html;
?>