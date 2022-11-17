<?php
    include("header.php");
    include('nav.php');
?>

<html class="fondoMenus">
    <div class="containerModify">
        <main> 
            <?php if(isset($alert)){ ?>
                <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; ?></p>
            <?php } ?>
            <form action="<?php echo FRONT_ROOT ?> Guardian/modifyAvailability" method="post">
                
                <div>
                    <label for="">Fecha inicio</label>
                </div>
                
                <div>
                    <input type="date" name="availabilityStart">
                </div>

                <div class="containerFecha">
                    <label for="">Fecha fin</label>
                </div>

                <div class="containerFecha">
                    <input type="date" name="availabilityEnd">
                </div>

                <div class="containerFecha">
                    <?php if(isset($exception)){?>
                    <td><?php echo $exception->getMessage();?></td>
                    <?php }?>
                </div>

                <button type="submit" class="buttonModify buttonHoversGreen" name="id" value="<?php echo $_SESSION["idUser"] ?>">Modificar</button>
            </form>
        </main>
    </div>
</html>    