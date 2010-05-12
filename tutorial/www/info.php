<?php
/**
 * Samurai::info()を出力するためのエントリーポイント
 *
 * @package    Package
 * @copyright  Foo Project
 * @author     Foo Bar <foo@bar.jp>
 */

require_once 'Samurai/Samurai.class.php';

//SamuraiFWの起動
define('SAMURAI_APPLICATION_NAME', 'tutorial');
if(!preg_match('/samurai-fw\.org$/', $_SERVER['HTTP_HOST'])){
    define('SAMURAI_ENVIRONMENT', 'local');
    Samurai::unshiftSamuraiDir('D:\satoshi_kiuchi\ProgramFiles\php\PEAR\Samurai.BEFOOL');
} else {
    Samurai::unshiftSamuraiDir('/usr/share/pear/Samurai.BEFOOL');
}
Samurai::unshiftSamuraiDir(dirname(dirname(__FILE__)));
Samurai::init();
Samurai_Config::set('action.default', 'samurai_info');
$Controller = Samurai::getContainer()->getComponent('Controller');
$Controller->execute();

