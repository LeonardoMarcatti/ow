<?php
    namespace classes;
    class Connection
    {
        private string $server = 'localhost';
        private string $db = 'ow';
        private string $user = 'root';
        private string $password = 'a';
        private object $conection;

        public function getConnection()
        {
            try {
                $this->conection = new \PDO("mysql:host=$this->server; dbname=$this->db", $this->user, $this->password);
            } catch (\Throwable $th) {
                echo 'Erro linha: ' . $th->getLine() . "<br>";
                echo ('Código: ' . $th->getMessage());
            };

            return $this->conection;
        }
    };
?>