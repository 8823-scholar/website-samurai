<?php
/**
 * DescribeWebWikiManager
 *
 * @package    SamuraiWEB
 * @subpackage spec
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class DescribeWebWikiManager extends PHPSpec_Context
{
    private
        $WikiManager;


    // list methods
    public function itListMethods()
    {
        /**
         * $WikiManager->setLocale($locale);
         * $WikiManager->setDefaultLocale($locale);
         * $WikiManager->get($id | $condition);
         * $WikiManager->gets($condition);
         * $WikiManager->getHistory($wiki_id, $id | $condition);
         * $WikiManager->getHistories($wiki_id, $condition);
         * $WikiManager->getComment($wiki_id, $id | $condition);
         * $WikiManager->getComments($wiki_id, $condition);
         * $WikiManager->add($dto);
         * $WikiManager->addHistory($wiki_id, $dto);
         * $WikiManager->addComment($wiki_id, $dto, $User);
         * $WikiManager->save($wiki);
         * $WikiManager->saveHistory($history);
         * $WikiManager->saveComment($comment);
         * $WikiManager->edit($id, $attributes);
         * $WikiManager->editHistory($wiki_id, $id, $attributes);
         * $WikiManager->editComment($wiki_id, $id, $attributes);
         * $WikiManager->destroy($wiki);
         * $WikiManager->destroyHistory($history);
         * $WikiManager->destroyComment($comment);
         * $WikiManager->delete($id);
         * $WikiManager->deleteHistory($wiki_id, $id);
         * $WikiManager->deleteComment($wiki_id, $id);
         */
    }


    //設定
    public function it言語設定()
    {
        $this->spec($this->WikiManager->locale)->should->be('ja');
        $this->WikiManager->setLocale('en');
        $this->spec($this->WikiManager->locale)->should->be('en');
        $this->WikiManager->setLocale('ja');
    }
    public function itデフォルトの言語を設定する()
    {
        $this->spec($this->WikiManager->default_locale)->should->be('ja');
        $this->WikiManager->setDefaultLocale('en');
        $this->spec($this->WikiManager->default_locale)->should->be('en');
    }


    //取得系
    public function it取得()
    {
        $wiki = $this->WikiManager->get(1);
        $this->spec($wiki)->shouldNot->beNull();
        $this->spec($wiki->id)->should->be(1);
        //引数には$conditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->id = 10;
        $wiki = $this->WikiManager->get($condition);
        $this->spec($wiki)->should->beNull();
    }
    public function it取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $wikis = $this->WikiManager->gets($condition);
        $this->spec($wikis->getSize())->should->be(1);
    }

    public function itコメントの取得()
    {
        $comment = $this->WikiManager->getComment(1, 1);
        $this->spec($comment)->shouldNot->beNull();
        $this->spec($comment->id)->should->be(1);
        $this->spec($comment->wiki_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->id = 2;
        $comment = $this->WikiManager->getComment(1, $condition);
        $this->spec($comment)->shouldNot->beNull();
        $this->spec($comment->id)->should->be(2);
    }
    public function itコメントの取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $comments = $this->WikiManager->getComments(1, $condition);
        $this->spec($comments->getSize())->should->be(1);
    }

    public function it履歴の取得()
    {
        $history = $this->WikiManager->getHistory(1, 1);
        $this->spec($history)->shouldNot->beNull();
        $this->spec($history->id)->should->be(1);
        $this->spec($history->wiki_id)->should->be(1);
        //第二引数はconditionも可能
        $condition = $this->WikiManager->getCondition();
        $condition->where->id = 2;
        $history = $this->WikiManager->getHistory(1, $condition);
        $this->spec($history)->shouldNot->beNull();
        $this->spec($history->id)->should->be(2);
        $this->spec($history->wiki_id)->should->be(1);
    }
    public function it履歴の取得：複数()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->setLimit(1);
        $history = $this->WikiManager->getHistories(1, $condition);
        $this->spec($history->getSize())->should->be(1);
    }


    //操作系
    public function it追加()
    {
        $dto = new stdClass();
        $dto->name = 'spec/example1';
        $dto->content = 'うんたらかんたら';
        $wiki = $this->WikiManager->add($dto);
        $this->spec($wiki->name)->should->be('spec/example1');
        $this->spec($wiki->content)->should->be('うんたらかんたら');
        $this->WikiManager->add($dto);
    }
    public function it保存()
    {
        $wiki = $this->WikiManager->get(4);
        $wiki->name = 'spec/example2';
        $wiki->content = '編集しますた。';
        $this->WikiManager->save($wiki);
        $wiki = $this->WikiManager->get(4);
        $this->spec($wiki->name)->should->be('spec/example2');
        $this->spec($wiki->content)->should->be('編集しますた。');
    }
    public function it編集()
    {
        $this->WikiManager->edit(3, array('name' => 'spec/example2:edited'));
        $wiki = $this->WikiManager->get(3);
        $this->spec($wiki->name)->should->be('spec/example2:edited');
    }
    public function it破壊()
    {
        $wiki = $this->WikiManager->get(4);
        $this->spec($wiki)->shouldNot->beNull();
        $this->WikiManager->destroy($wiki);
        $wiki = $this->WikiManager->get(4);
        $this->spec($wiki)->should->beNull();
    }
    public function it削除()
    {
        $wiki = $this->WikiManager->get(5);
        $this->spec($wiki)->shouldNot->beNull();
        $this->WikiManager->delete($wiki->id);
        $wiki = $this->WikiManager->get($wiki->id);
        $this->spec($wiki)->should->beNull();
    }

    public function itコメントの追加()
    {
        $dto = new stdClass();
        $dto->name = 'hayabusa';
        $dto->comment = 'watashi ha hayabusa desu.';
        $comment = $this->WikiManager->addComment(2, $dto);
        $this->spec($comment->wiki_id)->should->be(2);
        $this->spec($comment->name)->should->be('hayabusa');
        $this->spec($comment->comment)->should->be('watashi ha hayabusa desu.');
        $this->WikiManager->addComment(2, $dto);
    }
    public function itコメントの保存()
    {
        $comment = $this->WikiManager->getComment(2, 4);
        $comment->name = 'falcon';
        $comment->comment = 'watashi ha falcon desu.';
        $this->WikiManager->saveComment($comment);
        $comment = $this->WikiManager->getComment(2, 4);
        $this->spec($comment->name)->should->be('falcon');
        $this->spec($comment->comment)->should->be('watashi ha falcon desu.');
    }
    public function itコメントの編集()
    {
        $this->WikiManager->editComment(2, 4, array('name' => 'kiuchi', 'comment' => 'watashi ha kiuchi desu.'));
        $comment = $this->WikiManager->getComment(2, 4);
        $this->spec($comment->name)->should->be('kiuchi');
        $this->spec($comment->comment)->should->be('watashi ha kiuchi desu.');
    }
    public function itコメントの破壊()
    {
        $comment = $this->WikiManager->getComment(2, 4);
        $this->spec($comment)->shouldNot->beNull();
        $this->WikiManager->destroyComment($comment);
        $comment = $this->WikiManager->getComment(2, 4);
        $this->spec($comment)->should->beNull();
    }
    public function itコメントの削除()
    {
        $comment = $this->WikiManager->getComment(2, 5);
        $this->spec($comment)->shouldNot->beNull();
        $this->WikiManager->deleteComment($comment->wiki_id, $comment->id);
        $comment = $this->WikiManager->getComment(2, 5);
        $this->spec($comment)->should->beNull();
    }

    public function it履歴の追加()
    {
        $dto = new stdClass();
        $dto->name = 'spec/example2';
        $dto->content = 'history of edited.';
        $history = $this->WikiManager->addHistory(2, $dto);
        $this->spec($history->wiki_id)->should->be(2);
        $this->spec($history->name)->should->be('spec/example2');
        $this->spec($history->content)->should->be('history of edited.');
        $history = $this->WikiManager->addHistory(2, $dto);
    }
    public function it履歴の保存()
    {
        $history = $this->WikiManager->getHistory(2, 3);
        $history->content = 'history of edited.:saved';
        $this->WikiManager->saveHistory($history);
        $history = $this->WikiManager->getHistory(2, 3);
        $this->spec($history->content)->should->be('history of edited.:saved');
    }
    public function it履歴の編集()
    {
        $this->WikiManager->editHistory(2, 3, array('content' => 'history of edited.:saved:edited'));
        $history = $this->WikiManager->getHistory(2, 3);
        $this->spec($history->content)->should->be('history of edited.:saved:edited');
    }
    public function it履歴の破壊()
    {
        $history = $this->WikiManager->getHistory(2, 3);
        $this->spec($history)->shouldNot->beNull();
        $this->WikiManager->destroyHistory($history);
        $history = $this->WikiManager->getHistory(2, 3);
        $this->spec($history)->should->beNull();
    }
    public function it履歴の削除()
    {
        $history = $this->WikiManager->getHistory(2, 4);
        $this->spec($history)->shouldNot->beNull();
        $this->WikiManager->deleteHistory($history->wiki_id, $history->id);
        $history = $this->WikiManager->getHistory(2, 4);
        $this->spec($history)->should->beNull();
    }
    public function it編集時に自動的に履歴が追加されるかどうか？()
    {
        //まずはwikiの作成
        $this->WikiManager->auto_history_add = true;
        $this->WikiManager->auto_revision_up = true;
        $dto = new stdClass();
        $dto->name = 'spec/example3';
        $dto->content = 'auto add to history ?';
        $dto->created_by = 1;
        $wiki = $this->WikiManager->add($dto);
        //履歴は格納されているか？
        $history = $this->WikiManager->getHistories($wiki->id)->getFirstRecord();
        $this->spec($history)->shouldNot->beNull();
        $this->spec($history->name)->should->be('spec/example3');
        $this->spec($history->content)->should->be('auto add to history ?');
        $this->spec($history->revision)->should->be(1);
        $this->spec($history->created_by)->should->be(1);
        
        //wikiを編集する
        $wiki->content = 'auto add to history ? :saved';
        $wiki->updated_by = 2;
        $this->WikiManager->save($wiki);
        //履歴は格納されているか？
        $history = $this->WikiManager->getHistories($wiki->id)->getFirstRecord();
        $this->spec($history)->shouldNot->beNull();
        $this->spec($history->name)->should->be('spec/example3');
        $this->spec($history->content)->should->be('auto add to history ? :saved');
        $this->spec($history->revision)->should->be(2);
        $this->spec($history->created_by)->should->be(2);
    }





    //準備
    public function before()
    {
        $this->WikiManager->auto_history_add = false;
        $this->WikiManager->auto_revision_up = false;
    }
    public function beforeAll()
    {
        //コンポーネント準備
        $this->WikiManager = new Web_Wiki_Manager();
        $this->WikiManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki` (
                `id` int(11) NOT NULL auto_increment,
                `name` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'ページ名',
                `content` text collate utf8_unicode_ci NOT NULL COMMENT '内容',
                `locale` varchar(3) collate utf8_unicode_ci NOT NULL default 'ja' COMMENT '言語',
                `localized_for` int(11) default NULL COMMENT 'あるWIKI翻訳の場合(=wiki.id)',
                `revision` int(11) NOT NULL default '1' COMMENT 'リビジョン番号',
                `created_by` int(11) NOT NULL default '0' COMMENT '=user.id',
                `updated_by` int(11) NOT NULL default '0' COMMENT '=user.id',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `name` (`name`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKI';
        ");
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_comments` (
                `id` int(11) NOT NULL auto_increment,
                `wiki_id` int(11) NOT NULL default '0' COMMENT '=wiki.id',
                `user_id` int(11) default NULL COMMENT '=user.id',
                `name` varchar(128) collate utf8_unicode_ci default NULL COMMENT '名前（未ログインの場合に限る）',
                `comment` text collate utf8_unicode_ci NOT NULL COMMENT 'コメント',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKIへのコメント';
        ");
        $this->WikiManager->AG->executeQuery("
            CREATE TEMPORARY TABLE IF NOT EXISTS `wiki_histories` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `wiki_id` int(11) NOT NULL DEFAULT '0' COMMENT '=wiki.id',
                `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ページ名',
                `content` text COLLATE utf8_unicode_ci NOT NULL COMMENT '内容',
                `locale` varchar(3) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ja' COMMENT '言語',
                `localized_for` int(11) DEFAULT NULL COMMENT 'あるWIKI翻訳の場合(=wiki.id)',
                `revision` int(11) NOT NULL DEFAULT '1' COMMENT 'リビジョン番号',
                `created_by` int(11) NOT NULL DEFAULT '0' COMMENT '=user.id',
                `updated_by` int(11) NOT NULL DEFAULT '0' COMMENT '=user.id',
                `created_at` int(11) NOT NULL DEFAULT '0',
                `updated_at` int(11) NOT NULL DEFAULT '0',
                `deleted_at` int(11) NOT NULL DEFAULT '0',
                `active` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
                PRIMARY KEY (`id`),
                KEY `wiki_id` (`wiki_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKIの変更履歴';
        ");
        //データ挿入
        $datas = array(
            array('name' => 'FrontPage', 'content' => '[ja] FrontPageのcontentです。', 'locale' => 'ja', 'revision' => 3),
            array('name' => 'FrontPage', 'content' => '[en] This is content of FrontPage.', 'locale' => 'en', 'localized_for' => 1),
            array('name' => 'directory/page', 'content' => 'このページにはまだ翻訳版がありません。', 'locale' => 'ja')
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki', $data);
        }

        $datas = array(
            array('wiki_id' => 1, 'user_id' => 1, 'name' => NULL, 'comment' => 'comment1'),
            array('wiki_id' => 1, 'user_id' => NULL, 'name' => 'falcon', 'comment' => 'comment2'),
            array('wiki_id' => 2, 'user_id' => 1, 'name' => 'falcon', 'comment' => 'comment3'),
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki_comments', $data);
        }

        $datas = array(
            array( 'wiki_id' => 1, 'name' => 'FrontPage', 'content' => '111111', 'revision' => 1, 'updated_by' => 1),
            array( 'wiki_id' => 1, 'name' => 'FrontPage', 'content' => '222222', 'revision' => 2, 'updated_by' => 1),
        );
        foreach($datas as $data){
            $this->WikiManager->AG->create('wiki_histories', $data);
        }
    }
}
