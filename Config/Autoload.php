<?php
namespace Config;
    class Autoload{
        
        public static function Start(){
            spl_autoload_register(function($classPath){
            
                $class = ucwords(str_replace("\\", "/", ROOT.$classPath). ".php");
            
                include_once($class);
            });
        }
    }


?>