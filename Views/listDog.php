<?php
     include('header.php');
     include("nav.php");

     use DAO\dogDAO as dogDAO;

     $DAODog = new dogDAO();
     $arrayListDog = $DAODog->getAll();

?>

<main>
     <section id="listado">
          <div>
               <h2>Perros</h2>
               <table>
                    <thead>
                         <th>Nombre</th>
                         <th>Raza</th>
                         <th>Tamaño</th>
                         <th>Observaciones</th>
                         <th>Foto</th>
                    </thead>
                    <tbody>

                         <?php
                         if (isset($arrayListDog)) {
                              foreach ($arrayListDog as $dog) {
                                   if ($dog->getIdOwner() == $_SESSION['idUser']) { ?>
                                        <tr>
                                             <td><?php echo $dog->getName() ?> </td>
                                             <td><?php echo $dog->getBreed() ?></td>
                                             <td><?php echo $dog->getSize() ?></td>
                                             <td><?php echo $dog->getObservations() ?></td>
                                             <td><?php echo $dog->getPhoto1() ?></td>
                                             <td><?php echo $dog->getPhoto2() ?></td>
                                             <?php if ($dog->getVideo() != null) { ?>
                                                  <td><?php echo $dog->getVideo(); ?></td>
                                        </tr>
                                             <?php }
                                        }
                                   }
                              }?>
                    </tbody>
               </table>
          </div>
     </section>
</main>