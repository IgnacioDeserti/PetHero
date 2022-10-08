<?php
    include("header.php");
?>
<html>
    <main>
        <div class="content">
            <header class="text-center">
                <h2 class="tituloInicio ">BIENVENIDO</h2>
            </header>
            <div class="loginForm">
                <form action=" <?php echo FRONT_ROOT?> /Process/inicioSesion.php" method="post">
                    <div class = "contenidoForm">
                        <label for="email"> <h3>Usuario</h3></label>
                        <input type="email" name="email" placeholder="email" class="inputLogin"><br><br>
                    
                        <label for="password"><h3>Password</h3></label>
                        <input type="password" name="password" placeholder="password" class="inputLogin">
                    
                        <button class="buttonInicio" type="submit">Iniciar Sesion</button>
                        <span class="registroInicio">¿No tenes cuenta? <a href="../Process/createProfile.php">Registrate!</a> </span>
                    </div>
                </form>
            </div>
        </div>
    </main>