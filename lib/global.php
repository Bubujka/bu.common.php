<?

doc('проверяет - является ли аргумент замыканием');
def('is_closure', function($arg){
        return (is_object($arg) and (get_class($arg) == 'Closure')) ? true : false;
});

