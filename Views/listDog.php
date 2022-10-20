<?php

       include('header.php');
       
       use DAO\dogDAO as dogDAO;

       $DAODog = new dogDAO();

       $arrayListDog = $DAODog->getAll();

?>

<main>
     <section id="listado">
          <div>
               <h2>Perros</h2>
               <table >
                    <thead>
                         <th>name</th>
                         <th>breed</th>
                         <th>size</th>
                         <th>observations</th>
                         <th>photo</th>
                    </thead>
                    <tbody>

                         <?php 
                         if(isset($arrayListDog)){
                              foreach($$arrayListDog as $dog)
                               {if($dog->getIdOwner==$_SESSION['idUser']){?>
                                   <tr>
                                        <td> <?php echo $dog->getName()?> </td>
                                        <td><?php echo $dog->getBreed()?></td>
                                        <td><?php echo $dog->getSize()?></td>
                                        <td><?php echo $dog->getObservations()?></td>
                                        <td><?php echo $dog->getPhoto()?></td>

                                   </tr>
                         <?php }}} ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>