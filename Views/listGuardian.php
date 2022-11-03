<?php
       include('header.php');
       include("nav.php");

       use Models\Guardian as guardian;
       use DAO\guardiansDAO as guardiansDAO;

       $daoGuardian = new guardiansDAO();

       $arrayListGuardian = $daoGuardian->getAll();

?>

<html class="fondoMenus">
     <main>
          <section id="listado">
               <div class="divListGuardian">
                    
                    <form action=" <?php echo FRONT_ROOT ?>Owner/showGuardianList" method="POST">
               
                    <div>
                         <label for="">Fecha inicio</label>
                    </div>
                
                    <div>
                         <input type="date" name="availabilityStart" required>
                    </div>

                    <div>
                         <label for="">Fecha fin</label>
                    </div>

                    <div>
                         <input type="date" name="availabilityEnd" required>
                    </div>

                    <button type="submit">Filtrar</button>

                    </form>

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
                              <?php 
                              if(isset($arrayListGuardian)){
                                   foreach($arrayListGuardian as $guardian)
                                   {
                                        if($guardian->getAvailabilityEnd() == null && $guardian->getAvailabilityStart() == null && ($availabilityStart == "1990-01-01" && $availabilityEnd == "3000-12-31")){
                                   ?>
                                        <tr>
                                             <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                             <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                             <td class="thListGuardian">No disponible</td> 
                                             <td class="thListGuardian">No disponible</td>
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
                                             <td><button class="" name="id" value="<?php echo $guardian->getIdGuardian() ?>">Seleccionar</button></td>                                        
                                        </tr>
                              <?php }else if($availabilityStart == "1990-01-01" && $availabilityEnd == "3000-12-31"){ ?>
                                   <tr>
                                             <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                             <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd();?></td>
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
                                             <td><button class="" name="id" value="<?php echo $guardian->getIdGuardian() ?>">Seleccionar</button></td>                                        
                                        </tr>
                              <?php }else{
                                        if($availabilityStart <= $guardian->getAvailabilityStart() && $availabilityEnd >= $guardian->getAvailabilityEnd()){ ?>
                                             <tr>
                                                  <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                                  <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart();?></td>
                                                  <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd();?></td>
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
                                                  <td><button class="" name="id" value="<?php echo $guardian->getIdGuardian() ?>">Seleccionar</button></td>                                        
                                             </tr>
                              <?php }}}} ?>
                         </tbody>
                    </table>
               </div>
          </section>
     </main>
</html>

