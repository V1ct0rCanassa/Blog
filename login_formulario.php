<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Projeto</title>
    <link rel="stylesheet" href="lib/bootstrap-4.2.1-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <!-- Inclui o topo da página -->
                <?php include 'includes/topo.php'; ?>
            </div>
        </div>
        <div class="row" style="min-height: 500px;">
            <div class="col-md-12">
                <!-- Inclui o menu da página -->
                <?php include 'includes/menu.php'; ?>
            </div>
            <div class="col-md-10" style="padding-top: 50px;">
                <!-- Formulário de login -->
                <div class="card-header">Login</div>
                <div class="card-body">
                    <form action="core/usuario_repositorio.php" method="post">
                        <input type="hidden" name="acao" value="login"> <!-- Ação de login -->
                        
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" required id="email" name="email"> <!-- Campo para e-mail -->
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" required id="senha" name="senha"> <!-- Campo para senha -->
                        </div>
                        <div class="text-right">
                            <button class="btn btn-success" type="submit">Acessar</button> <!-- Botão de login -->
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <!-- Inclui o rodapé da página -->
                <?php include 'includes/rodape.php'; ?>
            </div>
        </div>
    </div>
    <script src="lib/bootstrap-4.2.1-dist/js/bootstrap.min.js"></script>
</body>
</html>
