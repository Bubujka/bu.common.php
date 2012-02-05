<?php
if(!function_exists('bu\def\def'))
        if(file_exists($it = '/home/lib/bu.defun/load.php'))
                require_once $it;
        else
                exit("bu.defun not loaded!");
        


foreach(glob(__DIR__.'/lib/*.php') as $v)
        require_once $v;
