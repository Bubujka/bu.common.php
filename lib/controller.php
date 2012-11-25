<?php
doc_group('Функции контроллеров');

doc('хранилище информации по контроллерам');
def_accessor('bu\controllers', array());

doc('вернёт false если путь не относится к контроллеру');
def('not_a_url_fn', function($url){
  foreach(bu\controllers() as $v)
    if($v['url'] == $url)
      return false;

  return true;
});

doc('Запустить сайт');
def('run_site', function(){
  if(is_dev_host()){
    wrap_def_with_doc_wrapper();
    ini_set('display_errors', 1); 
    error_reporting(E_ALL);
  }else{
    ini_set('display_errors', 0); 
    error_reporting(E_ALL);
  }
  $u = preg_replace('/\?.*/', '', trim(uri(), '/'));
  $c = bu\controllers();
  if(!$u)
    $fn = 'index';
  elseif(!in_array($u, $c))
    $fn = 'show_404';
  else
    $fn = $u;

  $fn = "bu\\Controller\\$fn";
  $fn();
});

doc('функция для определения контроллеров');
def('controller', function($name, $fn){

  def("bu\\Controller\\$name", $fn);

  $t = bu\controllers();
  $t[] = $name;
  bu\controllers($t);

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

});

