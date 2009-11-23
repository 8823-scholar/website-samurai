<?
/**
 * Filter_ValidateIfUnlogined
 * 
 * ログインしてない時に限りValidate処理を行うFilter。
 * 
 * @package    SamuraiWEB
 * @subpackage Filter
 * @copyright  Samurai Framework Project
 * @author     Satoshinosuke Kiuchi <scholar@hayabusa-lab.jp>
 */
class Filter_ValidateIfUnlogined extends Filter_Validate
{
    public
        $User;
    
    
    /**
     * prefilter.
     * @override
     */
    public function _prefilter()
    {
        if($this->User->logined) return;
        parent::_prefilter();
    }
}
