<?php
/**
 * Wikiベースアクション
 *
 * すべてのWikiアクションはこれを継承してください。
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Web_Action_Wiki extends Web_Action
{
    public
        $wiki,
        $locale;
    public
        $Session,
        $Wickey,
        $WikiManager;


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
     * wikiをセットする
     *
     * @access     protected
     * @param      boolean  $is_required   必須かどうか
     */
    protected function _setWiki($is_required = true)
    {
        //指定のロケールをセット
        $this->locale = $this->Request->get('locale', $this->Session->get('locale'));
        $this->Session->set('locale', $this->locale);
        //wikiの取得
        $this->WikiManager->setLocale($this->locale);
        $this->wiki = $this->WikiManager->getByName($this->Request->get('name'));
        if($this->wiki){
            $this->wiki->name_encoded = urlencode($this->wiki->name);
            $this->wiki->is_newpage = false;
        } elseif(!$is_required){
            $this->wiki = new stdClass();
            $this->wiki->name = $this->Request->get('name');
            $this->wiki->name_encoded = urlencode($this->wiki->name);
            $this->wiki->locale = $this->locale;
            $this->wiki->is_newpage = true;
        } else {
            throw new Web_Exception('No such wiki.');
        }
    }
}
