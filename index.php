
<?php
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1 );
header('Content-type: text/html; charset=utf-8');
session_start();


// функция вывода заполненной формы
function notation2($key){
    
    
if ($key == null){
      $seller_name= "";
      $email="";
      $phone="";
      $location_id="Выберите Ваш город";
      $category_id="Выберите категорию";
      $title="Название объявления";
      $description="";
      $price="0";
} else{
  $seller_name= $_SESSION['advt'][$key]['seller_name'];
  $email=$_SESSION['advt'][$key]['email'];
  $phone=$_SESSION['advt'][$key]['phone'];
  $location_id=$_SESSION['advt'][$key]['location_id'];
  $category_id=$_SESSION['advt'][$key]['category_id'];
  $title=$_SESSION['advt'][$key]['title'];
  $description=$_SESSION['advt'][$key]['description'];
  $price=$_SESSION['advt'][$key]['price'];
}
 
 
?>
<form  method="post">
    
<label><b>Ваше имя </b></label><input type="text" maxlength="40"  value="<?php echo $seller_name;?>" name="seller_name">
<br>  
<label>Электронная почта </label><input type="text" value="<?php echo $email;?>" name="email">
<br>
<label>Номер телефона </label><input type="text" value="<?php echo $phone;?>" name="phone">
<br>
<label>Город</label> 
    <select title="Выберите Ваш город"  name="location_id">
        <option value="<?php echo $location_id;?>">-- <?php echo $location_id;?> --</option>
        <option >-- Города --</option>
            <option  value="Новосибирск">Новосибирск</option>   
            <option  value="Барабинск">Барабинск</option>   
            <option  value="Бердск">Бердск</option>   
            <option  value="Искитим">Искитим</option>   
            <option  value="Колывань">Колывань</option>
            <option id="select-region" value="0">Выбрать другой...</option> </select> 
<br>
<label>Категория</label> 
    <select title="Выберите категорию объявления"  name="category_id" > 
        <option value="<?php echo $category_id;?>">-- <?php echo $category_id;?> --</option>
            <optgroup label="Транспорт">
                <option value="Автомобили с пробегом">Автомобили с пробегом</option>
                <option value="Новые автомобили">Новые автомобили</option>
                <option value="Мотоциклы и мототехника">Мотоциклы и мототехника</option>
                <option value="Грузовики и спецтехника">Грузовики и спецтехника</option>
                <option value="Водный транспорт">Водный транспорт</option>
                <option value="Запчасти и аксессуары">Запчасти и аксессуары</option>
            </optgroup></select>
<br>
<label>Название объявления</label> <input type="text" maxlength="50" value="<?php echo $title;?>" name="title">
<br>
<label>Описание объявления</label><input type="text" maxlength="3000" value="<?php echo $description;?>" name="description">
<br>
<label>Цена</label> <input type="text" maxlength="9" value="<?php echo $price;?>" name="price"><span>руб.</span>
<br><br>
<input type="submit" value="Сохранить изменения"  name="main_form_submit" class="vas-submit-input" > 
</form>
<br><br>
<?php
//header("Location: index.php");  


}
echo "<br>";


// раскрытие объявления или его удаление или вывод пустой формы form_submit
//if($_GET == TRUE){
//
//    foreach ($_GET as $key => $value){ // выводим объявление в форме
//        if ($key == "id"){
//            $id=$_GET['id'];
//            notation2($id);
//        }
//        if ($key == "id_del"){   // удаляем объявление делаем вывод пустой формы 
//            $id_del=$_GET['id_del'];
//            unset($_SESSION['advt'][$id_del]);
//            unset($id_del);
//            $z="";
//            notation2($z);
//        } 
//    }
//} else {
//    $key="";
//    notation2($key); // пока нет данных выводим пустую форму
//}   
echo "<br>";



//добавленых объявления в массив ссесий
if ($_POST == TRUE){
    if($_GET == TRUE){
        foreach ($_GET as $key => $value){ //сохраняем редактированное объявление в форме
            if ($key == "id"){
                $id=$_GET['id'];
                $_SESSION['advt'][$id]=$_POST;
                $_GET['id']="";
                
            }else {$_SESSION['advt'][]=$_POST;
            }
        }
    unset($_GET['id']);    
    }else{$_SESSION['advt'][]=$_POST;
    }
} 


if($_GET == TRUE){

    foreach ($_GET as $key => $value){ // выводим объявление в форме
        if ($key == "id"){
            $id=$_GET['id'];
            notation2($id);
            //unset($_GET);
            //header("Location: index.php");
            //unset($_GET['id']);
        }
        if ($key == "id_del"){   // удаляем объявление делаем вывод пустой формы 
            $id_del=$_GET['id_del'];
            unset($_SESSION['advt'][$id_del]);
            unset($id_del);
            $z="";
            notation2($z);
        } 
    }
} else {
    $key="";
    notation2($key); // пока нет данных выводим пустую форму
} 
unset($_GET['id']);


if ($_SESSION == TRUE){
    foreach ($_SESSION['advt'] as $key => $value){
        title($key); 
        echo "<br>";
    }
}  

//вывод содержания объявления 
function title($x) {
    ?>
        <a href="index.php?id=<?php echo $x; ?>"><?php echo $_SESSION['advt'][$x]['title']; ?></a>
        <?php 
        echo '|  Цена:'.$_SESSION['advt'][$x]['price'].' руб.  |';
        echo  $_SESSION['advt'][$x]['seller_name'].'  |'; 
        ?>
        <a href="index.php?id_del=<?php echo $x; ?>">Удалить</a>
    <?php  
}
 
