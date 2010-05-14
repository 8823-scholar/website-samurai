<?php
/**
 * haikuテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_Haiku extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `haiku` (
                `id` int(11) NOT NULL auto_increment,
                `phrase` text collate utf8_unicode_ci NOT NULL COMMENT '本文',
                `composed_by` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT '詠んだ人',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='俳句';
        ");
        $this->message = "do create table 'haiku'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `haiku`;
        ");
        $this->message = "do drop table 'haiku'.";
    }
}

