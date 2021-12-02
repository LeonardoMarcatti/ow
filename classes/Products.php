<?php
    namespace classes;

    interface DAO{
        public function getUser(User $u);
        public function getAll();
        public function updateUser(User $u);
        public function deleteUser(User $u);
        public function insertUser(User $u);
    }

    class User
    {
        private string $name, $email, $birthday, $created_at, $updated_at;
        private int $id;

        public function setName(string $val)
        {
            $this->name = $val;
        }

        public function setEmail(float $val)
        {
            $this->email = $val;
        }

        public function setBirthday(int $val)
        {
            $this->birthday = $val;
        }

        public function setID(int $val)
        {
           $this->id = $val;
        }

        public function getID()
        {
            return $this->id;
        }

        public function getName()
        {
            return $this->name;
        }

        public function getEmail()
        {
            return $this->email;
        }

        public function getBirthday()
        {
            return $this->birthday;
        }

        public function getCreated_at()
        {
            return $this->created_at;
        }

        public function getUpdated_at()
        {
            return $this->updated_at;
        }
    };

    class ProductsDAO
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }
        
        public function getUser(Products $p){
            $sql = 'select id, produto, qte, preco from estoque where id = :id';
            $product = $this->pdo->prepare($sql);
            $product->bindValue(':id', $p->getID());
            $product->execute();
            
            if ($product->rowCount() > 0) {
                $result = $product->fetchAll(\PDO::FETCH_ASSOC);
                echo \json_encode($result);
            } else{
                echo 'Not found';
            };
        }

        public function getAll()
        {    
            $sql = 'select id, produto, qte, preco from estoque';
            $products = $this->pdo->prepare($sql);
            $products->execute();
            $itens = [];
            foreach ($products as $key => $value) {
                $item['id'] = $value['id'];
                $item['produto'] = $value['produto'];
                $item['preco'] = $value['preco'];
                $item['qte'] = $value['qte'];
                $itens[] = $item;
            };
            echo \json_encode($itens);
        }

        public function insertProduct()
        {
            $data = \json_decode(file_get_contents('php://input'));
            if (!empty($data->produto) && !empty($data->qte) && !empty($data->preco)) {
                $sql = "insert into estoque(produto, qte, preco) values(:prod, :qte, :preco)";
                $product = $this->pdo->prepare($sql);
                $product->bindValue(':prod', $data->produto);
                $product->bindValue(':qte', $data->qte);
                $product->bindValue(':preco', $data->preco);
                $product->execute();
                
                echo \json_encode(["success" => true]);
                
            } else {
               echo 'Error!';
            };
        }

        function updateProduct(Products $p)
        {            
            $data = \json_decode(file_get_contents('php://input'));
            if (!empty($data->produto)) {
                $sql = "update estoque set produto = :prod where id = :id";
                $update = $this->pdo->prepare($sql);
                $update->bindValue(':id', $p->getID());
                $update->bindValue(':prod',  $data->produto);
                $update->execute();
            };

            if (!empty($data->qte)) {
                $sql = "update estoque set qte = :qte where id = :id";
                $update = $this->pdo->prepare($sql);
                $update->bindValue(':id', $p->getID());
                $update->bindValue(':qte',  $data->qte);
                $update->execute();
            };

            if (!empty($data->preco)) {
                $sql = "update estoque set preco = :preco where id = :id";
                $update = $this->pdo->prepare($sql);
                $update->bindValue(':id', $p->getID());
                $update->bindValue(':preco',  $data->preco);
                $update->execute();
            };

            $this->getProduct($p);
        }

        function deleteProduct(Products $p)
        {
            $sql = 'delete from estoque where id = :id';
            $products = $this->pdo->prepare($sql);
            $products->bindValue(':id', $p->getID());
            $products->execute();

            $this->getAll();
        }
    };
    
    

