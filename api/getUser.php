<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');

    require_once '../classes/Connection.php';
    require_once '../classes/Users.php';

    use classes\Connection;
    use classes\User;
    use classes\UserDAO;

    if (!empty($_POST['id'])) {
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
    
        $db = new Connection();
        $conection = $db->getConnection();

        $user = new User();
        $dao = new UserDAO($conection);

        $user->setID($id);
        $val = $dao->getUser($user);
        if ($val) {
            $file = 'user.json';
            header("Content-Disposition: attachment; filename=". $file);
            \readfile('../downloads/user.json');
        } else {
            if (\file_exists('../downloads/user.json')) {
                \unlink('../downloads/user.json');
            };
        };
    } else {
        \http_response_code(500);
        exit;
    };
?>