<?php
/**
 * packageテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_Package extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `package` (
                `id` int(11) NOT NULL auto_increment,
                `alias` varchar(32) collate utf8_unicode_ci NOT NULL COMMENT 'IDに依存しない一意な名前',
                `name` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT '名前',
                `description` text collate utf8_unicode_ci NOT NULL COMMENT '説明文',
                `natural_locale` varchar(3) collate utf8_unicode_ci NOT NULL default 'ja' COMMENT 'メインの言語',
                `required_os` varchar(16) collate utf8_unicode_ci NOT NULL default 'independent' COMMENT '依存OS',
                `downloaded_count` int(11) NOT NULL default '0' COMMENT 'ダウンロード数',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `alias` (`alias`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージ';
        ");
        $this->message = "do create table 'package'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `package`;
        ");
        $this->message = "do drop table 'package'.";
    }
}

