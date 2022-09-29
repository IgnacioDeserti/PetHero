<?php

    if($_POST){
        if($_POST["do"] == "guardian"){
            header("location:../Views/createGuardianProfile.php");
        }else{
            header("location:../Views/createOwnerProfile.php");
        }
    }else{
        echo "NO ENTRA EN EL POST";
    }

?>