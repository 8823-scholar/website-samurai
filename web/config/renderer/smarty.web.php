<?
/**
 * config/renderer/smarty.web.php
 * 
 * Smarty用の初期化スクリプト。
 * Samurai_Renderer::initメソッドの中でインクルードされるので、
 * $this->Engine
 * でSmartyを参照できる。
 * 
 * @package    Package
 * @subpackage Config.Renderer
 * @copyright  Foo Project
 * @author     Foo Bar <foo@bar.jp>
 */
//その他のプロパティ
//$this->Engine->error_reporting = NULL;
//$this->Engine->compile_check = true;
//$this->Engine->force_compile = false;
//$this->Engine->caching = 0;
//$this->Engine->cache_lifetime = 3600;
//$this->Engine->cache_modified_check = false;
//$this->Engine->left_delimiter = '{';
//$this->Engine->right_delimiter = '}';

//Helper
//$this->addHelper('Foo', array('class'=>'Helper_Smarty_Foo'));
$Helper = $this->addHelper('Html', array('class' => 'Etc_Helper_Smarty_Html'));
$Helper = $this->addHelper('Wickey', array('class' => 'Etc_Wickey_Helper_Smarty'));
