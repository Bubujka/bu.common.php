<?php
doc_group('Функции контроллеров');

doc('хранилище информации по контроллерам');
def_accessor('aux\controllers', array());

doc('вернёт false если путь не относится к контроллеру');
def('not_a_url_fn', function($url){
        foreach(aux\controllers() as $v)
                if($v['url'] == $url)
                        return false;
        
        return true;
});

doc('функция для определения контроллеров');
def('def_url', function($name, $fn){
        def($name, $fn);
        $url_fn = $name.'_url';
        def($url_fn, function() use($name){
                return '/'.$name;
        });
        def($name.'_link', function($text) use($url_fn){
                return sprintf('<a href="%s">%s</a>', $url_fn(), $text);
        });
        def('redirect_to_'.$name, function() use($url_fn){
                redirect($url_fn());
        });

        def($name.'_post_form', function($data, $button = null) use($url_fn){
                if(is_closure($data))
                        $data = ob($data);
                echo '<form action="'.$url_fn().'" method=post>';
                        echo $data;
                if(!is_null($button))
                echo '<input type="submit" value="'.$button.'">';
                echo '</form>';
        });

        $t = aux\controllers();
        $t[$name] = array('url' => $name, 'name'=>$name, 'fn_name'=>$name, 'fn'=>$fn);
        aux\controllers($t);
});

