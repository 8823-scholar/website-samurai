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
    public function it取得：複数()
    {
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(2);
        $forums = $this->ForumManager->gets($condition);
        $this->spec($forums->getSize())->should->be(2);
    }

    public function it記事の取得()
    {
        $article = $this->ForumManager->getArticle(1, 2);
        $this->spec($article)->shouldNot->beNull();
        $this->spec($article->id)->should->be(2);
        $this->spec($article->forum_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->ForumManager->getCondition();
        $condition->where->parent_id = NULL;
        $article = $this->ForumManager->getArticle(2, $condition);
        $this->spec($article->forum_id)->should->be(2);
        $this->spec($article->parent_id)->should->beNull();
    }
    public function it記事の取得：複数()
    {
        $condition = $this->ForumManager->getCondition();
        $condition->setLimit(3);
        $articles = $this->ForumManager->getArticles(3, $condition);
        $this->spec($articles->getSize())->should->be(3);
    }
    public function it記事の取得：再帰的()
    {
        $article = $this->getArticlesReflexive(3, 5);
        $this->spec($article->children)->shouldNot->beNull();
        $this->spec($article->children->fetch()->children)->shouldNot->beNull();
    }



    //準備
    public function beforeAll()
    {
        //コンポーネント準備
        $this->ForumManager = new Web_Forum_Manager();
        $this->ForumManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->ForumManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `forum` (
                `id` int(11) NOT NULL auto_increment,
                `title` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT 'タイトル',
                `description` text collate utf8_unicode_ci NOT NULL COMMENT '説明文',
                `topic_count` int(11) NOT NULL default '0' COMMENT 'トピック（ルート記事）数',
                `article_count` int(11) NOT NULL default '0' COMMENT '投稿記事数',
                `last_posted` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT '最終投稿時間',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='フォーラム';
        ");
        $this->ForumManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `forum_articles` (
                `id` int(11) NOT NULL auto_increment,
                `forum_id` int(11) NOT NULL default '0' COMMENT '=forum.id',
                `parent_id` int(11) default NULL COMMENT '=forum_articles.id',
                `name` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT '名前',
                `mail` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT 'メールアドレス',
                `subject` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '件名',
                `body` text collate utf8_unicode_ci NOT NULL COMMENT '本文',
                `user_id` int(11) NOT NULL default '0' COMMENT '=user.id',
                `user_role` varchar(16) collate utf8_unicode_ci NOT NULL COMMENT '=user.role',
                `mail_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT 'メールアドレスを表示するかどうか',
                `mail_inform` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT 'メール通知するかどうか',
                `reply_count` int(11) NOT NULL default '0' COMMENT '返信数',
                `reply_last_id` int(11) default NULL COMMENT '最後の返信記事ID',
                `resolved` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT '解決フラグ',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `forum_id` (`forum_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='フォーラムの記事';
        ");
        //データ挿入
        $datas = array(
            array('title' => 'フォーラム１', 'description' => 'フォーラム１です。'),
            array('title' => 'フォーラム２', 'description' => 'フォーラム２です。'),
            array('title' => 'フォーラム３', 'description' => 'フォーラム３です。'),
        );
        foreach($datas as $data){
            $this->ForumManager->AG->create('forum', $data);
        }
        $datas = array(
            array('forum_id' => 1, 'parent_id' => NULL, 'name' => 'hayabusa', 'subject' => '1', 'body' => '1'),
            array('forum_id' => 1, 'parent_id' => 1, 'name' => 'falcon', 'subject' => '1:1', 'body' => '1:1'),
            array('forum_id' => 2, 'parent_id' => NULL, 'name' => 'hayabusa', 'subject' => '2', 'body' => '2'),
            array('forum_id' => 3, 'parent_id' => NULL, 'name' => 'falcon', 'subject' => '3', 'body' => '3'),
        );
    }
}
