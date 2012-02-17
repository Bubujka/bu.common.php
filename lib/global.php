<?
doc_group('global', 'глобальные функции, которые я использую повсеместно');

doc('проверяет - является ли аргумент замыканием');
def('is_closure', function($arg){
        return (is_object($arg) and (get_class($arg) == 'Closure')) ? true : false;
});



doc('выполняет функцию и возвращает всё что она напечатала в stdout в виде строки');
def('ob', function($fn){
        ob_start();
        $fn();
        $t = ob_get_contents();
        ob_end_clean();
        return $t;
});
