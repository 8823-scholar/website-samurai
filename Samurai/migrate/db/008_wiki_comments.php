<?php
/**
 * wiki_commentsテーブルを作成する
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_WikiComments extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->AG->executeQuery("
            CREATE TABLE IF NOT EXISTS `wiki_comments` (
                `id` int(11) NOT NULL auto_increment,
                `wiki_id` int(11) NOT NULL default '0' COMMENT '=wiki.id',
                `user_id` int(11) default NULL COMMENT '=user.id',
                `name` varchar(128) collate utf8_unicode_ci default NULL COMMENT '名前（未ログインの場合に限る）',
                `comment` text collate utf8_unicode_ci NOT NULL COMMENT 'コメント',
                `created_at` int(11) NOT NULL default '0',
                `updated_at` int(11) NOT NULL default '0',
                `deleted_at` int(11) NOT NULL default '0',
                `active` enum('0','1') collate utf8_unicode_ci NOT NULL default '1',
                PRIMARY KEY  (`id`)
            ) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='WIKIへのコメント';
        ");
        $this->message = "do create table 'wiki_comments'.";
    }


    /**
     * down処理
     *
     * @access     public
     */
    public function down()
    {
        $this->AG->executeQuery("
            DROP TABLE IF EXISTS `wiki_comments`;
        ");
        $this->message = "do drop table 'wiki_comments'.";
    }
}

