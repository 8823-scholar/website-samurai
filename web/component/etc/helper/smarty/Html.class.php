<?
/**
 * Etc_Helper_Smarty_Html
 * 
 * HTMLヘルパー。
 * HTML記述を助けるメソッドが詰め込まれている。
 * 
 * @package    Samurai
 * @subpackage Etc.Helper.Smarty
 * @copyright  BEFOOL,Inc.
 * @author     Satoshi Kiuchi <satoshi.kiuchi@befool.co.jp>
 */
class Etc_Helper_Smarty_Html
{
    public
        /** @var        string  mb_convert_kanaの値 */
        $kana = '',
        /** @var        boolean session_idがリンクに付加されるかどうか */
        $use_session = false,
        /** @var        string  スペーサー画像へのURL */
        $spacer_url = '',
        /** @var        string  URIの頭に常についてくる接頭語 */
        $prefix = BASE_URI,
        /** @var        array   引き回したい変数があればここに投げ込む */
        $args = array();
    public
        /** @var        object  Deviceコンポーネント */
        $Device,
        /** @var        object  Utilityコンポーネント */
        $Utility;
    
    
    /**
     * コンストラクタ。
     * @access     public
     */
    public function __construct()
    {
        
    }
    
    
    
    
    
    /**
     * リンクタグ生成。
     * @access     public
     * @param      string  $params['href']     URL
     * @param      string  $params['value']    <A></A>で囲みたい文字列
     * @param      string  $params['target']   ターゲットウインドウ
     * @param      string  $params['anchor']   アンカー(#のやつ)
     * @param      string  $params['image']    イメージ(ここで指定するのは、<IMG src='' />のsrcの部分)
     * @param      string  $params['access']   携帯電話のどのボタンでアクセスできるか
     * @param      boolean $params['prefix']   prefixを反映させるかどうか
     * @return     string  <A></A>タグ
     */
    public function a(array $params=array())
    {
        $href     = '';
        $value    = '';
        $anchor   = '';
        $icon     = '';
        $image    = '';
        $access   = '';
        $escape   = true;
        $kana     = NULL;
        $args     = $this->args;
        $no_prefix = false;
        foreach($params as $_key => $_val){
            if(is_int($_key)) continue;
            switch($_key){
                case 'href':
                case 'value':
                case 'anchor':
                case 'icon':
                case 'image':
                case 'kana':
                case 'access':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
                case 'args':
                    $$_key = array_merge($$_key, (array)$_val);
                    unset($params[$_key]);
                    break;
                case 'escape':
                case 'no_prefix':
                    $$_key = (bool)$_val;
                    unset($params[$_key]);
                    break;
            }
        }
        //valueの補完
        if($value == '') $value = '__';
        //hrefへの付加
        if($this->use_session){
            $args[session_name()] = session_id();
        }
        $href = $this->Utility->array2Url($href, $args);
        if($anchor) $href .= '#'.$anchor;
        //imageの場合
        if($image){
            $escape = false;
            $value = $this->_makeTag('img', array('src'=>$image), NULL);
        }
        if($icon){
            $value = $escape ? htmlspecialchars($value) : $value ;
            $escape = false;
            $value = $this->_makeTag('img', array('src'=>$icon, 'class'=>'icon'), NULL) . $value;
        }
        //出力
        $params['href'] = $this->isAbsolutePath($href, false) && !$no_prefix ? $this->prefix . $href : $href ;
        if($access){
            switch($this->Device->getWeb()){
                case 'ez':
                    $params['accesskey'] = $access; break;
                case 'v':
                    $params['accesskey'] = $access; break;
                case 'i':
                    $params['accesskey'] = $access; break;
            }
        }
        return $this->_makeTag('a', $params, $value, $escape);
    }
    
    
    /**
     * function a のエイリアス。
     * 情報を、書き換えて、aを呼び出します。
     * @access     public
     * @param      string  $params['to']        送り先
     * @param      string  $params['subject']   件名
     * @param      string  $params['body']      本文
     * @return     string  メールリンクタグ
     */
    public function mail($params){
        $to      = '';
        $subject = NULL;
        $body    = NULL;
        foreach($params as $_key => $_val){
            switch($_key){
                case 'to':
                case 'subject':
                case 'body':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
            }
        }
        $href = sprintf('mailto:%s', htmlspecialchars($to));
        $args = array();
        if($subject !== NULL) $args[] = sprintf('subject=%s', urlencode($subject));
        if($body !== NULL)    $args[] = sprintf('body=%s', urlencode($body));
        $href = sprintf('%s?%s', $href, join('&', $args));
        $params['href'] = $href;
        return $this->A($params);
    }
    
    
    /**
     * フォームタグ生成。
     * @access     public
     * @param      string  $params['action']    データ送付先
     * @param      string  $params['method']    METHOD
     * @param      string  $params['file']      ファイルを送付するかどうか
     * @param      string  $params['args']      actionに付加したい情報
     * @param      string  $params['buff']      バッファ(文字化け対策)
     * @param      boolean $params['end']       終了タグかどうか
     * @return     string  フォームタグ
     */
    public function form($params){
        $action    = '';
        $method    = 'POST';
        $file      = false;
        $end       = false;
        $args      = array();
        $no_prefix = false;
        foreach($params as $_key=>$_val){
            switch($_key){
                case 'action':
                case 'method':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
                case 'args':
                    $$_key = (array)$_val;
                    unset($params[$_key]);
                    break;
                case 'file':
                case 'end':
                case 'no_prefix':
                    $$_key = (bool)$_val;
                    unset($params[$_key]);
                    break;
            }
        }
        //閉じタグの場合
        if(!$action) $end = true;
        if($end) return '</form>';
        
        //準備
        if($this->use_session){
            $args[session_name()] = session_id();
        }
        
        //生成
        $action = $this->isAbsolutePath($action, false) && !$no_prefix ? $this->prefix . $action : $action ;
        if($this->Device->isMobile() && $this->Device->isImode() && isset($this->args['guid'])){
            $action .= strpos($action, '?') !== false ? '&guid=ON' : '?guid=ON';
        }
        $params['action'] = $action;
        $params['method'] = $method;
        if($file) $params['enctype'] = 'multipart/form-data';
        $form = array();
        $form[] = $this->_makeTag('form', $params, '', false, false, false);
        foreach($args as $_key => $_val){
            $form[] = $this->_array2input($_key, $_val, 'hidden');
        }
        $form = join("\r\n", $form);
        return $form;
    }
    
    
    /**
     * インプット。
     * @access     public
     * @param      string  $params['type']
     * @param      string  $params['name']
     * @param      string  $params['value']
     * @param      string  $params['label']
     * @param      int     $params['maxlength']
     * @param      int     $params['size']
     * @param      string  $params['selected']
     * @param      string  $params['istyle']
     * @param      string  $params['kana']
     * @param      boolean $params['escape']
     * @return     string  インプットタグ
     */
    public function input($params){
        $type      = 'text';
        $name      = '';
        $value     = NULL;
        $label     = '';
        $maxlength = 0;
        $size      = 0;
        $selected  = '';
        $disabled  = false;
        $kana      = NULL;
        $escape    = true;
        $istyle    = '';
        foreach($params as $_key=>$_val){
            switch($_key){
                case 'size':
                case 'maxlength':
                    $$_key = (int)$_val;
                    unset($params[$_key]);
                    break;
                case 'name':
                case 'type':
                case 'kana':
                case 'istyle':
                case 'label':
                case 'value':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
                case 'disable':
                case 'escape':
                    $$_key = (bool)$_val;
                    unset($params[$_key]);
                    break;
                case 'selected':
                    $$_key = $_val;
                    unset($params[$_key]);
                    break;
            }
        }
        
        //準備
        if($type) $params['type']  = $type;
        if($name) $params['name']  = $name;
        if($value !== NULL) $params['value'] = $value;
        if(!isset($params['class']) && $name) $params['class'] = $name;
        if($disabled) $params[] = 'disabled';
        
        //生成
        switch($type){
            case 'radio':
            case 'checkbox':
                if($value == $selected || (!$value && !$selected)){
                    $params[] = 'checked';
                } elseif(is_array($selected) && in_array($value, $selected)){
                    $params[] = 'checked';
                }
                break;
            case 'text':
                if($istyle){
                    if($this->Device->i){
                        if($istyle=='hira') $params['istyle'] = '1';
                        if($istyle=='kana') $params['istyle'] = '2';
                        if($istyle=='eiji') $params['istyle'] = '3';
                        if($istyle=='suji') $params['istyle'] = '4';
                    } elseif($this->Device->v){
                        if($istyle=='hira') $params['istyle'] = '1';
                        if($istyle=='kana') $params['istyle'] = '2';
                        if($istyle=='eiji') $params['istyle'] = '3';
                        if($istyle=='suji') $params['istyle'] = '4';
                    } elseif($this->Device->ez){
                        if($istyle=='hira') $params['istyle'] = '1';
                        if($istyle=='kana') $params['istyle'] = '2';
                        if($istyle=='eiji') $params['istyle'] = '3';
                        if($istyle=='suji') $params['istyle'] = '4';
                    } else {
                        if(isset($params['style'])) $params['style'] = (array)$params['style'];
                        if($istyle=='hira') $params['style'][] = 'ime-mode:active;';
                        if($istyle=='kana') $params['style'][] = 'ime-mode:active;';
                        if($istyle=='eiji') $params['style'][] = 'ime-mode:inactive;';
                        if($istyle=='suji') $params['style'][] = 'ime-mode:inactive;';
                    }
                }
            case 'file':
            case 'password':
                if($size) $params['size'] = $size;
                if($maxlength) $params['maxlength'] = $maxlength;
                break;
        }
        return $this->_makeTag('input', $params, $label, $escape, false);
    }
    /**
     * インプットタグエイリアス。
     * インプットタグの各種省略形メソッド。
     * @access     public
     */
    public function text($params){
        if(!isset($params['type'])) $params['type'] = 'text';
        //デフォルト
        if(isset($params['inner_label'])){
            $dummy_value   = $params['inner_label'];
            $dummy_name    = 'dummy_'.$params['name'];
            $dummy_params = array(
                'name'    => $dummy_name,
                'value'   => $dummy_value,
                'style'   => isset($params['style']) ? $params['style'] : '',
                'class'   => isset($params['class']) ? $params['class'] . ' dummy' : $dummy_name . ' dummy',
                'onFocus' => "this.style.display='none';this.previousSibling.style.display='';this.previousSibling.focus();",
            );
            $params['onBlur'] = "if(this.value==''){ this.style.display='none';this.nextSibling.style.display=''; }";
            if(!isset($params['value']) || $params['value'] == ''){
                if(isset($params['style'])){
                    is_array($params['style']) ? $params['style'][] = 'display:none' : $params['style'] .= 'display:none;';
                } else {
                    $params['style'] = 'display:none;';
                }
            } else {
                is_array($dummy_params['style']) ? $dummy_params['style'][] = 'display:none' : $dummy_params['style'] .= 'display:none;';
            }
            unset($params['inner_label']);
            return $this->input($params).$this->input($dummy_params);
        }
        return $this->input($params);
    }
    public function password($params){
        $params['type'] = 'password';
        return $this->text($params);
    }
    public function hidden($params){
        $params['type'] = 'hidden';
        return $this->input($params);
    }
    public function checkbox($params){
        $params['type'] = 'checkbox';
        if(isset($params['label'])){
            if(!isset($params['id'])) $params['id'] = $params['name'].'_'.$params['value'];
            $params['escape'] = false;
            $params['label'] = ' ' . $this->_makeTag('label', array('for'=>$params['id'], 'class'=>$params['name']), htmlspecialchars($params['label']));
        }
        return $this->input($params);
    }
    public function radio($params){
        $params['type'] = 'radio';
        if(isset($params['label']) || isset($params['image'])){
            $params['escape'] = false;
            //imageの場合
            if(isset($params['image'])){
                $label = $this->_makeTag('IMG', array('src'=>$params['image'],'class'=>'icon'), NULL);
                unset($params['image']);
            } else {
                $label = htmlspecialchars($params['label']);
            }
            if(!isset($params['id'])) $params['id'] = $params['name'].'_'.$params['value'];
            $params['label'] = ' ' . $this->_makeTag('label', array('for'=>$params['id'], 'class'=>$params['name']), htmlspecialchars($params['label']));
        }
        return $this->input($params);
    }
    public function file($params){
        $params['type'] = 'file';
        return $this->input($params);
    }
    public function submit($params){
        if(!isset($params['type'])) $params['type'] = 'submit';
        if(!isset($params['class'])) $params['class'] = 'submit';
        if(isset($params['dispatch'])){
            $params['name'] = 'dispatch_'.$params['dispatch'];
            unset($params['dispatch']);
        }
        return $this->input($params);
    }
    
    
    /**
     * セレクトボックス。
     * セレクトボックスは、飲み込むのにちょっと時間がかかるかもしれない。
     * {Html->select item=$item label='title' value='id' name='hoge' selected=$request.hoge}
     * @access     public
     * @param      array   $params['item']
     * @param      string  $params['name']
     * @param      string  $params['selected']
     * @param      string  $params['label']
     * @param      string  $params['value']
     * @param      string  $params['style']
     * @param      string  $params['onChange']
     * @param      string  $params['kana']
     * @param      boolean $params['escape']
     * @param      boolean $params['group']
     * @return     string  セレクトボックス
     */
    public function select($params){
        $name        = 'selectbox';
        $selected    = '';
        $label       = '';
        $value       = '';
        $kana        = $this->kana;
        $escape      = true;
        $group       = false;
        $item        = array();
        $attribute   = array();
        foreach($params as $_key=>$_val){
            switch($_key){
                case 'item':
                    $$_key = (array)$_val;
                    unset($params[$_key]);
                    break;
                case 'name':
                case 'kana':
                case 'selected':
                case 'label':
                case 'value':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
                case 'escape':
                case 'group':
                    $$_key = (bool)$_val;
                    unset($params[$_key]);
                    break;
            }
        }
        
        //準備
        $params['name'] = $name;
        
        //生成
        $select   = array();
        $select[] = $this->_makeTag('select', $params, '', false, false);
        foreach($item as $_key => $_val){
            if($group){
                if($_key) $select[] = $this->_makeTag('optgroup', array('label' => htmlspecialchars($_key)), '', false, false);
                foreach($_val as $_key2 => $_val2){
                    if($selected == $_val2[$value]){
                        $select[] = $this->_makeTag('option', array('selected', 'value' => htmlspecialchars($_val2[$value])), $_val2[$label], $escape);
                    } else {
                        $select[] = $this->_makeTag('option', array('value' => htmlspecialchars($_val2[$value])), $_val2[$label], $escape);
                    }
                }
                if($_key) $select[] = '</optgroup>';
            } else {
                $_value = $value && isset($_val[$value]) ? $_val[$value] : $_key;
                $_label = $label && isset($_val[$label]) ? $_val[$label] : $_val;
                if($selected == $_value){
                    $select[] = $this->_makeTag('option', array('selected', 'value' => htmlspecialchars($_value)), $_label, $escape);
                } else {
                    $select[] = $this->_makeTag('option', array('value' => htmlspecialchars($_value)), $_label, $escape);
                }
            }
        }
        $select[] = '</select>';
        
        $select = join("\r\n", $select);
        return $select;
    }
    
    
    /**
     * テキストエリア。
     * @access     public
     * @since      1.0.0
     * @param      string  $params['name']
     * @param      string  $params['value']
     * @param      int     $params['width']
     * @param      int     $params['height']
     * @return     string  テキストエリアタグ
     */
    function textarea($params){
        $name      = 'textarea';
        $value     = '';
        $width     = NULL;
        $height    = NULL;
        $istyle    = 'hira';
        foreach($params as $_key=>$_val){
            switch($_key){
                case 'name':
                case 'value':
                case 'istyle':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
                case 'width':
                case 'height':
                    $$_key = (int)$_val;
                    unset($params[$_key]);
                    break;
            }
        }
        
        //準備
        $params['name'] = $name;
        if($width!==NULL)  $params['cols'] = $width;
        if($height!==NULL) $params['rows'] = $height;
        if(!isset($params['class']) && $name) $params['class'] = $name;
        if($istyle){
            if($this->Device->i){
                if($istyle=='hira') $params['istyle'] = '1';
                if($istyle=='kana') $params['istyle'] = '2';
                if($istyle=='eiji') $params['istyle'] = '3';
                if($istyle=='suji') $params['istyle'] = '4';
            } elseif($this->Device->v){
                if($istyle=='hira') $params['istyle'] = '1';
                if($istyle=='kana') $params['istyle'] = '2';
                if($istyle=='eiji') $params['istyle'] = '3';
                if($istyle=='suji') $params['istyle'] = '4';
            } elseif($this->Device->ez){
                if($istyle=='hira') $params['istyle'] = '1';
                if($istyle=='kana') $params['istyle'] = '2';
                if($istyle=='eiji') $params['istyle'] = '3';
                if($istyle=='suji') $params['istyle'] = '4';
            } else {
                if(isset($params['style'])) $params['style'] = (array)$params['style'];
                if($istyle=='hira') $params['style'][] = 'ime-mode:active;';
                if($istyle=='kana') $params['style'][] = 'ime-mode:active;';
                if($istyle=='eiji') $params['style'][] = 'ime-mode:inactive;';
                if($istyle=='suji') $params['style'][] = 'ime-mode:inactive;';
            }
        }
        
        //生成
        return $this->_makeTag('textarea', $params, $value, true);
    }
    
    
    /**
     * BUTTON
     */
    public function button($params=array()){
        $value = '';
        $href  = '';
        foreach($params as $_key=>$_val){
            switch($_key){
                case 'value':
                case 'href':
                    $$_key = (string)$_val;
                    unset($params[$_key]);
                    break;
            }
        }
        if($href){
            $href = $this->isAbsolutePath($href, false) ? $this->prefix.$href : $href ;
            if(isset($params['onClick'])) $params['onClick'] = array();
            $params['onClick'][] = "location.href='{$href}';return false;";
        }
        return $this->_makeTag('button', $params, $value, true);
    }
    
    
    
    
    
