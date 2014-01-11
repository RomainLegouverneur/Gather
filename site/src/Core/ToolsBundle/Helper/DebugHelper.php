<?php

namespace Core\ToolsBundle\Helper;


class DebugHelper
{
    public static function varDump($var)
    {
        echo '<fieldset style="color: red; border: 1px solid red; background-color: #FFB381"><legend style="font-weight: bold">DEBUG</legend><pre>';
        var_dump($var);
        echo '</pre></fieldset>';
    }
}
?>