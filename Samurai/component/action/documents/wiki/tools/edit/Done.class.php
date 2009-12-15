<?php
/**
 * ドキュメント / WIKI / 編集(完了)
 * 
 * @package    SamuraiWEB
 * @subpackage Action
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Action_Documents_Wiki_Tools_Edit_Done extends Web_Action_Wiki
{
    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        $this->_setWiki(false);

        //チェックサム
        if(!$this->_checkSum()) return 'merge';

        $dto = $this->Request->get('dto');
        $dto->content = $this->Wickey->supplement($dto->content);

        if($this->wiki->is_newpage){
            $dto->name = $this->Request->get('name');
            $dto->locale = $this->Request->get('locale');
            $this->WikiManager->add($dto, $this->User);
        } else {
            $this->WikiManager->save($this->wiki, $dto, $this->User);
        }

        return 'success';
    }


    /**
     * checksumで同時編集をチェックする
     *
     * @access     private
     * @return     boolean
     */
    private function _checkSum()
    {
        $checksum = $this->Request->get('checksum');
        return $this->wiki->is_newpage || $checksum == md5($this->wiki->title . $this->wiki->content);
    }
}
