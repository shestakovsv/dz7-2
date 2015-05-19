<?
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1 );
header('Content-type: text/html; charset=utf-8');

//$name = "Сергей";
//$age = 26;
//echo "Меня зовут $name и мне $age лет.";

define('GOROD', "Koms");
echo GOROD.'<br>';
//define('GOROD', "dddd");

$book=array();
    $book['title']='Наследие';
    $book['author']='Тармашев';
    $book['pages']='100';
echo "Недавно я прочитал книгу $book[title] , написанную автором $book[author], я осилил все $book[pages] страниц, мне она очень понравилась <br>";

    $book1=array();
        $book1['title1']='Метро';
        $book1['author1']='Глуховский';
        $book1['pages1']='200';
    $book2=array();
        $book2['title2']='РАБ';
        $book2['author2']='Минаев';
        $book2['pages2']='300';
        
$books=array($book1, $book2);
echo "Недавно я прочитал книги ".$books['0']["title1"]." и ".$books['1']["title2"]." написанные соответственно авторами ".$books['0']["author1"]." и ".$books['1']["author2"];
echo ", я осилил в сумме ";
echo $books['0']["pages1"]+$books['1']["pages2"]." страниц, не ожидал от себя подобного" ;








    ?>