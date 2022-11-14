<?php
    include('header.php');
    include("nav.php");
?>
<html class="fondoMenus"> 
    <main>
        <section>
            <div class="divListGuardian">
                <table class="tableListGuardian">
                    <thead>
                        <caption class="captionListGuardian"> Reservas en espera de confirmacion </th>
                        <th class="thListGuardian">Nombre de la mascota</th>
                        <th class="thListGuardian">Nombre del Guardian</th>
                        <th class="thListGuardian">Fecha de inicio</th>
                        <th class="thListGuardian">Fecha de finalizacion</th>
                        <th class="thListGuardian">Precio</th>
                    </thead>
                    <tbody>
                            <?php foreach($wcReservationList as $reservation){ ?>
                                <tr>
                                    <td class="thListGuardian"><?php echo $allpets->getNameByIdPet($reservation->getIdPet()) ." (" . $allpets->getPetByIdPet($reservation->getIdPet())->getBreed() . ")";?> </td> 
                                    <td class="thListGuardian"><?php echo $guardian->getGuardianById($reservation->getIdGuardian())->getName() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getReservationDateStart() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getReservationDateEnd() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getPrice()?> </td>
                                </tr>
                            <?php }?>
                    </tbody>
                </table>
            </div>
                
            <div class="divListGuardian">
                <table class="tableListGuardian">
                    <thead>
                        <caption class="captionListGuardian">Reservas finalizadas</th>
                        <th class="thListGuardian">Nombre de la mascota</th>
                        <th class="thListGuardian">Nombre del Guardian</th>
                        <th class="thListGuardian">Fecha de inicio</th>
                        <th class="thListGuardian">Fecha de finalizacion</th>
                        <th class="thListGuardian">Precio</th>
                    </thead>
                    <tbody>
                            <?php foreach($fReservationList as $reservation){ ?>
                                <tr>
                                    <td class="thListGuardian"><?php echo $allpets->getNameByIdPet($reservation->getIdPet()) ." (" . $allpets->getPetByIdPet($reservation->getIdPet())->getBreed() . ")";?> </td> 
                                    <td class="thListGuardian"><?php echo $guardian->getGuardianById($reservation->getIdGuardian())->getName() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getReservationDateStart() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getReservationDateEnd() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getPrice()?> </td>

                                </tr>
                            <?php }?>
                    </tbody>
                </table>
                
            </div>

            <div class="divListGuardian">
                <table class="tableListGuardian">
                    <thead>
                        <caption class="captionListGuardian"> Reservas confirmadas</th>
                        <th class="thListGuardian">Nombre de la mascota</th>
                        <th class="thListGuardian">Nombre del Guardian</th>
                        <th class="thListGuardian">Fecha de inicio</th>
                        <th class="thListGuardian">Fecha de finalizacion</th>
                        <th class="thListGuardian">Precio</th>
                    </thead>
                    <tbody>
                        <?php foreach($cReservationList as $reservation){ ?>
                            <tr>
                                <td class="thListGuardian"><?php echo $allpets->getNameByIdPet($reservation->getIdPet()) ." (" . $allpets->getPetByIdPet($reservation->getIdPet())->getBreed() . ")";?> </td> 
                                <td class="thListGuardian"><?php echo $guardian->getGuardianById($reservation->getIdGuardian())->getName() ?> </td>
                                <td class="thListGuardian"><?php echo $reservation->getReservationDateStart() ?> </td>
                                <td class="thListGuardian"><?php echo $reservation->getReservationDateEnd() ?> </td>
                                <td class="thListGuardian"><?php echo $reservation->getPrice()?> </td>
                            </tr>
                        <?php }?>
                    </tbody>                  
                </table>
            </div>
        </section>
    </main>
</html>     