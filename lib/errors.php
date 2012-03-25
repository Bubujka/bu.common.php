<?php
doc_group('Функции помогающие в отлове ошибок');

doc('Установить максимальный уровень ошибок');
def('max_error_level', function(){
        ini_set('display_errors', 1); 
        error_reporting(E_ALL);
});
