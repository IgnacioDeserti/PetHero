<?php
       include('header.php');

       use Models\Dog;
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
                         <th>Name</th>
                         <th>Address</th>
                         <th>Email</th>
                         <th>Number</th>
                         <th>Availability Start</th>
                         <th>Availability End</th>
                         <th>Size</th>
                         <th>Reviews</th>
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

