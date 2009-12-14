<?
/**
 * WIKIマネージャー
 * 
 * wikiのデータ操作を担当。
 * wiki構文の解釈は行わないで、別途wickeyに任せる。
 * 
 * @package    SamuraiWEB
 * @subpackage wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Web_Wiki_Manager extends Web_Model
{
    /**
     * 言語設定
     *
     * @access   public
     * @var      string
     */
    public $locale = 'ja';

    /**
     * デフォルトの言語設定
     *
     * @access   public
     * @var      string
     */
    public $default_locale = 'ja';

    /**
     * 追加時・更新時に自動的に履歴を保存するかどうか
     *
     * @access   public
     * @var      boolean
     */
    public $auto_history_add = true;

    /**
     * 更新時にリビジョンを自動でupするかどうか
     *
     * @access   public
     * @var      boolean
     */
    public $auto_revision_up = true;

    /**
     * テーブル名
     *
     * @access   protected
     * @var      string
     */
    protected $_table = 'wiki';

    /**
     * テーブル名(履歴)
     *
     * @access   protected
     * @var      string
     */
    protected $_table_histories = 'wiki_histories';

    /**
     * テーブル名(コメント)
     *
     * @access   protected
     * @var      string
     */
    protected $_table_comments = 'wiki_comments';





    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * 取得
     *
     * @access     public
     * @param      id | object   $id
     * @return     object        ActiveGatewayRecord
     */
    public function get($id)
    {
        $condition = $this->_toAGCondition($id, $this->_table);
        return $this->AG->findDetail($this->_table, $condition);
    }

    /**
     * 名前から取得
     * また、その際ロケールが考慮される
     *
     * @access     public
     * @param      string   $name
     * @return     object   ActiveGatewayRecord
     */
    public function getByName($name)
    {
        $condition = $this->getCondition();
        $condition->where->name = $name;
        $condition->where->locale = $this->locale;
        $wiki = $this->AG->findDetail($this->_table, $condition);
        if(!$wiki){
            $condition->where->locale = $this->default_locale;
            $wiki = $this->AG->findDetail($this->_table, $condition);
        }
        return $wiki;
    }

    /**
     * 複数取得
     *
     * @access     public
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function gets($condition = NULL)
    {
        $this->_initAGCondition($condition);
        if(!$condition->order) $condition->order->id = 'ASC';
        return $this->AG->findAllDetail($this->_table, $condition);
    }


    /**
     * コメントの取得
     *
     * @access     public
     * @param      int            $wiki_id
     * @param      int | object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecord
     */
    public function getComment($wiki_id, $id)
    {
        $condition = $this->_toAGCondition($id, $this->_table_comments);
        $condition->where->wiki_id = $wiki_id;
        return $this->AG->findDetail($this->_table_comments, $condition);
    }

    /**
     * コメントの複数取得
     *
     * @access     public
     * @param      int      $wiki_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getComments($wiki_id, $condition = NULL)
    {
        $this->_initAGCondition($condition);
        if($wiki_id !== NULL) $condition->where->wiki_id = $wiki_id;
        return $this->AG->findAllDetail($this->_table_comments, $condition);
    }


    /**
     * 履歴の取得
     *
     * @access     public
     * @param      int            $wiki_id
     * @param      int | object   $id
     * @return     object   ActiveGatewayRecords
     */
    public function getHistory($wiki_id, $id)
    {
        $condition = $this->_toAGCondition($id, $this->_table_histories);
        $condition->where->wiki_id = $wiki_id;
        return $this->AG->findDetail($this->_table_histories, $condition);
    }

    /**
     * 履歴の複数取得
     *
     * @access     public
     * @param      int      $wiki_id
     * @param      object   $condition   ActiveGatewayCondition
     * @return     object   ActiveGatewayRecords
     */
    public function getHistories($wiki_id, $condition = NULL)
    {
        $this->_initAGCondition($condition);
        $condition->where->wiki_id = $wiki_id;
        if(!$condition->order) $condition->order->revision = 'DESC';
        return $this->AG->findAllDetail($this->_table_histories, $condition);
    }





    /**
     * 追加
     *
     * @access     public
     * @param      object   $dto
     * @param      object   $User   Web_User
     * @return     object   ActiveGatewayRecord
     */
    public function add($dto, Web_User $User = NULL)
    {
        if($User){
            $dto->created_by = $User->id;
        }
        $wiki = $this->AG->create($this->_table, $dto);

        //履歴の挿入
        if($this->auto_history_add){
            $this->_insertHistory($wiki->id);
        }

        return $wiki;
    }

    /**
     * コメントの追加
     *
     * @access     public
     * @param      int      $wiki_id
     * @param      object   $dto
     * @param      object   $User   Web_User
     * @return     object   ActiveGatewayRecord
     */
    public function addComment($wiki_id, $dto, Web_User $User = NULL)
    {
        $dto->wiki_id = $wiki_id;
        if($User !== NULL){
            $dto->user_id = $User->id;
        }
        return $this->AG->create($this->_table_comments, $dto);
    }

    /**
     * 履歴の追加
     *
     * @access     public
     * @param      int      $wiki_id
     * @param      object   $dto
     * @return     object   ActiveGatewayRecord
     */
    public function addHistory($wiki_id, $dto)
    {
        $dto->wiki_id = $wiki_id;
        return $this->AG->create($this->_table_histories, $dto);
    }


    /**
     * 保存
     *
     * @access     public
     * @param      object   $wiki
     * @param      array    $attributes
     */
    public function save($wiki, $attributes = array(), Web_User $User = NULL)
    {
        foreach($attributes as $_key => $_val) $wiki->$_key = $_val;
        if($User !== NULL) $wiki->updated_by = $User->id;
        $this->AG->save($wiki);

        //リビジョンアップ
        if($this->auto_revision_up){
            $this->_upRevision($wiki->id);
        }
        
        //履歴を格納
        if($this->auto_history_add){
            $this->_insertHistory($wiki->id);
        }
    }

    /**
     * コメントの保存
     *
     * @access     public
     * @param      object   $comment
     * @param      array    $attributes
     */
    public function saveComment($comment, $attributes = array())
    {
        foreach($attributes as $_key => $_val) $comment->$_key = $_val;
        $this->AG->save($comment);
    }

    /**
     * 履歴の保存
     *
     * @access     public
     * @param      $history
     */
    public function saveHistory($history, $attributes = array())
    {
        foreach($attributes as $_key => $_val) $history->$_key = $_val;
        $this->AG->save($history);
    }


    /**
     * 編集
     *
     * @access     public
     * @param      int | object   $id
     * @param      array    $attributes
     */
    public function edit($id, $attributes = array())
    {
        $condition = $this->_toAGCondition($id, $this->_table);
        return $this->AG->updateDetail($this->_table, $attributes, $condition);
    }

    /**
     * コメントの編集
     *
     * @access     public
     * @param      int            $wiki_id
     * @param      int | object   $id
     * @param      array          $attributes
     */
    public function editComment($wiki_id, $id, $attributes = array())
    {
        $condition = $this->_toAGCondition($id, $this->_table_comments);
        $condition->where->wiki_id = $wiki_id;
        $this->AG->updateDetail($this->_table_comments, $attributes, $condition);
    }

    /**
     * 履歴の編集
     *
     * @access     public
     * @param      int            $wiki_id
     * @param      int | object   $id
     * @param      array          $attributes
     */
    public function editHistory($wiki_id, $id, $attributes = array())
    {
        $condition = $this->_toAGCondition($id, $this->_table_histories);
        $condition->where->wiki_id = $wiki_id;
        $this->AG->updateDetail($this->_table_histories, $attributes, $condition);
    }


    /**
     * 破壊
     *
     * @access     public
     * @param      object   $wiki
     */
    public function destroy($wiki)
    {
        $this->AG->destroy($wiki);
    }

    /**
     * コメントの破壊
     *
     * @access     public
     * @param      object   $comment
     */
    public function destroyComment($comment)
    {
        $this->AG->destroy($comment);
    }

    /**
     * 履歴の破壊
     *
     * @access     public
     * @param      object   $history
     */
    public function destroyHistory($history)
    {
        $this->AG->destroy($history);
    }


    /**
     * 削除
     *
     * @access     public
     * @param      int | object   $id
     */
    public function delete($id)
    {
        $condition = $this->_toAGCondition($id, $this->_table);
        $this->AG->deleteDetail($this->_table, $condition);
    }

    /**
     * コメントの削除
     *
     * @access     public
     * @param      int            $wiki_id
     * @param      int | object   $id
     */
    public function deleteComment($wiki_id, $id)
    {
        $condition = $this->_toAGCondition($id, $this->_table_comments);
        $condition->where->wiki_id = $wiki_id;
        $this->AG->deleteDetail($this->_table_comments, $condition);
    }

    /**
     * 履歴の削除
     *
     * @access     public
     * @param      int            $wiki_id
     * @param      int | object   $id
     */
    public function deleteHistory($wiki_id, $id)
    {
        $condition = $this->_toAGCondition($id, $this->_table_histories);
        $condition->where->wiki_id = $wiki_id;
        $this->AG->deleteDetail($this->_table_histories, $condition);
    }





    /**
     * 履歴を挿入
     *
     * @access     private
     * @param      int       $wiki_id
     */
    public function _insertHistory($wiki_id)
    {
        $sql = "INSERT INTO `" . $this->_table_histories . "`
                    (`wiki_id`, `name`, `title`, `content`, `locale`, `localized_for`, `revision`, `created_by`, `created_at`, `updated_at`)
                SELECT `id` AS `wiki_id`, `name`, `title`, `content`, `locale`, `localized_for`, `revision`,
                    CASE
                        WHEN `updated_by` = 0 THEN `created_by`
                        ELSE `updated_by`
                    END AS `created_by`,
                    :created_at AS `created_at`, :updated_at AS `updated_at`
                FROM `" . $this->_table . "`
                WHERE `id` = :wiki_id";
        $params = array(':wiki_id' => $wiki_id, ':created_at' => time(), ':updated_at' => time());
        $this->AG->executeUpdate($sql, $params);
    }

    /**
     * リビジョンのアップ
     *
     * @access     private
     * @param      int       $wiki_id
     */
    private function _upRevision($wiki_id)
    {
        $sql = "UPDATE `" . $this->_table . "`
                SET `revision` = `revision` + 1
                WHERE `id` = :wiki_id";
        $params = array(':wiki_id' => $wiki_id);
        $this->AG->executeUpdate($sql, $params);
    }





    /**
     * ロケールの設定
     *
     * @access   public
     * @param    string   $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * デフォルトのロケールを設定
     *
     * @access   public
     * @param    string   $locale
     */
    public function setDefaultLocale($locale)
    {
        $this->default_locale = $locale;
    }
}
