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

    if (!empty($_POST['name']) && !empty($_POST['birthday']) && !empty($_POST['email'])) {
        $db = new Connection();
        $conection = $db->getConnection();
        $user = new User;
        $userDAO = new UserDAO($conection);
        $email = new Email;
        $emailDAO = new EmailDAO($conection);

        $name = \filter_input(\INPUT_POST, 'name', \FILTER_SANITIZE_STRING);
        $birthday = \filter_input(\INPUT_POST, 'birthday', \FILTER_SANITIZE_STRING);
        $created_at = date('Y-m-d H:i:s');
        $emailAddress = \filter_input(\INPUT_POST, 'email', \FILTER_SANITIZE_EMAIL);

        $user->setName($name);
        $user->setBirthday($birthday);
        $user->setCreated_at($created_at);

        $userDAO->addUser($user);
        $maxID = $userDAO->getMaxID();

        $email->setEmail($emailAddress);
        $email->setID_User($maxID->getID());
        $emailDAO->addEmail($email);

    } else {
        \http_response_code(500);
        exit;
    };
    


?>