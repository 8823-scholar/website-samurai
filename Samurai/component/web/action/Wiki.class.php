<?php
/**
 * Wikiベースアクション
 *
 * すべてのWikiアクションはこれを継承してください。
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Web_Action_Wiki extends Web_Action
{
    public
        $wiki,
        $locale;
    public
        $Session,
        $WikiManager;


    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * wikiをセットする
     * @access     protected
     */
    protected function _setWiki()
    {
        //指定のロケールをセット
        $this->locale = $this->Request->get('locale');
        $this->Session->set('locale', $this->locale);
        //wikiの取得
        $this->WikiManager->setLocale($this->locale);
        $this->wiki = $this->WikiManager->getByName($this->Request->get('name'));
        if(!$this->wiki) throw new Web_Exception('No such wiki.');
    }
}
