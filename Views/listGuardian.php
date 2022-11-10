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
                    
                    <form action="<?php echo FRONT_ROOT ?>Owner/selectGuardian" method="post">
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
                                        <th class="thListGuardian">Precio por dia</th>

                                   </tr>
                              </thead>
                              <tbody>
                                   <?php
                                        foreach($arrayListGuardian as $guardian){
                                        if($availabilityStart <= $guardian->getAvailabilityStart() && $availabilityEnd >= $guardian->getAvailabilityEnd()){ ?>
                                        <tr>
                                             <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                             <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart();?></td>
                                             <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd();?></td>
                                             <?php foreach ($gxsDAO->getSizeById($guardian->getIdGuardian()) as $size){?>
                                                  <td class="thListGuardian"><?php echo $size;?></td>    
                                             <?php } ?>
                                             <td class="thListGuardian"><?php echo $guardian->getPrice();?></td>      
                                             <td><button class="" name="id" value="<?php echo $guardian->getEmail() ?>">Seleccionar</button></td>                                        
                                        </tr> <?php }?>
                                   <?php }?>
                              </tbody>
                         </table>
                    </form>
               </div>
          </section>
     </main>
</html>

