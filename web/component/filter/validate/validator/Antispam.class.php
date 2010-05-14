<?
/**
 * Filter_Validate_Validator_Antispam
 * 
 * スパム認証チェック
 * 
 * @package    SamuraiWEB
 * @subpackage Filter.Validate
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Filter_Validate_Validator_Antispam extends Filter_Validate_Validator
{
    public
        $Session;
    
    
    /**
     * antispamの入力内容が一致するかどうか
     * @implements
     */
    public function validate($value, $params=array())
    {
        $value = (string)$value;
        $string = (string)$this->Session->getAndDel($params[0]);
        return $value === $string;
    }
}
