<?php
/**
 * wiki_historiesテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_WikiHistories extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `wiki_histories` (
                `id` int(11) NOT NULL auto_increment,
                `wiki_id` int(11) NOT NULL default '0' COMMENT '=wiki.id',
                `name` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'ページ名',
                `title` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT 'ページタイトル',
                `content` text collate utf8_unicode_ci NOT NULL COMMENT '内容',
                `locale` varchar(3) collate utf8_unicode_ci NOT NULL default 'ja' COMMENT '言語',
                `localized_for` int(11) default NULL COMMENT 'あるWIKI翻訳の場合(=wiki.id)',
                `revision` int(11) NOT NULL default '1' COMMENT 'リビジョン番号',
                `created_by` int(11) NOT NULL default '0' COMMENT '=user.id',
                `updated_by` int(11) NOT NULL default '0' COMMENT '=user.id',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `name` (`name`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKI';
        ");
        $this->message = "do create table 'wiki_histories'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `wiki_histories`;
        ");
        $this->message = "do drop table 'wiki_histories'.";
    }
}

