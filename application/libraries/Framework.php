<?php 
class Framework
{
    public static function load($class)
    {
        $CI =& get_instance();
        require_once('../../framework/libraries/'.$class.'.php');
    }
}
?>
