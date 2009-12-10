<?php
/**
 * テキストノード
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_Text extends Etc_Dom_Node
{
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct($value='')
    {
        parent::__construct();
        $this->nodeType = ETC_DOM_NODE_TEXT;
        $this->appendData($value);
    }


    /**
     * データの追加
     *
     * @access     public
     * @param      string  $data
     */
    public function appendData($data)
    {
        if(!is_string($data)) throw new Etc_Dom_Exception('data type missmatch.');
        $this->nodeValue .= $data;
    }


    /**
     * データの削除
     *
     * @access     public
     * @param      int     $offset
     * @param      int     $length
     */
    public function deleteData($offset, $length)
    {
        $pre = mb_substr($this->nodeValue, 0, $offset);
        $post = mb_substr($this->nodeValue, $offset + $length);
        $this->nodeValue = $pre . $post;
    }


    /**
     * データの挿入
     *
     * @access     public
     * @param      int     $offset
     * @param      string  $data
     */
    public function insertData($offset, $data)
    {
        if(!is_string($data)) throw new Etc_Dom_Exception('data type missmatch.');
        $pre = mb_substr($this->nodeValue, 0, $offset);
        $post = mb_substr($this->nodeValue, $offset);
        $this->nodeValue = $pre . $data . $post;
    }


    /**
     * データの置換
     *
     * @access     public
     * @param      int     $offset
     * @param      int     $length
     * @param      string  $data
     */
    public function replaceData($offset, $length, $data)
    {
        if(!is_string($data)) throw new Etc_Dom_Exception('data type missmatch.');
        $pre = mb_substr($this->nodeValue, 0, $offset);
        $post = mb_substr($this->nodeValue, $offset + $length);
        $this->nodeValue = $pre . $data . $post;
    }


    /**
     * valueを取得する
     * commentとの互換性保持
     *
     * @access     public
     * @return     string
     */
    public function getValue()
    {
        return htmlspecialchars($this->nodeValue);
    }
}