    /**
     * アイコンの挿入。
     * @access     public
     */
    public function icon($params=array()){
        $name     = '';
        $base_url = IMAGE_URL;
        $path     = '/_common/icon';
        foreach($params as $_key => $_val){
            switch($_key){
                case 'name':
                case 'base_url':
                case 'path':
                    $$_key = (string)$_val; break;
            }
        }
        $src = "{$base_url}{$path}/{$name}.png";
        $params = array('src' => $src, 'class'=>'icon');
        return $this->_makeTag('img', $params, NULL);
    }
    /**
     * スペーサーGIFの挿入。
     * $this->spacer_urlを指定してあげる必要がある。
     * @access     public
     */
    public function spacer($params=array()){
        $width  = 1;
        $height = 1;
        foreach($params as $_key=>$_val){
            switch($_key){
                case 'width':
                case 'height':
                    $$_key = (int)$_val; break;
            }
        }
        $params['width']  = $width;
        $params['height'] = $height;
        $params['src']    = $this->spacer_url;
        return $this->_makeTag('img', $params, NULL);
    }
    
    
    
    
    
    /**
     * argsの追加
     * @access     public
     * @param      string  $key     キー
     * @param      mixed   $value   値
     */
    public function setArg($key, $value)
    {
        $this->args[$key] = $value;
    }
    /**
     * argsの削除
     * @access     public
     * @param      string  $key   キー
     */
    public function delArg($key)
    {
        if(isset($this->args[$key])) unset($this->args[$key]);
    }
    
    
    
    
    
