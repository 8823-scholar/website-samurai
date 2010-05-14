<?php
/**
 * package_maintenersテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_PackageMainteners extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `package_mainteners` (
                `id` int(11) NOT NULL auto_increment,
                `package_id` int(11) NOT NULL default '0' COMMENT '=package.id',
                `name` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT '名前',
                `mail` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT 'メール',
                `role` enum('lead','developer','contributor','helper','other') collate utf8_unicode_ci NOT NULL default 'other' COMMENT '役割',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージ：メンテナー';
        ");
        $this->message = "do create table 'package_mainteners'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `package_mainteners`;
        ");
        $this->message = "do drop table 'package_mainteners'.";
    }
}

