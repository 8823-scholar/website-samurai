<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty strip modifier plugin
 *
 * Type:     modifier<br>
 * Name:     bytes<br>
 * Example:  {$var|bytes}
 * Date:     2009/12/01
 * @author   hayabusa <scholar@hayabusa-lab.jp>
 */
function smarty_modifier_bytes($integer)
{
    switch(true){
        case $integer < 1024000:
            $result = round($integer / 1024, 2) . 'KB';
            break;
        case $integer < 1024000000:
            $result = round($integer / 1024000, 2) . 'MB';
            break;
        default:
            $result = round($integer / 1024000000, 2) . 'GB';
            break;
    }
    return $result;
}
