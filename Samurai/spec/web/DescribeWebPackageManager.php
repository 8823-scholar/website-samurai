<?
/**
 * DescribeWebPackageManager
 *
 * @package    SamuraiWEB
 * @subpackage Spec
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class DescribeWebPackageManager extends PHPSpec_Context
{
    private
        $PackageManager;


    // list methods
    public function itListMethods()
    {
        /**
         * $PackageManager->get($id | $condition);
         * $PackageManager->gets($condition);
         * $PackageManager->getRelease($package_id, $id | $condition);
         * $PackageManager->getReleases($package_id, $condition);
         * $PackageManager->getReleases(NULL, $condition); //package_idを考慮しない場合
         * $PackageManager->getReleaseFile($package_id, $release_id, $id | $condition);
         * $PackageManager->getReleaseFiles($package_id, $release_id, $condition);
         * $PackageManager->add($dto);
         * $PackageManager->addRelease($package_id, $dto, $maintener);
         * $PackageManager->addReleaseFile($package_id, $release_id, $dto, $maintener);
         * $PackageManager->save($package);
         * $PackageManager->saveRelease($release);
         * $PackageManager->saveReleaseFile($file);
         * $PackageManager->edit($id, $attributes);
         * $PackageManager->editRelease($package_id, $release_id, $attributes);
         * $PackageManager->editReleaseFile($package_id, $release_id, $file_id, $attributes);
         * $PackageManager->destroy($package);
         * $PackageManager->destroyRelease($release);
         * $PackageManager->destroyReleaseFile($file);
         * $PackageManager->delete($id);
         * $PackageManager->deleteRelease($package_id, $release_id);
         * $PackageManager->deleteReleaseFile($package_id, $release_id, $file_id);
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
        $this->PackageManager = new Web_Package_Manager();
        $this->PackageManager->AG = ActiveGatewayManager::getActiveGateway('sandbox');
        //DB作成
        $this->PackageManager->AG->executeQuery("
        ");
        $this->PackageManager->AG->executeQuery("
        ");
        //データ挿入
        $datas = array(
        );
        foreach($datas as $data){
            $this->PackageManager->AG->create('forum', $data);
        }
        $datas = array(
        );
        foreach($datas as $data){
            $this->PackageManager->AG->create('forum_articles', $data);
        }
    }
}
