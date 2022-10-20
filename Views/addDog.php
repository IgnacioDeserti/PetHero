<?php
     include("header.php");
?>

<main class="d-flex align-items-center justify-content-center height-100">
     <div class="formAddDog">
          <header>
               <h2 style="text-align: center;">INGRESAR MASCOTA</h2>
          </header>

          <form action="<?php echo FRONT_ROOT ?> Owner/addDog" method="post" class="contentForm">
               
               <div class="divOwner">
                    <label for="">Nombre del Perro</label>
               </div>
               
               <div class="inputDog">
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Ingresar nombre" required>
               </div>

               <div class="divOwner">
                    <label for="">Raza</label>
               </div>

               <div class="inputDog">
                    <input type="text" name="breed" class="form-control form-control-lg" placeholder="Ingresar raza" required>
               </div>
               
               <div class="divOwner">
                    <label for="">Tamaño</label>             
               </div>

               <div class="inputDog">
                    <select name="size">
                         <option value="">Seleccione el tamaño de la mascota</option>
                         <option value="small">Pequeño</option>
                         <option value="medium">Medio</option>
                         <option value="Big">Grande</option>
                    </select>    
               </div>

               <div class="divOwner">
                    <label for="">Observaciones</label>
               </div>

               <div class="inputDog">
                    <textarea name="observations" cols="10" rows="2"></textarea>
               </div>

               <div class="divOwner">
                    <label for="">Ingresar foto perfil</label>         
               </div>

               <div class="fileDog">
                    <input type="file" name="photo1"  class="form-control form-control-lg" required>
               </div>
               
               <div class="divOwner">
                    <label for="">Ingresar foto plan de vacunacion</label>
               </div>

               <div class="fileDog">
                    <input type="file" name="photo2"  class="form-control form-control-lg" required>
               </div>

               <div class="divOwner">
                    <label for="">Ingresar video (opcional)</label>
               </div>

               <div class="fileDog">
                    <input type="file" name="video"  class="form-control form-control-lg">
               </div>

               <button class="buttonAddDog" type="submit">Agregar Mascota</button>
          </form>
          <a href="<?php echo FRONT_ROOT?> Owner/showListDog "><button class="buttonGoBackDog">Volver</button></a>
     
     </div>
</main>