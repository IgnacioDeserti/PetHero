<?php 

	namespace Process;

	require_once("../Config/Autoload.php");

	use Config\Autoload;
	use Models\Guardian as Guardian;
	use Repositories\guardiansRepository as guardiansRepository;

	Autoload::Start();

	$repo = new guardiansRepository();

	$repo->getAll();


	if($_POST){

		$newGuardian = new Guardian();
		$newGuardian->setName($_POST["name"]);
		$newGuardian->setAddress($_POST["address"]);
		$newGuardian->setEmail($_POST["email"]);
		$newGuardian->setNumber($_POST["number"]);
		$newGuardian->setUserName($_POST["userName"]);
		$newGuardian->setPassword($_POST["password"]);
		$newGuardian->setSize($_POST["size"]);
		
		$searched = $repo->getGuardian($newGuardian);


		if($searched == NULL){
			$repo->add($newGuardian);
			echo "<script> if(confirm('Perfil creado con éxito!'));";
			echo "window.location = '../Views/guardian.php';
			</script>";

		}else{
			echo "<script> if(confirm('Nombre de usuario ya registrado, ingrese otro'));";
			echo "window.location = '../Views/createGuardianProfile.php';
			</script>";
		}
		
	}else{
		echo "<script> if(confirm('Error en el método de envio de datos'));";
		echo "window.location = '../index.php';
		</script>";
	}
		
?>	