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
                              if (isset($arrayListPet)) {
                                   foreach ($arrayListDog as $Pet) {
                                        if ($Pet->getIdOwner() == $_SESSION['idUser']) { ?>
                                             <tr>
                                                  <td class="thListGuardian"><img src="<?php echo $Pet->getPhoto1() ?>" width="200px" alt=" Foto de: <?php echo $Pet->getName();?>"></td>
                                                  <td class="thListGuardian"><img src="<?php echo $Pet->getPhoto2() ?>" width="200px" alt=" Plan de vacunacion de: <?php echo $Pet->getName();?>"></td>
                                                  <td class="thListGuardian"><?php echo $Pet->getName() ?> </td>
                                                  <td class="thListGuardian"><?php echo $Pet->getBreed() ?></td>
                                                  <?php if($Pet->getSize() == "Small"){?>
                                                       <td class="thListGuardian">Pequeño</td>
                                                  <?php }else if($Pet->getSize() == "Medium"){?>
                                                       <td class="thListGuardian">Mediano</td>
                                                  <?php }else{?>
                                                       <td class="thListGuardian">Grande</td>
                                                  <?php }?>
                                                  <td class="thListGuardian"><?php echo $Pet->getObservations() ?></td>
                                                  <?php if ($Pet->getVideo() != null) { ?>
                                                       <td class="thListGuardian"><iframe src="<?php echo $Pet->getVideo(); ?>" frameborder="0" width="200" height="200"></iframe></td>
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