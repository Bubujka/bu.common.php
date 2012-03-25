<?php
doc_group('Функции для редиректа');

doc('перенаправить юзера по ссылке');
def('redirect', function($url){
        header('Location: '.$url);
        exit;
});
