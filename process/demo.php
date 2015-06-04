<?php
// 最大进程数
$max = 2;

// 输出的header头
echo "type\ti\tppid\tpid\treturn" . PHP_EOL;

// 需要输出的数据
$format = "%s\t%u\t%u\t%u\t%u";

function demo($exit = false)
{
    global $max, $format;
    for ($i = 0; $i < $max; $i++)
    {
        // fork子进程, 返回值阅读readme
        $s_pid  = pcntl_fork();

        // 当前进程的父进程ID
        $ppid   = posix_getppid();

        // 当前进程的ID
        $pid    = getmypid();

        if ($s_pid < 0) 
        {
            // fork子进程出错
            die('fork error');
        }
        elseif ($s_pid)
        {
            // 当前进程执行段
            echo sprintf($format, 'parent', $i, $ppid, $pid, $s_pid) . PHP_EOL;
        }
        else
        {
            // fork后的子进程执行段
            echo sprintf($format, 'son', $i, $ppid, $pid, $s_pid) . PHP_EOL;

            // 子进程执行完是否退出
            if ($exit) 
            {
                exit;
            }
        }
    }
    return ;
}

// fork的子进程不退出
demo();


// fork的子进程执行完退出
demo(true);
