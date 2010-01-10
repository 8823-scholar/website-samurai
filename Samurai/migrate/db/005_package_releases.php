<?php
/**
 * package_releasesテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_PackageReleases extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `package_releases` (
                `id` int(11) NOT NULL auto_increment,
                `package_id` int(11) NOT NULL default '0' COMMENT '=package.id',
                `version` varchar(16) collate utf8_unicode_ci NOT NULL default '0.0.0' COMMENT 'バージョン',
                `stability` enum('stable','beta','alpha') collate utf8_unicode_ci NOT NULL default 'alpha' COMMENT '状態',
                `datetime` datetime NOT NULL default '0000-00-00 00:00:00' COMMENT 'リリース日',
                `downloaded_count` int(11) NOT NULL default '0' COMMENT 'ダウンロード数',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージのリリース';
        ");
        $this->message = "do create table 'package_releases'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `package_releases`;
        ");
        $this->message = "do drop table 'package_releases'.";
    }
}

