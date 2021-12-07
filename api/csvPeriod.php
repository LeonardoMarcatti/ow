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

    if (!empty($_POST['id']) && !empty($_POST['de']) && !empty($_POST['ate'])){
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $from = \filter_input(\INPUT_POST, 'de', \FILTER_SANITIZE_STRING);
        $to = \filter_input(\INPUT_POST, 'ate', \FILTER_SANITIZE_STRING);
        $explodedFrom = \explode('/', $from);
        $explodedTo = \explode('/', $to);
        $formatedFrom = $explodedFrom[2] . '-' . $explodedFrom[1] . '-' . $explodedFrom[0];
        $formatedTo = $explodedTo[2] . '-' . $explodedTo[1] . '-' . $explodedTo[0];

        $db = new Connection();
        $conection = $db->getConnection();

        $movDAO = new MovimentDAO($conection);
        $data = $movDAO->getPeriod($formatedFrom, $formatedTo, $id);

        if (!empty($data)) {
            $open = \fopen('php://output', 'w');
            \fputcsv($open, \array_keys($data[0]), ';');

            foreach ($data as $key => $value) {
                \fputcsv($open, $value, ';');
            };
    
            \fclose($open);
    
            header("Content-Disposition: attachment; filename=csvperiod.csv");
        };

    } else{
        \http_response_code(404);
        echo 'not found';
        exit;
    };
?>