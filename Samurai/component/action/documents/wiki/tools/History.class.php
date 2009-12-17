<?php
/**
 * ドキュメント / WIKI / 変更履歴
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Documents.Wiki
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_History extends Web_Action_Wiki
{
    public
        $wiki1,
        $wiki2,
        $histories = array(),
        $diff_html = '';
    public
        $Diff,
        $DiffRendererHtml;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();
        $this->Wickey->addTag('h3', array('inputable' => false));

        $condition = $this->WikiManager->getCondition();
        $histories = $this->WikiManager->getHistories($this->wiki->id, $condition);
        $this->histories = $histories->toArray();

        $do = $this->Request->get('do', 'none');
        $return = 'success';
        switch($do){
            case 'view':
                $return = $this->_doView();
                break;

            case 'source':
                $return = $this->_doSource();
                break;

            case 'diff':
                $return = $this->_doDiff();
                break;

            case 'diffnow':
                $return = $this->_doDiffnow();
                break;
        }

        return $return;
    }


    /**
     * 過去のwikiの表示
     *
     * @access     private
     * @return     string
     */
    private function _doView()
    {
        $condition = $this->WikiManager->getCondition();
        $condition->where->revision = $this->Request->get('rev');
        $this->wiki1 = $this->WikiManager->getHistory($this->wiki->id, $condition);
        return $this->wiki1 ? 'view' : 'success' ;
    }

    /**
     * ソースを表示
     *
     * @access     private
     * @return     string
     */
    private function _doSource()
    {
        $return = $this->_doView();
        return $this->wiki1 ? 'source' : $return ;
    }

    /**
     * 直前のリビジョンと比較する
     *
     * @access     private
     * @return     string
     */
    private function _doDiff()
    {
        $this->_doView();
        if(!$this->wiki1) return 'success';
        $condition = $this->WikiManager->getCondition();
        $condition->where->revision = $condition->isLessThan($this->wiki1->revision, false);
        $condition->order->revision = 'DESC';
        $this->wiki2 = $this->WikiManager->getHistory($this->wiki->id, $condition);
        if($this->wiki1 && $this->wiki2){
            $string1 = $this->wiki1->content;
            $string2 = $this->wiki2->content;
        } else {
            $string1 = $this->wiki1->content;
            $string2 = NULL;
        }
        $diff = $this->Diff->diff($string2, $string1);
        $this->diff_html = $this->DiffRendererHtml->render($diff);
        return 'diff';
    }

    /**
     * 現在のリビジョンと比較する
     *
     * @access     private
     * @return     string
     */
    private function _doDiffnow()
    {
        $this->_doView();
        if(!$this->wiki1) return 'success';
        $this->wiki2 = $this->wiki;
        if($this->wiki1 && $this->wiki2){
            $string1 = $this->wiki1->content;
            $string2 = $this->wiki2->content;
        } else {
            $string1 = $this->wiki1->content;
            $string2 = NULL;
        }
        $diff = $this->Diff->diff($string1, $string2);
        $this->diff_html = $this->DiffRendererHtml->render($diff);
        return 'diffnow';
    }
}
