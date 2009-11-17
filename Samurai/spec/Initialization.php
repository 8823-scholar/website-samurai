<?
/**
 * Initialization.php
 *
 * SPEC初期化ファイル
 *
 * @package    Samuraiweb
 * @subpackage Spec
 * @copyright  Samurai Framework Project
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
//AG設定
Samurai_Loader::load('library/ActiveGateway/ActiveGatewayManager.class.php');
$AGManager = ActiveGatewayManager::singleton();
$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.samuraiweb.yml'));
$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.development.yml'));
$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.local.yml'));
