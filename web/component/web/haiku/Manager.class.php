<?php
/**
 * haiku管理クラス
 * 
 * haiku関連テーブルの操作を目的としています
 * 
 * @package    SamuraiWEB
 * @subpackage Haiku
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Web_Haiku_Manager extends Samurai_Model
{
    protected
        $_table = 'haiku';


    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * ランダムに一つ取得
     *
     * @access     public
     * @param      int | object   $id
     * @return     object   ActiveGatewayRecord
     */
    public function getByRandom()
    {
        $sql = "SELECT * FROM `:th` WHERE `active` = '1' ORDER BY RAND()";
        $sql = str_replace(':th', $this->_table, $sql);
        return $this->AG->findSql($this->_table, $sql);
    }
}
