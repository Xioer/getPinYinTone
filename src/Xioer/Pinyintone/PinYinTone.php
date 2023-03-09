<?php
namespace Xioer\Pinyintone;

class PinyinTone{
     
    protected $pinyin = [
        'a' => ['a','ā','á','ǎ','à'],
        'e' => ['e','ē','é','ě','è'],
        'i' => ['i','ī','í','ǐ','ì'],
        'o' => ['o','ō','ó','ǒ','ò'],
        'u' => ['u','ū','ú','ǔ','ù'],
        'v' => ['ü','ǖ','ǘ','ǚ','ǜ']
    ];

    public function getPinYin($str)
    {
        $arr = explode(' ', $str);
        $msg = "";
        foreach($arr as &$value){
            $msg.= $this->get_pin_yin($value).' ';
        }
        return $msg;
    }

    /**没有a 找oe iuv并列标最后 */
    private function get_pin_yin($str){
        // global $pinyin;
        $last = intval(substr($str,-1));
        // print_r($str);exit;
        
        if(strstr($str,'a')){
            $replace_char = $this->pinyin['a'][$last];
            // print_r($replace_char);exit;
            $str = str_replace('a',$replace_char,$str);
            $str = substr($str,0,strlen($str)-1);
        }elseif(strstr($str,'o')){
            $replace_char = $this->pinyin['o'][$last];
            $str = str_replace('o',$replace_char,$str);
            $str = substr($str,0,strlen($str)-1);
        }elseif(strstr($str,'e')){
            $replace_char = $this->pinyin['e'][$last];
            $str = str_replace('e',$replace_char,$str);
            $str = substr($str,0,strlen($str)-1);
        }else{
            $iuv = 'iuv';
            $arr_str = str_split($str);
            //数组倒序
            $arr_str = array_reverse($arr_str);
            //查找第一个符合iuv的字符
            foreach($arr_str as $v){
                if(strpos($iuv,$v) !== false){
                    //找到第一个包含iuv的字符并且替换
                    $str = substr($str,0,strlen($str)-1);
                    $replace_char = $this->pinyin[$v][$last];
                    $str = str_replace($v,$replace_char,$str);
                    break;
                }
            }
        }
        return $str;
    }
}