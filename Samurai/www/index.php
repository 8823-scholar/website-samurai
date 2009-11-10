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
define('SAMURAI_APPLICATION_NAME', 'samurai-web');
//define('SAMURAI_MODE', 'dev');
include_once('D:\satoshi_kiuchi\ProgramFiles\php\PEAR\Samurai\Samurai.class.php');
Samurai::unshiftSamuraiDir('D:\satoshi_kiuchi\BEFOOL\Samurai\samurai.web\trunk\Samurai');
Samurai::init();
//Samurai_Controllerの起動
$Controller = Samurai::getContainer()->getComponent('Controller');
$Controller->execute();
