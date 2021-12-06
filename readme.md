A - CONFIGURAÇÕES INICIAIS
    1 - A pasta ow deve ser copiada para a pasta html do apache2;
        1.1 - Adicionar permissões recursivas de leitura e escrita no servidor para a pasta downloads;
    2 - Quando for utilizada a API os caminhos para os endpoints seguião um padrão até essa pasta seguido de uma barra '/' e o nome do endpoint.php; Ex. ip_do_server/ow/endpoint.php
    3 - No mysql, rodar o script que se encontra na pasta ow que criará o banco de dados bem como as tabelas e as populariza-rá com alguns dados de exemplo;
    4 - Para usar a API vamos utilizar o Postman;

B - SOBRE O POSTMAN
    1 - Os caminhos para os endpoints estão dentro da pasta api que por sua vez escontram dentro da pasta ow;
    2 - Os endpoints da API são:
        2.1 - Para obter um único usuário (arquivo JSON): getUser.php;
        2.2 - Para obter todos os usuários (arquivo JSON): getAll.php;
        2.2 - Para deletar um usuário: delUser.php;
        2.3 - Para adicionar um usuário: addUser.php;
        2.4 - Para adicionar movimentação: addMov.php;
        2.5 - Para deletar movimentação: delMov.php;
        2.6 - Para obter todas as movimentações (arquivo csv) de um usuário: csvAll.php;
        2.7 - Para obter as movimentações de um período estipulado (arquivo csv) de um usuário: csvPeriod.php;
        2.8 - Para obter as movimentações dos últimos 30 dias (arquivo csv) de um usuário: csv30.php;
    3 - Para todos esses endpoints vamos usar apenas o método POST;
        3.1 - Adicionar no campo da URL o endpoint desejado e para cada um existe um body diferente que deve ser adicionado;
            3.1.1 - Clicar em body e selecionar form-data e para cada endpoint teremos que adicionar key/value distinto:
                a - Para os itens abaixo é necessário clicar na seta bem ao lado do botão SEND e selecionar Send and Download para baixar os respectivos arquivos;
                    3.1.1.1 - Para getUser.php: id/numero_do_id;
                    3.1.1.2 - Para getAll.php: selcione none dentro de body;
                    3.1.1.3 - Para csv30.php: id/numero_do_id;
                    3.1.1.4 - Para csvPeriod.php: id/numero_do_id, de/uma_data e ate/outra_data; Ex: xx/xx/xxxx
                    3.1.1.5 - Para csvAll.php: id/numero_do_id;
                b - Para os itens abaixo é necessário somente clicar em SEND pois nenhum arquivo será retornado;
                    3.1.1.6 - Para addUser.php: nome/nome_do_usuário, email/endereco_de_email e nascimento/data_nascimento;
                    3.1.1.7 - Para addMov.php: tipo/(deb,cred,est), valor/um número e id/numero de id;
                    3.1.1.8 - Para delMov.php: id/numero_do_id. Este é o id do movimento e não do usuário;
                    3.1.1.9 - Para delUser.php: id/id_do_usuário;
                    3.1.1.10 - Para setSaldo.php: id/id_do_usuário e valor/um numero.

C - VISUALIZAR MOVIMENTAÇÃO
    1 - Aponte a url para ip_do_server/ow/sites;
    2 - Selecione um usuário na lista a esquerda e clique em Visualizar;
    3 - São exibidos 5 movimentos por vez a direita e abaixo do botão visualizar aparecerá informações sobre o usuário bem como, se existirem mais de 5 movimentações, alguns outros botões que mostram mais movimentações.