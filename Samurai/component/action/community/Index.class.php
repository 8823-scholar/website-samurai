<?
/**
 * Action_Community_Index
 * 
 * コミュニティ / TOPページ
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Community
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Action_Community_Index extends Web_Action
{
    public
        $forums = array();
    public
        $ForumManager;


    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        $this->_setForums();

        return 'success';
    }




    /**
     * フォーラムの一覧をセットする
     * @access     private
     */
    private function _setForums()
    {
        $condition = $this->ForumManager->getCondition();
        $condition->order->sort = 'ASC';
        $forums = $this->ForumManager->gets($condition);
        $this->forums = $forums->toArray();
        //仮
        if($this->forums){
            $this->forums[0]['last_posted_at'] = '2009-11-20 02:45:44';
            $this->forums[0]['last_article'] = array('name' => 'hayabusa', 'id' => 1, 'subject' => 'インストールの仕方について');
        }
    }
}
