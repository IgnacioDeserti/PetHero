<div>
  <header>
    <nav class="">
      <ul class="clear">
        <?php if($_SESSION["typeUser"] == "O"){?>
          <div class="containerMenu">
            <li class="liMenu">Menu</li>
              <ul class="subMenu">
                <li><a href="<?php echo FRONT_ROOT . "Owner/showAddPet" ?>">Agregar mascota</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/showListPet" ?>">Ver listado mascotas</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/filterGuardians" ?>">Ver listado guardianes</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/showReservationsList" ?>">Ver listado reservas</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Home/logOut" ?>">Cerrar Sesion</a></li>
              </ul>
            </li>
          </div>
        <?php }else{?>
          <div class="containerMenu">
            <li class="liMenu">Menu</li>
              <ul class="subMenu">
                <li><a href="<?php echo FRONT_ROOT ?> Guardian/showModifyView">Modificar disponibilidad</a></li>
                <li><a href="<?php echo FRONT_ROOT ?> Guardian/showReservationsList">Lista Reservas</a></li>
                <li><a href="<?php echo FRONT_ROOT ?> Home/logOut">Cerrar Sesion</a></li>
              </ul>
            </li>
          </div>
        <?php }?>

      </ul>
    </nav>
  </header>
</div>