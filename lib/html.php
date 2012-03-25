<?php
doc_group('Функции генерирующие html');

doc('распечатать массив внутри блока <pre>');
def('ppr', function($a){
        echo '<pre>'.print_R($a, true).'</pre>';
});
