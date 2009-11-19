<?
/**
 * www/index.php
 * 
 * SamuraiFWへの入り口。
 * 
 * @package    Package
 * @subpackage Www
 * @copyright  Foo Project
 * @author     Foo Bar <foo@bar.jp>
 */
//SamuraiFWの起動
define('SAMURAI_APPLICATION_NAME', 'web');
if(!preg_match($_SERVER['HTTP_HOST'], '/samurai-fw\.org$/')){
    define('SAMURAI_ENVIRONMENT', 'local');
}
include_once('Samurai/Samurai.class.php');
Samurai::unshiftSamuraiDir(dirname(dirname(__FILE__)));
Samurai::init();
//Samurai_Controllerの起動
$Controller = Samurai::getContainer()->getComponent('Controller');
$Controller->execute();
