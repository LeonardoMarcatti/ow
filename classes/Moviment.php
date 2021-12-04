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
    };    
    
?>

