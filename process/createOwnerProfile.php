<?php 

	namespace Process;

	require_once("../Config/Autoload.php");

	use Config\Autoload as Autoload;
	use DAO\ownersDAO as ownerDAO;
	use Models\Owner as Owner;

	Autoload::Start();

	$repo = new ownerDAO();

	$repo->getAll();


	if($_POST){

		$newOwner = new Owner();
		$newOwner->setName($_POST["name"]);
		$newOwner->setAddress($_POST["address"]);
		$newOwner->setEmail($_POST["email"]);
		$newOwner->setNumber($_POST["number"]);
		$newOwner->setUserName($_POST["userName"]);
		$newOwner->setPassword($_POST["password"]);
		
		$searched = $repo->getOwner($newOwner);


		if($searched == NULL){
			$repo->add($newOwner);
			echo "<script> if(confirm('Perfil creado con éxito!'));";
			echo "window.location = '../Views/owner.php';
			</script>";

		}else{
			echo "<script> if(confirm('Nombre de usuario ya registrado, ingrese otro'));";
			echo "window.location = '../Views/createOwnerProfile.php';
			</script>";
		}
		
	}else{
		echo "<script> if(confirm('Error en el método de envio de datos'));";
		echo "window.location = '../index.php';
		</script>";
	}
	
?>	