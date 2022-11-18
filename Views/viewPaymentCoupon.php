<?php
    include("header.php");
    include("nav.php");
?>

<html class="fondoMenus">
    <main>
    <?php if(isset($alert)) { ?>
                <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } ?> </p>
        <div class="divListGuardian">
            <table class="tableListGuardian">
                <thead>
                    <th class="thListGuardian">Dueño</th>
                    <th class="thListGuardian">Guardian</th>
                    <th class="thListGuardian">Mascota</th>
                    <th class="thListGuardian">Precio</th>
                    <th class="thListGuardian">Fecha</th>
                    <th class="thListGuardian">Titular Tarjeta</th>
                    <th class="thListGuardian">Numero de Orden</th>
                </thead>

                <tbody>
                    <td class="thListGuardian"><?= $payment->getOwnerName() ?></td>
                    <td class="thListGuardian"><?= $payment->getGuardianName() ?></td>
                    <td class="thListGuardian"><?= $payment->getPetName() ?></td>
                    <td class="thListGuardian"><?= $payment->getPrice() ?></td>
                    <td class="thListGuardian"><?= $payment->getDate() ?></td>
                    <td class="thListGuardian"><?= $payment->getTitular() ?></td>
                    <td class="thListGuardian"><?= $payment->getReservationNumber() ?></td>
                </tbody>
            </table>
        </div>
    </main>
</html>