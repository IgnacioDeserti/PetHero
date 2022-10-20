<?php
    include('header.php');
?>
<html>
    <main>
        <div class="content">
            <header class="text-center">
                <h2 class="tituloInicio ">BIENVENIDO</h2>
            </header>
            <div class="loginForm">
                <form action=" <?php echo FRONT_ROOT?> inicioSesion/inicioSesion" method="post">
                    <div class = "contenidoForm">
                        <label for="email"> <h3>Usuario</h3></label>
                        <input type="email" name="email" placeholder="email" class="inputLogin"><br><br>
                    
                        <label for="password"><h3>Password</h3></label>
                        <input type="password" name="password" placeholder="password" class="inputLogin">
                    
                        <button class="buttonInicio buttonHoversGreen" type="submit">Iniciar Sesion</button>
                    </div>
                </form>
                <div>
                    <span>¿No tenes cuenta? <form action="<?php echo FRONT_ROOT ?>createProfile/createProfile" method="post"><button type="submit">Registrate!</button></form></span>
                </div>
            </div>
        </div>
    </main>