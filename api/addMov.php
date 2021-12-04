<?php
    namespace ow;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    
    require_once '../classes/Connection.php';
    require_once '../classes/Moviment.php';
    
    use classes\Connection;
    use classes\Moviment;
    use classes\MovimentDAO;

    if (!empty($_POST['type']) && !empty($_POST['value']) && !empty($_POST['iduser'])) {
        $type = \strtoupper(\filter_input(\INPUT_POST, 'type', \FILTER_SANITIZE_STRING));
        $value = str_replace(',', '.', $_POST['value']);
        $value = \filter_var($value, \FILTER_SANITIZE_NUMBER_FLOAT, \FILTER_FLAG_ALLOW_FRACTION);
        $created_at = date('Y-m-d H:i:s');
        $id = \filter_input(\INPUT_POST, 'iduser', \FILTER_SANITIZE_NUMBER_INT);

        $db = new Connection();
        $conection = $db->getConnection();
        $mov = new Moviment;
        $dao = new MovimentDAO($conection);

        $mov->setType($type);
        $mov->setValue($value);
        $mov->setCreatedAt($created_at);
        $mov->setID_User($id);

        $dao->addMov($mov);
    };

?>