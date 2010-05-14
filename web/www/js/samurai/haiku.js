/**
 * 俳句API通信用のjavascript
 *
 * @package    SamuraiWEB
 * @subpackage Www.Js
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
Samurai.Haiku = function(){}

Samurai.Haiku.prototype = {
    /**
     * header部分に俳句を埋め込む
     *
     * @access     public
     */
    append2Header : function()
    {
        jQuery.getJSON('/ajax/haiku', {}, function(data){
            if(data.haiku){
                jQuery('#haiku-phrase').empty().append(data.haiku.phrase);
                jQuery('#haiku-composed_by').empty().append('by ' + data.haiku.composed_by);
            }
        });
    }
}
