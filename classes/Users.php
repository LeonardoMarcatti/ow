<?php
    namespace classes;

    interface DAOusers{
        public function getUser(User $u);
        public function getAll();
        public function deleteUser(User $u);
        public function addUser(User $u);
    }

    class User
    {
        private string $name, $birthday, $created_at, $updated_at;
        private int $id;

        public function setName(string $val)
        {
            $this->name = $val;
        }

        public function setBirthday(string $val)
        {
            $this->birthday = $val;
        }

        public function setCreated_at(string $val)
        {
            $this->created_at = $val;
        }

        public function setUpdated_at(string $val)
        {
            $this->updated_at = $val;
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

    class UserDAO implements DAOusers
    {
        private $pdo;

        public function __construct(\PDO $conection){
            $this->pdo = $conection;
        }

        public static function createFileJSON($file_name, $content)
        {
            $file = \fopen('../downloads/' . $file_name, 'w+');
            \fputs($file, $content);
            \fclose($file);
        }
        
        public function getUser(User $u)
        {
            $sql = "select u.id, u.name, u.birthday, u.created_at, ifnull(u.updated_at, '-') as updated_at, e.email from users u join email e on u.id = e.id_user where u.id = :id";
            $user = $this->pdo->prepare($sql);
            $user->bindValue(':id', $u->getID());
            $user->execute();
            
            if ($user->rowCount() > 0) {
                $result = $user->fetch(\PDO::FETCH_ASSOC);
                self::createFileJSON('user.json', \json_encode($result));
                return true;
            } else{
                http_response_code(404);
                echo 'Not found';
            };
        }

        public function getAll()
        {
            $sql = "select u.id, u.name, u.birthday, u.created_at, ifnull(u.updated_at, '-') as updated_at, e.email from users u join email e on u.id = e.id_user order by created_at desc";
            $all = $this->pdo->prepare($sql);
            $all->execute();
            $result = $all->fetchAll(\PDO::FETCH_ASSOC);
            self::createFileJSON('all.json', \json_encode($result));
        }

        public function getUsers()
        {
            $sql = "select u.id, u.name, u.birthday, e.email from users u join email e on u.id = e.id_user";
            $all = $this->pdo->prepare($sql);
            $all->execute();
            $result = $all->fetchAll(\PDO::FETCH_ASSOC);
            return $result;
        }

        public function addUser(User $u)
        {
            $sql = 'insert into users(name, birthday, created_at) values(:n, :b, :c)';
            $insert = $this->pdo->prepare($sql);
            $insert->bindValue(':n', $u->getName());
            $insert->bindValue(':b', $u->getBirthday());
            $insert->bindValue(':c', $u->getCreated_at());
            $insert->execute();
        }

        public function getMaxID()
        {
            $sql = 'select max(id) as id from users';
            $select = $this->pdo->prepare($sql);
            $select->execute();
            $result = $select->fetch(\PDO::FETCH_ASSOC);

            $user = new User();
            $user->setID($result['id']);
            return $user;
        }

        public function deleteUser(User $u)
        {
            $sql = 'delete from users where id = :id';
            $delete = $this->pdo->prepare($sql);
            $delete->bindValue(':id', $u->getID());
            $delete->execute();
        }
    };