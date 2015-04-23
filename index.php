<?
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1 );
header('Content-type: text/html; charset=utf-8');

$ini_string='
[игрушка мягкая мишка белый]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[одежда детская куртка синяя синтепон]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';
    
[игрушка детская велосипед]
цена = '.  mt_rand(1, 10).';
количество заказано = '.  mt_rand(1, 10).';
осталось на складе = '.  mt_rand(0, 10).';
diskont = diskont'.  mt_rand(0, 2).';

';
$bd=  parse_ini_string($ini_string, true);
print_r($bd);
echo '<br>';

//расчет скидки
foreach($bd as $z=> $name_p)
    {
    if ($z=='игрушка детская велосипед'){ // расчет скидки для велосипедов
        if ($name_p['количество заказано']>2){
            $bd['игрушка детская велосипед']['цена']=$bd['игрушка детская велосипед']['цена']*0.7;
            $bd["$z"]['diskont']= 'скидка 30%';
        }else { 
            while(list($key,$value) = each($name_p)){   
                if ($value=="diskont1"){
                    $name_p['цена']= $name_p['цена']*0.9;
                    $bd["$z"]['цена']=$name_p['цена'];
                    $bd["$z"]['diskont']= 'скидка 10%';
                }
                if ($value=="diskont2"){
                    $name_p['цена']= $name_p['цена']*0.8;
                    $bd["$z"]['цена']=$name_p['цена'];
                    $bd["$z"]['diskont']= 'скидка 20%';
                }
                if ($value=="diskont0"){
                    $bd["$z"]['diskont']= 'скидок нет';
                }
            }
        }   
    }   else{  while(list($key,$value) = each($name_p)){  // расчет скидки для всего остального
                if ($value=="diskont1"){
                    $name_p['цена']= $name_p['цена']*0.9;
                    $bd["$z"]['цена']=$name_p['цена'];
                    $bd["$z"]['diskont']= 'скидка 10%';
                }
                if ($value=="diskont2"){
                    $name_p['цена']= $name_p['цена']*0.8;
                    $bd["$z"]['цена']=$name_p['цена'];
                    $bd["$z"]['diskont']= 'скидка 20%';
                }
                if ($value=="diskont0"){
                    $bd["$z"]['diskont']= 'скидок нет';
                }
            }
        }
}
echo "<br>"."<table>";        // вывод таблички заказов по найденому в инете скрипту
foreach($bd as $x => $name)
{
    echo '<tr align="center"><td style="background-color:#CCC;" colspan="2">'.$x.'</td>';
    while(list($key,$value) = each($name))
    {
        echo '<tr><td><p>'.$key.'</p></td>
              <td><p>'.$value.'</p></td></tr>';
    }
    echo '</tr>';   
}    
echo "</table";

// ИТОГО

$pz=0; //всего позиций заказанно  
foreach($bd as $x => $name1)
{
    if ((in_array("количество заказано",$name1, TRUE))>0);
    {
        $pz=$pz+1;
    }
  }   
  echo "<br>"."Позиций заказанно: ".$pz;
  
  
  
$okp=0; //общее колличество позиций шт
foreach($bd as $z => $name_p)
{
    while(list($key,$value) = each($name_p))
    {
        if ($key=="количество заказано"){
        $okp = $okp + $value;
        }
    }
  }   
  echo "<br>"."всего заказанно : "."$okp шт.";
  
  
$osz=0; //общая сумма заказа
$c=0;
$kz=0;
foreach($bd as $z => $name_p){
        while(list($key,$value) = each($name_p)){
        if ($key=="цена"){
        $c =$value;
        }
        if ($key=="количество заказано"){
        $kz= $value;   
        }
    }
  $osz=($c*$kz)+$osz;
  }   
  echo "<br>"."общая сумма заказа : "."$osz"."<br>";
  
  $ons=0;
  $kzb=0;
//УВЕДОМЛЕНИЯ о недеостающих заказах на складе
foreach($bd as $z=> $name_p)
    {
    while(list($key,$value) = each($name_p)){
        
        if ($key=="количество заказано"){
            $kzb = $value;}
      
        if ($key=="осталось на складе"){
        $ons = $value;}
//        echo $}
        }
        if ($kzb > $ons){
                    echo "товара $z недостаточно на складе, в колличестве: ".($kzb-$ons)."шт.<br>"; }
    }
    
    ?>