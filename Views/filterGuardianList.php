<?php
     include('header.php');
     include("nav.php");
?>

<html class="fondoMenus">
     <div class="containerFilterGuardian">
          <form action=" <?php echo FRONT_ROOT ?>Owner/showGuardianList" method="POST">
                    
                    <div class="containerFilter">
                         <label for="">Fecha inicio</label>
                    </div>
               
                    <div class="inputFilter">
                         <input type="date" name="availabilityStart" required>
                    </div>

                    <div class="containerFilter2">
                         <label for="">Fecha fin</label>
                    </div>

                    <div class="inputFilter2">
                         <input type="date" name="availabilityEnd" required>
                    </div>

                    <div class="containerFilter3">
                         <label for="">Mascota a cuidar</label>
                    </div>

                    <div class="inputFilter3">
                         <select name="breed" required>
                              <option value="">Selecciona mascota</option>
                              <?php foreach($listPets as $pet){?>
                              <option value="<?php echo $pet->getIdPet();?>"><?php echo $pet->getName() . " ". $pet->getType() . ' ('.$pet->getBreed().')'?></option>
                              <?php }?>
                         </select>
                    </div>
                    <button class="buttonFilter buttonHoversGreen" type="submit">Filtrar guardianes</button>
                    

          </form>
     </div>
</html>