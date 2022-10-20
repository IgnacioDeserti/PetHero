<div class="wrapper row1">
  <header> 
    <div>
      <h1>Menu</h1>
    </div>
    <nav class="">
      <ul class="clear">
        <?php if($_SESSION["typeUser"] == "O"){?>
        <li class=""><a class="" href="">Menu</a>
          <ul>
            <li><a href="<?php echo FRONT_ROOT . "Owner/showAddDog" ?>">AGREGAR PERRO</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Event/showDogList" ?>">VER LISTADO PERROS</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/logOut" ?>">LOG OUT</a></li>
          </ul>
        </li>
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