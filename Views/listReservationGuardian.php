<?php
    include('header.php');
    include("nav.php");
?>
<html class="fondoMenus"> 
    <main>
        <section>
            <?php if(isset($alert)){ ?>
                <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; ?></p>
            <?php } ?>
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
                                        <td class="thListGuardian"><?php echo $allpets->getNameByIdPet($reservation->getIdPet()) ?> </td> 
                                        <td class="thListGuardian"><?php echo $guardian->getGuardianById($reservation->getIdGuardian())->getName() ?> </td>
                                        <td class="thListGuardian"><?php echo $reservation->getReservationDateStart() ?> </td>
                                        <td class="thListGuardian"><?php echo $reservation->getReservationDateEnd() ?> </td>
                                        <td class="thListGuardian"><?php echo $reservation->getPrice()?></td>
                                        <form action="<?php echo FRONT_ROOT ?>Guardian/selectAction" method="POST">
                                            <td><button name="button" value="Accept" class="buttonSelectG buttonHoversGreen" type="submit"> Aceptar</button></td>
                                            <td><button name="button" value="Decline" class="buttonSelectG buttonRedHovers" type="submit"> Rechazar</button></td>
                                            <input type="hidden" name="idReservation" value="<?php echo $reservation->getIdReservation() ?>">
                                        </form>
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
                                    <td class="thListGuardian"><?php echo $allpets->getNameByIdPet($reservation->getIdPet()) ?> </td> 
                                    <td class="thListGuardian"><?php echo $guardian->getGuardianById($reservation->getIdGuardian())->getName() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getReservationDateStart() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getReservationDateEnd() ?> </td>
                                    <td class="thListGuardian"><?php echo $reservation->getPrice()?> </td>
                                    <form action="<?= FRONT_ROOT . 'Guardian/getCoupon'?>" method = 'POST'>
                                        <td><button class="buttonSelectG buttonHoversGreen" type= 'submit' value = '<?= $reservation->getIdReservation()?>'>Ver cupon de pago</button><td>
                                    </form>
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
                                        <td class="thListGuardian"><?php echo $allpets->getNameByIdPet($reservation->getIdPet()) ?> </td>
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