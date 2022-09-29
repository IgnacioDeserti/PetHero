<?php

    require_once('../Config/Autoload.php');

    use Config\Autoload as Autoload;
    use Repositories\ownerRepository as ownerRepository;
    use Repositories\guardiansRepository as guardiansRepository;

    $repoOwners = new ownerRepository();
    $repoOwners->getAll();

    $repoGuardians = new guardiansRepository();
    $repoGuardians->getAll();


    if($_POST){
        foreach($repoOwners as $owner){
            if($_POST['email'] == $owner->getEmail()){
                if($_POST['password'] == $owner->getPassword()){
                    $loggedUser = $owner;
                    session_start();
                    $_SESSION['loggedUser'] = $loggedUser;
                    header("../Views/owner.php");
                }
            }
        }
        if($loggedUser == NULL){
            foreach($repoGuardians as $guardian){
                if($_POST['email'] == $guardian->getEail()){
                    if($_POST['password'] == $gurdian->getPassword()){
                        $loggedUser = $guardian;
                        session_start();
                        $_SESSION['loggedUser'] = $loggedUser;
                        header("../Views/guardian.php");
                    }
                }
            }
        }

    }else{
        echo "<script> if(confirm('Verifique que los datos ingresados sean correctos'));";
        echo "window.location = '../Views/inicio.php';
            </script>";
    }

?>