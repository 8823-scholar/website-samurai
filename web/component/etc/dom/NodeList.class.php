<?
/**
 * Nodeを複数保持するイテレータ
 * 
 * @package    Etc
 * @subpackage Dom
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Dom_NodeList implements Iterator
{
    public
        /** @var        int     要素数 */
        $length = 0;
    private
        /** @var        array   要素群 */
        $_nodes = array();
    
    
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * ノードを追加する
     *
     * @access     public
     * @param      object  $node   Etc_Dom_Node
     * @return     object  Etc_Dom_Node
     */
    public function addNode(Etc_Dom_Node $node)
    {
        $this->_nodes[] = $node;
        $this->length++;
        return $node;
    }


    /**
     * 指定のノードを削除
     *
     * @access     public
     * @param      object  $node   Etc_Dom_Node
     */
    public function removeNode(Etc_Dom_Node $node)
    {
        foreach($this->_nodes as $_key => $_node){
            if($node === $_node){
                unset($this->_nodes[$_key]);
                $this->_nodes = array_values($this->_nodes);
                $this->length--;
                return true;
            }
        }
        throw new Etc_Dom_Exception('not found such node.');
    }


    /**
     * 指定のノードを置換
     *
     * @access     public
     * @param      object  $new_node   Etc_Dom_Node
     * @param      object  $old_node   Etc_Dom_Node
     */
    public function replaceNode(Etc_Dom_Node $new_node, Etc_Dom_Node $old_node)
    {
        foreach($this->_nodes as $_key => $node){
            if($node === $old_node){
                $this->_nodes[$_key] = $new_node;
                return true;
            }
        }
        throw new Etc_Dom_Exception('not found such node.');
    }


    /**
     * ノードを指定のノードの手前に挿入する
     *
     * @access     public
     * @param      object  $new_node   Etc_Dom_Node
     * @param      object  $ref_node   Etc_Dom_Node
     */
    public function insertBefore(Etc_Dom_Node $new_node, Etc_Dom_Node $ref_node)
    {
        foreach($this->_nodes as $_key => $node){
            if($node === $ref_node){
                $pre_nodes = array_slice($this->_nodes, 0, $_key);
                $post_nodes = array_slice($this->_nodes, $_key);
                $this->_nodes = array_merge($pre_nodes, array($new_node), $post_nodes);
                $this->length++;
                return true;
            }
        }
        throw new Etc_Dom_Exception('not found such node.');
    }


    /**
     * 指定インデックスのノードを取得する
     *
     * @access     public
     * @param      int     $index
     * @return     object  Etc_Dom_Node
     */
    public function item($index)
    {
        return isset($this->_nodes[$index]) ? $this->_nodes[$index] : NULL ;
    }





    /**
     * ノードを空にする
     *
     * @access     public
     */
    public function clear()
    {
        $this->_nodes = array();
        $this->length = 0;
    }





    /**
     * @implements
     */
    public function rewind()
    {
        reset($this->_nodes);
    }
    public function key()
    {
        return key($this->_nodes);
    }
    public function current()
    {
        return current($this->_nodes);
    }
    public function next()
    {
        next($this->_nodes);
    }
    public function valid()
    {
        $result = $this->key();
        if($result === NULL){
            $this->rewind();
            return false;
        } else {
            return true;
        }
    }
}
