<?php
    namespace classes;

    class Balance 
    {
        private int $id, $id_user;
        private float $start, $current;

        public function setID(int $id)
        {
            $this->id = $id;
        }

        public function getID()
        {
            return $this->id;
        }

        public function setID_User(int $id)
        {
            $this->id_user = $id;
        }

        public function getID_User()
        {
            return $this->id_user;
        }

        public function setStart(float $start)
        {
            $this->start = $start;
        }

        public function getStart()
        {
            return $this->start;
        }

        public function setCurrent(float $current)
        {
            $this->current = $current;
        }

        public function getCurrent()
        {
            return $this->current;
        }
    };
   
    class BalanceDAO 
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public function checkBalance(Balance $b)
        {
            $sql = 'select current_balance from balance where id_user = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $b->getID_User());
            $select->execute();
            if ($select->rowCount() > 0) {
                $result = $select->fetch(\PDO::FETCH_ASSOC)['current_balance'];
                if ($result != '0.00') {
                    return true;  
                };
            };            
            return false;            
        }

        public function getStartBalance(Balance $b)
        {
            $sql = 'select start_balance from balance where id_user = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $b->getID_User());
            $select->execute();
            $result = $select->fetch()['start_balance'];
            return $result;
        }

        public function setStartBalance(Balance $b)
        {
            $sql = 'update balance set start_balance = :s where id_user = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':s', $b->getStart());
            $update->bindValue(':id', $b->getID_User());
            $update->execute();
        }

        public function getCurrentBalance(Balance $b)
        {
            $sql = 'select current_balance from balance where id_user = :id';
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $b->getID_User());
            $select->execute();
            $result = $select->fetch()['current_balance'];
            return $result;
        }

        public function setCurrentBalance(Balance $b)
        {
            $sql = 'update balance set current_balance = :c where id_user = :id';
            $update = $this->pdo->prepare($sql);
            $update->bindValue(':c', $b->getCurrent());
            $update->bindValue(':id', $b->getID_User());
            $update->execute();
        }

        public function delBalance(Balance $b)
        {
            $sql = 'delete from balance where id_user = :id';
            $del = $this->pdo->prepare($sql);
            $del->bindValue(':id', $b->getID_User());
            $del->execute();
        }
    };

?>