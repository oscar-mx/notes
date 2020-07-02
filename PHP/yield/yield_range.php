<?php
//常规
/*
$start_mem = memory_get_usage();
$arr = range( 1, 10000 );
foreach( $arr as $item ){
    //echo $item.',';
}
$end_mem = memory_get_usage();
echo " 使用内存 : ". ( $end_mem - $start_mem ) .'字节'.PHP_EOL;
*/

//使用yield

$start_mem = memory_get_usage();
function getYieldRange(){
    $arr = range( 1, 10000 );
    foreach( $arr as $item ){
        yield $item;
    }
}
$generator = getYieldRange();

foreach($generator as $name) {
    //echo $name;
}
$end_mem = memory_get_usage();
echo " 使用内存 : ". ( $end_mem - $start_mem ) .'字节'.PHP_EOL;