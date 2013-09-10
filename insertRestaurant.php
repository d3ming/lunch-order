<?php
include_once 'authenticate.php';
include_once 'mysql.php';

$name = $_POST['restaurantName'];
$type = $_POST['restaurantType'];

if ($_POST['menuInputURL']) {
    $url = $_POST['menuInputURL'];
} else if ($_FILES['menuInputFile']['name']) {
    print_r($_FILES['menuInputFile']);
    $ext = pathinfo($_FILES['menuInputFile']['name'], PATHINFO_EXTENSION);
    $fileName = "./Menus/$name"."_menu.$ext";
    move_uploaded_file($_FILES['menuInputFile']["tmp_name"], $fileName);
    $url = "./Menus/$name"."_menu.$ext";
} else {
    $url = "";
}

try {
    $statement = $pdo->prepare("INSERT INTO restaurants (name,food_type,menu_url) VALUES (?,?,?)");
    $statement->execute(array($name, $type, $url));
} catch (PDOException $e){
    $error = "PDO error :" . $e->getMessage() . "<br/>";
    echo json_encode($error);
}
