<?php

    namespace DAO;

    use Models\Guardian as Guardian;

    interface IGuardiansDAO{
        function add(Guardian $newGuardian);
        function delete($id);
        function getAll();
    }

?>