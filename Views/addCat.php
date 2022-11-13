<?php
     include("header.php");
     include("nav.php");
?>

<html class="fondoMenus">
     <main class="d-flex align-items-center justify-content-center height-100">
          <div class="formAddPet">
               <header>
                    <h2 style="text-align: center;"> INGRESAR GATO</h2>
               </header>

               <form action="<?php echo FRONT_ROOT ?> Owner/addPet" method="post" class="contentForm" enctype="multipart/form-data">
                    
                    <div class="divOwner">
                         <label for="">Nombre del animal</label>
                    </div>
                    
                    <div class="inputPet">
                         <input type="text" name="name" class="form-control form-control-lg" placeholder="Ingresar nombre" required>
                    </div>

                    <div class="divOwner">
                         <label for="">Raza</label>
                    </div>

                    <div class="inputPet">
                         <select name="breed" required>
                              <option value="">Seleccione raza</option>
                              <option value="Siames">Siames</option>
                              <option value="Persa">Persa </option>
                              <option value="Kohana">Kohana</option>
                              <option value="Elfo">Elfo</option>
                              <option value="Bambino">Bambino</option>
                              <option value="Gato Lobo">Gato Lobo</option>
                              <option value="Imalayo">Imalayo</option>
                              <option value="Van Turco">Van Turco</option>
                              <option value="Angora Turco">Angora Turco</option>
                              <option value="Habana">Habana</option>
                         </select>
                    </div>
                    
                    <div class="divOwner">
                         <label for="">Tamaño</label>             
                    </div>

                    <div class="inputPet">
                         <select name="size">
                              <option value="">Seleccione el tamaño</option>
                              <option value="1">Pequeño</option>
                              <option value="2">Medio</option>
                              <option value="3">Grande</option>
                         </select>    
                    </div>

                    <div class="divOwner">
                         <label for="">Observaciones</label>
                    </div>

                    <div class="inputPet">
                         <textarea name="observations" cols="10" rows="2" maxlength="200" required></textarea>
                    </div>

                    <div class="divOwner">
                         <label for="">Ingresar foto perfil</label>         
                    </div>

                    <div class="filePet">
                         <input type="file" name="photo1"  id = 'photo1' required>
                    </div>
                    
                    <div class="divOwner">
                         <label for="">Ingresar foto plan de vacunacion</label>
                    </div>

                    <div class="filePet">
                         <input type="file" name="photo2" id = 'photo2' required>
                    </div>

                    <div class="divOwner">
                         <label for="">Ingresar video (opcional)</label>
                    </div>

                    <div class="filePet">
                         <input type="file" name="video">
                    </div>

                    <input type="hidden" name="type" value="<?php echo $type ?>">

                    <button class="buttonAddPet buttonHoversGreen" type="submit">Agregar Mascota</button>
               </form>
               <a href="<?php echo FRONT_ROOT?> Owner/typePet "><button class="buttonGoBackPet buttonRedHovers">Volver</button></a>
          
          </div>
     </main>
</html>