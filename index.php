
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf-8');

function rewriting_cookies($Announcements) {
    $line_cookie = serialize($Announcements);
    setcookie('Announcements', $line_cookie, time() + 3600 * 24 * 7);
}


//добавленых объявления в массив ссесий
if ($_POST == TRUE) {
    if ($_GET == TRUE) {
        foreach ($_GET as $key => $value) { //сохраняем редактированное объявление в форме
            if ($key == "id") {
                $id = $_GET['id'];
                $Announcements = unserialize($_COOKIE["Announcements"]);
                $Announcements[$id] = $_POST;
                rewriting_cookies($Announcements);
                $_GET['id'] = "";
            } else {
                $Announcements = unserialize($_COOKIE["Announcements"]);
                $Announcements[] = $_POST;
                rewriting_cookies($Announcements);
            }
        }
        unset($_GET['id']);
    } else {
        if (isset($_COOKIE['Announcements'])) {
            $Announcements = unserialize($_COOKIE['Announcements']);
            $Announcements[] = $_POST;
            rewriting_cookies($Announcements);
        } else {
            $Announcements[] = $_POST;
            rewriting_cookies($Announcements);
        }
    }
    $Location = basename($_SERVER['PHP_SELF']);
    header("Location: $Location");
    exit;
}


if ($_GET == TRUE) {

    foreach ($_GET as $key_get => $value) { // выводим объявление в форме
        if ($key_get == "id") {
            $id_key = $_GET['id'];
        }
        if ($key_get == "id_del") {   // удаляем объявление делаем вывод пустой формы 
            $id_del = $_GET['id_del'];
            $Announcements = unserialize($_COOKIE["Announcements"]);
            unset($Announcements[$id_del]);
            rewriting_cookies($Announcements);
            unset($id_del);
            $id_key = "";
            $Location = basename($_SERVER['PHP_SELF']);
            header("Location: $Location");
            exit;
        }
    }
} else {
    $id_key = ""; // пока нет данных выводим пустую форму
}



$location['Новосибирск']='Новосибирск';
$location['Барабинск']='Барабинск';
$location['Бердск']='Бердск';
$location['Искитим']='Искитим';
$location['Колывань']='Колывань';

$category["Автомобили с пробегом"]="Автомобили с пробегом";
$category["Новые автомобили"]="Новые автомобили";
$category['Мотоциклы и мототехника']="Мотоциклы и мототехника";
$category['Грузовики и спецтехника']='Грузовики и спецтехника';
$category['Водный транспорт']="Водный транспорт";
$category['Запчасти и аксессуары']="Запчасти и аксессуары";

if ($id_key == null) {
    $seller_name = "";
    $email = "";
    $phone = "";
    $location_id = "Выберите Ваш город";
    $category_id = "Выберите категорию";
    $title = "";
    $description = "";
    $price = "0";
} else {
    $Announcements = unserialize($_COOKIE["Announcements"]);
    $seller_name = $Announcements[$id_key]['seller_name'];
    $email = $Announcements[$id_key]['email'];
    $phone = $Announcements[$id_key]['phone'];
    $location_id = $Announcements[$id_key]['location_id'];
    $category_id = $Announcements[$id_key]['category_id'];
    $title = $Announcements[$id_key]['title'];
    $description = $Announcements[$id_key]['description'];
    $price = $Announcements[$id_key]['price'];
}
   
?>

<form  method="post">

    <label><b>Ваше имя </b></label><input type="text" maxlength="40"  value="<?php echo $seller_name; ?>" name="seller_name">
    <br>  
    <label>Электронная почта </label><input type="text" value="<?php echo $email; ?>" name="email">
    <br>
    <label>Номер телефона </label><input type="text" value="<?php echo $phone; ?>" name="phone">
    <br>
    <label>Город</label> 
    <select title="Выберите Ваш город"  name="location_id">
        <option >-- Города --</option>
        <?php
        foreach ($location as $value => $city){
            $selected = ($city == $location_id) ? 'selected=""' : '';
            echo '<option data-coords=",," '.$selected.' value="'.$value.'">'.$city.'</option>';
        }
        ?>
        <option id="select-region" value="0">Выбрать другой...</option> </select> 
    <br>
    <label>Категория</label> 
    <select title="Выберите категорию объявления"  name="category_id" > 
        <option >-- категории --</option>
        <optgroup label="Транспорт">
            <?php
                foreach ($category as $value => $category_typ){
                    $selected = ($category_typ == $category_id) ? 'selected=""' : '';
                    echo '<option data-coords=",," '.$selected.' value="'.$value.'">'.$category_typ.'</option>';
                }
            ?>
        </optgroup></select>
    <br>
    <label>Название объявления</label> <input type="text" maxlength="50" value="<?php echo $title; ?>" name="title">
    <br>
    <label>Описание объявления</label><input type="text" maxlength="3000" value="<?php echo $description; ?>" name="description">
    <br>
    <label>Цена</label> <input type="text" maxlength="9" value="<?php echo $price; ?>" name="price"><span>руб.</span>
    <br><br>
    <input type="submit" value="Сохранить изменения"  name="main_form_submit" class="vas-submit-input" > 
</form>
<br><br>
<?php
if (isset($_COOKIE['Announcements'])) {
    $Announcements = unserialize($_COOKIE["Announcements"]);
    foreach ($Announcements as $x => $value) {
        ?>
        <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?id=<?php echo $x; ?>"><?php echo $Announcements[$x]['title']; ?></a>
        <?php
        echo '|  Цена:' . $Announcements[$x]['price'] . ' руб.  |';
        echo $Announcements[$x]['seller_name'] . '  |';
        ?>
        <a href="<?php echo basename($_SERVER['PHP_SELF']); ?>?id_del=<?php echo $x; ?>">Удалить</a>        
        <?php
        echo "<br>";
    }
}


