<?php
def_accessor('docs', array());
def_accessor('doc'); 

def('doc_fn', function($name, $doc){
        $t = docs();
        $t[$name] = $doc;
        docs($t);
});

def_wrapper('def', function($fn){
        if($it = doc()){
                doc(null);
                doc_fn($fn->args[0], $it);
        }
        return $fn();
});

doc_fn('doc_fn', 'записать документацию по функции.');
doc_fn('doc', 'сохраняет документацию, которую заберёт следующий вызов функции def');
doc_fn('docs', 'функция, хранящая в себе всю документацию');
