<?php

    namespace DAO;

    use Models\Pet as Pet;

    interface IPetDAO{
        function add(Pet $newPet);
        function delete($id);
        function getAll();
    }

?>