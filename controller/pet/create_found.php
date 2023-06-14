<?php
require_once('../../model/found.class.php');

$userId         = $_POST['userId'];
$name           = $_POST['name'];
$genre          = $_POST['genre'];
$petType        = $_POST['petType'];
$breeds         = $_POST['breeds'];
$petColor       = $_POST['petColor'];
$petEyeColor    = $_POST['petEyeColor'];

if (isset($_POST['action']) && $_POST['action'] === 'create_found' && $userId !== '') {
    $warning = '';
    $fileUrl = '';
    if (isset($_FILES['file'])) {
        if (
            $_FILES['file']['type'] === 'image/pjpeg' ||
            $_FILES['file']['type'] === 'image/jpeg' ||
            $_FILES['file']['type'] === 'image/png'
        ) {
            $fileUrl = "img/pets/founds/" . $_FILES['file']['name'];
            if (!move_uploaded_file($_FILES['file']['tmp_name'], "../../img/pets/founds/" . $_FILES['file']['name'])) {
                $warning = 'Problemas al subir la imagen!';
                $fileUrl = '';
            }
        } else {
            $warning = "Imagen formato incorrecto!";
        }
    }
    
    $pet = new Found();
    $create = $pet->create($userId, $name, $genre, $petType, $breeds, $petColor, $petEyeColor, $fileUrl);
    if ($create) {
        echo json_encode([ 'response' => 'success', 'warning' => $warning ]);
    } else {
        echo json_encode([ 'response' => 'error_insert' ]);
    }
} else {
    echo json_encode([ 'response' => 'error_request' ]);
}
?>