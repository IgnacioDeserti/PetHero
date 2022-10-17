<?php

    namespace DAO;

    use Models\Dog as Dog;

    interface IDogDAO{
        function add(Dog $newDog);
        function delete($id);
        function getAll();
    }

?>