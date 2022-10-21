<?php
     include('header.php');
     include("nav.php");
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
                                                  <td class="thListGuardian"><img src="<?php echo $dog->getPhoto1() ?>" width="200px" alt=" Foto de: <?php echo $dog->getName();?>"></td>
                                                  <td class="thListGuardian"><img src="<?php echo $dog->getPhoto2() ?>" width="200px" alt=" Plan de vacunacion de: <?php echo $dog->getName();?>"></td>
                                                  <td class="thListGuardian"><?php echo $dog->getName() ?> </td>
                                                  <td class="thListGuardian"><?php echo $dog->getBreed() ?></td>
                                                  <?php if($dog->getSize() == "Small"){?>
                                                       <td class="thListGuardian">Pequeño</td>
                                                  <?php }else if($dog->getSize() == "Medium"){?>
                                                       <td class="thListGuardian">Mediano</td>
                                                  <?php }else{?>
                                                       <td class="thListGuardian">Grande</td>
                                                  <?php }?>
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