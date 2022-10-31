<?php 
    include("header.php");
    include("nav.php");
?>

<html class="fondoMenus">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Pet Hero <?php $_SESSION["name"] ?></title>
    </head>
        
    <body>
        <form action=" <?php echo FRONT_ROOT?> Guardian/showModifyView" method="post">
            <button type='submit' class="buttonMenuGuardian buttonHoversGreen" value='<?php echo $_SESSION['idUser']?>' name='id'>Modificar Disponibilidad</button>
        </form>
    </body>
</html>
