<?php
    namespace sites;
    setlocale(LC_ALL, "pt_BR.utf-8");
    require_once '../classes/Connection.php';

    use classes\Connection;


    if ($_POST['id']) {
        $id = \filter_input(\INPUT_POST, 'id', \FILTER_SANITIZE_NUMBER_INT);
        $db = new Connection;
        $conn = $db->getConnection();

        $sql = "select u.id, u.name as name, u.birthday, u.created_at, ifnull(updated_at, '-') as updated_at, e.email, m.mov_type as 'type', m.mov_value as Value, m.mov_created_at as 'moved' from users u join email e on u.id = e.id_user join moviment m on u.id = m.id_user where u.id = :id";
        $select = $conn->prepare($sql);
        $select->bindValue(':id', $id);
        $select->execute();
        $result = $select->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    };

?>