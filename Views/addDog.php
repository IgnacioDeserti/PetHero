<?php
     include("header.php");
?>

<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <header class="text-center">
               <h2>INGRESAR MASCOTA</h2>
          </header>

          <form action="<?php FRONT_ROOT . "Owner/addDog" ?>" method="post" class="loginCSS">
               <div class="form-group">
                    <label for="">Nombre del Perro</label>
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Ingresar nombre" required>
               </div>
               <div class="form-group">
                    <label for="">Raza</label>
                    <input type="text" name="breed" class="form-control form-control-lg" placeholder="Ingresar raza" required>
               </div>
               <div>
                    <label for="">Tamaño</label>
                    <select name="size" id="">
                    <option value="">Seleccione el tamaño de la mascota</option>
                    <option value="small">Pequeño</option>
                    <option value="medium">Medio</option>
                    <option value="Big">Grande</option>
                    </select>                 
               </div>
               <div class="form-group">
                    <label for="">Observaciones</label>
                    <textarea name="observations" cols="50" rows="30"></textarea>
               </div>
               <div class="form-group">
                    <input type="file" name="photo1"  class="form-control form-control-lg" placeholder="Ingresar foto perfil" required>          
               </div>
               <div class="form-group">
                    <input type="file" name="photo2"  class="form-control form-control-lg" placeholder="Ingresar foto plan de vacunacion" required>          
               </div>
               <div class="form-group">
                    <input type="file" name="video"  class="form-control form-control-lg" placeholder="Ingresar video">          
               </div>

               <button class="btn btn-dark btn-block btn-lg" type="submit">Ingresar Mascota</button>
          </form>
     
     </div>
</main>