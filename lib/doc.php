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
  $t[$dgn]['fns'][$name]['doc'] = $doc;
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



// временное хранилище параметров
def_accessor('bu\aux\_params', array());

// Собираем параметры до момента определения
def('param', function($doc, $type = null){
  $t = bu\aux\_params();
  $t[] = array('doc'=>$doc, 'type'=>$type);
  bu\aux\_params($t);
});

def('wrap_def_with_doc_params_wrapper', function(){
  with_wrapper('def', function($fn){
    if($it = bu\aux\_params()){
      bu\aux\_params(array());
      $reflection = new ReflectionFunction($fn->args[1]);
      $param_names = array();
      foreach($reflection->getParameters() as $v)
        $param_names[] = $v->name;
      $params = array();
      foreach($param_names as $k => $v)
        if(isset($it[$k]))
          $params[$v] = $it[$k];
        else
          $params[$v] = array('doc'=>'', 'type'=>'');
      $t = docs();
      $t[doc_group_name()]['fns'][$fn->args[0]]['params'] = $params;
      docs($t);
    }
   return $fn();
  });
});


doc_group('doc', 'функции для документирования');

doc_fn('doc_fn', 'записать документацию по функции.');
doc_fn('doc', 'сохраняет документацию, которую заберёт следующий вызов функции def');
doc_fn('docs', 'функция, хранящая в себе всю документацию');
