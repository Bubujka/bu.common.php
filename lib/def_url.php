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
        def($url_fn, function($get_args = array()) use($name){
                $t = ($get_args) ? '?'.http_build_query($get_args) : '';
                return '/'.$name.$t;
        });
        def($name.'_link', function($text, $get_args = array()) use($url_fn){
                return sprintf('<a href="%s">%s</a>', $url_fn($get_args), $text);
        });
        def('redirect_to_'.$name, function($args = null) use($url_fn){
                $url = is_null($args) ? $url_fn() : $url_fn().'?'.http_build_query($args);
                redirect($url);
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

        def($name.'_get_button', function($name, $data=array()) use($url_fn){
                echo '<form action="'.$url_fn().'" method=get class=get-button>';
                foreach($data as $k=>$v)
                        printf("<input type='hidden' name='%s' value='%s'>", $k, $v);
                echo '<input type="submit" value="'.$name.'">';
                echo '</form>';
        });

        def($name.'_post_button', function($name, $data=array()) use($url_fn){
                echo '<form action="'.$url_fn().'" method=post class=post-button>';
                foreach($data as $k=>$v)
                        printf("<input type='hidden' name='%s' value='%s'>", htmlspecialchars($k), htmlspecialchars($v));
                echo '<input type="submit" value="'.$name.'">';
                echo '</form>';
        });

        $t = aux\controllers();
        $t[$name] = array('url' => $name, 'name'=>$name, 'fn_name'=>$name, 'fn'=>$fn);
        aux\controllers($t);
});

