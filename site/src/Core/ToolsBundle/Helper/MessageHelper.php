<?php

namespace Core\ToolsBundle\Helper;


class MessageHelper
{
    public static function build($content, $success = true)
    {
        return (array('text' => $content, 'success' => $success));
    }
}
?>
