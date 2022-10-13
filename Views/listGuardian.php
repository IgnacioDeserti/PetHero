<?php
       include('header.php');

       use Models\Guardian as guardian;
       use DAO\guardiansDAO as guardiansDAO;

       $daoGuardian = new guardiansDAO();

       $arrayListGuardian = $daoGuardian->getAll();

?>

<main>
     <section id="listado">
          <div>
               <h2>Guardianes</h2>
               <table >
                    <thead>
                         <th>name</th>
                         <th>address</th>
                         <th>email</th>
                         <th>number</th>
                         <th>availabilityStart</th>
                         <th>availabilityEnd</th>
                         <th>size</th>
                         <th>reviews</th>
                    </thead>
                    <tbody>

                         <?php 
                         if(isset($arrayListGuardian)){
                              foreach($arrayListGuardian as $guardian)
                               {?>
                                   <tr>
                                        <td><?php echo $guardian->getName()?> </td>
                                        <td><?php echo $guardian->getAddress()?></td>
                                        <td><?php echo $guardian->getEmail()?></td>
                                        <td><?php echo $guardian->getNumber()?></td>
                                        <td><?php echo $guardian->getAvailabilityStart()?></td>
                                        <td><?php echo $guardian->getAvailabilityEnd()?></td>
                                        <td><?php echo $guardian->getSize()?></td>
                                        <td><?php echo $guardian->getReviews()?></td>
                                   </tr>
                         <?php }} ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>

