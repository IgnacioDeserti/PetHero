<div>
  <header>
    <nav class="">
      <ul class="clear">
        <?php if($_SESSION["typeUser"] == "O"){?>
          <div class="containerMenu">
            <li class="liMenu">Menu</li>
              <ul class="subMenu">
                <li><a href="<?php echo FRONT_ROOT . "Owner/showAddDog" ?>">Agregar perro</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/showListDog" ?>">Ver listado perros</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/showGuardianList" ?>">Ver listado guardianes</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Home/logOut" ?>">Cerrar Sesion</a></li>
              </ul>
            </li>
          </div>
        <?php }else{?>
          <div class="containerMenu">
            <li class="liMenu">Menu</li>
              <ul class="subMenu">
                <li><a href="<?php echo FRONT_ROOT . "Home/logOut" ?>">Cerrar Sesion</a></li>
              </ul>
            </li>
          </div>
        <?php }?>

      </ul>
    </nav>
  </header>
</div>