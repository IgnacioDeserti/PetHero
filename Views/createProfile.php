<?php include("header.php");
?>

<main>
    <div class="backgroundCreateProfile">
        <header>
            <h2 class="tituloCreateProfile">Registrate como:</h2>
        </header>
        <div>
            <form action="../Process/createProfileP.php" method="post">
                <button type="submit" name="do" value="guardian" class="buttonCreateProfileGuardian">Guardian</button>
                <button type="submit" name="do" value="owner" class="buttonCreateProfileOwner">Dueño</button>
            </form>
        </div>
        
    </div>
</main>