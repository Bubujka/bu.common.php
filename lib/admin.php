<?php
doc('Проверка - является ли пользователь администратором');
def('is_admin', function(){
  return (isset($_SESSION['is_admin']) and $_SESSION['is_admin']);
});

doc('Адрес по которому может авторизоваться администратор');
def_accessor('admin_auth_url', '/');
