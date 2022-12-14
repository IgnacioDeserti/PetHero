<?php
    include('header.php');
    include("nav.php");
?>

<html class="fondoMenus">
<?php if(isset($alert)) { ?>
                    <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } ?> </p>
    <div class="containerFilterGuardian">
        <form action=" <?php echo FRONT_ROOT ?>Owner/makeReservation" method = 'post'>
            
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
                <option value="">Seleccione mascota</option>
                <?php foreach($petChecked as $pet){?>
                <option value="<?php echo $pet->getIdPet()?>"><?php echo $pet->getName() .'('.$pet->getBreed().')'?></option>
                <?php }?>
            </select>

            <input type="hidden" name="idGuardian" value="<?php echo $idGuardian?>">
            </div>
            <button type="submit" class="buttonFilter buttonHoversGreen">Hacer Reserva</button>
        </form>
    </div>
</html>