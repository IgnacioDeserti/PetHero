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
                         <input type="date" name="availabilityStart">
                    </div>

                    <div>
                         <label for="">Fecha fin</label>
                    </div>

                    <div>
                         <input type="date" name="availabilityEnd">
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
                                        if($guardian->getAvailabilityStart()>= $availabilityStart && $guardian->getAvailabilityEnd()<= $availabilityEnd){
                                   ?>
                                        <tr>
                                             <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                             <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                             <?php if(($guardian->getAvailabilityStart() == null || $guardian->getAvailabilityEnd() == null)){?>
                                             <td class="thListGuardian">No disponible</td> 
                                             <td class="thListGuardian">No disponible</td>
                                             <?php } 
                                             else{?>
                                                  <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd();?></td>
                                             <?php } ?>
                                             <td class="thListGuardian"><?php foreach($guardian->getSize() as $size){
                                                  if(strcmp($size, "small") == 0){
                                                  ?> Pequeño <?php
                                                  }else if(strcmp($size, "medium") == 0){
                                                  ?> Mediano <?
                                                  }else{
                                                  ?> Grande <?php
                                                  }
                                             }?>
                                             </td>                                        
                                        </tr>
                              <?php }}} ?>
                         </tbody>
                    </table>
               </div>
          </section>
     </main>
</html>

