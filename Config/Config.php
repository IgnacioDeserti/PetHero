<?php
    namespace Config;

    define("ROOT", dirname(__DIR__). "/");
    define("IMG_ROOT", ROOT . "Views/img");
    define("FRONT_ROOT", "http://localhost/Facultadxampp/PetHero/");
    define("VIEWS_PATH", "Views/");
    define("CSS_PATH", FRONT_ROOT.VIEWS_PATH . "css/");
    define("JS_PATH", FRONT_ROOT.VIEWS_PATH . "js/");
    define("IMG_PATH", FRONT_ROOT.VIEWS_PATH . "img/");

    define("DB_HOST", "localhost");
    define("DB_NAME", "PetHero");
    define("DB_USER", "root");
    define("DB_PASS", "");
?>