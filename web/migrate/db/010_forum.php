<?php
/**
 * forumテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_Forum extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `forum` (
                `id` int(11) NOT NULL auto_increment,
                `title` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT 'タイトル',
                `description` text collate utf8_unicode_ci NOT NULL COMMENT '説明文',
                `topic_count` int(11) NOT NULL default '0' COMMENT 'トピック（ルート記事）数',
                `article_count` int(11) NOT NULL default '0' COMMENT '投稿記事数',
                `last_posted_at` int(11) default NULL COMMENT '最終投稿時間',
                `last_posted_id` int(11) default NULL COMMENT '=forum_articles.id',
                `sort` int(2) NOT NULL default '99' COMMENT '並び順',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='フォーラム';
        ");
        $this->message = "do create table 'forum'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `forum`;
        ");
        $this->message = "do drop table 'forum'.";
    }
}

