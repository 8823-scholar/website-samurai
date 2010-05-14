<?php
/**
 * Wickey用のGeSHiレンダラー
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Helper_GeshiRenderer extends GeSHiRendererHTML
{
    function getHeader ()
    {
        $this->contextCSS = array();
        return '';
    }

    function getFooter ()
    {
        $this->contextCSS = array();
        return '';
    }
}
