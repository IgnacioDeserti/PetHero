<?php
     include("header.php");
     include("nav.php");
?>

<html class="fondoMenus">
     <main class="d-flex align-items-center justify-content-center height-100">
          <div class="formAddPet">
               <header>
                    <h2 style="text-align: center;"> INGRESAR PERRO</h2>
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
                              <option value="Caniche">Caniche</option>
                              <option value="Golden">Golden</option>
                              <option value="Pitbull">Pitbull</option>
                              <option value="Labrador">Labrador</option>
                              <option value="Bulldog">Bulldog</option>
                              <option value="Ovejero Aleman">Ovejero Aleman</option>
                              <option value="Gran Danes">Gran Danes</option>
                              <option value="Dalmata">Dalmata</option>
                              <option value="Rottweiler">Rottweiler</option>
                              <option value="Salchicha">Salchicha</option>
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