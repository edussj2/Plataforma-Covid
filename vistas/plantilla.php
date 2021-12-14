<?php
    session_start(['name'=>'UNPRG']);
?>
<!doctype html>
<html lang="es">
<head>

    <!-- *** Meta Descripciones *** -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title><?php echo COMPANY; ?></title>
    <link rel="icon" type="image/png" href="<?php echo SERVERURL; ?>vistas/assets/iconos/iconoVirus.png"/>
    <!-- *** Meta Descripciones *** -->

    <!-- === Estilos CSS === -->
    <?php 
        include "./vistas/modulos/style.php";
    ?>
    <!-- === Estilos CSS === -->

    <!-- === JavaScript === -->
    <?php 
        include "./vistas/modulos/script.php";
    ?>
    <!-- === JavaScript  === -->
    <!-- === Google fonts === -->
    <link href="https://fonts.googleapis.com/css?family=Muli:300,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@200;300;500&family=Poppins:ital,wght@0,200;0,600;1,200;1,500&display=swap" rel="stylesheet">   
    <!-- === Google fonts === -->

    <!-- === Iconos === -->
    <link href="https://unpkg.com/ionicons@4.5.10-0/dist/css/ionicons.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <!-- === Iconos === -->

</head>
<body>
<?php
    $peticionAjax = false;
    require_once "./controladores/vistasControlador.php";

    $vt = new vistasControlador();
    $vistasRpta = $vt->obtener_vistas_controlador();

    if($vistasRpta =="login" || $vistasRpta =="404"){
        require_once "./vistas/contenidos/".$vistasRpta."-view.php";
    }else{
        require_once "./controladores/loginControlador.php";

        $lc = new loginControlador();

        if(!isset($_SESSION['token_unprg']) || !isset($_SESSION['usuario_unprg'])){
            echo $lc->forzar_cierre_sesion_controlador();
        }
?>
    
    <!--  === Barra de Navegacion  === -->
    <?php 
        include "./vistas/modulos/navBar.php";
    ?>
    <!--  === Barra de Navegacion  === -->
    
    <div class="d-flex contenido-slide-main">

      <!--  === Sidebar ===  -->
      <?php 
        include "./vistas/modulos/sideBar.php";
      ?>
      <!--  === Sidebar  === -->

      <!--  === Contenido ===  -->
      <main class="content bg-grey p-3 mb-5">

        <!--  === Contenido Neto === -->
        <?php 
          require_once $vistasRpta;
        ?>
        <!--  === Contenido Neto === -->

      </main>
      <!--  === Contenido  === -->
    </div>
         
<?php
     include "./vistas/modulos/logout.php";
     include "./vistas/modulos/selects.php";
    };
?>
    <!-- === JavaScript === -->
    <?php 
        include "./vistas/modulos/scriptExtra.php";
    ?>
    <!-- === JavaScript  === -->
</body>
</html> 