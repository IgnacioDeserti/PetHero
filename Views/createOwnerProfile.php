<?php
    include("header.php");
?>
<html class="pantallaInicial">
    <main>
    <?php if(isset($alert)) { ?>
                    <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } ?> </p>
        <div class="formCreateProfile">         
            <header>            
                <h3 class="tituloForm">Create un nuevo perfil como dueño</h3>        
            </header>          
                    
            <form action=" <?php echo FRONT_ROOT ?>Home/createOwnerProfile" method="POST" class="contentForm"> 
                    <div class="divOwner">                    
                        <label for="">Name</label>                                     
                    </div>

                    <div class="inputOwner">
                        <input type="text" name="name" placeholder="Ingresar nombre" required>
                    </div>

                    <div class="divOwner">                    
                        <label for="">Address</label>                                     
                    </div>
                    
                    <div class="inputOwner">
                        <input type="text" name="address" placeholder="Ingresar dirección" required>
                    </div>

                    <div class="divOwner">                    
                        <label for=""> Email</label>                    
                    </div>   

                    <div class ="inputOwner">
                        <input type="email" name="email"  placeholder="Ingresar email"  required>               
                    </div>

                    <div class="divOwner">                     
                        <label for="">Number</label>                   
                    </div>

                    <div class="inputOwner">
                        <input type="number" name="number"  placeholder="Ingresar numero de telefono" required>
                    </div>

                    <div class="divOwner">                    
                        <label for="">User Name</label>                                     
                    </div>

                    <div class="inputOwner">
                        <input type="text" name="userName"  placeholder="Ingresar usuario" required>                
                    </div>

                    <div class="divOwner">                    
                        <label for="">Password</label>        
                    </div> 

                    <div class="inputOwner">
                        <input type="password" name="password"  placeholder="Ingresar contraseña" required>                
                    </div>
                    
                    <div>
                        <input type="hidden" name="typeUser" value="O">
                        <button type="submit" class="buttonOwner buttonHoversGreen">Registrarse</button>
                    </div>
                </form>
            
            <form action="<?php echo FRONT_ROOT . "Home/createProfile"?>">
                <button class="buttonGoBackOwner buttonRedHovers">Volver</button>        
            </form>
        </div>

    </main>
</hmtl>