<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once '../classes/Connection.php';
    require_once '../classes/Moviment.php';
    
    use classes\Connection;
    use classes\Moviment;
    use classes\MovimentDAO;

    if (!empty($_POST['id'])){
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);

        $db = new Connection();
        $conection = $db->getConnection();
        $mov = new Moviment;
        $dao = new MovimentDAO($conection);

        $mov->setID($id);
        if ($dao->checkMov($mov)) {
            $dao->delMov($mov);
            \http_response_code(200);
            echo 'Movimentação removida com sucesso.';
            exit;
        } else {
            \http_response_code(404);
            echo 'Movimentação inexistente. Verifique o ID correspondente';
            exit;
        };
    } else{
        \http_response_code(404);
        echo 'Por favor insira ID da movimentação';
        exit;
    };
?>