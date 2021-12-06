<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once '../classes/Connection.php';
    require_once '../classes/Users.php';
    require_once '../classes/Email.php';
    require_once '../classes/Balance.php';
    require_once '../classes/Moviment.php';

    use classes\Connection;
    use classes\User;
    use classes\UserDAO;
    use classes\Email;
    use classes\EmailDAO;
    use classes\Balance;
    use classes\BalanceDAO;
    use classes\Moviment;
    use classes\MovimentDAO;

    if (!empty($_POST['id'])) {
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        
        $db = new Connection();
        $conection = $db->getConnection();

        $balance = new Balance;
        $balanceDAO = new BalanceDAO($conection);
        $balance->setID_User($id);
        $checkBalance = $balanceDAO->checkBalance($balance);

        $mov = new Moviment;
        $movDAO = new MovimentDAO($conection);
        $mov->setID_User($id);
        $checkMoviment = $movDAO->checkMov($mov);

        if ($checkBalance && $checkMoviment) {
            \http_response_code(500);
            echo 'Não é possível deletar usuário pois o mesmo possui saldo ou movimentação.';
            exit;
        } else {
            $user = new User;
            $userDAO = new UserDAO($conection);
            $email = new Email;
            $emailDAO = new EmailDAO($conection);

            $email->setID_User($id);    
            $emailDAO->deleteEmail($email);
            $balanceDAO->delBalance($balance);

            $user->setID($id);
            $userDAO->deleteUser($user);
            \http_response_code(200);
            echo 'Usuário removido com sucesso.';
            exit;
        }
    } else {
        \http_response_code(500);
        echo 'ID não enviado.';
        exit;
    };
?>