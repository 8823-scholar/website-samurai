<?php
class DescribeEtcWickeyExternal extends PHPSpec_Context
{
    private
        $Wickey;
    
    
    //動画系
    public function itYoutube()
    {
        //仕様後付のため
        return;
        $text = "aaaa<external site='youtube' value='abcdefzhijklmn' />aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<object width="425" height="350"><param name="movie" value="http://www.youtube.com/v/abcdefzhijklmn">
<param name="wmode" value="transparent">
<embed src="http://www.youtube.com/v/abcdefzhijklmn" type="application/x-shockwave-flash" width="425" height="350" wmode="transparent"></embed></object>aaaa</div>'
        );
    }
    
    public function itAmeba()
    {
        //仕様後付のため
        return;
        $text = "aaaa<external site='ameba' value='abcdefzhijklmn' />aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(join('', array(
            '<div class="wickey">aaaa<script language="javascript" type="text/javascript" src="http://visionmovie.ameba.jp/mcj.php?id=abcdefzhijklmn"></script>aaaa</div>'
        )));
    }
    
    public function itDailymotion()
    {
        //仕様後付のため
        return;
        $text = "aaaa<external site='dailymotion' value='abcdefzhijklmn' />aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<object width="200" height="166"><param name="movie" value="http://www.dailymotion.com/swf/abcdefzhijklmn">
<param name="wmode" value="transparent">
<param name="allowfullscreen" value="true">
<embed src="http://www.dailymotion.com/swf/abcdefzhijklmn" type="application/x-shockwave-flash" width="200" height="166" wmode="transparent" allowfullscreen="true"></embed></object>aaaa</div>'
        );
    }
    
    public function itニコニコ動画()
    {
        //仕様後付のため
        return;
        $text = "<external site='nico2' value='abcdefzhijklmn' />";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey"><script src="http://ext.nicovideo.jp/thumb_watch/abcdefzhijklmn?w=400&amp;h=335" type="text/javascript" charset="utf-8"></script></div>'
        );
    }
    public function itニコニコ動画：iframe表示()
    {
        //仕様後付のため
        return;
        $text = "<external site='nico2' value='abcdefzhijklmn' iframe />";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey"><iframe width="312" height="176" src="http://ext.nicovideo.jp/thumb/abcdefzhijklmn" frameborder="0"></iframe></div>'
        );
    }
    
    
    
    //Google系
    public function itGoogleMap()
    {
        //仕様後付のため
        return;
        $text = "aaaa<external site='gmap' value='http://maps.google.co.jp/maps?ie=UTF8&amp;ll=35.706517,139.655113&amp;spn=0.026972,0.056133&amp;z=14&amp;iwloc=0x6018f27d7b07b7f1:0xf1fea6c3c2e4a55c&amp;source=embed' />aaaa";
        $text = $this->Wickey->render($text);
        $this->spec($text)->should->equal(
            '<div class="wickey">aaaa<span class="map gmap"><iframe width="300" height="247" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.co.jp/maps?ie=UTF8&amp;ll=35.706517,139.655113&amp;spn=0.026972,0.056133&amp;z=14&amp;iwloc=0x6018f27d7b07b7f1:0xf1fea6c3c2e4a55c&amp;source=embed&amp;s=AARTsJqzARj-Z8VnW5pkPMLMmZbqrJcYpw"></iframe><br /><small><a href="http://maps.google.co.jp/maps?ie=UTF8&amp;ll=35.706517,139.655113&amp;spn=0.026972,0.056133&amp;z=14&amp;iwloc=0x6018f27d7b07b7f1:0xf1fea6c3c2e4a55c&amp;source=embed" target="_blank" style="color:#0000FF;text-align:left">大きな地図で見る</a></small></span>aaaa</div>'
        );
    }
    
    
    
    
    
    /**
     * 初期化処理
     * @access     public
     */
    public function beforeAll()
    {
        Samurai_Loader::loadByClass('Etc_Wickey');
        $this->Wickey = new Etc_Wickey();
    }
}
