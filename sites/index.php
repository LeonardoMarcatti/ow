<?php
    namespace sites;
    setlocale(LC_ALL, "pt_BR.utf-8");

    require_once '../classes/Connection.php';
    require_once '../classes/Email.php';
    require_once '../classes/Moviment.php';
    require_once '../classes/Users.php';
    require_once '../classes/Info.php';

    use classes\Connection;
    use classes\UserDAO;
    use classes\InfoDAO;

    $db = new Connection;
    $conn = $db->getConnection();
    $userDAO = new UserDAO($conn);
    $users = $userDAO->getUsers();
    $perPage = 5;

    if (!empty($_POST['user'])) {
        $id = \filter_input(\INPUT_POST, 'user', \FILTER_SANITIZE_NUMBER_INT);

        $infoDAO = new InfoDAO($conn);

        $userInfo = $infoDAO->getUserInfo($id);
        $number = $infoDAO->getMovimentNumber($id);
        $block = $infoDAO->getMovimentBlock($id);
        $pages = ceil($number/$perPage);
    };

    if (!empty($_GET['id']) && !empty($_GET['page'])) {
        $page = \filter_input(\INPUT_GET, 'page', \FILTER_SANITIZE_NUMBER_INT) - 1;
        $id = \filter_input(\INPUT_GET, 'id', \FILTER_SANITIZE_NUMBER_INT);

        $infoDAO = new InfoDAO($conn);
        $number = $infoDAO->getMovimentNumber($id);
        $block = $infoDAO->getMovimentBlock($id, $page*5);
        $pages = ceil($number/$perPage);
        $userInfo = $infoDAO->getUserInfo($id);
    };

?>

<!DOCTYPE html>
<html lang="pt-BR">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=yes">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="icon" href="https://phproberto.gallerycdn.vsassets.io/extensions/phproberto/vscode-php-getters-setters/1.2.3/1525759974843/Microsoft.VisualStudio.Services.Icons.Default" type="image/gif" sizes="16x16">
        <link rel="stylesheet" href="assets/css/style.css">
        <title>PHP</title>
    </head>
    <body>
        <div class="container-fluid">
            <div id="divform" class="col-4 float-start">
                <form action="index.php" method="post">
                    <div class="mb-3">
                        <label for="select">Selecione Usuário:</label>
                        <select name="user" id="select" class="form-select">
                            <option value="0">Selecione Usuário</option>
                            <?php 
                                foreach ($users as $key => $user) { ?>
                                    <option value="<?=$user['id']?>"><?=$user['name']?></option>
                            <?php }; ?>
                        </select>
                    </div>
                    <div id="user_info" class="mb-3"></div>
                    <div>
                        <button type="submit" class="btn btn-success">Visualizar</button>
                    </div>
                    <?php
                        if (isset($userInfo)) { ?>
                            <p>Nome: <?=$userInfo['name']?></p>
                            <p>Email: <?=$userInfo['email']?></p>
                            <p>Nascimento: <?=$userInfo['birthday']?></p>
                            <p>Cadastrado em: <?=$userInfo['created_at']?></p>
                            <p>Atualizado em: <?=$userInfo['updated_at']?></p>
                     <?php   };
                    ?>

                    
                </form>
                <div id="footer">
                    <?php
                        if (isset($pages)) {
                            for ($i=0; $i < $pages; $i++) { ?>
                                <div class="page"><a href="index.php?id=<?=$id?>&page=<?=$i+1?>"><?=$i+1?></a></div>
                            <?php }; 
                        };
                        ?>
                </div>
            </div>
            <div class="col-8 float-end" id="user_movs">
                <?php 
                    if ( isset($block) && \count($block) > 0) { ?>
                        <table class="table table-hover table-bordered">
                            <thead class="table-dark text-center">
                                <tr>
                                    <th class="col-1">ID</th>
                                    <th class="col-3">Tipo</th>
                                    <th class="col-4">Valor</th>
                                    <th class="col-4">Data</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    foreach ($block as $key => $value) { ?>
                                        <tr class="text-center">
                                            <td><?=$value['id']?></td>
                                            <td><?=$value['mov_type']?></td>
                                            <td><?=$value['mov_value']?></td>
                                            <td><?=$value['mov_created_at']?></td>
                                        </tr>
                                <?php }; ?>
                            </tbody>
                        </table>
                 <?php }; ?>
            </div>
        </div>
        

        <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/ec29234e56.js" crossorigin="anonymous"></script>
        <script src="" defer></script>
    </body>
</html>