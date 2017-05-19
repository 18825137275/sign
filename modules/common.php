<?php
use think\Db;

/**
 * 清空缓存
 */
function clear_cache() {
	
	$path=ROOT_PATH.'runtime/';
	
    $dirs = array();
    $noneed_clear = array(".", "..");
    $rootdirs = array_diff(scandir($path), $noneed_clear);
    foreach ($rootdirs as $dir) {
        if ($dir != "." && $dir != "..") {
            $dir = $path . $dir;
            if (is_dir($dir)) {
                array_push($dirs, $dir);
                $tmprootdirs = scandir($dir);
                foreach ($tmprootdirs as $tdir) {
                    if ($tdir != "." && $tdir != "..") {
                        $tdir = $dir . '/' . $tdir;
                        if (is_dir($tdir)) {
                            array_push($dirs, $tdir);
                        }
                    }
                }
            }
        }
    }
    $dirtool = new \oscshop\Dir();
    foreach ($dirs as $dir) {
        $dirtool->del($dir);
    }
}

//生成唯一订单号
function build_order_no(){
    return date('Ymd').substr(implode(NULL, array_map('ord', str_split(substr(uniqid(), 7, 13), 1))), 0, 8);
}

/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function data_auth_sign($data) {
	//数据类型检测
	if(!is_array($data)){
		$data = (array)$data;
	}
	ksort($data); //排序
	$code = http_build_query($data); //url编码并生成query字符串
	$sign = sha1($code); //生成签名
	return $sign;
}

/**
 * 读取模块配置
 * @param string $module module
 * @return array 
 */
function module_config($module){
	$list=Db::name('config')->where('module',$module)->select();
	$config=[];
	foreach ($list as $k => $v) {
		$config[$v['name']]=$v['value'];
	}
	return $config;
}

/**
 * 系统加密方法
 * @param string $data 要加密的字符串
 * @param string $key  加密密钥
 * @param int $expire  过期时间 (单位:秒)
 * @return string 
 */
function think_ucenter_encrypt($data, $key, $expire = 0) {
	$key  = md5($key);
	$data = base64_encode($data);
	$x    = 0;
	$len  = strlen($data);
	$l    = strlen($key);
	$char =  '';
	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x=0;
		$char  .= substr($key, $x, 1);
		$x++;
	}
	$str = sprintf('%010d', $expire ? $expire + time() : 0);
	for ($i = 0; $i < $len; $i++) {
		$str .= chr(ord(substr($data,$i,1)) + (ord(substr($char,$i,1)))%256);
	}
	return str_replace('=', '', base64_encode($str));
}

/**
 * 系统解密方法
 * @param string $data 要解密的字符串 （必须是think_encrypt方法加密的字符串）
 * @param string $key  加密密钥
 * @return string 
 */
function think_ucenter_decrypt($data, $key){
	$key    = md5($key);
	$x      = 0;
	$data   = base64_decode($data);
	$expire = substr($data, 0, 10);
	$data   = substr($data, 10);
	if($expire > 0 && $expire < time()) {
		return '';
	}
	$len  = strlen($data);
	$l    = strlen($key);
	$char = $str = '';
	for ($i = 0; $i < $len; $i++) {
		if ($x == $l) $x = 0;
		$char  .= substr($key, $x, 1);
		$x++;
	}
	for ($i = 0; $i < $len; $i++) {
		if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1))) {
			$str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
		}else{
			$str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
		}
	}
	return base64_decode($str);
}

/**
 * 保存用户行为，前台用户和后台用户
 * @param int $uid 用户id
 * @param string $name 用户名
 * @param string $type config('FRONTEND_USER')/config('BACKEND_USER')
 * @param string $info 行为描述
 */
function storage_user_action($uid,$name,$type,$info){
	if(config('storage_user_action')==true){
		Db::name('user_action')->insert([
		'type'=>$type,
		'user_id'=>$uid,
		'uname'=>$name,
		'add_time'=>date('Y-m-d H:i:s',time()),
		'info'=>$info]);
	}
}
/**
 * 获取客户端IP地址
 * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
 * @param boolean $adv 是否进行高级模式获取（有可能被伪装） 
 * @return mixed
 */
function get_client_ip($type = 0,$adv=false) {
    $type       =  $type ? 1 : 0;
    static $ip  =   NULL;
    if ($ip !== NULL) return $ip[$type];
    if($adv){
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            $pos    =   array_search('unknown',$arr);
            if(false !== $pos) unset($arr[$pos]);
            $ip     =   trim($arr[0]);
        }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
            $ip     =   $_SERVER['HTTP_CLIENT_IP'];
        }elseif (isset($_SERVER['REMOTE_ADDR'])) {
            $ip     =   $_SERVER['REMOTE_ADDR'];
        }
    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
        $ip     =   $_SERVER['REMOTE_ADDR'];
    }
    // IP地址合法验证
    $long = sprintf("%u",ip2long($ip));
    $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
    return $ip[$type];
}

