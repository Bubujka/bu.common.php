<?

doc('если вызвана без аргументов - вернёт $_GET массив.
С аргументом - значение этого ключа в массиве или null');
def('get', function($arg = null){
        if(!func_num_args())
                return $_GET;
        if(isset($_GET[$arg]))
                return $_GET[$arg];
        return null;
});


doc('если вызвана без аргументов - вернёт $_POST массив.
С аргументом - значение этого ключа в массиве или null');
def('post', function($arg = null){
        if(!func_num_args())
                return $_POST;
        if(isset($_POST[$arg]))
                return $_POST[$arg];
});


doc('вернёт адрес хоста или null');
def('http_host', function(){
        if(isset($_SERVER['HTTP_HOST']))
                return $_SERVER['HTTP_HOST'];
});


doc('вернёт ip пользователя или null');
def('ip', function(){
        if(isset($_SERVER['REMOTE_ADDR']))
                return $_SERVER['REMOTE_ADDR'];
});

