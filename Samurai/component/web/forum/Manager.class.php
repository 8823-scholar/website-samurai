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
            $condition->where->forum_id = $forum_id;
        }
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
     * フォーラムの作成
     * @access     public
     * @param      mixed    $dto
     * @return     object   ActiveGatewayRecord
     */
    public function add($dto)
    {
        $dto = (object)$dto;
        return $this->AG->cretae($this->_table, $dto);
    }

    /**
     * 記事の追加
     * @access     public
     * @param      int      $forum_id
     * @param      mixed    $dto
     * @param      object   $User
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
        return $this->AG->create($this->_table_articles, $dto);
    }
}
