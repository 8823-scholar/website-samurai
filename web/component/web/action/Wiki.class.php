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
        $WikiManager,
        $UserManager;


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
        if($this instanceof Action_Documents_Wiki_Show){
            $name = preg_replace('|^/documents/.+?/|', '', MAIN_URI);
            if(urldecode($name) != $this->Request->get('name')){
                $name;
            } else {
                $name = $this->Request->get('name');
            }
        } else {
            $name = $this->Request->get('name');
        }
        $this->WikiManager->setLocale($this->locale);
        $this->wiki = $this->WikiManager->getByName($name);
        if($this->wiki){
            $this->wiki->name_encoded = urlencode($this->wiki->name);
            $this->wiki->is_newpage = false;
            $this->wiki->creator = $this->UserManager->get($this->wiki->created_by);
            $this->wiki->updater = $this->UserManager->get($this->wiki->updated_by);
        } elseif(!$is_required){
            $this->wiki = new stdClass();
            $this->wiki->name = $name;
            $this->wiki->name_encoded = urlencode($this->wiki->name);
            $this->wiki->locale = $this->locale;
            $this->wiki->is_newpage = true;
        } else {
            throw new Web_Exception('No such wiki.');
        }
    }



    /**
     * ヘルパーメソッド
     * 最近編集されたページを返却する
     *
     * @access     public
     * @param      array    $params
     * @param      object   $Smarty   Smarty
     * @return     array
     */
    public function getNearEdits(array $params, Smarty $Smarty)
    {
        $per = 5;
        extract($params);
        $cond = $this->WikiManager->getCondition();
        $cond->order->updated_at = 'DESC';
        $cond->setLimit($per);
        $wikis = $this->WikiManager->gets($cond);
        $return = array();
        foreach($wikis as $wiki){
            $wiki->name_encoded = urlencode($wiki->name);
            $date = date('Y-m-d', $wiki->updated_at);
            if(!isset($return[$date])){
                $return[$date] = array();
            }
            $return[$date][] = $wiki->toArray();
        }
        return $return;
    }
}
