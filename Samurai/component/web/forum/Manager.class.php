<?
/**
 * Web_Forum_Manager
 * 
 * コンポーネント - フォーラム
 * 
 * @package    SamuraiWEB
 * @subpackage Forum
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Web_Forum_Manager extends Samurai_Model
{
    protected
        $_table = 'forum',
        $_table_articles = 'forum_articles';


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
        if(!$condition->order) $condition->order->updated_at = 'DESC';
        return $this->AG->findAllDetail($this->_table, $condition);
    }

    /**
     * 記事の取得
     * @access     public
     * @param      int      $forum_id
     * @param      mixed    $id
     * @return     object   ActiveGatewayRecord
     */
    public function getArticle($forum_id, $id)
    {
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            $condition = $id;
        } else {
            $this->_initAGCondition($condition);
            $condition->where->id = $id;
        }
        $condition->where->forum_id = $forum_id;
        return $this->AG->findDetail($this->_table_articles, $condition);
    }

    /**
     * 記事の複数取得
     * @access     public
     * @param      int      $forum_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getArticles($forum_id, $condition=NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->forum_id = $forum_id;
        if(!$condition->order) $condition->order->updated_at = 'DESC';
        return $this->AG->findAllDetail($this->_table_articles, $condition);
    }

    /**
     * 記事の再帰的取得
     * @access     public
     * @param      int      $forum_id
     * @param      int      $article_id
     * @return     object   ActiveGatewayRecord
     */
    public function getArticlesReflexive($forum_id, $article_id)
    {
        $article = $this->getArticle($forum_id, $article_id);
        if($article){
            $this->appendChildren($article);
        }
        return $article;
    }

    /**
     * 子記事をアペンドする
     * @access     public
     * @param      object   ActiveGatewayRecord
     * @return     void
     */
    public function appendChildren(ActiveGatewayRecord $article)
    {
        //子記事の取得
        $condition = $this->_initAGCondition($condition);
        $condition->where->parent_id = $article->id;
        $condition->order->created_at = 'ASC';
        $article->children = $this->getArticles($article->forum_id, $condition);
        foreach($article->children as $child){
            $this->appendChildren($child);
        }
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
}
