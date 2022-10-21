<?php
     include('header.php');
     include("nav.php");

     use DAO\dogDAO as dogDAO;

     $DAODog = new dogDAO();
     $arrayListDog = $DAODog->getAll();

?>
<html class="fondoMenus">
     <main>
          <section id="listado">
               <div class="divListGuardian">
                    <table class="tableListGuardian">
                         <caption style="text-align: center;">Perros</caption>
                         <thead>
                              <th class="thListGuardian">Foto Perfil</th>
                              <th class="thListGuardian">Foto Vacunacion</th>
                              <th class="thListGuardian">Nombre</th>
                              <th class="thListGuardian">Raza</th>
                              <th class="thListGuardian">Tamaño</th>
                              <th class="thListGuardian">Observaciones</th>
                         </thead>
                         <tbody>

                              <?php
                              if (isset($arrayListDog)) {
                                   foreach ($arrayListDog as $dog) {
                                        if ($dog->getIdOwner() == $_SESSION['idUser']) { ?>
                                             <tr>
                                                  <td class="thListGuardian"><?php echo $dog->getPhoto1() ?></td>
                                                  <td class="thListGuardian"><?php echo $dog->getPhoto2() ?></td>
                                                  <td class="thListGuardian"><?php echo $dog->getName() ?> </td>
                                                  <td class="thListGuardian"><?php echo $dog->getBreed() ?></td>
                                                  <td class="thListGuardian"><?php echo $dog->getSize() ?></td>
                                                  <td class="thListGuardian"><?php echo $dog->getObservations() ?></td>
                                                  <?php if ($dog->getVideo() != null) { ?>
                                                       <td class="thListGuardian"><?php echo $dog->getVideo(); ?></td>
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
</html>