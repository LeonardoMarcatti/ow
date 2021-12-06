<?php
    namespace classes;

    interface DAOmov{
        public function addMov(Moviment $m);
        public function delMov(Moviment $m);
    }

    class Moviment
    {
        private string $type, $created_at;
        private float $value;
        private int $id_user, $id;
        
        public function setType(string $val)
        {
            $this->type = $val;
        }

        public function setID(int $val)
        {
            $this->id = $val;
        }

        public function setCreatedAt(string $val)
        {
            $this->created_at = $val;
        }

        public function setValue(float $val)
        {
            $this->value = $val;
        }

        public function setID_User(int $val)
        {
            $this->id_user = $val;
        }

        public function getType()
        {
            return $this->type;
        }

        public function getCreatedAt()
        {
            return $this->created_at;
        }

        public function getValue()
        {
            return $this->value;
        }

        public function getID()
        {
            return $this->id;
        }

        public function getID_User()
        {
            return $this->id_user;
        }
    };
    class MovimentDAO implements DAOmov
    {
        private object $pdo;

        public function __construct(\PDO $con)
        {
            $this->pdo = $con;
        }

        public function addMov(Moviment $m)
        {
            $sql = 'insert into moviment(mov_type, mov_value, mov_created_at, id_user) values(:t, :v, :c, :i)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':t', $m->getType());
            $insert->bindValue(':v', $m->getValue());
            $insert->bindValue(':c', $m->getCreatedAt());
            $insert->bindValue(':i', $m->getID_User());
            $insert->execute();
        }

        public function delMov(Moviment $m)
        {
            $sql = 'delete from moviment where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $m->getID());
            $delete->execute();
        }

        public function getAllMov(Moviment $m)
        {
            $sql = 'select u.id as ID_usuario, u.name as Nome, e.email, m.mov_type as operacao, m.mov_value as Valor, m.mov_created_at as Data, b.current_balance as Saldo from users u join email e on u.id = e.id_user join moviment m on u.id = m.id_user join balance b on u.id = b.id_user where u.id = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $m->getID_User());
            $select->execute();
            if ($select->rowCount() > 0 ) {
                $result = $select->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            } else{
                \http_response_code(404);
                echo 'not found';
                exit;
            };
        }

        public function checkMov(Moviment $m)
        {
            $sql = 'select id from moviment where id_user = :id limit 1';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $m->getID_User());
            $select->execute();
            if ($select->rowCount() > 0) {
                return true;
            };
            return false;            
        }

        public function getLast30(int $id)
        {
            $sql = 'select * from moviment where id_user = :id and mov_created_at < (now() - interval 30 day)';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $id);
            $select->execute();
            if ($select->rowCount() > 0 ) {
                $result = $select->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            };
            
            \http_response_code(404);
            echo 'not found';
            exit;
        }

        public function getPeriod(string $from, string $to, int $id)
        {
            $sql = 'select * from moviment where id_user = :id and mov_created_at > :f and mov_created_at < :t';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $id);
            $select->bindValue(':f', $from);
            $select->bindValue(':t', $to);
            $select->execute();
            if ($select->rowCount() > 0 ) {
                $result = $select->fetchAll(\PDO::FETCH_ASSOC);
                return $result;
            };
            
            \http_response_code(404);
            echo 'not found';
            exit;
        }

    };    
    
?>

