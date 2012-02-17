<?
// Функции для загрузки файлов.

doc('проходит по аргументам и пытается загрузить первый найденный файл.
Если ни одного файла не найдено - возникнет исключение.');
def('try_files', function(){
        foreach(($pths = func_get_args()) as $pth)
                if(file_exists($pth)){
                        require $pth;
                        return;
                }
        throw new Exception('All files not exists: '.implode(', ', $pths));
});



doc('получает аргументом путь для glob и подгружает все результаты что он вернёт.');
def('require_glob', function($pth){
        foreach(glob($pth) as $v)
                require_once $v;
});
