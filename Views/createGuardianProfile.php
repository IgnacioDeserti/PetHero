<?php
    include("header.php");
?>
<html class="pantallaInicial">
    <main>
    <?php if(isset($alert)) { ?>
                    <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } ?> </p>       
        <div class="formCreateProfile">         
            <header>            
                <h3 class="tituloForm">Create un nuevo perfil como guardian</h3>        
            </header>

            <form action=" <?php echo FRONT_ROOT ?>Home/createGuardianProfile" method="POST" class="contentForm"> 
                    <div class="divForm">                    
                        <label for="">Name</label>                     
                        <input type="text" name="name" placeholder="Ingresar nombre" class="inputForm" required>                
                    </div>                
                    <div class="divForm">                    
                        <label for="">Address</label>                     
                        <input type="text" name="address" placeholder="Ingresar dirección" class="inputForm" required>                
                        </div>                
                    <div class="divForm">                    
                        <label for=""> Email</label>                    
                        <input type="email" name="email" placeholder="Ingresar email" class="inputForm" required>               
                    </div>                 
                    <div class="divForm">                     
                        <label for="">Number</label>                   
                        <input type="number" name="number" placeholder="Ingresar numero de telefono" class="inputForm" required>
                    </div>
                    <div class="divForm">                    
                        <label for="">User Name</label>                     
                        <input type="text" name="userName" placeholder="Ingresar usuario" class="inputForm" required>                
                    </div>                 
                    <div class="divForm">                    
                        <label for="">Password</label>        
                        <input type="password" name="password" placeholder="Ingresar contraseña" class="inputForm" required>                
                    </div>                 
                    <div class='divForm'>
                        <input type="checkbox" id="ch1" name="size[]" value="1" checked>
                        <label for="ch1">Pequeño</label>
                        <input type="checkbox" id="ch2" name="size[]" value="2">
                        <label for="ch2">Mediano</label>
                        <input type="checkbox" id="ch3" name="size[]" value="3">
                        <label for="ch3">Grande</label>
                    </div>

                    <div class='divForm'>
                        <label> Precio por dia</label>
                        <input type="number" name='price' placeholder="Ingrese el monto" class="inputForm" required>
                    </div>

                    <div>
                        <input type="hidden" name="typeUser" value="G">
                        <button type="submit" class="buttonForm buttonHoversGreen">Registrarse</button>
                    </div>

            </form>
            
            <form action="<?php echo FRONT_ROOT . "Home/createProfile"?>">
                <button class="buttonGoBackGuardian buttonRedHovers">Volver</button>        
            </form>
        </div>

    </main>
</html>