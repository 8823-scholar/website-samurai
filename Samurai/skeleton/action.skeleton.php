<?="<?\n"?>
/**
 * <?=$class_name."\n"?>
 * 
 * [[機能説明]]
 * 
 * @package    <?=$package != '' ? $package."\n" : "[[パッケージ名]]\n"?>
 * @subpackage Action.
<?include('_doc_comment.skeleton.php');?>
 */
class <?=$class_name?> extends Samuraiweb_Action
{
    /**
     * 実行トリガー。
     * @access     public
     */
    public function execute()
    {
        parent::execute();
        return 'success';
    }
}
