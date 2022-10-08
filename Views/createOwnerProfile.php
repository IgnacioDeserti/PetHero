<?php
    include("header.php");
?>
<main>        
    <div class="formCreateProfile">         
        <header>            
             <h2 class="tituloForm">Create un nuevo perfil como dueño</h2>        
        </header>          
        <form action="../Process/createOwnerProfile.php" method="POST" class="contentForm">                
            <div class="divForm">                    
                <label for="">Name</label>                     
                <input type="text" name="name" placeholder="Ingresar nombre" class="inputForm" required>                
            </div>                 
            <div class="divForm">                    
                <label for="">Address</label>                    
                <input type="email" name="email" placeholder="Ingresar email" class="inputForm" required>               
            </div>                 
            <div class="divForm">                    
                <label for="">Email</label>        
                <input type="password" name="password" placeholder="Ingresar contraseña" class="inputForm" required>                
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

            <button type="submit" class="buttonForm">Registrarse</button>
        </form>
    </div>

</main>