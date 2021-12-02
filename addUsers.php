<?php
    namespace api;

    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    use classes\Connection;
    use classes\Products;
    use classes\ProductsDAO;

    require_once 'classes/Connection.php';
    require_once 'classes/Products.php';

    $name = \filter_input(\INPUT_POST, 'name', \FILTER_SANITIZE_STRING);
    $email = \filter_input(\INPUT_POST, 'email', \FILTER_SANITIZE_EMAIL);
    $birthday = \filter_input(\INPUT_POST, 'birthday', \FILTER_SANITIZE_STRING);
    $created_at = \filter_input(\INPUT_POST, 'created_at', \FILTER_SANITIZE_STRING);
    $db = new Connection();
    $conn = $db->getConnection();
    $products = new Products();
    $dao = new ProductsDAO($conn);
