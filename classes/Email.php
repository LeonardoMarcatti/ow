<?php
    namespace classes;

    interface DAOemail
    {
        public function addEmail(Email $e);
        public function deleteEmail(Email $e);
        public function checkEmail(Email $e);
    }

    class Email
    {
        private int $id, $id_user;
        private string $email;
        
        public function setID(int $val)
        {
            $this->id = $val;
        }

        public function getID()
        {
            return $this->id;
        }

        public function setID_User(int $val)
        {
            $this->id_user = $val;
        }

        public function getID_User()
        {
            return $this->id_user;
        }

        public function setEmail(string $val)
        {
            $this->email = $val;
        }

        public function getEmail()
        {
            return $this->email;
        }
    }

    final class EmailDAO implements DAOemail
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function addEmail(Email $e)
        {
            $sql = 'insert into email(email, id_user) values(:e, :i)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':e', $e->getEmail());
            $insert->bindValue(':i', $e->getID_User());
            $insert->execute();
        }

        public function deleteEmail(Email $e)
        {
            $sql = 'delete from email where id_user = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $e->getID_User());
            $delete->execute();
        }

        public function checkEmail(Email $e)
        {
            $sql = 'select id from email where email = :e';
            $check = $this->pdo->prepare($sql);
            $check->bindValue(':e', $e->getEmail());
            $check->execute();
            if ($check->rowCount() > 0) {
               return true;
            };
            return false;
        }
    }
?>