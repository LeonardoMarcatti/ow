<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    

    require_once '../classes/Connection.php';
    require_once '../classes/Users.php';

    use classes\Connection;
    use classes\UserDAO;    
    
    $db = new Connection();
    $conection = $db->getConnection();
    $dao = new UserDAO($conection);
    $dao->getAll();

    $file = 'all.json';
    header("Content-Disposition: attachment; filename=". $file);
    \readfile('../downloads/' . $file);
?>