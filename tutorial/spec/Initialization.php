<?php
/**
 * SPEC用の初期化ファイル
 *
 * すべてのSPECで必要な前提処理をここに記述してください。
 * beforeSuperAllみたいなものです。
 * 
 * @package    Package
 * @subpackage Action
 * @copyright  Foo Project
 * @author     Foo Bar <foo@bar.jp>
 */

//AG設定
Samurai_Loader::load('library/ActiveGateway/ActiveGatewayManager.class.php');
$AGManager = ActiveGatewayManager::singleton();
$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.yml'));
$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.production.yml'));
//$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.development.yml'));
//$AGManager->import(Samurai_Loader::getPath('config/activegateway/activegateway.sandbox.yml'));
$AG = $AGManager->getActiveGateway('sandbox');

