<?php
require_once 'bu.defun/load.php';
foreach(glob(__DIR__.'/lib/*.php') as $v)
        require_once $v;
