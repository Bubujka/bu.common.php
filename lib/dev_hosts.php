<?php
doc_group('dev_hosts', 'функции определяющие является ли сайт в dev или prod режиме');

doc('хранилище dev-хостов');
def_accessor('aux\dev_hosts', array());

doc('установить один единственный dev-хост');
def('dev_host', function($host){
        aux\dev_hosts(array($host));
});

doc('установить dev-хосты из аргументов');
def('dev_hosts', function(/* $host, $host2, $host3 ... */){
        aux\dev_hosts(func_get_args());
});

doc('вернёт true, если текущий сайт находится в dev_hosts');
def('is_dev_host', function(){
        return in_array(http_host(), aux\dev_hosts());
});
