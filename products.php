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

    $method = $_SERVER['REQUEST_METHOD'];
    $db = new Connection();
    $conn = $db->getConnection();
    $products = new Products();
    $dao = new ProductsDAO($conn);

    switch ($method) {
        case 'GET':
            if (!empty($_GET['id'])) {
                $id = intval($_GET['id']);
                $products->setID($id);
                $dao->getProduct($products);
            } else{
                $dao->getAll();
            };
            break;
            
        case 'POST':
            $dao->insertProduct();
            break;

        case 'PUT':
            $id = intval($_GET['id']);
            $products->setID($id);
            $dao->updateProduct($products);
            break;

        case 'DELETE':
            $id = intval($_GET['id']);
            $products->setID($id);
            $dao->deleteProduct($products);
            break;

        default:
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    };
?>