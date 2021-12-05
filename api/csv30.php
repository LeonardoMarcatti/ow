<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    

    require_once '../classes/Connection.php';
    require_once '../classes/Users.php';
    require_once '../classes/Moviment.php';

    use classes\Connection;
    use classes\MovimentDAO;

    if (!empty($_POST['id'])){
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $db = new Connection();
        $conection = $db->getConnection();

        $movDAO = new MovimentDAO($conection);
        $data = $movDAO->getLast30($id);

        if (!empty($data)) {
            $open = \fopen('php://output', 'w');
            foreach ($data as $key => $value) {
                \fputcsv($open, $value, ';');
            };
    
            \fclose($open);
    
            header("Content-Disposition: attachment; filename=csv30.csv");
        };

    } else{
        \http_response_code(404);
        echo 'not found';
        exit;
    }
?>