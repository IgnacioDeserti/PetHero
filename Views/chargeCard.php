<?php
     include("header.php");
     include("nav.php");
?>

<html class="fondoMenus">
     <main class="d-flex align-items-center justify-content-center height-100">
     <?php if(isset($alert)) { ?>
                    <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } ?> </p>
          <div class="formSelectPet">
               <header>
                    <h2 style="text-align: center;"> INGRESAR TARJETA</h2>
               </header>

               <form action="<?php echo FRONT_ROOT ?> Owner/chargePayment" method="post" class="contentForm" enctype="multipart/form-data">

                    <div class="divOwner">
                         <label for="">Numero de tarjeta</label>
                    </div>
                    
                    <div class="inputPet">
                         <input name="cardNumber" maxlength="16" placeholder="1111 - 2222 - 3333 - 4444 " required>
                    </div>

                    <div class="divOwner">
                         <label for="">Titular de la tarjeta</label>
                    </div>

                    <div class="inputPet">
                         <input type="text" name="titular" class="form-control form-control-lg" placeholder="-ingrese los numeros sin espacios" required>
                    </div>
                    
                    <div class="divOwner">
                         <label for="">Año de expiracion de la tarjeta</label>             
                    </div>

                    <div class="inputPet">
                         <input type="month" name="expirationDate" class="form-control form-control-lg"  required>
                    </div>

                    <div class="divOwner">
                         <label for="">Codigo de seguridad</label>     
                    </div>

                    <div class="filePet">
                         <input name="expirationYear" class="form-control form-control-lg" minlength="3" maxlength="3" required>
                    </div>

                    <input type="hidden" name="idReservation" value="<?= $idReservation ?>">

                    <button class="buttonSelectPet buttonHoversGreen" type="submit">Cargar tarjeta</button>
               </form>
               <a href="<?= FRONT_ROOT?> Owner/listReservationOwner"><button class="buttonGoBackSelectPet buttonRedHovers">Volver</button></a>
          
          </div>
     </main>
</html>