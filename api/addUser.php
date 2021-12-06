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

    if (!empty($_POST['nome']) && !empty($_POST['nascimento']) && !empty($_POST['email'])) {
        
        $name = \filter_input(\INPUT_POST, 'nome', \FILTER_SANITIZE_STRING);
        $birthday = \filter_input(\INPUT_POST, 'nascimento', \FILTER_SANITIZE_STRING);
        $exploded = \explode('/', $birthday);
        $formated_birthday = $exploded[2] . '-' . $exploded[1] . '-' . $exploded[0];
        $created_at = date('Y-m-d H:i:s');
        $emailAddress = \filter_input(\INPUT_POST, 'email', \FILTER_SANITIZE_EMAIL);

        //Verifica se o usuário tem mais de 18 anos
        if ((date('Y') - $exploded[2]) >= 18) {
            
            $db = new Connection();
            $conection = $db->getConnection();
            $user = new User;
            $userDAO = new UserDAO($conection);
            $email = new Email;
            $emailDAO = new EmailDAO($conection);

            $email->setEmail($emailAddress);

            //Verifica a existência prévia de um email no DB
            if ($emailDAO->checkEmail($email)) {
                \http_response_code(500);
                echo 'Email já cadastrado!';
                exit;
            } else {
                $user->setName($name);
                $user->setBirthday($formated_birthday);
                $user->setCreated_at($created_at);
                $userDAO->addUser($user);

                $maxID = $userDAO->getMaxID();
                $email->setID_User($maxID->getID());
                $emailDAO->addEmail($email);
    
                \http_response_code(200);
                echo 'Usuário criado com sucesso!';
                exit;
            };
        } else {
            \http_response_code(406);
            echo 'Usuário menor de idade!';
            exit;
        };
    } else {
        \http_response_code(500);
        echo 'Dados não enviados';
        exit;
    };
    


?>