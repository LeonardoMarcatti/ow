<?php
    namespace classes;

use NumberFormatter;

class InfoDAO
    {
        private object $pdo;

        public function __construct(\PDO $con)
        {
            $this->pdo = $con;
        }

        public function getUserInfo(int $id)
        {
            $sql = "select u.id, u.name as name, u.birthday, u.created_at, updated_at, e.email from users u join email e on u.id = e.id_user where u.id = :id";
            $select = $this->pdo->prepare($sql);
            $select->bindValue(':id', $id);
            $select->execute();
            $result = $select->fetch(\PDO::FETCH_ASSOC);
            $user = [];
            foreach ($result as $key => $value) {
                if ($key == 'created_at' || ($key == 'updated_at' && $value != null) || $key == 'birthday') {
                    $date = \explode('-', $value);
                    $new_date = $date[2] . '/' . $date[1] . '/' . $date[0];
                    $user[$key] = $new_date;
                } else{
                    $user[$key] = $value;
                };
                
            };
            return $user;
        }

        public function getMovimentNumber(int $id)
        {
            $sql = 'select count(*) as number from moviment where id_user = :id';
            $number = $this->pdo->prepare($sql);
            $number->bindValue(':id', $id);
            $number->execute();
            $result = $number->fetch(\PDO::FETCH_ASSOC)['number'];
            return $result;
        }

        public function getMovimentBlock(int $id, int $offset = 0)
        {
            $sql = "select * from moviment where id_user = :id limit 5 offset " . $offset;
            $block = $this->pdo->prepare($sql);
            $block->bindValue(':id', $id);
            $block->execute();
            $result = $block->fetchAll(\PDO::FETCH_ASSOC);
            $movs = [];
            $mov = [];
            foreach ($result as $key => $item) {
                foreach ($item as $key2 => $value) {
                    if ($key2 == 'mov_created_at') {
                        $date = \explode('-', $value);
                        $new_date = $date[2] . '/' . $date[1] . '/' . $date[0];
                        $mov[$key2] = $new_date;
                    } else if ($key2 == 'mov_value'){
                        $currency = new NumberFormatter('pt_BR', NumberFormatter::CURRENCY);
                        $value = $currency->formatCurrency($value, "BRL");
                        $mov[$key2] = $value;
                    } else{
                        $mov[$key2] = $value;
                    };
                };
                $movs[] = $mov;                 
            };
            return $movs;
        }
    }

?>