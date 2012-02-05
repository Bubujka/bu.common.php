<?php
def('try_files', function(){
        foreach(($pths = func_get_args()) as $pth)
                if(file_exists($pth)){
                        require $pth;
                        return;
                }
        throw new Exception("All files not exists: ".implode(', ', $pths));
});
