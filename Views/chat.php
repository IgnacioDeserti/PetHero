<?php
    include("header.php");
    include("nav.php");
?>

<html class="fondoMenus">
    <main class="d-flex align-items-center justify-content-center height-100">
        <div class="containerChatMenu">
            <header>
                <h2 style="text-align: center;"> </h2>
            </header>

            <form action="<?php echo FRONT_ROOT ?> Home/LoadChat" method="post" class="contentForm" enctype="multipart/form-data">
                
                <div class="containerImgChat">
                    <img class="imgSendMessage" src="https://st2.depositphotos.com/19428878/44645/v/600/depositphotos_446453832-stock-illustration-default-avatar-profile-icon-social.jpg"width="50px" height="50px"></img>
                </div>

                <div class="containerNameUser">
                    <h3>Chat con <?= $name; ?></h3>
                </div>

                <div class="containerChat">
                    <?php
                        if(isset($chat)){
                            foreach($chat as $message){?>
                                <div class="containerMessage">
                                    <h4 class="<?php if ($message->getSender() == $_SESSION["typeUser"]) {
                                        echo "sender";
                                    } else {
                                        echo "receiver";
                                    } ?>"> 
                                    <?= $message->getContent(); ?></h4>
                                    <h6 class="<?php if ($message->getSender() == $_SESSION["typeUser"]) {
                                        echo "sender";
                                    } else {
                                        echo "receiver";
                                    } ?>">
                                        <?= $message->getFecha() ?></h6>
                                </div>
                            <?php } ?>
                        <?php } ?>
                </div> 

                <div class="containerNewMessage">
                    <input type="textarea" name="content" class="newMessageTextArea" placeholder="Escribe un mensaje">
                </div>

                <input type="hidden" name="idReservation" value="<?php echo $idReservation; ?>">

                <button class="buttonSendMessage buttonHoversGreen" type="submit"><img class="imgSendMessage" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQdXuAPaGjfVszgVw9SQ7NjvRn1MYUXYfEDfQ&usqp=CAU" width="50px" height="50px"></img></button>
            </form>
        
        </div>
    </main>
</html>