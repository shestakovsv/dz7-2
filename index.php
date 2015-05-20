<?
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1 );
header('Content-type: text/html; charset=utf-8');

$date=array();
    $date[]=  rand(time(), 1);
    $date[]=  rand(time(), 1);
    $date[]=  rand(time(), 1);
    $date[]=  rand(time(), 1);
    $date[]=  rand(time(), 1);
    print_r($date);
    sort($date);
    echo date('d.m.Y',$date[0]).'<br>';
    
$s=array();
$x=array();
    foreach ($date as $key => $value) {
        echo date('d.m.Y',$value).'<br>';
        $x[]=date('d',$value);
        $s[]=date('m',$value);    
    } 
sort($x);
sort($s);
echo "наименьший день в массиве ".$x[0].'<br>';
echo "наибольший месяц в массиве ".$s[4].'<br>';

$selected=array_pop($date);
echo 'посдедний элемент массива: '.date('d.m.Y H:i:s',$selected).'<br>';

echo 'время на сервере: '.date('d.m.Y H:i:s',time()).'<br>';
date_default_timezone_set('America/New_York');
echo 'время в Нью-Йорке: '.date('d.m.Y H:i:s',time()).'<br>';
//?>