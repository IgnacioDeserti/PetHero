<div>
  <header>
    <nav class="">
      <ul class="clear">
        <?php if($_SESSION["typeUser"] == "O"){?>
          <div class="containerMenu">
            <li class="liMenu">Menu</li>
              <ul class="subMenu">
                <li><a href="<?php echo FRONT_ROOT . "Owner/showAddDog" ?>">AGREGAR PERRO</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/showListDog" ?>">VER LISTADO PERROS</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Owner/showGuardianList" ?>">VER LISTADO GUARDIANES</a></li>
                <li><a href="<?php echo FRONT_ROOT . "Home/logOut" ?>">LOG OUT</a></li>
              </ul>
            </li>
          </div>
        <?php }else{?>
          <li class=""><a class="" href="">Menu</a>
          <ul>
            <li><a href="<?php echo FRONT_ROOT . "Home/logOut" ?>">LOG OUT</a></li>
          </ul>
        </li>
        <?php }?>

      </ul>
    </nav>
  </header>
</div>