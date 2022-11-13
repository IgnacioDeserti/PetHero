<?php
       include('header.php');
       include("nav.php");
?>

<html>
        <form action=" <?php echo FRONT_ROOT ?>Owner/showGuardianList" method="POST">
               
               <div>
                    <label for="">Fecha inicio</label>
               </div>
           
               <div>
                    <input type="date" name="availabilityStart" required>
               </div>

               <div>
                    <label for="">Fecha fin</label>
               </div>

               <div>
                    <input type="date" name="availabilityEnd" required>
               </div>

               <div>
                    <label for="">Mascota a cuidar</label>
               </div>

               <div>
                    <select name="breed" required>
                         <option value="">Selecciona mascota</option>
                            <?php foreach($listPets as $pet){?>
                            <option value="<?php $pet->getBreed()?>"><?php echo $pet->getName() .'('.$pet->getBreed().')'?></option>
                            <?php }?>
                    </select>
                    <input type="hidden" name="type" value="<?php echo $pet->getType()?>">
                    <input type="hidden" name="size" value="<?php echo $pet->getType()?>">
               </div>

               <button type="submit">Filtrar guardianes</button>

        </form>
</html>