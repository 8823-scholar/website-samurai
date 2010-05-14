<?php
/**
 * デフォルトデータをロードする
 * 
 * @package    SamuraiWEB
 * @subpackage Migrate.DB
 * @copyright  2007-2010 Samurai Framework Project
 * @author     KIUCHI Satoshinosuke <scholar@hayabusa-lab.jp>
 * @version    SVN: $Id: $
 */
class Migrate_LoadDefaultDatas extends Samurai_Migration
{
    /**
     * up処理
     *
     * @access     public
     */
    public function up()
    {
        $this->_loadUsers();
        $this->_loadHaikus();
        $this->_loadWikis();
        $this->_loadForums();
        $this->message = "load default datas.";
    }

    /**
     * デフォルトユーザーのロード
     *
     * @access     private
     */
    private function _loadUsers()
    {
        $datas = array(
            array(
                'name' => 'hayabusa', 'mail' => 'scholar@hayabusa-lab.jp', 'pass' => 'munekyun8823', 'real_name' => '木内智史之介',
                'introduction' => 'Samurai Frameworkの開発者です。よろしくお願いします:)', 'role' => 'admin', 'locale' => 'ja'
            ),
        );
        foreach($datas as $data) $this->AG->create('user', $data);
    }

    /**
     * 俳句をロードする
     *
     * @access     private
     */
    private function _loadHaikus()
    {
        $datas = array(
            array('phrase' => '世の人は　我を何とも　言わば言え　我が為すことは　我のみぞ知る', 'composed_by' => '坂本竜馬'),
            array('phrase' => 'まっすぐな道でさみしい', 'composed_by' => '種田山頭火'),
            array('phrase' => '咳をしても一人', 'composed_by' => '尾崎放哉'),
            array('phrase' => '身はたとひ 武蔵野野辺に 朽ちぬとも 留め置かまし 大和魂', 'composed_by' => '吉田松陰'),
            array('phrase' => 'ふたたひと　還らぬ歳を　はかなくも　今は惜しまぬ　身となりにけり', 'composed_by' => '武市瑞山'),
            array('phrase' => 'おもしろき　こともなき世を　おもしろく', 'composed_by' => '高杉晋作'),
            array('phrase' => '是非に及ばず', 'composed_by' => '織田信長'),
            array('phrase' => '露と落ち　露と消えにし　吾が身かな　浪花の事も　夢のまた夢', 'composed_by' => '豊臣秀吉'),
            array('phrase' => '心しらぬ　人は何とも言はばいへ　身をも惜まじ　名をも惜まじ', 'composed_by' => '明智光秀'),
            array('phrase' => '思いゆく　言の葉なくて　ついにゆく　道は迷わじ　なるにまかせて', 'composed_by' => '黒田如水'),
            array('phrase' => '柿食えば　鐘が鳴るなり　法隆寺', 'composed_by' => '正岡子規'),
            array('phrase' => '生まれる時代をまちがえた', 'composed_by' => '木内智史之介'),
            array('phrase' => '旅先で　無一文になる', 'composed_by' => '木内智史之介'),
        );
        foreach($datas as $data) $this->AG->create('haiku', $data);
    }

    /**
     * wikiデータのロード
     *
     * @access     private
     */
    private function _loadWikis()
    {
        $datas = array(
            array(
                'name' => 'FrontPage', 'title' => 'Samurai Framework ドキュメント', 'content' => '*top* ドキュメントメニュー',
                'locale' => 'ja', 'revision' => 1, 'created_by' => 1
            ),
        );
        foreach($datas as $data) $this->AG->create('wiki', $data);
    }

    /**
     * フォーラムデータのロード
     *
     * @access     private
     */
    private function _loadForums()
    {
        $datas = array(
            array('title' => 'Q&A', 'description' => 'Samurai Frameworkに関する様々な質問をお寄せください。', 'sort' => 1),
            array('title' => 'バグ報告', 'description' => "バグ報告はこちらからお願い致します。とても助かります。\nthank you :)", 'sort' => 2),
            array('title' => '要望', 'description' => "要望はこちらからお願い致します。\r\n皆さんの意見をお待ちしております。", 'sort' => 3),
            array('title' => '開発に関して', 'description' => 'Samurai Frameworkの改善点や新規機能などについての議論場です。', 'sort' => 4),
        );
        foreach($datas as $data) $this->AG->create('forum', $data);
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

