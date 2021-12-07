<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');

    require_once '../classes/Connection.php';
    require_once '../classes/Balance.php';
    require_once '../classes/Users.php';

    use classes\Connection;
    use classes\Balance;
    use classes\BalanceDAO;
    use classes\User;
    use classes\UserDAO;

    
    if (!empty($_POST['id']) && !empty($_POST['valor'])) {
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $value = str_replace(',', '.', $_POST['valor']);
        $value = \filter_var($value, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION);

        $db = new Connection;
        $conn = $db->getConnection();
        $balance = new Balance;
        $balanceDAO = new BalanceDAO($conn);
        $user = new User;
        $userDAO = new UserDAO($conn);
        $user->setID($id);

        if ($userDAO->userExits($user)) {
            $balance->setID_User($id);
            $balance->setStart($value);
            $start_balance_value = $balanceDAO->getStartBalance($balance);
            $current_balance_value = $balanceDAO->getCurrentBalance($balance);

            if ($start_balance_value == $current_balance_value) {
                $balance->setCurrent($value);
                $balanceDAO->setCurrentBalance($balance);
                $balanceDAO->setStartBalance($balance);
            } else {
                $diff = $value - $start_balance_value;
                $balance->setCurrent($current_balance_value + $diff);
                $balanceDAO->setCurrentBalance($balance);
                $balanceDAO->setStartBalance($balance);
            };

            \http_response_code(200);
            echo 'Saldo inicial atualizado.';
            exit;
        } else {
            \http_response_code(500);
            echo 'Usuário Inexistente. Verifique o número de ID';
            exit;
        };

    } else {
        \http_response_code(500);
        echo 'ID e valor não enviados.';
        exit;
    };
    

?>