/**
 * 把返回的数据集转换成Tree
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = 'children', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}
//字符串长度计算
function utf8_strlen($string) {
	return strlen(utf8_decode($string));
}

function utf8_strrpos($string, $needle, $offset = null) {
	if (is_null($offset)) {
		$data = explode($needle, $string);

		if (count($data) > 1) {
			array_pop($data);

			$string = join($needle, $data);

			return utf8_strlen($string);
		}

		return false;
	} else {
		if (!is_int($offset)) {
			trigger_error('utf8_strrpos expects parameter 3 to be long', E_USER_WARNING);

			return false;
		}

		$string = utf8_substr($string, $offset);

		if (false !== ($position = utf8_strrpos($string, $needle))) {
			return $position + $offset;
		}

		return false;
	}
}
//字符串截取
function utf8_substr($string, $offset, $length = null) {
	// generates E_NOTICE
	// for PHP4 objects, but not PHP5 objects
	$string = (string)$string;
	$offset = (int)$offset;

	if (!is_null($length)) {
		$length = (int)$length;
	}

	// handle trivial cases
	if ($length === 0) {
		return '';
	}

	if ($offset < 0 && $length < 0 && $length < $offset) {
		return '';
	}

	// normalise negative offsets (we could use a tail
	// anchored pattern, but they are horribly slow!)
	if ($offset < 0) {
		$strlen = strlen(utf8_decode($string));
		$offset = $strlen + $offset;

		if ($offset < 0) {
			$offset = 0;
		}
	}

	$Op = '';
	$Lp = '';

	// establish a pattern for offset, a
	// non-captured group equal in length to offset
	if ($offset > 0) {
		$Ox = (int)($offset / 65535);
		$Oy = $offset%65535;

		if ($Ox) {
			$Op = '(?:.{65535}){' . $Ox . '}';
		}

		$Op = '^(?:' . $Op . '.{' . $Oy . '})';
	} else {
		$Op = '^';
	}

	// establish a pattern for length
	if (is_null($length)) {
		$Lp = '(.*)$';
	} else {
		if (!isset($strlen)) {
			$strlen = strlen(utf8_decode($string));
		}

		// another trivial case
		if ($offset > $strlen) {
			return '';
		}

		if ($length > 0) {
			$length = min($strlen - $offset, $length);

			$Lx = (int)($length / 65535);
			$Ly = $length % 65535;

			// negative length requires a captured group
			// of length characters
			if ($Lx) {
				$Lp = '(?:.{65535}){' . $Lx . '}';
			}

			$Lp = '(' . $Lp . '.{' . $Ly . '})';
		} elseif ($length < 0) {
			if ($length < ($offset - $strlen)) {
				return '';
			}

			$Lx = (int)((-$length) / 65535);
			$Ly = (-$length)%65535;

			// negative length requires ... capture everything
			// except a group of  -length characters
			// anchored at the tail-end of the string
			if ($Lx) {
				$Lp = '(?:.{65535}){' . $Lx . '}';
			}

			$Lp = '(.*)(?:' . $Lp . '.{' . $Ly . '})$';
		}
	}

	if (!preg_match( '#' . $Op . $Lp . '#us', $string, $match)) {
		return '';
	}

	return $match[1];

}
/**
 * 自动生成新尺寸 的图片
 */
function resize($filename, $width, $height=null) {
		
	if (!is_file(DIR_IMAGE . $filename)) {
			return;
		}
		//如果没有填写高度，把高度等比例缩小
		if($height==null){
			
			$info = getimagesize(DIR_IMAGE . $filename);
			
			if($width>$info[0]){//如果缩小后宽度尺寸大于原图尺寸，使用原图尺寸
				$width=$info[0];
				$height=$info[1];
			}else{
				$height=$info[1]*($width/$info[0]);
			}
			
		}
		
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

		$old_image = $filename;
		$new_image = 'cache/' . utf8_substr($filename, 0, utf8_strrpos($filename, '.')) . '-' . $width . 'x' . $height . '.' . $extension;

		if (!is_file(DIR_IMAGE . $new_image) || (filectime(DIR_IMAGE . $old_image) > filectime(DIR_IMAGE . $new_image))) {
			$path = '';

			$directories = explode('/', dirname(str_replace('../', '', $new_image)));

			foreach ($directories as $directory) {
				$path = $path . '/' . $directory;

				if (!is_dir(DIR_IMAGE . $path)) {
					@mkdir(DIR_IMAGE . $path, 0777);
				}
			}

			list($width_orig, $height_orig) = getimagesize(DIR_IMAGE . $old_image);

			if ($width_orig != $width || $height_orig != $height) {
				$image = new \oscshop\Image(DIR_IMAGE . $old_image);
				$image->resize($width, $height);
				$image->save(DIR_IMAGE . $new_image);
			} else {
				copy(DIR_IMAGE . $old_image, DIR_IMAGE . $new_image);
			}
		}	
		
	return 'uploads/' . $new_image;
			
}

/**
 * 检查模块是否已经安装
 * @param type $moduleName 模块名称
 * @return boolean
 */
function is_module_install($moduleName) {
	
	//此处还需要判断模块依赖关系
	
	if (!$module = cache('module')) {
		
		$list=Db::name('module')->field('module')->where('disabled',1)->select();
		
		$m=[];
		
		foreach ($list as $k => $v) {
			$m[$v['module']]=$v;
		}
		cache('module', $m);	
		
		$module=$m;
	}
	
    if (isset($module[$moduleName])) {
        return true;
    }
    return false;
}

/**
 * 安全过滤函数
 *
 * @param $string
 * @return string
 */
function safe_replace($string) {
    $string = str_replace('%20','',$string);
    $string = str_replace('%27','',$string);
    $string = str_replace('%2527','',$string);
    $string = str_replace('*','',$string);
    $string = str_replace('"','&quot;',$string);
    $string = str_replace("'",'',$string);
    $string = str_replace('"','',$string);
    $string = str_replace(';','',$string);
    $string = str_replace('<','&lt;',$string);
    $string = str_replace('>','&gt;',$string);
    $string = str_replace("{",'',$string);
    $string = str_replace('}','',$string);
    $string = str_replace('\\','',$string);
    return $string;
}

function safe_filter($data){
	
	if(is_array($data)){
		foreach ($data as $k => $v) {
			$data[$k]=safe_replace($v);
		}
	}else{
		$data=safe_replace($data);
	}
	
	return $data;
}
