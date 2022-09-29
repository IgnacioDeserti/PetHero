<?php
     include("header.php");
?>

<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <header class="text-center">
               <h2>Practico N° 4</h2>
          </header>

          <form action="../process/createDogProfile.php" method="post" class="loginCSS">
               <div class="form-group">
                    <label for="">Nombre del Perro</label>
                    <input type="text" name="userName" class="form-control form-control-lg" placeholder="Ingresar usuario">
               </div>
               <div class="form-group">
                    <label for="">Raza</label>
                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
               </div>
               <div class="form-group">
                    <label for="">Tamaño</label>
                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
               </div>
               <div class="form-group">
                    <label for="">Observaciones</label>
                    <input type="text" name="password" class="form-control form-control-lg" placeholder="Ingresar constraseña">
               </div>
               <button class="btn btn-dark btn-block btn-lg" type="submit">Iniciar Sesión</button>
          </form>
     
     </div>
</main>