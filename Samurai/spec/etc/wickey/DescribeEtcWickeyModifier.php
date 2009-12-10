<?php
class DescribeEtcWickeyModifier extends PHPSpec_Context
{
    private
        $Wickey;
    
    
    public function itBoldAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier bold>aaaa</modifier>aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="font-weight:bolder;">aaaa</span>aaaa</div>'
        );
    }
    public function itItalicAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier italic>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="font-style:italic;">aaaa</span></div>'
        );
    }
    
    
    public function itUnderlineAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier underline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="text-decoration:underline;">aaaa</span></div>'
        );
    }
    public function itOverlineAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier overline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="text-decoration:overline;">aaaa</span></div>'
        );
    }
    public function itDeleteAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier delete>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="text-decoration:line-through;">aaaa</span></div>'
        );
    }
    public function itTextDecoration複合()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier delete underline overline>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="text-decoration:line-through underline overline;">aaaa</span></div>'
        );
    }
    
    
    public function itColorAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier color='#666666'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="color:#666666;">aaaa</span></div>'
        );
    }
    public function itBgcolorAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier bgcolor='#666666'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span style="background-color:#666666;">aaaa</span></div>'
        );
    }
    public function itHrefAttribute()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier href='http://befool.co.jp/'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<A href="http://befool.co.jp/" target="_blank">aaaa</A></div>'
        );
        $text = "aaaa<modifier href='http://befool.co.jp/' target='test'>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<A href="http://befool.co.jp/" target="test">aaaa</A></div>'
        );
    }
    
    
    //位置系
    public function it左寄せ()
    {
        //仕様後付のため
        return;
        $text = "<modifier left>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey"><div style="text-align:left;">aaaa</div></div>'
        );
    }
    public function it右寄せ()
    {
        //仕様後付のため
        return;
        $text = "<modifier right>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey"><div style="text-align:right;">aaaa</div></div>'
        );
    }
    public function it中央寄せ()
    {
        //仕様後付のため
        return;
        $text = "<modifier center>aaaa</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey"><div style="text-align:center;">aaaa</div></div>'
        );
    }
    
    
    public function itコード()
    {
        //仕様後付のため
        return;
        $text = "aaaa<modifier code='php'>\$a = '2';</modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<div class="code php">$a&nbsp;=&nbsp;\'2\';</div></div>'
        );
        //コードは中身を解釈しない
        $text = "aaaa<modifier code='php'>\$a = '2';<modifier bold>abcdefg</modifier></modifier>";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<div class="code php">$a&nbsp;=&nbsp;\'2\';&lt;modifier&nbsp;bold&gt;abcdefg&lt;/modifier&gt;</div></div>'
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
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Befool_Wickey');
        $this->Wickey = new Befool_Wickey();
    }
}
