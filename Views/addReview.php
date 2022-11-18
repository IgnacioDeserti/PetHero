<?php
    include("header.php");
    include("nav.php");
?>

<html class="fondoMenus">
    <main class="d-flex align-items-center justify-content-center height-100">
        <div class="formSelectPet">
            <header>
                <h2 style="text-align: center;"> INGRESAR REVIEW</h2>
            </header>

            <form action="<?php echo FRONT_ROOT ?> Owner/addReview" method="post" class="contentForm" enctype="multipart/form-data">

                <div class="divOwner">
                    <label for="">Valoracion (1-5)</label>
                </div>

                <div class="inputPet">
                    <select name="breed" required>
                        <option value="1" selected>1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                    </select>
                </div>
                    
                <div class="divOwner">
                    <label for="">Observaciones</label>             
                </div>

                <div class="inputPet">
                    <textarea name="observations" maxlength="100" required></textarea>
                </div>

                <input type="hidden" name="idOwner" value="<?= $reservation->getIdOwner() ?>">
                <input type="hidden" name="idGuardian" value="<?= $reservation->getIdGuardian() ?>">
                <input type="hidden" name="idReservation" value="<?= $reservation->getIdReservation() ?>">

                    <button class="buttonSelectPet buttonHoversGreen" type="submit">Agregar Mascota</button>
            </form>
            <a href="<?php echo FRONT_ROOT?> Owner/showReservationsList "><button class="buttonGoBackSelectPet buttonRedHovers">Volver</button></a>
        
        </div>
    </main>
</html>