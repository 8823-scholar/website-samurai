<?php
/**
 * ドキュメント / WIKI
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Show extends Web_Action_Wiki
{
    public
        $breads = array(),
        $comments = array();
    public
        $Wickey;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki(false);
        $this->Wickey->addTag('h3', array('inputable' => false));
        $this->Wickey->addTag('attach');

        if(!$this->wiki->is_newpage && $this->wiki->alias){
            return array('alias', 'locale' => $this->locale, 'path' => urlencode($this->wiki->alias));
        }

        if(!$this->wiki->is_newpage){
            $condition = $this->WikiManager->getCondition();
            $comments = $this->WikiManager->getCommentsWithUserInfo($this->wiki->id, $condition);
            $this->comments = $comments->toArray();
        }

        $this->_setBreads();

        return $this->wiki->is_newpage ? 'newpage' : 'success';
    }


    /**
     * パンくずリストを生成
     *
     * @access     private
     */
    private function _setBreads()
    {
        $names = explode('/', $this->wiki->name);
        while(array_pop($names)){
            $name = join('/', $names);
            $wiki = $this->WikiManager->getByName($name);
            if($wiki){
                $this->breads[] = array('title' => $wiki->title, 'path' => urlencode($name));
            }
        }
        $this->breads = array_reverse($this->breads);
    }
}

