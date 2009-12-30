<?php
/**
 * インデックス
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Index extends Web_Action
{
    public
        $articles = array();
    public
        $ForumManager;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        //最新のフォーラム投稿を取得
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(10);
        $condition->total_rows = false;
        $condition->order->created_at = 'DESC';
        $articles = $this->ForumManager->getArticles(NULL, $condition);
        $this->articles = $articles->toArray();

        return 'success';
    }
}
