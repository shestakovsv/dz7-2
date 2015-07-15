
<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf-8');

function rewriting_cookies($Announcements) {
    $line_cookie = serialize($Announcements);
    setcookie('Announcements', $line_cookie, time() + 3600 * 24 * 7);
}

$Location = basename($_SERVER['PHP_SELF']);
$Announcements = (isset($_COOKIE["Announcements"])) ? unserialize($_COOKIE["Announcements"]) : "";
//print_r($_POST);
//добавленых объявления в массив ссесий
if (isset($_POST['main_form_submit'])) {
//$Announcements = unserialize($_COOKIE["Announcements"]);
    if ($_GET == TRUE) {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $Announcements[$id] = $_POST;
            $_GET['id'] = "";
        } else {
            $Announcements[] = $_POST;
        }
        unset($_GET['id']);
    } else {
        $Announcements[] = $_POST;
    }
    rewriting_cookies($Announcements);
    header("Location: $Location");
    exit;
}


if ($_GET == TRUE) {
    if (isset($_GET['id'])) {
        $id_key = $_GET['id'];
    }
    if (isset($_GET['id_del'])) {
        $id_del = $_GET['id_del'];
        unset($Announcements[$id_del]);
        rewriting_cookies($Announcements);
        unset($id_del);
        $id_key = "";
        header("Location: $Location");
        exit;
    }
} else {
    $id_key = ""; // пока нет данных выводим пустую форму
}



$location['Новосибирск'] = 'Новосибирск';
$location['Барабинск'] = 'Барабинск';
$location['Бердск'] = 'Бердск';
$location['Искитим'] = 'Искитим';
$location['Колывань'] = 'Колывань';

$category["Автомобили с пробегом"] = "Автомобили с пробегом";
$category["Новые автомобили"] = "Новые автомобили";
$category['Мотоциклы и мототехника'] = "Мотоциклы и мототехника";
$category['Грузовики и спецтехника'] = 'Грузовики и спецтехника';
$category['Водный транспорт'] = "Водный транспорт";
$category['Запчасти и аксессуары'] = "Запчасти и аксессуары";

$private['Частное лицо'] = "Частное лицо";
$private['Компания'] = "Компания";

if ($id_key == null) {
    $seller_name = "";
    $email = "";
    $phone = "";
    $location_id = "Выберите Ваш город";
    $category_id = "Выберите категорию";
    $title = "";
    $description = "";
    $price = "0";
    $manager = "";
    $email = "";
    $phone = "";
    $private_checked = 1;
    $allow_mails = 0;
} else {
    $seller_name = $Announcements[$id_key]['seller_name'];
    $email = $Announcements[$id_key]['email'];
    $phone = $Announcements[$id_key]['phone'];
    $location_id = $Announcements[$id_key]['location_id'];
    $category_id = $Announcements[$id_key]['category_id'];
    $title = $Announcements[$id_key]['title'];
    $description = $Announcements[$id_key]['description'];
    $price = $Announcements[$id_key]['price'];
    $manager = $Announcements[$id_key]['manager'];
    $email = $Announcements[$id_key]['email'];
    $phone = $Announcements[$id_key]['phone'];
    $private_checked = $Announcements[$id_key]['private'];
    if (isset($Announcements[$id_key]['allow_mails'])) {
        $allow_mails = $Announcements[$id_key]['allow_mails'];
    } else {
        $allow_mails = 0;
    }
}
$checked = ($private_checked == 0) ? 'checked = ""' : "";
?>


<form  method="post">

    <label><input type = "radio" checked = "" value = "1" name = "private">Частное лицо</label>
    <label><input type = "radio" <?php echo $checked; ?>  value = "0" name = "private">Компания</label>
    <br>
    <label><b>Контактное лицо</b></label> <input type="text" maxlength="40" value="<?php echo $manager; ?>" name="manager">
    <br> 
    <label>Электронная почта</label><input type="text" value="<?php echo $email; ?>" name="email">
    <br>

    <?php
    if ($allow_mails == 1) {
        echo '<label  for="allow_mails"> <input type="checkbox" value="1" name="allow_mails" id="allow_mails" CHECKED class="form-input-checkbox">
    <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> </label> </div>';
    } else {
        echo '<label  for="allow_mails"> <input type="checkbox" value="1" name="allow_mails" id="allow_mails"  class="form-input-checkbox">
    <span class="form-text-checkbox">Я не хочу получать вопросы по объявлению по e-mail</span> </label> </div>';
    }
    ?>

    <br>
    <label><b>Ваше имя </b></label><input type="text" maxlength="40"  value="<?php echo $seller_name; ?>" name="seller_name">
    <br>  

    <label>Номер телефона </label><input type="text" value="<?php echo $phone; ?>" name="phone">
    <br>
    <label>Город</label> 
    <select title="Выберите Ваш город"  name="location_id">
        <option >-- Города --</option>
        <?php
        foreach ($location as $value => $city) {
            $selected = ($city == $location_id) ? 'selected=""' : '';
            echo '<option data-coords=",," ' . $selected . ' value="' . $value . '">' . $city . '</option>';
        }
        ?>
        <option id="select-region" value="0">Выбрать другой...</option> </select> 
    <br>
    <label>Категория</label> 
    <select title="Выберите категорию объявления"  name="category_id" > 
        <option >-- категории --</option>
        <optgroup label="Транспорт">
            <?php
            foreach ($category as $value => $category_typ) {
                $selected = ($category_typ == $category_id) ? 'selected=""' : '';
                echo '<option data-coords=",," ' . $selected . ' value="' . $value . '">' . $category_typ . '</option>';
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
    foreach ($Announcements as $id => $value) {
        ?>
        <a href="<?php echo $Location; ?>?id=<?php echo $id; ?>"><?php echo $Announcements[$id]['title']; ?></a>
        <?php
        echo '|  Цена:' . $Announcements[$id]['price'] . ' руб.  |';
        echo $Announcements[$id]['seller_name'] . '  |';
        ?>
        <a href="<?php echo $Location; ?>?id_del=<?php echo $id; ?>">Удалить</a>        
        <?php
        echo "<br>";
    }
}


      
