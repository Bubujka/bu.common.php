<?php
doc_group('view', 'функции для работы с шаблонами');
doc('Аксессор для установки лайаута');
def_accessor('layout', 'default');
def('parse_haml', function($pth){
  $haml = new HamlParser();
  return $xhtml = $haml->parse($pth);
});

def('parse_haml_file', function($pth){
  $cpth = 'cache/view/'.$pth.'.php';
  $tpth = 'view/'.$pth.'.haml';
  
  $t = parse_haml($tpth);
  @mkdir(dirname($cpth), 0755, true);
  file_put_contents($cpth, $t);
});

def('have_haml_tpl', function($pth){
  return file_exists('view/'.$pth.'.haml');
});

def('valid_haml_cache', function($pth){
  $cpth = 'cache/view/'.$pth.'.php';
  $tpth = 'view/'.$pth.'.haml';
  if(file_exists($cpth) and (filemtime($cpth) > filemtime($tpth)))
    return true;
  return false;
});


doc('путь до папки с шаблонами.');
def_return('view_pth', 'view');

doc('загружает php файл из папки view_pth() и возвращает результат работы в виде строки.');
def('view', function(){
  if(func_num_args() == 2)
    extract(func_get_arg(1));

  if(have_haml_tpl(func_get_arg(0))){
    if(!valid_haml_cache(func_get_arg(0)))
      parse_haml_file(func_get_arg(0));
    require 'cache/view/'.func_get_arg(0).'.php';
  }else{
    require view_pth().'/'.func_get_arg(0).'.php';
  }
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
