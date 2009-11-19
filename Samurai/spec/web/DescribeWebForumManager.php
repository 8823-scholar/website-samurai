<?
/**
 * DescribeWebForumManager
 *
 * @package    SamuraiWEB
 * @subpackage Spec
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class DescribeWebForumManager extends PHPSpec_Context
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
        $article = $this->ForumManager->getArticlesReflexive(3, 5);
        $this->spec($article->children)->shouldNot->beNull();
        $this->spec($article->children->fetch()->children)->shouldNot->beNull();
    }

    //操作系
    public function it追加()
    {
        $dto = new stdClass();
        $dto->title = '追加しますたよ';
        $dto->description = 'うっほうっほうほほほほほ。';
        $forum = $this->ForumManager->add($dto);
        $this->spec($forum->title)->should->be('追加しますたよ');
        $this->spec($forum->description)->should->be('うっほうっほうほほほほほ。');
    }
    public function it保存()
    {
        $forum = $this->ForumManager->get(2);
        $forum->title = 'このフォーラムはすでに編集されている。';
        $forum->description = 'ID:2のフォーラムを編集しましたが、なにか？';
        $this->ForumManager->save($forum);
        $forum = $this->ForumManager->get(2);
        $this->spec($forum->title)->should->be('このフォーラムはすでに編集されている。');
        $this->spec($forum->description)->should->be('ID:2のフォーラムを編集しましたが、なにか？');
    }
    public function it編集()
    {
        $this->ForumManager->edit(2, array('title' => 'editしますた'));
        $forum = $this->ForumManager->get(2);
        $this->spec($forum->title)->should->be('editしますた');
    }
    public function it破壊()
    {
        $forum = $this->ForumManager->get(4);
        $this->spec($forum)->shouldNot->beNull();
        $this->ForumManager->destroy($forum);
        $forum = $this->ForumManager->get(4);
        $this->spec($forum)->should->beNull();
    }
    public function it削除()
    {
        $forum = $this->ForumManager->get(3);
        $this->spec($forum)->shouldNot->beNull();
        $this->ForumManager->delete($forum->id);
        $forum = $this->ForumManager->get(3);
        $this->spec($forum)->should->beNull();
    }

    public function it記事の追加()
    {
        $dto = new stdClass();
        $dto->name = 'hayabusa';
        $dto->mail = 'hayabusa@samurai-fw.org';
        $dto->subject = '記事の追加です';
        $dto->body = '記事の追加なんてほんとにできるの？';
        $article = $this->ForumManager->addArticle(4, $dto);
        $this->spec($article->forum_id)->should->be(4);
        $this->spec($article->name)->should->be('hayabusa');
        $this->spec($article->mail)->should->be('hayabusa@samurai-fw.org');
        $this->spec($article->subject)->should->be('記事の追加です');
        $this->spec($article->body)->should->be('記事の追加なんてほんとにできるの？');
    }
    public function it記事の保存()
    {
        $article = $this->ForumManager->getArticle(1, 2);
        $article->subject = '編集しますた';
        $article->body = 'forum:1, id:2 の記事を編集しましたが、なにか？';
        $this->ForumManager->saveArticle($article);
        $article = $this->ForumManager->getArticle(1, 2);
        $this->spec($article->subject)->should->be('編集しますた');
        $this->spec($article->body)->should->be('forum:1, id:2 の記事を編集しましたが、なにか？');

    }
    public function it記事の編集()
    {
        $this->ForumManager->editArticle(1, 3, array('subject'=>'1:3,edited', 'body'=>'1:3,edited'));
        $article = $this->ForumManager->getArticle(1, 3);
        $this->spec($article->subject)->should->be('1:3,edited');
        $this->spec($article->body)->should->be('1:3,edited');
    }
    public function it記事の破壊()
    {
        $article = $this->ForumManager->getArticle(4, 8);
        $this->spec($article)->shouldNot->beNull();
        $this->ForumManager->destroyArticle($article);
        $article = $this->ForumManager->getArticle(4, 8);
        $this->spec($article)->should->beNull();
    }
    public function it記事の削除()
    {
        $article = $this->ForumManager->getArticle(1, 3);
        $this->spec($article)->shouldNot->beNull();
        $this->ForumManager->deleteArticle($article->forum_id, $article->id);
        $article = $this->ForumManager->getArticle(1, 3);
        $this->spec($article)->should->beNull();
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
                `mail` varchar(128) collate utf8_unicode_ci NOT NULL default '' COMMENT 'メールアドレス',
                `subject` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '件名',
                `body` text collate utf8_unicode_ci NOT NULL COMMENT '本文',
                `user_id` int(11) NOT NULL default '0' COMMENT '=user.id',
                `user_role` varchar(16) collate utf8_unicode_ci NOT NULL default 'normal' COMMENT '=user.role',
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
            array('forum_id' => 1, 'parent_id' => 1, 'name' => 'falcon', 'subject' => '1:2', 'body' => '1:2'),
            array('forum_id' => 2, 'parent_id' => NULL, 'name' => 'hayabusa', 'subject' => '2', 'body' => '2'),
            array('forum_id' => 3, 'parent_id' => NULL, 'name' => 'falcon', 'subject' => '3', 'body' => '3'),
            array('forum_id' => 3, 'parent_id' => 5, 'name' => 'falcon', 'subject' => '3:1', 'body' => '3:1'),
            array('forum_id' => 3, 'parent_id' => 5, 'name' => 'falcon', 'subject' => '3:2', 'body' => '3:2'),
        );
        foreach($datas as $data){
            $this->ForumManager->AG->create('forum_articles', $data);
        }
    }
}
