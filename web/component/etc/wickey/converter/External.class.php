<?php
/**
 * 外部サイト連携コンバーター
 *
 * 外部サービスとの連携に用いられる。
 * 
 * @package    Etc
 * @subpackage Wickey
 * @copyright  2007-2009 Samurai Framework Project
 * @author     hayabusa <scholar@hayabusa-lab.jp>
 */
class Etc_Wickey_Converter_External extends Etc_Wickey_Converter
{
    /**
     * コンストラクタ
     *
     * @access     public
     */
    public function __construct()
    {
        
    }


    /**
     * 変換トリガー
     *
     * @implements
     * @access     public
     */
    public function convert(Etc_Dom_Node $node)
    {
        $method = '_do' . ucfirst(strtolower($node->getAttribute('site')));
        if(method_exists($this, $method)){
            $new_node = $this->$method($node);
            $this->_appendAttribute($new_node, 'class', 'external');
            return $new_node;
        } else {
            return $node;
        }
    }

    /**
     * YOUTUBE
     *
     * @access     protected
     */
    protected function _doYoutube(Befool_Dom_Node $node)
    {
        if(!$node->hasAttribute('value')) return $node;
        if($this->Device->isMobile()) return $this->_convert4Mobile('YouTube動画');
        
        $root = $this->option->root;
        $new_node = $root->createElement('object');
        $new_node->setAttribute('width', $this->option->mini ? 300 : 425);
        $new_node->setAttribute('height', $this->option->mini ? 247 : 350);
        
        $swf_url = sprintf('http://www.youtube.com/v/%s', $node->getAttribute('value'));
        
        //PARAM値アペンド
        $param = $root->createElement('param');
        $param->setAttribute('name', 'movie');
        $param->setAttribute('value', $swf_url);
        $new_node->appendChild($param->cloneNode());
        $param->setAttribute('name', 'wmode');
        $param->setAttribute('value', 'transparent');
        $new_node->appendChild($param->cloneNode());
        
        //EMBED値アペンド
        $embed = $root->createElement('embed');
        $embed->setAttribute('src', $swf_url);
        $embed->setAttribute('type', 'application/x-shockwave-flash');
        $embed->setAttribute('width', $this->option->mini ? 300 : 425);
        $embed->setAttribute('height', $this->option->mini ? 247 : 350);
        $embed->setAttribute('wmode', 'transparent');
        $new_node->appendChild($embed);
        
        return $new_node;
    }



    /**
     * ニコニコ動画
     *
     * @access     protected
     */
    protected function _doNico2(Etc_Dom_Node $node)
    {
        if(!$node->hasAttribute('value')) return $node;
        if($this->Device->isMobile()) return $this->_convert4Mobile('ﾆｺﾆｺ動画');
        
        $root = $this->option->root;
        if($node->hasAttribute('iframe')){
            $new_node = $root->createElement('iframe');
            $new_node->setAttribute('width', 312);
            $new_node->setAttribute('height', 176);
            $new_node->setAttribute('src', sprintf('http://ext.nicovideo.jp/thumb/%s', $node->getAttribute('value')));
            $new_node->setAttribute('frameborder', '0');
        } else {
            $new_node = $root->createElement('script');
            $src = sprintf('http://ext.nicovideo.jp/thumb_watch/%s', $node->getAttribute('value'));
            $src .= $this->option->mini ? '?w=300&h=251' : '?w=400&h=335' ;
            
            $new_node->setAttribute('src', $src);
            $new_node->setAttribute('type', 'text/javascript');
            $new_node->setAttribute('charset', 'utf-8');
        }
        $this->_removeNextBR($node);
        
        return $new_node;
    }



    /**
     * Ameba
     *
     * @access     protected
     */
    protected function _doAmeba(Etc_Dom_Node $node)
    {
        if(!$node->hasAttribute('value')) return $node;
        if($this->Device->isMobile()) return $this->_convert4Mobile('Ameba動画');
        
        $root = $this->option->root;
        $new_node = $root->createElement('script');
        $new_node->setAttribute('language', 'javascript');
        $new_node->setAttribute('type', 'text/javascript');
        $new_node->setAttribute('src', sprintf('http://visionmovie.ameba.jp/mcj.php?id=%s', $node->getAttribute('value')));
        
        $this->_appendAttribute($new_node, 'class', 'ameba');
        
        return $new_node;
    }



