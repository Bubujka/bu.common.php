<?php
doc_group('view', 'функции для работы с шаблонами');


doc('путь до папки с шаблонами.');
def_return('view_pth', 'view');

doc('загружает php файл из папки view_pth() и возвращает результат работы в виде строки.');
def('view', function($pth, $args = array()){
  if(func_num_args() == 2)
    extract(func_get_arg(1));
  require view_pth().'/'.$pth.'.php';
});
with_wrapper('view', 'ob'); 

doc('загружает шаблон, передавая в него одну переменную с именем $data.');
def('dview', function($pth, $data){
        return view($pth, array('data'=>$data));
});

doc('обойти массив, для каждого его элемента загрузить шаблон и объединить 
всё в одну строку');
def('map_view', function($pth, $array, $imploder = ''){
        $fn = function($v) use($pth){ 
                return view($pth, $v);
        };
        return implode($imploder, array_map($fn, $array));
});

doc('обойти массив, для каждого его элемента загрузить шаблон и объединить 
всё в одну строку, но при этом каждый элемент передавать в переменной $data');
def('map_dview', function($pth, $array, $imploder = ''){
        $fn = function($v) use($pth){ 
                return dview($pth, $v);
        };
        return implode($imploder, array_map($fn, $array));
});
