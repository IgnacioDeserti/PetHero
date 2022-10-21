<?php 
    include('header.php');
?>
<html class="pantallaInicial">
    <main>
        <div class="backgroundCreateProfile">
            <header>
                <h2 style="text-align: center;">Registrate como:</h2>
            </header>
            <div>
                <form action="<?php echo FRONT_ROOT ?> createProfile/profileType" method="post">
                    <button type="submit" name="do" value="guardian" class="buttonCreateProfileGuardian buttonHoversGreen">Guardian</button>
                    <button type="submit" name="do" value="owner" class="buttonCreateProfileOwner buttonHoversGreen">Dueño</button>
                    <button type="submit" name="do" value="goBack" class="buttonGoBackCreateProfile buttonRedHovers">Volver</button>
                </form>
            </div>
            
        </div>
    </main>
</html>