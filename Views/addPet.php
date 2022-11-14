<?php
     include("header.php");
     include("nav.php");
?>

<html class="fondoMenus">
     <main>
          <div class="formSelectPet">
               <header>
                    <h2 style="text-align: center;"> ¿QUE MASCOTA QUIERE AGREGAR?</h2>
               </header>

               <form action="<?php echo FRONT_ROOT ?> Owner/typePet" method="post" class="contentForm" enctype="multipart/form-data">

                    <div class="divSelectPet">
                         <label for="">Tipo de animal</label>
                    </div>

                    <div class="inputSelectPet">
                         <select name="type" required>
                              <option value="">Seleccione el tipo de mascota</option>
                              <option value="D">Perro</option>
                              <option value="C">Gato</option>
                         </select>    
                    </div>

                    <button class="buttonSelectPet buttonHoversGreen" type="submit">Agregar Mascota</button>
               </form>
               <a href="<?php echo FRONT_ROOT?> Owner/showListPet "><button class="buttonGoBackSelectPet buttonRedHovers">Volver</button></a>
          
          </div>
     </main>
</html>