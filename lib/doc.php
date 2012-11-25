<?php
def_accessor('doc_group_name');
def_accessor('doc_group_doc');
def('doc_group', function($name, $doc = ''){
  doc_group_name($name);
  doc_group_doc($doc);
});

def_accessor('docs', array());
def_accessor('doc'); 

def('doc_fn', function($name, $doc){
  $t = docs();
  if(!isset($t[($dgn = doc_group_name())]))
    $t[$dgn] = array('doc'=>doc_group_doc(),'fns'=>array());
  $t[$dgn]['fns'][$name] = $doc;
  docs($t);
});

def('wrap_def_with_doc_wrapper', function(){
  with_wrapper('def', function($fn){
    if($it = doc()){
      doc(null);
      doc_fn($fn->args[0], $it);
    }
    return $fn();
  });
});

doc_group('doc', 'функции для документирования');

doc_fn('doc_fn', 'записать документацию по функции.');
doc_fn('doc', 'сохраняет документацию, которую заберёт следующий вызов функции def');
doc_fn('docs', 'функция, хранящая в себе всю документацию');
