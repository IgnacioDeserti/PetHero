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
                              <th>name</th>
                              <th>address</th>
                              <th>email</th>
                              <th>number</th>
                              <th>availabilityStart</th>
                              <th>availabilityEnd</th>
                              <th>size</th>
                         </tr>
                    </thead>
                    <tbody>
                         <?php 
                         if(isset($arrayListGuardian)){
                              foreach($arrayListGuardian as $guardian)
                               {?>
                                   <tr class="rowListGuardian">
                                        <td><?php echo $guardian->getName();?> </td>
                                        <td><?php echo $guardian->getAddress();?></td>
                                        <td><?php echo $guardian->getEmail();?></td>
                                        <td><?php echo $guardian->getNumber();?></td>
                                        <td><?php echo $guardian->getAvailabilityStart();?></td>
                                        <td><?php echo $guardian->getAvailabilityEnd();?></td>
                                        <td><?php foreach($guardian->getSize() as $size){
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

