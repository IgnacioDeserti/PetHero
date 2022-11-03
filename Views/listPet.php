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
                              <th class="thListGuardian">Video</th>
                         </thead>
                         <tbody>
                              <form action="" method="post">
                                   <?php
                                   if (isset($arrayListPet)) {
                                        foreach ($arrayListPet as $Pet) { ?>
                                             <tr>
                                                  <td class="thListGuardian"><img src="<?php echo $Pet->getPhoto1() ?>" width="150px" height="150px" alt=" Foto de: <?php echo $Pet->getName();?>"></td>
                                                  <td class="thListGuardian"><img src="<?php echo $Pet->getPhoto2() ?>" width="150px" height="150px" alt=" Plan de vacunacion de: <?php echo $Pet->getName();?>"></td>
                                                  <td class="thListGuardian"><?php echo $Pet->getName() ?> </td>
                                                  <td class="thListGuardian"><?php echo $Pet->getBreed() ?></td>
                                                  <?php foreach($sizeList as $size){ 
                                                       if($Pet->getIdSize() == $size->getIdSize()){?>
                                                            <td class="thListGuardian"><?php echo $size->getName() ?></td>
                                                       <?php }} ?>
                                                  <td class="thListGuardian"><?php echo $Pet->getObservations() ?></td>
                                                  <?php if ($Pet->getVideo() != null) { ?>
                                                       <td class="thListGuardian"><iframe src="<?php echo $Pet->getVideo(); ?>" frameborder="0" width="150" height="150"></iframe></td>
                                                       <input type="button" value="<?php echo $Pet->getIdPet() ?>">
                                             </tr>
                                                  <?php } else { ?>
                                                       <td class="thListGuardian">No disponible</td>
                                             <?php } ?> 
                                                  <input type="hidden" name="email" value="<?php echo $guardian->getEmail() ?>">>
                                        <?php }
                              } ?> 
                              </form>
                         </tbody>
                    </table>
               </div>
          </section>
     </main>
</html>