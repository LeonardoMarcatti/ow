<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once '../classes/Connection.php';
    require_once '../classes/Moviment.php';
    
    use classes\Connection;
    use classes\Moviment;
    use classes\MovimentDAO;

    if (!empty($_POST['tipo']) && !empty($_POST['valor']) && !empty($_POST['id'])) {
        $type = \strtoupper(\filter_input(\INPUT_POST, 'tipo', \FILTER_SANITIZE_STRING));
        $value = str_replace(',', '.', $_POST['valor']);
        $value = \filter_var($value, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION);
        $created_at = date('Y-m-d H:i:s');
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);

        $db = new Connection();
        $conection = $db->getConnection();
        $mov = new Moviment;
        $dao = new MovimentDAO($conection);

        $mov->setType($type);
        $mov->setValue($value);
        $mov->setCreatedAt($created_at);
        $mov->setID_User($id);
        $dao->addMov($mov);

        \http_response_code(200);
        echo 'Movimentação adicionada com sucesso!';
        exit;
    } else{
        \http_response_code(404);
        echo 'Por favor insira ID do usuário, valor da movimentação e o tipo de movimentação';
        exit;
    };

?>