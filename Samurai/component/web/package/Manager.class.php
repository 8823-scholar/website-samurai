<?
/**
 * Web_Package_Manager
 * 
 * コンポーネント - パッケージ
 * 
 * @package    SamuraiWEB
 * @subpackage Package
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Web_Package_Manager extends Samurai_Model
{
    protected
        $_table = 'package',
        $_table_releases = 'package_releases',
        $_table_releases_files = 'package_releases_files',
        $_table_mainteners = 'package_mainteners';


    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * 取得
     * @access     public
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function get($id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            return $this->AG->findDetail($this->_table, $id);
        } else {
            return $this->AG->find($this->_table, $id);
        }
    }

    /**
     * 複数取得
     * @access     public
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function gets($condition=NULL)
    {
        $this->_initAGCondition($condition);
        if(!$condition->order) $condition->order->id = 'ASC';
        return $this->AG->findAllDetail($this->_table, $condition);
    }

    /**
     * リリースの取得
     * @access     public
     * @param      int      $package_id
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function getRelease($package_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        return $this->AG->findDetail($this->_table_releases, $condition);
    }

    /**
     * リリースの複数取得
     * @access     public
     * @param      int      $package_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getReleases($package_id, $condition=NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->package_id = $package_id;
        if(!$condition->order) $condition->order->datetime = 'DESC';
        return $this->AG->findAllDetail($this->_table_releases, $condition);
    }

    /**
     * リリースファイルの取得
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function getReleaseFile($package_id, $release_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->package_id = $package_id;
        $condition->where->release_id = $release_id;
        return $this->AG->findDetail($this->_table_releases_files, $condition);
    }

    /**
     * リリースファイルの複数取得
     * @access     public
     * @param      int      $package_id
     * @param      int      $release_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getReleaseFiles($package_id, $release_id, $condition=NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->package_id = $package_id;
        $condition->where->release_id = $release_id;
        if(!$condition->order) $condition->order->sort = 'ASC';
        return $this->AG->findAllDetail($this->_table_releases_files, $condition);
    }





    /**
     * 作成
     * @access     public
     * @param      mixed    $dto
     * @return     object   ActiveGatewayRecord
     */
    public function add($dto)
    {
        $dto = (object)$dto;
        return $this->AG->create($this->_table, $dto);
    }

    /**
     * 記事の追加
     * @access     public
     * @param      int      $forum_id
     * @param      mixed    $dto
     * @param      object   $User       Web_User
     * @return     object   ActiveGatewayRecord
     */
    public function addArticle($forum_id, $dto, Web_User $User=NULL)
    {
        $dto = (object)$dto;
        $dto->forum_id = $forum_id;
        if($User){
            $dto->user_id = $User->id;
            $dto->user_role = $User->role;
        }
        $article = $this->AG->create($this->_table_articles, $dto);
        //フォーラムの更新
        $sql = 'UPDATE `' . $this->_table . '`
                SET `last_posted_id` = :posted_id, `last_posted_at` = :posted_at,
                    `topic_count` = `topic_count` + :topic_up, `article_count` = `article_count` + :article_up
                WHERE `id` = :forum_id';
        $topic_up = isset($article->root_id) && $article->root_id ? 0 : 1 ;
        $article_up = isset($article->root_id) && $article->root_id ? 1 : 0 ;
        $params = array(':posted_id' => $article->id, ':posted_at' => $article->created_at, ':topic_up' => $topic_up, ':article_up' => $article_up, ':forum_id' => $forum_id);
        $this->AG->executeUpdate($sql, $params);
        return $article;
    }

    /**
     * 保存
     * @access     public
     * @param      object   $forum        ActiveGatewayRecord
     * @param      mixed    $attributes   上書き値
     */
    public function save($forum, $attributes=array())
    {
        foreach($attributes as $_key => $_val) $forum->$_key = $_val;
        $this->AG->save($forum);
    }

    /**
     * 記事の保存
     * @access     public
     * @param      object   $article      ActiveGatewayRecord
     * @param      mixed    $attributes   上書き値
     */
    public function saveArticle($article, $attributes=array())
    {
        foreach($attributes as $_key => $_val) $article->$_key = $_val;
        $this->AG->save($article);
    }

    /**
     * 編集
     * @access     public
     * @param      mixed    $id
     * @param      mixed    $attributes
     */
    public function edit($id, $attributes=array())
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $this->AG->updateDetail($this->_table, $attributes, $id);
        } else {
            $this->AG->update($this->_table, $id, $attributes);
        }
    }

    /**
     * 記事の編集
     * @access     public
     * @param      int      $forum_id
     * @param      mixed    $id
     * @param      mixed    $attributes
     */
    public function editArticle($forum_id, $id, $attributes=array())
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->forum_id = $forum_id;
        $this->AG->updateDetail($this->_table_articles, $attributes, $condition);
    }


    /**
     * 破壊
     * @access     public
     * @param      object   $forum
     */
    public function destroy($forum)
    {
        $condition = $this->getCondition();
        $condition->where->forum_id = $forum->id;
        $this->AG->deleteAllDetail($this->_table_articles, $condition);
        $this->AG->destroy($forum);
    }

    /**
     * 記事の破壊
     * @access     public
     * @param      object   $article
     */
    public function destroyArticle($article)
    {
        $this->AG->destroy($article);
    }

    /**
     * 削除
     * @access     public
     * @param      mixed    $id
     */
    public function delete($id)
    {
        //記事の削除が絡むのでdestroyで統一
        $forum = $this->get($id);
        $this->destroy($forum);
    }

    /**
     * 記事の削除
     * @access     public
     * @param      int      $forum_id
     * @param      mixed    $id
     */
    public function deleteArticle($forum_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->forum_id = $forum_id;
        $this->AG->deleteDetail($this->_table_articles, $condition);
    }



    /**
     * 返信
     * @access    public
     * @param     object   $parent   ActiveGatewayRecord
     * @param     object   $dto
     * @return    object   ActiveGatewayRecord
     */
    public function reply(ActiveGatewayRecord $parent, $dto)
    {
        $dto->root_id = $parent->root_id ? $parent->root_id : $parent->id ;
        $dto->parent_id = $parent->id;
        $article = $this->addArticle($parent->forum_id, $dto);
        //トピックの更新
        $topic = $parent->root_id ? $this->getArticle($parent->forum_id, $parent->root_id) : $parent ;
        $sql = 'UPDATE `' . $this->_table_articles . '`
                SET `reply_count` = `reply_count` + 1, `last_replied_id` = :replied_id, `last_replied_at` = :replied_at, `updated_at` = :updated_at
                WHERE `id` = :id';
        $params = array(':replied_id' => $article->id, ':replied_at' => $article->created_at, ':updated_at' => time(), ':id' => $topic->id);
        $this->AG->executeUpdate($sql, $params);
        return $article;
    }





    /**
     * メール通知してほしい人を取得
     * @access     public
     * @param      int      $forum_id
     * @param      int      $topic_id
     * @return     object   ActiveGatewayRecords
     */
    public function getUsersWannaInform($forum_id, $topic_id)
    {
        $sql = "SELECT f.id, f.forum_id, f.root_id, f.parent_id, f.user_id,
                    COALESCE(u.name, f.name) AS name, COALESCE(u.mail, f.mail) AS mail
                FROM forum_articles AS f LEFT JOIN user AS u ON u.id = f.user_id
                WHERE (f.id = :topic_id OR f.root_id = :topic_id) AND f.forum_id = :forum_id AND f.mail_inform = '1'
                GROUP BY `mail`
                HAVING mail != ''";
        $params = array(':forum_id' => $forum_id, ':topic_id' => $topic_id);
        return $this->AG->findAllSql($this->_table_articles, $sql, $params);
    }
}
