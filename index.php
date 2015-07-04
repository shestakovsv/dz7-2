
<?php
error_reporting(E_ERROR|E_WARNING|E_PARSE|E_NOTICE);
ini_set('display_errors', 1 );
header('Content-type: text/html; charset=utf-8');
session_start();

//print_r($_COOKIE["Announcements"]);
//$Announcements=array();


//echo "<br>";
print_r($_POST);



//добавленых объявления в массив ссесий
if ($_POST == TRUE){
    if($_GET == TRUE){
        foreach ($_GET as $key => $value){ //сохраняем редактированное объявление в форме
            if ($key == "id"){
                $id=$_GET['id'];
                $Announcements['adv'][$id]=$_POST;
                setcookie('Announcements',$Announcements);
                $_GET['id']="";
                
            }else { $Announcements['adv'][]=$_POST;
            setcookie('Announcements',$Announcements);
            }
            
        }
    unset($_GET['id']);    
    }else{$Announcements['adv'][]=$_POST; 
    setcookie('Announcements',$Announcements);
    //header("Location: index.php");
    //exit; 
    }  
//header("Location: index.php");
//exit;    
} 


if($_GET == TRUE){

    foreach ($_GET as $key_get => $value){ // выводим объявление в форме
        if ($key_get == "id"){
            $key=$_GET['id'];
        }
        if ($key_get == "id_del"){   // удаляем объявление делаем вывод пустой формы 
            $id_del=$_GET['id_del'];
            unset($Announcements['adv'][$id_del]);
            unset($id_del);
            $key="";
        } 
    }
} else {
    $key=""; // пока нет данных выводим пустую форму
} 


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
      $seller_name= $Announcements['adv'][$key]['seller_name'];
      $email=$Announcements['adv']['email'];
      $phone=$Announcements['adv'][$key]['phone'];
      $location_id=$Announcements['adv'][$key]['location_id'];
      $category_id=$Announcements[$key]['category_id'];
      $title=$Announcements['adv'][$key]['title'];
      $description=$Announcements['adv'][$key]['description'];
      $price=$Announcements['adv'][$key]['price'];
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



//$Announcements['adv'][]=$_POST;
//var_dump($Announcements);    
   
    
    
//if ($_COOKIE["Announcements"] == TRUE){
//    echo '22222222222222222222222';
//$Announcements=unserialize($_COOKIE["Announcements"]);  
//}
// global $Announcements;


//if ($Announcements == TRUE){
//   
//    foreach ($Announcements['adv'] as $key => $value){
//        title($key); 
//        echo "<br>";
//    }
//}  
print_r($Announcements['adv'][0]['title']);
title("0");

//вывод содержания объявления 
function title($x) {
    ?>
        <a href="index.php?id=<?php echo $x; ?>"><?php echo $Announcements['adv'][$x]['title']; ?></a>
        <?php 
        echo '|  Цена:'.$Announcements['adv'][$x]['price'].' руб.  |';
        echo  $Announcements['adv'][$x]['seller_name'].'  |'; 
        ?>
        <a href="index.php?id_del=<?php echo $x; ?>">Удалить</a>
    <?php 
    
}
 
