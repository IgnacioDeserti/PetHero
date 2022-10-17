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
            <li><a href="<?php echo FRONT_ROOT . "Event/add" ?>">NUEVO</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Event/showEventList" ?>">EVENTOS</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/logout" ?>">LOGOUT</a></li>
          </ul>
        </li>
        <?php }else{?>
          <li class=""><a class="" href="">Menu</a>
          <ul>
          <li><a href="<?php echo FRONT_ROOT . "Event/showEventListGerente" ?>">EVENTOS</a></li>
          <li><a href="<?php echo FRONT_ROOT . "Event/showReportList" ?>">REPORT LIST</a></li>
            <li><a href="<?php echo FRONT_ROOT . "Home/logout" ?>">LOGOUT</a></li>
          </ul>
        </li>
        <?php }?>

      </ul>
    </nav>
  </header>
</div>