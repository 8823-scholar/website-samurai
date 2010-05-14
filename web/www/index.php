<?php
/**
 * エントリーポイント
 * 
 * @package    Samurai
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @license    http://www.opensource.org/licenses/bsd-license.php The BSD License
 */

require_once 'Samurai/Samurai.class.php';

//SamuraiFWの起動
define('SAMURAI_APPLICATION_NAME', 'web');
if(!preg_match('/samurai-fw\.org$/', $_SERVER['HTTP_HOST'])){
    define('SAMURAI_ENVIRONMENT', 'local');
    Samurai::unshiftSamuraiDir('D:\satoshi_kiuchi\ProgramFiles\php\PEAR\Samurai.BEFOOL');
} else {
    Samurai::unshiftSamuraiDir('/usr/share/pear/Samurai.BEFOOL');
}
Samurai::unshiftSamuraiDir(dirname(dirname(__FILE__)));
Samurai::init();
$Controller = Samurai::getContainer()->getComponent('Controller');
$Controller->execute();

