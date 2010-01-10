<?php
/**
 * package_releases_filesテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_PackageReleasesFiles extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `package_releases_files` (
                `id` int(11) NOT NULL auto_increment,
                `package_id` int(11) NOT NULL default '0' COMMENT '=package.id',
                `release_id` int(11) NOT NULL default '0' COMMENT '=package_releases.id',
                `filename` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT 'ファイル名',
                `size` int(11) NOT NULL default '0' COMMENT 'ファイルサイズ',
                `downloaded_count` int(11) NOT NULL default '0' COMMENT 'ダウンロード数',
                `sort` int(2) NOT NULL default '99' COMMENT '並び順',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='パッケージ：リリース：ファイル';
        ");
        $this->message = "do create table 'package_releases_files'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `package_releases_files`;
        ");
        $this->message = "do drop table 'package_releases_files'.";
    }
}

