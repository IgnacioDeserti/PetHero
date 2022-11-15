<?php
    include('header.php');
    include ("nav.php");
?>

<html class="fondoMenus">
     <main>
          <section id="listado">
               <div class="divListGuardian">
                    
                    <form action="<?php echo FRONT_ROOT ?>Owner/makeReservation" method="post">
                         <table class="tableListGuardian">
                              <caption style="text-align: center;"Perros>Guardianes</caption>
                              <thead>
                                   <tr>
                                        <th class="thListGuardian">Nombre</th>
                                        <th class="thListGuardian">Dirección</th>
                                        <th class="thListGuardian">Email</th>
                                        <th class="thListGuardian">Número</th>
                                        <th class="thListGuardian">Comienzo estadía</th>
                                        <th class="thListGuardian">Fin estadía</th>
                                        <th class="thListGuardian">Tamaños</th>
                                   </tr>
                              </thead>
                              <tbody>
                                   <tr>
                                        <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                        <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                        <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                        <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                        <?php if($guardian->getAvailabilityStart() == null && $guardian->getAvailabilityEnd() == null){ ?>
                                             <td class="thListGuardian">No disponible</td> 
                                             <td class="thListGuardian">No disponible</td>
                                        <?php } else { ?>
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart(); ?></td> 
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd(); ?></td> 
                                        <?php } ?>
                                        <td class="thListGuardian"><?php foreach($arrayListGuardianxSize as $gxs){
                                             if($gxs->getIdGuardian() == $guardian->getIdGuardian()){
                                                  foreach($arrayListSize as $size){
                                                       if($gxs->getIdSize() == $size->getIdSize()){
                                                            echo $size->getName(), "<br>";
                                                       }
                                                  }
                                             }
                                        }?>
                                        </td>
                                        <?php if($guardian->getAvailabilityStart() != null && $guardian->getAvailabilityEnd() != null){ ?>
                                             <td><button class="buttonSelectG buttonHoversGreen">Hacer reserva</button></td>
                                        <?php } ?>
                                        <input type="hidden" name="availabilityStart" value="<?php echo $availabilityStart; ?>">   
                                        <input type="hidden" name="availabilityEnd" value="<?php echo $availabilityEnd; ?>">   
                                        <input type="hidden" name="idPet" value="<?php echo $idPet; ?>">
                                        <td><input type="hidden" name="idGuardian" value="<?php echo $guardian->getIdGuardian()?>"></td>
                    </form>
                    
                    <form action="<?php echo FRONT_ROOT?> Owner/filterGuardians">
                                        <td><button class="buttonSelectG buttonRedHovers" type="submit">Volver</button>
                                   </tr>
                    </form>
                         </table>

                         <table>
                          <?php  foreach($reviewsList as $review) { ?>
                                   <tr>
                                        <td><?php echo $ownerList->getNameById($review->getIdOwner())."ㅤㅤㅤ".$review->getRating()."⭐" ?></td>
                                   </tr>
                                   <tr>
                                        <td><?php echo $review->getObservations() ?></td>
                                   </tr>
                          <?php } ?>
                         </table>
               </div>
          </section>
     </main>
</html>
