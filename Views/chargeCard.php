?php
     include("header.php");
     include("nav.php");
?>

<html class="fondoMenus">
     <main class="d-flex align-items-center justify-content-center height-100">
          <div class="formAddPet">
               <header>
                    <h2 style="text-align: center;"> INGRESAR GATO</h2>
               </header>

               <form action="<?php echo FRONT_ROOT ?> Owner/chargePayment" method="post" class="contentForm" enctype="multipart/form-data">
                    <input >
                    <div class="divOwner">
                         <label for="">Numero de tarjeta</label>
                    </div>
                    
                    <div class="inputPet">
                         <input type="number" name="cardNumber" class="form-control form-control-lg" placeholder="-ingrese los numeros sin espacios" required minlength="16" maxlength="16">
                    </div>

                    <div class="divOwner">
                         <label for="">Titular de la tarjeta</label>
                    </div>

                    <div class="inputPet">
                         <input type="text" name="titular" class="form-control form-control-lg" placeholder="-ingrese los numeros sin espacios" required>
                    </div>
                    
                    <div class="divOwner">
                         <label for="">Mes de expiracion de la tarjeta</label>             
                    </div>

                    <div class="inputPet">
                         <input type="month" name="expirationMonth" class="form-control form-control-lg"  required>
                    </div>

                    <div class="divOwner">
                         <label for="">Año de expiracion de la tarjeta</label>   
                    </div>

                    <div class="inputPet">
                         <input type="year" name="expirationYear" class="form-control form-control-lg"  required>
                    </div>

                    <div class="divOwner">
                         <label for="">Codigo de seguridad</label>     
                    </div>

                    <div class="filePet">
                         <input type="number" name="expirationYear" class="form-control form-control-lg" minlength="3" maxlength="3" required>
                    </div>

                    <input type="hidden" name="idReservation" value="<?php echo $idReservation ?>">

                    <button class="buttonAddPet buttonHoversGreen" type="submit">Cargar tarjeta</button>
               </form>
               <a href="<?php echo FRONT_ROOT?> Owner/listReservationOwner"><button class="buttonGoBackPet buttonRedHovers">Volver</button></a>
          
          </div>
     </main>
</html>