<?php 

	namespace Process;
	require_once("../Config/Autoload.php");
	use Repositories\ownerRepository as ownerRepository;
	

	if($_POST){
		$userName = $_POST['userName'];
		$password = $_POST['password'];
		if($userName == 'Cosme Fulanito'){
			if($password == 'strongPassword'){
		
				
				header("location:../add-bill.php");
		
			}else{
				echo "<script> if(confirm('Verifique que la contraseña sea correcta'));";
				echo "window.location = '../index.php';
				</script>";
			}
		
		}else{
			echo "<script> if(confirm('Verifique que el nombre de usuario sea correcto'));";
			echo "window.location = '../index.php';
			</script>";
		}
	}else{
		echo "<script> if(confirm('Error en el método de envio de datos'));";
			echo "window.location = '../index.php';
			</script>";
	}
	
?>	