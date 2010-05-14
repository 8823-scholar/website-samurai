/**
 * SamuraiWEB用のjavascript
 *
 * @package    SamuraiWEB
 * @subpackage Www.Js
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 */
Samurai = {};


//jQueryのprototype.js意識
jQuery.noConflict();


/**
 * namespace作成
 *
 * @access     public
 * @param      string   name
 */
Samurai.namespace = function()
{
    var a = arguments, o = null, j, d;
    for (i=0; i<a.length; i++) {
        d = a[i].split('.');
        o = Samurai;
        for (j=(d[0] == 'Samurai') ? 1 : 0; j<d.length; j++) {
            o[d[j]] = o[d[j]] || {};
            o = o[d[j]];
        }
    }
    return o;
}
