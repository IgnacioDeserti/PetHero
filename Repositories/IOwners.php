<?php

    namespace Repositories;

    use Models\Owner as Owner;

    interface IOwners{
        function add(Owner $newOwner);
        function delete($id);
        function getAll();
    }

?>