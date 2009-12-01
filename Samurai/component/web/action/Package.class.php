<?
/**
 * Web_Action_Package
 * 
 * パッケージメインアクション
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Web_Action_Package extends Web_Action
{
    public
        $package,
        $release,
        $file;
    public
        $PackageManager;


    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * パッケージをセットする
     * @access     protected
     */
    protected function _setPackage()
    {
        $this->package = $this->PackageManager->get($this->Request->get('package_alias', $this->Request->get('package_id')));
        if(!$this->package) throw new Web_Exception('No such package.');
    }

    /**
     * トピックをセットする
     * @access     protected
     */
    protected function _setTopic()
    {
        $this->topic = $this->ForumManager->getArticle($this->forum->id, $this->Request->get('topic_id'));
        if(!$this->topic) throw new Web_Exception('No such topic.');
    }

    /**
     * 記事をセットする
     * @access     protected
     */
    protected function _setArticle()
    {
        $this->article = $this->ForumManager->getArticle($this->forum->id, $this->Request->get('article_id'));
        if(!$this->article) throw new Web_Exception('No such article.');
    }
}
