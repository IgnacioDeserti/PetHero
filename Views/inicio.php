<?php
    include("header.php");
?>

    <main class="pagInicio">
        <div class="content">
            <header class="text-center">
                <h2 class="tituloInicio ">BIENVENIDO</h2>
            </header>
            <div class="loginForm">
                <form action="../Process/inicioSesion.php" method="post">
                
                    <label for="email"> <h3>Usuario</h3></label><br>
                    <input type="email" name="email" placeholder="email"><br>
                
                
                    <label for="password"><h3>Password</h3></label><br>
                    <input type="password" name="password" placeholder="password"><br>
                
                    <button class="buttonInicio" type="submit">Iniciar Sesion</button>
                    <link rel="" href="">
                </form>
            </div>
        </div>

    </main>