    /**
     * CSSのロード
     * @access     public
     * @param      array   $params
     * @return     string  CSSを読み込むタグ
     */
    public function load($params=array())
    {
        $file = '';
        $type = '';
        extract($params);
        $files = preg_split('/\s*,\s*/', $file);
        $tags = array();
        foreach($files as $file){
            //URLで指定されていない場合はURLの補完
            if(!preg_match('#^(https?|shttp)://#', $file)){
                if($type == 'css' && defined('CSS_URL')){
                    $file = CSS_URL . $file;
                }
                elseif($type == 'javascript' && defined('JS_URL')){
                    $file = JS_URL . $file;
                }
            }
            if($this->isAbsolutePath($file, false)) $file = $this->prefix . $file;
            //読込
            if($type == 'css'){
                $tags[] = $this->_makeTag('link', array('rel' => 'stylesheet', 'href' => $file, 'type' => 'text/css'), NULL);
            }
            elseif($type == 'javascript'){
                $tags[] = $this->_makeTag('script', array('src' => $file, 'type' => 'text/javascript'));
            }
        }
        return join("\r\n", $tags);
    }
    
    
    
    
    
    /**
     * タグを吐くためだけの関数。
     * このクラスのほとんどの関数はこの関数のエイリアスとして動作すべきである。
     * @access     private
     * @param      string  $tag_name     タグの名前
     * @param      array   $attributes   属性
     * @param      string  $inner_html   内容
     * @param      boolean $escape       内容をエスケープするかどうか
     * @param      string  $kana         内容をmb_convert_kanaするかどうかのオプション
     * @param      boolean $close        閉じタグか必要かどうか、また閉じないかどうか。NULLの場合はそもそも閉じタグが必要ない場合(hrやbrなど)
     */
    public function _makeTag($tag_name, $attributes=array(), $inner_html='', $escape=true, $close=true){
        //属性の整理
        $array_attribute = array('style','onClick','onMouseOver','onMouseOut','onChange');
        foreach($attributes as $_key => $_val){
            if(!is_numeric($_key) && in_array($_key, $array_attribute)){
                $attributes[$_key] = sprintf('%s="%s"', $_key, join(';', (array)$_val));
            } else {
                if(is_numeric($_key)){
                    $attributes[$_key] = sprintf('%s', htmlspecialchars((string)$_val));
                } else {
                    $attributes[$_key] = sprintf('%s="%s"', $_key, htmlspecialchars((string)$_val));
                }
            }
        }
        //内容の整理
        if($this->kana){
            $inner_html = mb_convert_kana($inner_html, $this->kana);
            if(isset($attributes['title'])) mb_convert_kana($attributes['title'], $this->kana);
        }
        if($inner_html === NULL){
            $close = NULL;
            $inner_html = '';
        }
        if($escape) $inner_html = htmlspecialchars($inner_html, ENT_QUOTES);
        //タグの生成
        $tag  = '<' . $tag_name;
        $tag .= $attributes ? ' '.join(' ', $attributes) : '' ;
        $tag .= $close === NULL ? ' />' : '>' ;
        $tag .= $inner_html;
        $tag .= $close === true ? '</' . $tag_name . '>' :  '' ;
        return $tag;
    }
    
    
    /**
     * 配列を指定のinputで展開する。
     * @access     private
     */
    function _array2input($key, $value, $type='hidden'){
        $inputs = array();
        if(is_array($value)){
            foreach($value as $_key => $_val){
                $new_key = sprintf('%s[%s]', $key, $_key);
                $inputs[] = $this->_array2input($new_key, $_val, $type);
            }
        } else {
            $inputs[] = $this->input(array('name'=>$key, 'value'=>$value, 'type'=>$type));
        }
        return join("\r\n", $inputs);
    }
    
    
    
    
    
    /**
     * 絶対パスかどうか判断する
     * @access     public
     * @param      string  $url
     * @param      boolean $within_protocol
     * @return     boolean
     */
    public function isAbsolutePath($url, $within_protocol=true)
    {
        return preg_match('|^/|', $url) || ( $within_protocol && preg_match('|^[a-z]+://|', $url) );
    }
}
