<?php
/**
 * userテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_User extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `user` (
                `id` int(11) NOT NULL auto_increment,
                `name` varchar(32) collate utf8_unicode_ci NOT NULL COMMENT '名前',
                `mail` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT 'メール',
                `pass` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT 'パスワード',
                `real_name` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT '本名',
                `introduction` text collate utf8_unicode_ci NOT NULL COMMENT '自己紹介',
                `role` enum('admin','developer','supporter','normal') collate utf8_unicode_ci NOT NULL default 'normal' COMMENT '役割',
                `locale` varchar(3) collate utf8_unicode_ci NOT NULL default 'ja' COMMENT 'デフォルトロケール',
                `logined_at` int(11) NOT NULL default '0' COMMENT 'ログイン時間',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `name` (`name`),
                KEY `mail` (`mail`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ユーザー';
        ");
        $this->message = "do create table 'user'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `user`;
        ");
        $this->message = "do drop table 'user'.";
    }
}

