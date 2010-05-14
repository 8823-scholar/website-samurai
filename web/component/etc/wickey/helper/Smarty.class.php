<?php
/**
 * Wickey用のSmartyHelper
 * 
 * Smartyテンプレート上でWickeyの操作を助けるクラス
 * 
 * @package    SamuraiWEB
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Helper_Smarty
{
    public
        $Wickey;


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * wickeyテキストを解釈
     *
     * @access     public
     * @param      array    $params
     * @param      object   $Smarty   Smarty
     * @return     string
     */
    public function render(array $params, Smarty $Smarty)
    {
        $text = '';
        $option = new stdClass();
        foreach($params as $_key => $_val){
            switch($_key){
            case 'text':
                $$_key = (string)$_val;
                break;
            case 'base':
                $option->base = (string)$_val;
                break;
            }
        }
        return $this->Wickey->render($text, $option);
    }


    /**
     * wickeyで描画された見出しの一覧をメニュー化して描画
     *
     * @access     public
     * @param      array    $params
     * @param      object   $Smarty   Smarty
     * @return     string
     */
    public function renderContentsMenu(array $params, Smarty $Smarty)
    {
        return $this->Wickey->renderContentsMenu();
    }
}
