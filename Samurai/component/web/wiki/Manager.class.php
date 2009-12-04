<?
/**
 * Web_Wiki_Manager
 * 
 * WikiManagerのSPEC
 * 
 * @package    SamuraiWEB
 * @subpackage component.web
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Web_Wiki_Manager extends Samurai_Model
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
    protected $_table_comment = 'wiki_comments';





    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
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
        if(is_object($id) && $id instanceof ActiveGatewayCondition){
            return $this->AG->findDetail($this->_table, $id);
        } else {
            return $this->AG->find($this->_table, $id);
        }
    }

    /**
     * 複数取得
     *
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
