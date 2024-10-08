<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuário | Proxeto</title>
    <link rel="stylesheet" href="lib/bootstrap-4.2.1-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <?php include 'includes/topo.php'; ?>
            </div>
        </div>
        <div class="row" style="min-height: 500px;">
            <div class="col-md-12">
                <?php include 'includes/menu.php'; ?>
            </div>
            <div class="col-md-10" style="padding-top: 50px;">
                <?php
                    require_once 'includes/funcoes.php';
                    require_once 'core/conexao_mysql.php';
                    require_once 'core/sql.php';
                    require_once 'core/mysql.php';

                    // Verifica se o usuário está logado
                    if (isset($_SESSION['login'])) {
                        $id = (int) $_SESSION['login']['usuario']['id'];

                        // Busca os dados do usuário pelo ID
                        $criterio = [['id', '=', $id]];
                        $retorno = buscar('usuario', ['id', 'nome', 'email'], $criterio);
                        $entidade = $retorno[0]; // Captura a entidade do usuário
                    }
                ?>
                <h2>Usuário</h2>
                <!-- Formulário para inserir ou atualizar dados do usuário -->
                <form action="core/usuario_repositorio.php" method="post">
                    <input type="hidden" name="acao" value="<?php echo empty($id) ? 'insert' : 'update'; ?>">
                    <input type="hidden" name="id" value="<?php echo $entidade['id'] ?? ''; ?>">

                    <div class="form-group">
                        <label for="nome">Nome</label>
                        <input type="text" class="form-control" required id="nome" name="nome" value="<?php echo $entidade['nome'] ?? ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="email">E-mail</label>
                        <input type="email" class="form-control" required id="email" name="email" value="<?php echo $entidade['email'] ?? ''; ?>">
                    </div>
                    <?php if (!isset($_SESSION['login'])): ?>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" required id="senha" name="senha">
                        </div>
                    <?php endif; ?>
                    <div class="text-right">
                        <button class="btn btn-success" type="submit">Salvar</button> 
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <?php include 'includes/rodape.php'; ?>
            </div>
        </div>
    </div>
</body>
</html>
