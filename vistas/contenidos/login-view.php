<!-- *** Preloader *** -->
<div class="spinner-wrapper">
    <div class="spinner">
        <div class="bounce1"></div>
        <div class="bounce2"></div>
        <div class="bounce3"></div>
    </div>
</div>
<!-- *** Fin preloader *** -->

    
<div class="container-login">
    <div class="forms-container-login">
        <div class="signin-pass">
            <form action="" class="sign-in-form" method="POST" autocomplete="off">
              <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/logoUnprg.png" alt="" class="unprg-login">
              <h2 class="title">Iniciar Sesión</h2>
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input type="email" placeholder="Correo Institucional" name="usuario" required="" maxlength="60"/>
              </div>
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input type="password" placeholder="Contraseña" name="clave" required="" minlength="6"/>
              </div>
              <input type="submit" value="Iniciar" class="boton" />
              <p class="social-text">Solicita tu cuenta al correo spunprg@gmail.com</p>
              <div class="social-media">
                <a href="http://www.unprg.edu.pe/admision/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Admisión" target="_blank">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="http://cpu.unprg.edu.pe/cpu/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Centro-Pre" target="_blank">
                  <i class="fa fa-book"></i>
                </a>
                <a href="http://www.unprg.edu.pe/univ/portal/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Pre-Grado" target="_blank">
                  <i class="fas fa-university"></i>
                </a>
                <a href="https://www.epgunprg.edu.pe/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Post-Grado" target="_blank">
                  <i class="fas fa-graduation-cap"></i>
                </a>
              </div>
            </form>
            <form action="" class="pass-form" method="POST" autocomplete="off">
              <img src="<?php echo SERVERURL; ?>vistas/assets/iconos/logoUnprg.png" alt="" class="unprg-login">
              <h2 class="title">¿Olvidaste tu contraseña?</h2>
              <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input type="email" placeholder="Correo Institucional" name="correoInstitucional" required="" maxlength="60" />
              </div>
              <input type="submit" class="boton" value="Recuperar" />
              <p class="social-text">Solicita tu cuenta al correo spunprg@gmail.com</p>
              <div class="social-media">
                <a href="http://www.unprg.edu.pe/admision/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Admisión" target="_blank">
                  <i class="fas fa-edit"></i>
                </a>
                <a href="http://cpu.unprg.edu.pe/cpu/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Centro-Pre" target="_blank">
                  <i class="fa fa-book"></i>
                </a>
                <a href="http://www.unprg.edu.pe/univ/portal/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Pre-Grado" target="_blank">
                  <i class="fas fa-university"></i>
                </a>
                <a href="https://www.epgunprg.edu.pe/" class="social-icon" data-toggle="tooltip" data-placement="bottom" title="Post-Grado" target="_blank">
                  <i class="fas fa-graduation-cap"></i>
                </a>
              </div>
              <div class="RespuestaAjax"></div>
            </form>
        </div>
    </div>
  
    <div class="panels-container-login">
        <div class="panel left-panel">
            <div class="content-login">
              <h3>¿No conoces esta plataforma?</h3>
              <p>
                Te invitamos a conocer el uso de esta plataforma en un video explicativo. <a href="https://www.youtube.com/watch?v=iXfsszrp67M&feature=youtu.be" target="_blank">Click Aquí</a>
              </p>
              <button class="boton transparente pass-btn" id="pass-btn" style="line-height:14px;">
                Recuperar Clave
              </button>
            </div>
            <img src="<?php echo SERVERURL; ?>vistas/assets/img/login1.svg" class="imagen" alt="" />
        </div>
        <div class="panel right-panel">
            <div class="content-login">
              <h3>¿Tienes una cuenta?</h3>
              <p>
                Si eres estudiante de la Universidad Nacional Pedro Ruiz Gallo accede con tu correo Institucional.
              </p>
              <button class="boton transparente" id="sign-in-btn">
                Iniciar
              </button>
            </div>
            <img src="<?php echo SERVERURL; ?>vistas/assets/img/login2.svg" class="imagen" alt="" />
        </div>
    </div>
</div>
<?php
  if(isset($_POST['usuario']) && isset($_POST['clave']) ){
      require_once "./controladores/loginControlador.php";
      $login = new loginControlador();

      echo $login->iniciar_sesion_controlador();
  }if(isset($_POST['correoInstitucional'])){
      require_once "./controladores/loginControlador.php";
      $login = new loginControlador();

      echo $login->recuperar_cuenta_controlador();
  }
?>