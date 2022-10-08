<?php

    namespace DAO;

    use Models\Owner as Owner;

    interface IOwnersDAO{
        function add(Owner $newOwner);
        function delete($id);
        function getAll();
    }

?>