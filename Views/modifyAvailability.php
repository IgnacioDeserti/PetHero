<?php
    include("header.php");
    include('nav.php');
?>

<div>
    <main> 
        <form action="<?php echo FRONT_ROOT ?> Guardian/modifyAvailability" method="post">
            
            <div>
                <label for="">Fecha inicio</label>
            </div>
            
            <div>
                <input type="date" name="availabilityStart">
            </div>

            <div>
                <label for="">Fecha fin</label>
            </div>

            <div>
                <input type="date" name="availabilityEnd">
            </div>

            <button type="submit" name="id" value="<?php echo $_SESSION["idUser"] ?>">Modificar</button>
        </form>
    </main>
</div>