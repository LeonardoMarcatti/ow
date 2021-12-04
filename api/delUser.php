<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once '../classes/Connection.php';
    require_once '../classes/Users.php';
    require_once '../classes/Email.php';

    use classes\Connection;
    use classes\User;
    use classes\UserDAO;
    use classes\Email;
    use classes\EmailDAO;

    if (!empty($_POST['id'])) {
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        
        $db = new Connection();
        $conection = $db->getConnection();
        $user = new User;
        $userDAO = new UserDAO($conection);
        $email = new Email;
        $emailDAO = new EmailDAO($conection);

        $email->setID_User($id);
        $emailDAO->deleteEmail($email);
        $user->setID($id);
        $userDAO->deleteUser($user);
        \http_response_code(200);
        exit;

    } else {
        \http_response_code(500);
        exit;
    };
?>