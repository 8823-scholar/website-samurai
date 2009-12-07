<?
/**
 * Web_Model
 * 
 * SamuraiWEBでのModelはすべてこれを継承すること。
 * 
 * @package    SamuraiWEB
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Web_Model extends Samurai_Model
{
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        parent::__construct(); 
    }


    /**
     * @access     protected
     * @param      mixed    $value
     * @param      value    $key
     * @return     object   ActiveGatewayCondition
     */
    protected function _toAGCondition($value, $alias, $key=NULL)
    {
        if(is_object($value) || (is_array($value) && (!isset($value[0]) || !$value))){
            $this->_initAGCondition($value);
            return $value;
        } else {
            if($key === NULL){
                $record = $this->AG->build($alias);
                $key = $record->getPrimaryKey();
            }
            $this->_initAGCondition($condition);
            $condition->where->$key = $value;
            return $condition;
        }
    }
}
