<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header('Content-Description: File Transfer');
    header('Content-Type: text/csv');
    

    require_once '../classes/Connection.php';
    require_once '../classes/Users.php';
    require_once '../classes/Moviment.php';

    use classes\Connection;
    use classes\Moviment;
    use classes\MovimentDAO;

    if (!empty($_POST['id'])){
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $db = new Connection();
        $conection = $db->getConnection();
        $mov = new Moviment;
        $mov->setID_User($id);
        $movDAO = new MovimentDAO($conection);
        $data = $movDAO->getAllMov($mov);

        if (!empty($data)) {
            $open = \fopen('php://output', 'w');
            \fputcsv($open, \array_keys($data[0]), ';');

            foreach ($data as $key => $value) {
                \fputcsv($open, $value, ';');
            };
    
            \fclose($open);
    
            header("Content-Disposition: attachment; filename=all.csv");
        };
    } else{
        \http_response_code(404);
        echo 'not found';
        exit;
    };
?>