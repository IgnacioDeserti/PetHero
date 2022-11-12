<?php
       include('header.php');
       include("nav.php");
?>

<html>

    <form action=" <?php echo FRONT_ROOT ?>Owner/makeReservation" method = 'post'>
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
            <?php foreach($petChecked as $pet){?>
            <option value="<?php $pet->getIdPet()?>"><?php echo $pet->getName() .'('.$pet->getBreed().')'?></option>
            <?php }?>
        </select>
        <input type="hidden" name="idGuardian" value="<?php $idGuardian?>">
        </div>
        <button type="submit">Hacer Reserva</button>
    </form>
</html>