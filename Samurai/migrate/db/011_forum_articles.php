<?php
/**
 * forum_articlesテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_ForumArticles extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `forum_articles` (
                `id` int(11) NOT NULL auto_increment,
                `forum_id` int(11) NOT NULL default '0' COMMENT '=forum.id',
                `root_id` int(11) default NULL COMMENT '=forum_articles.id',
                `parent_id` int(11) default NULL COMMENT '=forum_articles.id',
                `name` varchar(64) collate utf8_unicode_ci NOT NULL COMMENT '名前',
                `mail` varchar(128) collate utf8_unicode_ci NOT NULL COMMENT 'メールアドレス',
                `subject` varchar(255) collate utf8_unicode_ci NOT NULL COMMENT '件名',
                `body` text collate utf8_unicode_ci NOT NULL COMMENT '本文',
                `user_id` int(11) NOT NULL default '0' COMMENT '=user.id',
                `user_role` varchar(16) collate utf8_unicode_ci NOT NULL COMMENT '=user.role',
                `mail_display` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT 'メールアドレスを表示するかどうか',
                `mail_inform` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT 'メール通知するかどうか',
                `reply_count` int(11) NOT NULL default '0' COMMENT '返信数',
                `last_replied_at` int(11) default NULL COMMENT '最終返信時間',
                `last_replied_id` int(11) default NULL COMMENT '=forum_articles.id',
                `resolved` enum('0','1') collate utf8_unicode_ci NOT NULL default '0' COMMENT '解決フラグ',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`),
                KEY `forum_id` (`forum_id`),
                KEY `root_id` (`root_id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='フォーラムの記事';
        ");
        $this->message = "do create table 'forum_articles'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `forum_articles`;
        ");
        $this->message = "do drop table 'forum_articles'.";
    }
}

