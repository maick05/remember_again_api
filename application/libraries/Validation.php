<?php 
class Validation
{
    public static function isEmpty($dados)
    {
        $msg = json_encode(array('status' => 'danger', 'mensagem' => "Empty data!", 'key' => 'error', 'icon' => 'bug'));
        if(sizeof($dados) > 0)
        {
            foreach($dados as $value)
            {
                if(!isset($value))
                {
                    echo $msg;
                    return true;
                }
            }
            return false;

        }
        else
        {
            echo $msg;
            return true;
        }
    }
}