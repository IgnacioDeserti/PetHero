<?php 
    include('header.php');
?>

<main>
    <div class="backgroundCreateProfile">
        <header>
            <h2 class="tituloCreateProfile">Registrate como:</h2>
        </header>
        <div>
            <form action="<?php echo FRONT_ROOT ?> createProfile/profileType" method="post">
                <button type="submit" name="do" value="guardian" class="buttonCreateProfileGuardian">Guardian</button>
                <button type="submit" name="do" value="owner" class="buttonCreateProfileOwner">Dueño</button>
                <button type="submit" name="do" value="goBack" class="buttonGoBackCreateProfile">Volver</button>
            </form>
        </div>
        
    </div>
</main>