<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

use think\Db;

/**
 * 设置全局配置到文件
 *
 * 
 */
function sys_config_setbyarr($data)
{
    $file = './application/admin/config.php';
    if(file_exists($file)){
        $configs=include $file;
    }else {
        $configs=array();
    }
    $configs=array_merge($configs,$data);//array_merge — 合并一个或多个数组
    return file_put_contents($file, "<?php\treturn " . var_export($configs, true) . ";");//写入文件
	//var_export — 输出或返回一个变量的字符串表示
}

/**
 *
 *获取日志文件
 *
 */
 function list_file($filename,$pattern='*')
 {
	$patterns [0] = $pattern;
	$i=0;
	$dir=array();
	if(is_dir($filename))
	{
		$filename=rtrim($filename,'/').'/';
	}
	foreach($patterns as $v)
	{
		$list=glob($filename.$v);
		//$list=glob($list.'/'.$v);
		//var_dump($list);exit;
		if($list !== false){
			foreach($list as $file)
			{
				//echo $path;exit;
				//$dir[$i]=glob($path.'/'.$file);
				$dir [$i] ['filename'] = basename($file);
				$dir [$i] ['path'] = dirname($file);
				$dir [$i] ['pathname'] = realpath($file);
				$dir [$i] ['owner'] = fileowner($file);
				$dir [$i] ['perms'] = substr(base_convert(fileperms($file), 10, 8), -4);
				$dir [$i] ['atime'] = fileatime($file);
				$dir [$i] ['ctime'] = filectime($file);
				$dir [$i] ['mtime'] = filemtime($file);
				$dir [$i] ['size'] = filesize($file);
				$dir [$i] ['type'] = filetype($file);
				$dir [$i] ['ext'] = is_file($file) ? strtolower(substr(strrchr(basename($file), '.'), 1)) : '';
				$dir [$i] ['isDir'] = is_dir($file);
				$dir [$i] ['isFile'] = is_file($file);
				$dir [$i] ['isLink'] = is_link($file);
				$dir [$i] ['isReadable'] = is_readable($file);
				$dir [$i] ['isWritable'] = is_writable($file);
				$i++;
			}
		}
		
		
	}
	 $cmp_func = create_function('$a,$b', '
		if( ($a["isDir"] && $b["isDir"]) || (!$a["isDir"] && !$b["isDir"]) ){
			return  $a["filename"]>$b["filename"]?1:-1;
		}else{
			if($a["isDir"]){
				return -1;
			}else if($b["isDir"]){
				return 1;
			}
			if($a["filename"]  ==  $b["filename"])  return  0;
			return  $a["filename"]>$b["filename"]?-1:1;
		}
		');
    usort($dir, $cmp_func);
	//unset($list);
    return $dir;
	//var_dump($dir);exit;
 }
 
/**
 * 强制下载
 *
 * @param string $filename
 */
function force_download_content($filename, $content)
{
    header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Transfer-Encoding: binary");
    header("Content-Disposition: attachment; filename=$filename");
    echo $content;
    exit ();
}
 /**
 * 删除文件夹
 *
 */
function remove_dir($dir, $time_thres = -1)
    {
        foreach (list_file($dir) as $f) {
			//var_dump($f);exit;
            if ($f ['isDir']) {
				if(count(scandir($f ['pathname']))<=2)
				{
					rmdir($f ['pathname']);
				}else{
					remove_dir($f ['pathname'] . '/');
				}
				
                
            } else if ($f ['isFile'] && $f ['filename'] != 'index') {
                if ($time_thres == -1 || $f ['mtime'] < $time_thres) {
					//echo $f['filename'];exit;
					$path=substr($f['path'],0,strrpos($f ['pathname'],$f['filename']));
                    unlink($f ['pathname']);
					//rmdir(substr($f ['pathname'],0,-4));
					rmdir($path);
                }
            }
        }
    }
 
 /**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author rainfer <81818832@qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array(' B', ' KB', ' MB', ' GB', ' TB', ' PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 
 