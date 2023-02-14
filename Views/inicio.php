<?php
    include('header.php');
?>
<html class="pantallaInicial">
    <main>
        <div>
            <header>
                <h2 class="tituloInicio ">BIENVENIDO</h2>
            </header>
            <?php if(isset($alert)) { ?>
                <p class="psException <?= $alert["type"] ?>"> <?= $alert["text"]; } ?> </p>
            <div class="loginForm">
                <form action=" <?php echo FRONT_ROOT?> Home/inicioSesion" method="post">
                    <div class = "contenidoForm">
                        <label for="email"> <h3>Usuario</h3></label>
                        <input type="email" name="email" placeholder="email" class="inputLogin"><br><br>
                    
                        <label for="password"><h3>Password</h3></label>
                        <input type="password" name="password" placeholder="password" class="inputLogin">
                    </div>

                    <div class="selectUser">
                        <label for="">Guardian</label>
                        <input type="radio" name="typeUser" value="G" checked>

                        <label for="">Dueño</label>
                        <input type="radio" name="typeUser" value="O">
                    </div>
                        <button class="buttonInicio buttonHoversGreen" type="submit">Iniciar Sesion</button>
                    
                </form>
                <div class="createProfileLink">
                    <h5>¿No tenes cuenta?</h5> <form action="<?php echo FRONT_ROOT ?>Home/createProfile" method="post"><button type="submit" class="buttonCreateLink buttonHoversGreen">Registrate!</button></form>
                </div>
            </div>
        </div>
    </main>