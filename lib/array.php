<?php
doc_group('array', 'функции для работы с массивами');

doc('алиас для array_map');
def('map', function($fn, $array){
  return array_map($fn, $array);
});

doc('обход массива с передачей ключа и значения функции');
def('kmap', function($fn, $array){
  $return = array();
  foreach($array as $k=>$v)
    $return[$k] = $fn($k, $v);
  return $return;
});

doc('алиас для array_filter с переставленными местами аргументами');
def('filter', function($fn, $array){
  return array_filter($array, $fn);
});

doc('фильтрация массива при которой фильтрующей функции передаётся ещё и ключ');
def('kfilter', function($fn, $array){
  $return = array();
  foreach($array as $k=>$v)
    if($fn($k, $v))
      $return[$k] = $v;
  return $return;
});
