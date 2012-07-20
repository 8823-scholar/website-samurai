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
if(!getenv('SAMURAI_ENVIRONMENT')){
    switch($_SERVER['HTTP_HOST']){
    case 'samurai-fw.org':
        break;
    default:
        define('SAMURAI_ENVIRONMENT', 'local');
        break;
    }
}
Samurai::unshiftSamuraiDir(dirname(dirname(__FILE__)));
Samurai::init();
$Controller = Samurai::getContainer()->getComponent('Controller');
$Controller->execute();