    /**
     * DailyMotion
     *
     * @access     protected
     */
    protected function _doDailymotion(Etc_Dom_Node $node)
    {
        if(!$node->hasAttribute('value')) return $node;
        if($this->Device->isMobile()) return $this->_convert4Mobile('DailyMotion動画');
        
        $root = $this->option->root;
        $new_node = $root->createElement('object');
        $new_node->setAttribute('width', 200);
        $new_node->setAttribute('height', 166);
        
        $swf_url = sprintf('http://www.dailymotion.com/swf/%s', $node->getAttribute('value'));
        
        //PARAM値アペンド
        $param = $root->createElement('param');
        $param->setAttribute('name', 'movie');
        $param->setAttribute('value', $swf_url);
        $new_node->appendChild($param);
        $param = $root->createElement('param');
        $param->setAttribute('name', 'wmode');
        $param->setAttribute('value', 'transparent');
        $new_node->appendChild($param);
        $param = $root->createElement('param');
        $param->setAttribute('name', 'allowfullscreen');
        $param->setAttribute('value', 'true');
        $new_node->appendChild($param);
        
        //EMBED値アペンド
        $embed = $root->createElement('embed');
        $embed->setAttribute('src', $swf_url);
        $embed->setAttribute('type', 'application/x-shockwave-flash');
        $embed->setAttribute('width', 200);
        $embed->setAttribute('height', 166);
        $embed->setAttribute('wmode', 'transparent');
        $embed->setAttribute('allowfullscreen', 'true');
        $new_node->appendChild($embed);
        
        return $new_node;
    }


    /**
     * Veoh用の変換
     *
     * @access     private
     */
    private function _convert4Veoh(Etc_Dom_Node $node)
    {
        if(!$node->hasAttribute('value')) return $node;
        if($this->Device->isMobile()) return $this->_convert4Mobile($root, 'Veoh動画');
        
        $swf_url = sprintf('http://www.veoh.com/videodetails2.swf?permalinkId=%s&id=anonymous&player=videodetailsembedded&videoAutoPlay=0', $node->getAttribute('value'));
        
        //OBJECT
        $new_node = $root->createElement('object');
        $new_node->setAttribute('width', 340);
        $new_node->setAttribute('height', 260);
        $new_node->setAttribute('class', 'resource');
        $param = $root->createElement('param');
        $param->setAttribute('name', 'movie');
        $param->setAttribute('value', $swf_url);
        $new_node->appendChild($param);
        $param = $root->createElement('param');
        $param->setAttribute('name', 'wmode');
        $param->setAttribute('value', 'transparent');
        $new_node->appendChild($param);
        $param = $root->createElement('param');
        $param->setAttribute('name', 'allowfullscreen');
        $param->setAttribute('value', 'true');
        $new_node->appendChild($param);
        
        //EMBED
        $embed = $root->createElement('embed');
        $embed->setAttribute('src', $swf_url);
        $embed->setAttribute('type', 'application/x-shockwave-flash');
        $embed->setAttribute('width', 340);
        $embed->setAttribute('height', 260);
        $embed->setAttribute('wmode', 'transparent');
        $embed->setAttribute('allowfullscreen', 'true');
        $embed->setAttribute('class', 'resource');
        $new_node->appendChild($embed);
        
        return $new_node;
    }



    /**
     * GoogleMap
     *
     * @access     protected
     */
    protected function _doGmap(Etc_Dom_Node $node)
    {
        if(!$node->hasAttribute('value')) return $node;
        if($this->Device->isMobile()) return $this->_convert4Mobile('GoogleMap地図');
        
        $root = $this->option->root;
        $new_node = $root->createElement('span');
        $new_node->setAttribute('class', 'map gmap');
        
        $iframe = $root->createElement('iframe');
        $iframe->setAttribute('width', 300);
        $iframe->setAttribute('height', 247);
        $iframe->setAttribute('frameborder', 0);
        $iframe->setAttribute('scrolling', 'no');
        $iframe->setAttribute('marginheight', 0);
        $iframe->setAttribute('marginwidth', 0);
        $iframe->setAttribute('src', html_entity_decode($node->getAttribute('value')) . '&s=AARTsJqzARj-Z8VnW5pkPMLMmZbqrJcYpw');
        $new_node->appendChild($iframe);
        $new_node->appendChild($root->createElement('br'));
        
        $small = $root->createElement('small');
        $a = $root->createElement('a', '大きな地図で見る');
        $a->setAttribute('href', html_entity_decode($node->getAttribute('value')));
        $a->setAttribute('target', '_blank');
        $a->setAttribute('style', 'color:#0000FF;text-align:left');
        $small->appendChild($a);
        $new_node->appendChild($small);
        
        return $new_node;
    }
}
