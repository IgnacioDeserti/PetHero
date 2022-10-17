<?php
       include('header.php');

       use Models\Guardian as guardian;
       use DAO\guardiansDAO as guardiansDAO;

       $daoGuardian = new guardiansDAO();

       $arrayListGuardian = $daoGuardian->getAll();

?>

<main>
     <section id="listado">
          <div class="divListGuardian">
               <table class="tableListGuardian">
                    <caption>Guardianes</caption>
                    <thead>
                         <tr>
                              <th class="thListGuardian">name</th>
                              <th class="thListGuardian">address</th>
                              <th class="thListGuardian">email</th>
                              <th class="thListGuardian">number</th>
                              <th class="thListGuardian">availabilityStart</th>
                              <th class="thListGuardian">availabilityEnd</th>
                              <th class="thListGuardian">size</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php 
                         if(isset($arrayListGuardian)){
                              foreach($arrayListGuardian as $guardian)
                               {?>
                                   <tr>
                                        <td class="thListGuardian"><?php echo $guardian->getName();?> </td>
                                        <td class="thListGuardian"><?php echo $guardian->getAddress();?></td>
                                        <td class="thListGuardian"><?php echo $guardian->getEmail();?></td>
                                        <td class="thListGuardian"><?php echo $guardian->getNumber();?></td>
                                        <td class="thListGuardian"><?php echo $guardian->getAvailabilityStart();?></td>
                                        <td class="thListGuardian"><?php echo $guardian->getAvailabilityEnd();?></td>
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
                         <?php }} ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>

