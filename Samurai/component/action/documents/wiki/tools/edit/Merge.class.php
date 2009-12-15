<?php
/**
 * ドキュメント / WIKI / 編集(マージ)
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Edit_Merge extends Web_Action_Wiki
{
    public
        $checksum = '',
        $diff_html = '',
        $merged_content = '',
        $is_conflict = false;
    public
        $Diff,
        $DiffRendererHtml,
        $DiffRendererText;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki();
        $this->checksum = md5($this->wiki->title . $this->wiki->content);

        $original = $this->Request->get('original');
        $revision = $this->wiki->content;
        $working  = $this->Request->get('content');
        $diff1 = $this->Diff->diff($original, $revision);
        $diff2 = $this->Diff->diff($original, $working);
        $diff3 = $this->Diff->merge($diff1, $diff2);
        $this->is_conflict = $this->Diff->isConflict($diff3);
        $this->diff_html = $this->DiffRendererHtml->render($diff3);
        $this->merged_content = $this->DiffRendererText->render($diff3);
        
        return 'success';
    }
}
