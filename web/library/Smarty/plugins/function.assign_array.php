<?php
/**
 * Smarty/plugins/function.assign_array.php
 * 
 * Smartyテンプレート上から、配列にアサインできるプラグイン。
 * varの値を「.(ドット)」区切りで記述することにより、意図した配列へのアサインを実現する。
 * <code>
 *      {assign_array var='example.data1' value=1}
 *      {assign_array var='example.data2.' value='no key'}
 *      {assign_array var='example.data3.foo.bar' value='zoo'}
 * </code>
 * 
 * @package     B3M
 * @subpackage  Library.Smarty.Plugin.Function
 * @copyright   Befool,Inc.
 * @license     別紙契約書参照
 * @author      Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 * @version     $Id: e52cfb945f5f3174ba8c039d99ba978bfdc9fd13 $
 */
function smarty_function_assign_array($params, $Smarty)
{
    //初期化
    $var   = isset($params['var']) ? (string)$params['var'] : '' ;
    $value = isset($params['value']) ? $params['value'] : NULL ;
    $var   = preg_replace('/\.+/', '.', $var);
    $names = explode('.', $var);
    if(count($names) < 1) return;
    
    //最初の値が基本的な変数名になる
    $base_name  = array_shift($names);
    $smarty_var = isset($Smarty->_tpl_vars[$base_name]) ? $Smarty->_tpl_vars[$base_name] : array() ;
    
    //その他の値は、すべてその配列のキーとなる
    $key_string = '';
    foreach($names as $name){
        $key_string .= (is_numeric($name) || !$name) ? "[$name]" : "['$name']" ;
    }
    
    //配列の生成
    $script = "\$smarty_var$key_string = \$value;";
    eval($script);
    
    //アサイン
    $Smarty->assign($base_name, $smarty_var);
}

