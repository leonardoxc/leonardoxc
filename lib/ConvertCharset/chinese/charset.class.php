<?php
/**
 * 最后更新于 2007-11-21 4:43 By muqiao
 * @author muqiao
 * 说明:
 * unescape escape big2gb(gb转big时 在big中不含的字变为?) 该三方法偶自己原创
 * chs2utf8 utf82chs在原基础上改进了算法 原方法来源忘了
 * jsonencode 有参考Services_JSON 但有很大区别 此处可以将utf-8 gb2312 big5都可以jsonencode
 * jsondecode 自己原创 该算法是模拟目录读取的方法 
 *   可以将json中中文unicode编码unescape为gbk big5 utf8 
 *   把array转化为object还不是小case? 所以这里没有decode为object的
 *   不过还有一些不可预料的错误 
 */
define('TABLE_DIR',dirname(__FILE__).'/table');
define('USEEXISTS',FALSE);//是否使用系统存在的php内置编码转换函数
//其实php内置编码转换函数转换的不够好
class Charset{
	
	private static $target_lang,$source_lang;
	protected static $string = '';
	protected static $table = NULL;
	
	/**
	 * 编码互换
	 *
	 * @param string $source
	 * @param string $source_lang  输入编码 'utf-8' or 'gb2312' or 'big5'
	 * @param string $target_lang  输出编码 'utf-8' or 'gb2312' or 'big5'
	 * @return string
	 */
	static public function convert($source,$source_lang,$target_lang='utf-8'){
		if($source_lang != ''){
			$source_lang = str_replace(
				array('gbk','utf8','big-5'),
				array('gb2312','utf-8','big5'),
				strtolower($source_lang)
			);
		}
		if($target_lang != ''){
			$target_lang = str_replace(
				array('gbk','utf8','big-5'),
				array('gb2312','utf-8','big5'),
				strtolower($target_lang)
			);
		}
		if($source_lang == $target_lang||$source == ''){
			return $source;
		}
		$index = $source_lang."_".$target_lang;
		if(USEEXISTS&&!in_array($index,array('gb2312_big5','big5_gb2312'))){//繁简互换并不是交换字符集编码 
			if(function_exists('iconv')){
				return iconv($source_lang,$target_lang,$source);
			}
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding($source,$target_lang,$source_lang);
			}
		}
		$table = self::loadtable($index);
		if(!$table){
			return $source;
		}
		self::$string = $source;
		self::$source_lang = $source_lang;
		self::$target_lang = $target_lang;
		if($source_lang=='gb2312'||$source_lang=='big5'){
			if($target_lang=='utf-8'){
				self::$table = $table;
				return self::CHS2UTF8();
			}
			if($target_lang=='gb2312'){
				self::$table = array_flip($table);
			}else{
				self::$table = $table;
			}
			return self::BIG2GB();
		}elseif(self::$source_lang=='utf-8'){
			self::$table = array_flip($table);
			return self::UTF82CHS();
		}
		return NULL;
	}
	/**
	 * js 中的unescape功能
	 * 
	 * @param string $str       源字符串
	 * @param string $charset   目标字符串编码 'utf-8' or 'gb2312' or 'big5'
	 * @return string
	 */
	static public function unescape($str,$charset='utf-8'){
		$charset = strtolower($charset);
		self::$target_lang = str_replace(
			array('gbk','utf8','big-5'),
			array('gb2312','utf-8','big5'),
			$charset
		);
		if(self::$target_lang!='utf-8'&&
			!(USEEXISTS&&(function_exists('mb_convert_encoding')||function_exists('iconv')))
		){
			self::$table = array_flip(self::loadtable('unescapeto'.$charset));
		}
		$str = strtr($str,
			array('\\"' => '"','\\\\'=> '\\','\\/'=> '/','\\b' => chr(8),
				'\\f'=>chr(12),'\\r'=> chr(13),'\\t'=>chr(9),
				'%20'=>' '
			)
		);
		return preg_replace_callback('/[\\\\|%]u(\w{4})/iU',array('Charset','descape'),$str);
	}
	/**
	 * js 中的escape功能
	 * 
	 * @param string $str       源字符串
	 * @param string $charset   源字符串编码 'utf-8' or 'gb2312' or 'big5'
	 * @return string
	 */
	static public function escape($str,$charset='utf-8'){
		$escaped = '';
		$charset = strtolower($charset);
		$charset = str_replace(
			array('gbk','big-5','utf8'),
			array('gb2312','big5','utf-8'),
			$charset
		);
		$str = strtr($str,array("\r" => '\\r',"\n" => '\\n',"\t" => '\\t',"\b"  => '\\b',
			"\f" => '\\f',"\\" => '\\\\','"' => '\"',"\x08" => '\b',"\x0c" => '\f'," "=>'%20')
		);
		$ulen = strlen($str);
		if($charset!='utf-8'){
			$table = self::loadtable($charset.'escape');
			for($i=0;$i<$ulen;$i++){
				$c = $str[$i];
				if(ord($c)>0x80){
					$bin = $c.$str[$i+1];
					$i += 1;
					$escaped .= sprintf('\u%04X',$table[hexdec(bin2hex($bin))]);
					// bin2hex 返回的是string 必须再转化
				}else{
					$escaped .= $c;
				}
			}
			return $escaped;
		}else{
			for($i=0;$i<$ulen;$i++){
				$c = $str[$i];
				$char = ord($c);
				switch ($char>>4){
					case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
						$escaped .= $c;
						break;
					case 12: case 13:
						$char = ((($char&0x1F)<<6)|(ord($str[++$i])&0x3F));
						$escaped .= sprintf('\u%04X',$char);
						break;
					case 14:
						$char = ((($char&0x0F)<<12)|((ord($str[++$i])&0x3F)<<6)|(ord($str[++$i])&0x3F));
						$escaped .= sprintf('\u%04X',$char);
						break;
					default:$escaped .= $c;break;
				}
			}
			return $escaped;
		}
	}
	/**
	 * json_decode
	 * 
	 * @param string $encoded   源字符串
	 * @param string $charset   目标字符串编码 'utf-8' or 'gb2312' or 'big5'
	 * @return string/array/boolean/null
	 */ 
	static public function jsondecode($encoded,$charset='utf-8'){
		$encoded = preg_replace(array('/([\t\b\f\n\r ])*/s','#^\s*//(.+)$#m','#^\s*/\*(.+)\*/#Us','#/\*(.+)\*/\s*$#Us'),'',$encoded);//eat whitespace and comments
		self::$target_lang = $charset;
		$c = self::cursor($encoded);
		switch($c){
			case '{':return self::parseArray($encoded);
			case '[':return self::parseArray($encoded,FALSE);
			case '"':return self::string_find($encoded);
			case 't':return TRUE;
			case 'f':return FALSE;
			case 'n':return NULL;
			default:return self::num_read($c.$encoded);
		}
	}
	/**
	 * json_encode
	 * 
	 * @param mixvar $var       多类型变量
	 * @param string $charset   默认'utf-8'源变量中字符编码 'utf-8' or 'gb2312' or 'big5'
	 * @return string
	 */
	static public function jsonencode($var,$charset=NULL){
		if(is_null($charset)){
			$charset = self::$source_lang;
		}else{
			self::$source_lang = $charset;
		}
		if(!$charset){
			$charset = 'utf-8';
		}
		switch (gettype($var)){
			case 'boolean':
				return $var ? 'true' : 'false';
			case 'NULL':
				return 'null';
			case 'integer':
				return (int) $var;
			case 'double':
			case 'float':
				return (float) $var;
			case 'string':
				$var = self::escape($var,$charset);
				return '"'.$var.'"';
			case 'array':
				return self::encodearray($var);
			case 'object':
				$var = get_object_vars($var);
				return self::encodearray($var);
			default:return 'null';
		}
	}
	/**
	 * 汉字拼音
	 *
	 * @param string $str
	 * @param string $charset     输入编码 'utf-8' or 'gb2312' or 'big5'
	 * @return string
	 */
	static public function PinYin($str,$charset='utf-8'){
		if($charset!='gb2312'){
			$str = self::convert($str,$charset,'gb2312');
		}
		self::$table = include(TABLE_DIR.'/pinyin.php');
		$gblen = strlen($str);
		$pin = '';
		for($i=0;$i<$gblen;$i++){
			$c = ord($str[$i]);
			if($c > 0x00A0){
				$index = 0x10000-($c*0x0100 + ord($str[++$i]));
				$pin .= self::getPinYin($index);
			}else{
				$pin .= $str[$i];
			}
		}
		return trim($pin);
	}
	static protected function getPinYin($index){
		if($index==0x1534) return 'yan';
		if($index>0x4F5F||$index<0x2807){
			return '';
		}
		if(!self::$table){
			return '';
		}
		while(true){
			if(!isset(self::$table[$index])){
				$index += 1;
				if($index > 0x4F5F){
					return '';
				}
				continue;
			}else{
				return self::$table[$index];
			}
		}
		return '';
	}
	static protected function loadtable($index){
		static $table = array();
		$tabIndex = '';
		switch ($index) {
			case 'gb2312_utf-8':
			case 'utf-8_gb2312':
			case 'gb2312escape':
			case 'unescapetogb2312':
				$tabIndex = 'gbkutf';
				break;
			case 'big5_utf-8':
			case 'utf-8_big5':
			case 'big5escape':
			case 'unescapetobig5':
				$tabIndex = 'big5utf';
				break;
			case 'gb2312_big5':
			case 'big5_gb2312':
				$tabIndex = 'gbkbig5';
				break;
			default:return NULL;
		}
		if(!isset($table[$tabIndex])){
			$table[$tabIndex] = include(TABLE_DIR."/".$tabIndex.".php");
		}
		return $table[$tabIndex];
	}
	static protected function descape($str){
		$dec = hexdec($str[1]);
		$str = self::u2utf8($dec);
		if(self::$target_lang == 'utf-8'){
			return $str;
		}
		if(USEEXISTS){
			if(function_exists('iconv')){
				return iconv('utf-8',self::$target_lang,$str);
			}
			if(function_exists('mb_convert_encoding')){
				return mb_convert_encoding($str,self::$target_lang,'utf-8');
			}
		}
		if(isset(self::$table[$dec])){
			return self::hex2bin(dechex(self::$table[$dec]));
		}else{
			return "&#".$dec.";";
		}
	}
	static protected function parseArray(&$str,$index=TRUE){
		$result = array();
		$fp = self::array_open($index,$str);//模拟打开目录
		while($fp){
			$type = '';
			$key = '';
			$value = self::array_read($fp,$type,$index,$key);//模拟读取目录
			if($type=='{'){
				if($index){
					$result[$key] = self::parseArray($fp);//递归
				}else{
					$result[] = self::parseArray($fp);
				}
			}elseif($type=='['){
				if($index){
					$result[$key] = self::parseArray($fp,FALSE);
				}else{
					$result[] = self::parseArray($fp,FALSE);
				}
			}else{
				if($index){
					$result[$key] = $value;
				}else{
					$result[] = $value;
				}
			}
		}
		return $result;
	}
	static protected function array_open($index=TRUE,&$string){
		if($index){
			$end = '}';
			$new = '{';
		}else{
			$end = ']';
			$new = '[';
		}
		$endpos = self::getpos($string,$end);
		//用getpos获得$endpos 因为要判断{,},[,]是不是在字符串里面
		$newpos = self::getpos($string,$new);
		$fp = '';
		if($endpos===FALSE){
			return 'null';
		}elseif($newpos===FALSE||$newpos>$endpos){
			$fp = substr($string,0,$endpos);
			$string = substr($string,$endpos+1);
			return $fp;
		}else{// 条件'if($newpos<$endpos)'可以不要了 找到与自己匹对结束符
			$i = 1;
			while($i){
				$endpos = self::getpos($string,$end,$endpos+1);
				$newpos = self::getpos($string,$new,$endpos+1);
				if($endpos===FALSE){
					return 'null';
				}elseif($newpos===FALSE){
					$i-=1;
					continue;
				}elseif($newpos<$endpos){
					$i+=1;
					continue;
				}else{
					continue;
				}
			}
			$fp = substr($string,0,$endpos);
			$string = substr($string,$endpos+1);
			return $fp;
		}
	}
	static protected function getpos($string,$sign,$offset=0){
		/**
		 * 判断是否在字符串里面原理:
		 * 取得$offset到$pos($sign)位置之间字符串中'"'个数
		 * 如果为奇数说明在字符串里面 否则在字符串外面
		 */
		$pos = strpos($string,$sign,$offset);
		if($pos===FALSE){
			return FALSE;
		}
		$str = substr($string,$offset,$pos-$offset);
		$in = substr_count(str_replace('\"','',$str),'"')%2;
		if(!$in){
			return $pos;
		}
		do{
			$next = strpos($string,$sign,$pos+1);
			if($next===FALSE){
				return FALSE;
			}
			$str = substr($string,$pos,$next-$pos);
			$in = !(substr_count(str_replace('\"','',$str),'"')%2);
			$pos = $next;
		}while($in);
		return $pos;
	}
	static protected function array_read(&$fp,&$type,$index=TRUE,&$key=null){
		if($fp[0]==','){
			self::cursor($fp);//跳过','
		}
		if($index){//有索引的数组 
			self::cursor($fp);//跳过 '"'合法
			$key = self::string_find($fp);//读取索引值
			self::cursor($fp);//跳过':'
		}
		$c = self::cursor($fp);
		switch($c){
			case '{':
				$type='{';
				return NULL;
			case '[':
				$type='[';
				return NULL;
			case '"':
				$rs = self::string_find($fp);
				$s = self::cursor($fp);//跳过','or '}' or ']' 要求合法
				if(!($s==','||$s==null)){
					die('parse error1!');
				}
				return $rs;
			case 't':
				if(self::cursor($fp,3)=='rue'){//跳过'rue'
					$s = self::cursor($fp);//跳过','or '}' or ']' 要求合法
					if(!($s==','||$s==null)){
						die("parse error$s!");
					}
					return TRUE;
				}else{
					die('parse error3!');
				}
			case 'f':
				if(self::cursor($fp,4)=='alse'){
					$s = self::cursor($fp);//跳过','or '}' or ']' 要求合法
					if(!($s==','||$s==null)){
						die('parse error4!');
					}
					return FALSE;
				}else{
					die('parse error5!');
				}
			case 'n':
				if(self::cursor($fp,3)=='ull'){//跳过'ull'
					$s = self::cursor($fp);//跳过','or '}' or ']' 要求合法
					if(!($s==','||$s==null)){
						die('parse error6!');
					}
					return NULL;
				}else{
					die('parse error7!');
				}
			default:
				$pos = strpos($fp,',');
				if($pos===FALSE){
					$num = substr($fp,0);
					$fp = '';
				}else{
					$num = substr($fp,0,$pos);
					$fp = substr($fp,$pos+1);
				}
				return self::num_read($c.$num);
		}
	}
	static protected function string_find(&$str){
		$end = strpos($str,'"',0);
		while($str[$end-1]=='\\'){
			$end = strpos($str,'"',$end+1);
			if($end===FALSE){
				return 'null';
			}
		}
		return self::unescape(substr(self::cursor($str,$end+1),0,-1),self::$target_lang);
	}
	static protected function num_read($str){
		$matches = array();
		if (preg_match('/-?([0-9])*(\.[0-9]*)?((e|E)((-|\+)?)[0-9]+)?/s',$str,$matches)){
			$num = $matches[0];
			$val   = intval($num);
			$fval  = floatval($num);
			$value = $val?$val:$fval;
			return $value;
		}else{
			return NULL;
		}
	}
	static protected function cursor(&$str,$shift=1){
		$get = substr($str,0,$shift);
		$str = substr($str,$shift);
		return $get;
	}
	static protected function encodearray($array){
		if(!$array){
			return 'null';
		}
		if((array_keys($array)!==range(0,sizeof($array)- 1))){
			$rs = '';
			foreach($array as $key=>$value){
				$rs .= ','.self::jsonencode(strval($key)).':';
				if(is_array($value)){
					$rs .= self::encodearray($value);
				}else{
					$rs .= self::jsonencode($value);
				}
			}
			$rs = '{'.ltrim($rs,',').'}';
			return $rs;
		}else{
			$rs = '';
			foreach($array as $value){
				if(is_array($value)){
					$rs .= ','.self::encodearray($value);
				}else{
					$rs .= ','.self::jsonencode($value);
				}
			}
			$rs = '['.ltrim($rs,',').']';
			return $rs;
		}
	}
	static protected function CHS2UTF8(){
		$utf8 = "";
		while(self::$string){
			if (ord(self::$string[0]) > 0x80){
				$bin = substr(self::$string,0,2);
				$utf8 .= self::u2utf8(self::$table[hexdec(bin2hex($bin))]);
				self::$string = substr(self::$string,2);
			}else{
				$utf8 .= self::$string[0];
				self::$string = substr(self::$string,1);
			}
		}
		return $utf8;
	}
	static protected function UTF82CHS(){
		$chs  = "";
		$ulen = strlen(self::$string);
		for($i=0;$i<$ulen;$i++){
			$c = self::$string[$i];
			$char = ord($c);
			switch ($char>>4){
				case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
					$chs .= $c;
					break;
				case 12: case 13:
					$char = self::$table[(($char&0x1F)<<6)|(ord(self::$string[++$i])&0x3F)];
					$chs .= self::hex2bin(dechex($char));
					break;
				case 14:
					$char = self::$table[
						(($char&0x0F)<<12)
						|((ord(self::$string[++$i])&0x3F)<<6)
						|(ord(self::$string[++$i])& 0x3F)
					];
					$chs .= self::hex2bin(dechex($char));
					break;
				default:$chs .= $c;break;
			}
		}
		return trim($chs);
	}
	static protected function BIG2GB(){
		$ret = '';
		while(self::$string){
			if(ord(self::$string[0]) > 0x80){
				$index = hexdec(bin2hex(self::$string[0].self::$string[1]));
				$value = self::$table[$index];
				$ret .= self::hex2bin(dechex($value));
				self::$string = substr(self::$string,2);
			}else{
				$ret .= self::$string[0];
				self::$string = substr(self::$string,1);
			}
		}
		return $ret;
	}
	static protected function u2utf8($c){
		$str = '';
		if($c < 0x80){
			$str.= chr($c);
		}elseif($c < 0x800){
			$str.= chr(0xC0 | $c>>6);
			$str.= chr(0x80 | $c & 0x3F);
		}elseif($c < 0x10000){
			$str.= chr(0xE0 | $c>>12);
			$str.= chr(0x80 | $c>>6 & 0x3F);
			$str.= chr(0x80 | $c & 0x3F);
		}elseif($c < 0x200000){
			$str.= chr(0xF0 | $c>>18);
			$str.= chr(0x80 | $c>>12 & 0x3F);
			$str.= chr(0x80 | $c>>6 & 0x3F);
			$str.= chr(0x80 | $c & 0x3F);
		}
		return $str;
    }
	static protected function hex2bin($hexdata){
		$bindata = '';
		for ($i = 0, $count = strlen($hexdata); $i < $count; $i += 2){
			$bindata .= chr(hexdec($hexdata[$i].$hexdata[$i + 1]));
		}
		return $bindata;
    }
}
//exam
//$str = '{"obj":["\"]]]]","["]}';
//echo Charset::jsonencode(array('你好'=>'这是encoded的汉字','2'=>array('[][]','""""','  {}  ')));
//$str = '{"\u4F60\u597D":"\u8FD9\u662Fencoded\u7684\u6C49\u5B57","2":["[][]","\"\"\"\"ll\"","%20%20{}%20%20"]}';
//print_r(Charset::jsondecode($str));
?>