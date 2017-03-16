<?php
namespace app\admin\behavior;
use think\Log;
class Cron 
{
    public function run(&$params)
    {
		/*
	   // 行为逻辑
		ignore_user_abort(true);
		set_time_limit(0);
		date_default_timezone_set('PRC'); // 切换到中国的时间
		$interval=10;
		$nowtime=time();
		$starttime=strtotime('16:22:00');
		$endtime=strtotime('16:24:00');
		if($starttime<=$nowtime&&$nowtime<=$endtime)
		{
			$true=true;
		}else{
			$true=false;
		}
		while($true)
		{
			if(count(scandir(LOG_PATH))>2)
			{
				remove_dir(LOG_PATH);
				sleep($interval);   //延缓执行
			}else{
				break;
			}
			

				
				//sleep($interval);   //延缓执行

			
		}
		/*
		$run_time = strtotime('+1 day'); // 定时任务第一次执行的时间是明天的这个时候
		$interval = 10; // 每12个小时执行一次
		//if(!file_exists(dirname(__FILE__).'/cron-run')) exit(); // 在目录下存放一个cron-run文件，如果这个文件不存在，说明已经在执行过程中了，该任务就不能再激活，执行第二次，否则这个文件被多次访问的话，服务器就要崩溃掉了

		do {
		  if(!file_exists(dirname(__FILE__).'/cron-switch')) break; // 如果不存在cron-switch这个文件，就停止执行，这是一个开关的作用
		  $gmt_time = microtime(true); // 当前的运行时间，精确到0.0001秒
		  $loop = isset($loop) && $loop ? $loop : $run_time - $gmt_time; // 这里处理是为了确定还要等多久才开始第一次执行任务，$loop就是要等多久才执行的时间间隔
		  $loop = $loop > 0 ? $loop : 0;
		  if(!$loop) break; // 如果循环的间隔为零，则停止
		  sleep($loop); 
		  // ...
		  // 执行某些代码
		  // ...
		  @unlink(dirname(__FILE__).'/cron-run'); // 这里就是通过删除cron-run来告诉程序，这个定时任务已经在执行过程中，不能再执行一个新的同样的任务
		  $loop = $interval;
		} while(true);
		
		$interval=strtotime('11:36:00');
		$key_file=ROOT_PATH."key.txt";
		if(isset($_GET['s']))
		{
			if($_GET['s']=='0')  //停止工作
			{
				$s='false';
				echo 'Function is off';
			}elseif($_GET['s']=='1')  //工作
			{
				$s='true';
			}elseif($_GET['s']==2)  //退出
			{
				$s='die';
				echo 'Function exited';
			}else
			{
				die('Err 0:stop working 1:working 2:exit');
			}
			$string="<?php \n return \"".$s."\";'\n?>";
			write_inc($key_file,$string,true);
			
			exit();
		}
		if(file_exists($key_file))
		{
			do{
				$mkey=include $key_file;
				if($mkey=="true")   //如果工作
				{
					///////  工作区间  /////
					$showtime=date('Y-m-d H:i:s');
					$fp=fopen(ROOT_PATH.'key.txt','a');
					fwrite($fp,$showtime."\n");
					fclose($fp);
				}elseif($mkey=="die")
				{
					die("I am dying!");
				}
				sleep($interval);   //延缓执行
			}while(true);
		}else{
			die($key_file."does not exist!");
		}
		function write_inc($path,$string,$type=false)
		{
			$path=ROOT_PATH.$path;
			if($path==false)
			{
				file_put_contents($path,$string,FILE_APPEND);
			}ELSE{
				file_put_contents($path,$string);
			}
		}
		*/
    }
}