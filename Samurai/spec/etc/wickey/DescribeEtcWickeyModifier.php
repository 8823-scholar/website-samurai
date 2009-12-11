<?php
/**
 * Wickey / Modifierタグ変換のspec
 *
 * <code>
 *     <modifier bold>aaaa</modifier>
 *     <modifier italic>aaaa</modifier>
 *     <modifier color='#CCCCCC'>change the color.</modifier>
 *     <modifier bgcolor='#CCCCCC'>change the background color.</modifier>
 *     <modifier underline>bbbb</modifier>
 *     <modifier color='#FFFFFF' bgcolor='#999999'>enable conbinations.</modifier>
 *     <modifier code='php'>
 *     <?
 *         class Foo_Bar_Zoo
 *         {
 *             function test()
 *             {
 *                 echo 'test';
 *             }
 *         }
 *     ?>
 *     </modifier>
 * </code>
 *
 * @package    Samurai
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class DescribeEtcWickeyModifier extends PHPSpec_Context
{
    /**
     * Wickeyコンポーネント
     *
     * @access   private
     * @var      object
     */
    private $Wickey;


    //装飾系
    public function itBold()
    {
        $text = "aaaa<modifier bold>aaaa</modifier>aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="font-weight:bolder;">aaaa</span>aaaa<br /></p></div>'
        );
    }
    public function itItalic()
    {
        $text = "aaaa<modifier italic>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="font-style:italic;">aaaa</span><br /></p></div>'
        );
    }

    public function itUnderline()
    {
        $text = "aaaa<modifier underline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="text-decoration:underline;">aaaa</span><br /></p></div>'
        );
    }
    public function itOverline()
    {
        $text = "aaaa<modifier overline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="text-decoration:overline;">aaaa</span><br /></p></div>'
        );
    }
    public function itDelete()
    {
        $text = "aaaa<modifier delete>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="text-decoration:line-through;">aaaa</span><br /></p></div>'
        );
    }
    public function itTextDecoration複合()
    {
        $text = "aaaa<modifier delete underline overline>bbbb</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="text-decoration:line-through underline overline;">bbbb</span><br /></p></div>'
        );
    }

    public function itColor()
    {
        $text = "aaaa<modifier color='#666666'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="color:#666666;">aaaa</span><br /></p></div>'
        );
    }
    public function itBgcolor()
    {
        $text = "aaaa<modifier bgcolor='#666666'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<span style="background-color:#666666;">aaaa</span><br /></p></div>'
        );
    }
    public function itHref()
    {
        $text = "aaaa<modifier href='http://befool.co.jp/'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<a href="http://befool.co.jp/" target="_blank">aaaa</a><br /></p></div>'
        );
        $text = "aaaa<modifier href='http://befool.co.jp/' target='test'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<a href="http://befool.co.jp/" target="test">aaaa</a><br /></p></div>'
        );
    } 


    //位置系
    public function it左寄せ()
    {
        $text = "<modifier left>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p><div style="text-align:left;">aaaa</div><br /></p></div>'
        );
    }
    public function it右寄せ()
    {
        $text = "<modifier right>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p><div style="text-align:right;">aaaa</div><br /></p></div>'
        );
    }
    public function it中央寄せ()
    {
        $text = "<modifier center>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p><div style="text-align:center;">aaaa</div><br /></p></div>'
        );
    }


    //その他系
    public function itコード()
    {
        $text = "aaaa<modifier code='php'><? \$a = '2'; ?></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<div class="code php">$a&nbsp;=&nbsp;\'2\';</div><br /></p></div>'
        );
        //コードは中身を解釈しない
        $text = "aaaa<modifier code='php'><? \$a = '2'; ?><modifier bold>abcdefg</modifier></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><p>aaaa<div class="code php">$a&nbsp;=&nbsp;\'2\';&lt;modifier&nbsp;bold&gt;abcdefg&lt;/modifier&gt;</div><br /></p></div>'
        );
    }
    
    
    public function it引用()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier blockquote>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<div class="blockquote">$a = \'2\';</div></div>'
        );
    }
    
    
    
    public function it複雑でも耐えられるか？！()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier italic underline delete color='#666666' bold>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="font-style:italic; text-decoration:underline line-through; color:#666666; font-weight:bolder;">'
                .'$a = \'2\';</span></div>'
        );
    }
    public function itCode属性は他の属性と同居できない()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier code='php' italic color='#666666' bold>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<div class="code php">$a&nbsp;=&nbsp;\'2\';</div></div>'
        );
    }
    public function it入れ子構造への挑戦()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier overline>aaaa<modifier color='#666666'>bbbb</modifier></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="text-decoration:overline;">aaaa<span style="color:#666666;">bbbb</span></span></div>'
        );
    }





    /**
     * 初期化処理
     * @access     public
     */
    public function before()
    {
        $this->Wickey = new Etc_Wickey();
    }
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Wickey');
    }






    /**
     * 改行などを取り除く
     * (expected を記述するのが煩わしいので)
     *
     * @access   private
     * @param    string   $text
     * @return   string
     */
    private function _deleteWhiteSpace($text)
    {
        return preg_replace("/[\r\n\t]/", '', $text);
    }
}
