<?
/**
 * DescribeSamuraiwebForumManager
 *
 * @package    Samuraiweb
 * @subpackage Spec
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class DescribeSamuraiwebForumManager extends PHPSpec_Context
{
    private
        $ForumManager;


    // list methods
    public function itListMethods()
    {
        /**
         * $ForumManager->get($id | $condition);
         * $ForumManager->gets($condition);
         * $ForumManager->getArticle($forum_id, $id | $condition);
         * $ForumManager->getArticles($forum_id, $condition);
         * $ForumManager->getArticlesReflexive($forum_id, $article_id);
         * $ForumManager->getArticlesWithoutForum($condition);
         * $ForumManager->add($dto);
         * $ForumManager->addArticle($forum_id, $dto, $User);
         * $ForumManager->save($forum);
         * $ForumManager->saveArticle($article);
         * $ForumManager->edit($forum_id, $attributes);
         * $ForumManager->editArticle($forum_id, $article_id, $attributes);
         * $ForumManager->destroy($forum);
         * $ForumManager->destroyArticle($article);
         * $ForumManager->delete($forum_id);
         * $ForumManager->deleteArticle($forum_id, $article_id);
         */
    }


    //取得系
    public function it取得()
    {
        $forum = $this->ForumManager->get(2);
        $this->spec($forum)->shouldNot->beNull();
        $this->spec($forum->id)->should->be(2);
        //引数には$conditionも可能
        $condition = $this->ForumManager->getCondition();
        $condition->where->id = 3;
        $forum = $this->ForumManager->get($condition);
        $this->spec($forum)->shouldNot->beNull();
        $this->spec($forum->id)->should->be(3);
    }



    //準備
    public function beforeAll()
    {
        //コンポーネント準備
        $this->ForumManager = new Samuraiweb_Forum_Manager();
        $this->ForumManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->ForumManager->AG->executeQuery("
            
        ");
    }
}
