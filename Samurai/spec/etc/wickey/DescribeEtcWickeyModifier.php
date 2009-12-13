<?php
/**
 * Wickey / Modifierタグ変換のspec
 *
 * @package    Samurai
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class DescribeEtcWickeyModifier extends PHPSpec_Context
{
    private
        $Wickey;


    //装飾系
    public function itBold()
    {
        $text = "aaaa<modifier bold>aaaa</modifier>aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="font-weight:bolder;">aaaa</span>aaaa<br /></div></div></div>'
        );
    }
    public function itItalic()
    {
        $text = "aaaa<modifier italic>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="font-style:italic;">aaaa</span><br /></div></div></div>'
        );
    }

    public function itUnderline()
    {
        $text = "aaaa<modifier underline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="text-decoration:underline;">aaaa</span><br /></div></div></div>'
        );
    }
    public function itOverline()
    {
        $text = "aaaa<modifier overline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="text-decoration:overline;">aaaa</span><br /></div></div></div>'
        );
    }
    public function itDelete()
    {
        $text = "aaaa<modifier delete>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="text-decoration:line-through;">aaaa</span><br /></div></div></div>'
        );
    }
    public function itTextDecoration複合()
    {
        $text = "aaaa<modifier delete underline overline>bbbb</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="text-decoration:line-through underline overline;">bbbb</span><br /></div></div></div>'
        );
    }

    public function itColor()
    {
        $text = "aaaa<modifier color='#666666'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="color:#666666;">aaaa</span><br /></div></div></div>'
        );
    }
    public function itBgcolor()
    {
        $text = "aaaa<modifier bgcolor='#666666'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="background-color:#666666;">aaaa</span><br /></div></div></div>'
        );
    }
    public function itHref()
    {
        $text = "aaaa<modifier href='http://befool.co.jp/'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<a href="http://befool.co.jp/" target="_blank">aaaa</a><br /></div></div></div>'
        );
        $text = "aaaa<modifier href='http://befool.co.jp/' target='test'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<a href="http://befool.co.jp/" target="test">aaaa</a><br /></div></div></div>'
        );
    } 


    //位置系
    public function it左寄せ()
    {
        $text = "<modifier left>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph"><div style="text-align:left;">aaaa</div><br /></div></div></div>'
        );
    }
    public function it右寄せ()
    {
        $text = "<modifier right>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph"><div style="text-align:right;">aaaa</div><br /></div></div></div>'
        );
    }
    public function it中央寄せ()
    {
        $text = "<modifier center>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph"><div style="text-align:center;">aaaa</div><br /></div></div></div>'
        );
    }


    //その他系
    public function itコード()
    {
        $text = "aaaa<modifier code='php'><? \$a = '2'; ?></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<pre class="code php"><span style="color:#000000;font-weight:bold;" title="php/php/start">&lt;?</span> <span style="color:#3333ff;" title="php/php/varstart">$</span><span style="color:#3333ff;" title="php/php/var">a</span> <span style="color:#008000;" title="php/php/symbol">=</span> <span style="color:#ff0000;" title="php/php/single_string/start">\'</span><span style="color:#ff0000;" title="php/php/single_string">2</span><span style="color:#ff0000;" title="php/php/single_string/end">\'</span><span style="color:#008000;" title="php/php/symbol">;</span> <span style="color:#000000;font-weight:bold;" title="php/php/end">?&gt;</span></pre><br /></div></div></div>'
        );
        //コードは中身を解釈しない
        $text = "aaaa<modifier code='php'><? \$a = '2'; ?><modifier bold>abcdefg</modifier></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<pre class="code php"><span style="color:#000000;font-weight:bold;" title="php/php/start">&lt;?</span> <span style="color:#3333ff;" title="php/php/varstart">$</span><span style="color:#3333ff;" title="php/php/var">a</span> <span style="color:#008000;" title="php/php/symbol">=</span> <span style="color:#ff0000;" title="php/php/single_string/start">\'</span><span style="color:#ff0000;" title="php/php/single_string">2</span><span style="color:#ff0000;" title="php/php/single_string/end">\'</span><span style="color:#008000;" title="php/php/symbol">;</span> <span style="color:#000000;font-weight:bold;" title="php/php/end">?&gt;</span><span style="color:#000000;font-weight:bold;" title="html/html/tag/start">&lt;modifier</span><span style="color:#008000;" title="html/html/tag"> bold</span><span style="color:#000000;font-weight:bold;" title="html/html/tag/end">&gt;</span><span style="color:#000000;" title="html/html">abcdefg</span><span style="color:#000000;font-weight:bold;" title="html/html/tag/start">&lt;/modifier</span><span style="color:#000000;font-weight:bold;" title="html/html/tag/end">&gt;</span></pre><br /></div></div></div>'
        );
    }
    public function it引用()
    {
        $text = "aaaa<modifier blockquote>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<blockquote>$a = \'2\';</blockquote><br /></div></div></div>'
        );
    }
    
    
    //挑戦系
    public function it複雑でも耐えられるか？！()
    {
        $text = "aaaa<modifier italic underline delete color='#666666' bold>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="font-style:italic; text-decoration:underline line-through; color:#666666; font-weight:bolder;">$a = \'2\';</span><br /></div></div></div>'
        );
    }
    public function itCode属性は他の属性と同居できない()
    {
        $text = "aaaa<modifier code='php' italic color='#666666' bold>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<pre class="code php"><span style="color:#000000;" title="html/html">$a = \'2\';</span></pre><br /></div></div></div>'
        );
    }
    public function it入れ子構造への挑戦()
    {
        $text = "aaaa<modifier overline>aaaa<modifier color='#666666'>bbbb</modifier></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($this->_deleteWhiteSpace($text))->should->equal(
            '<div class="wickey"><div class="section"><div class="paragraph">aaaa<span style="text-decoration:overline;">aaaa<span style="color:#666666;">bbbb</span></span><br /></div></div></div>'
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
