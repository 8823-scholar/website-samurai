<?php
/**
 * 俳句を取得するAPI
 *
 * idを指定された場合はその俳句を、指定されない場合はランダムに一つ返却する
 * 
 * @package    SamuraiWEB
 * @subpackage Action.Ajax.Haiku
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
class Action_Ajax_Haiku extends Web_Action_Ajax
{
    public
        $HaikuManager;


    /**
     * 実行トリガー
     *
     * @access     public
     */
    public function execute()
    {
        parent::execute();

        if($id = $this->Request->get('id')){
            $haiku = $this->HaikuManager->get($id);
        } else {
            $haiku = $this->HaikuManager->getByRandom();
        }

        $dto = new stdClass();
        $dto->error = false;
        $dto->haiku = $haiku;
        $dto->message = '';
        if(!$haiku){
            $dto->error = true;
            $dto->message = 'haiku is not found.';
        }

        return $dto;
    }
}
