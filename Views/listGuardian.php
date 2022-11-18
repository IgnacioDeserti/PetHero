<?php
     include('header.php');
     include("nav.php");
?>

<html class="fondoMenus">
     <main>
          
     <?php if(count($listChecked) != 0) { if(isset($alert)) { ?>
                         <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } }?> </p>
          <section id="listado">
               <div class="divListGuardian">

                    <form action="<?php echo FRONT_ROOT ?>Owner/selectGuardian" method="post">
                         <table class="tableListGuardian">
                              <caption style="text-align: center;"Perros>Guardianes</caption>
                              <?php if(count($listChecked) == 0) {?>
                                   <td>NO HAY GUARDIANES DISPONIBLES</td>
                                   <?php } else {?>
                                   <thead>
                                        <tr>
                                             <th class="thListGuardian">Nombre</th>
                                             <th class="thListGuardian">Dirección</th>
                                             <th class="thListGuardian">Email</th>
                                             <th class="thListGuardian">Número</th>
                                             <th class="thListGuardian">Comienzo estadía</th>
                                             <th class="thListGuardian">Fin estadía</th>
                                             <th class="thListGuardian">Tamaños</th>
                                             <th class="thListGuardian">Precio por dia</th>
                                        </tr>
                                   </thead>
                                   <tbody>
                                        <?php
                                             foreach($listChecked as $guardian){?>
                                             <tr>
                                                  <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                                  <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd();?></td>
                                                  <td class="thListGuardian"><?php foreach ($gxsDAO->getSizeById($guardian->getIdGuardian()) as $size){?>
                                                       <?php echo $size. "<br>";?>   
                                                  <?php } ?></td> 
                                                  <td class="thListGuardian"><?php echo $guardian->getPrice();?></td>
                                                  <input type="hidden" name="availabilityStart" value="<?php echo $availabilityStart; ?>">   
                                                  <input type="hidden" name="availabilityEnd" value="<?php echo $availabilityEnd; ?>">   
                                                  <input type="hidden" name="idPet" value="<?php echo $idPet; ?>">   
                                                  <td><button class="buttonSelectG buttonHoversGreen" name="id" value="<?php echo $guardian->getEmail() ?>">Seleccionar</button></td>                                     
                                             </tr> 
                                   </tbody>
                              <?php }}?>
                         </table>
                    </form>
               </div>
          </section>
     </main>
</html>

