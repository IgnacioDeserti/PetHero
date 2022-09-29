<?php

    namespace Repositories;

    use Models\Guardian as Guardian;

    interface IGuardians{
        function add(Guardian $newGuardian);
        function delete($id);
        function getAll();
    }

?>