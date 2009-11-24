<?
/**
 * Action_Etc_Antispam
 * 
 * アンチスパム用の認証用画像を出力する
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Etc
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Etc_Antispam extends Web_Action
{
    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        
        $this->_kcaptcha();
    }





    /**
     * kcaptcha版
     * @access     private
     */
    private function _kcaptcha()
    {
        Samurai_Loader::load('library/kcaptcha/kcaptcha.php');
        $captcha = new KCAPTCHA();
        $space = $this->Request->get('space', 'antispam');
        $this->Session->set($space, $captcha->getKeyString());
    }
}
