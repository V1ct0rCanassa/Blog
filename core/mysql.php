<?php

// Função para inserir dados em uma tabela
function insere(string $entidade, array $dados) : bool
{
    $retorno = false;

    // Cria placeholders e determina o tipo de cada dado
    foreach ($dados as $campo => $dado) {
        $coringa[$campo] = '?'; // Placeholder
        $tipo[] = gettype($dado)[0]; // Tipo do dado
        $$campo = $dado;  
    }

    // Monta a instrução SQL de inserção
    $instrucao = insert($entidade, $coringa);
    
    // Conecta ao banco de dados
    $conexao = conecta();

    // Prepara a instrução SQL
    $stmt = mysqli_prepare($conexao, $instrucao);

    // Vincula os parâmetros usando eval (prática arriscada)
    eval('mysqli_stmt_bind_param($stmt, \'' . implode('', $tipo) . '\',$' . implode(', $', array_keys($dados)) . ');');

    // Executa a instrução
    mysqli_stmt_execute($stmt);
    
    // Verifica se a operação afetou alguma linha
    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    // Armazena erros, se houver
    $_SESSION['erros'] = mysqli_stmt_error_list($stmt);

    // Fecha a instrução
    mysqli_stmt_close($stmt);

    // Desconecta do banco de dados
    desconecta($conexao);

    return $retorno; // Retorna o status da operação
}

// Função para atualizar registros em uma tabela
function atualiza(string $entidade, array $dados, array $criterio = []) : bool
{
    $retorno = false;

    // Cria placeholders e determina o tipo de cada dado a ser atualizado
    foreach ($dados as $campo => $dado) {
        $coringa_dados[$campo] = '?';
        $tipo[] = gettype($dado)[0];
        $$campo = $dado;
    }

    // Processa os critérios para a atualização
    foreach ($criterio as $expressao) {
        $dado = $expressao[count($expressao) - 1];

        $tipo[] = gettype($dado)[0];
        $expressao[count($expressao) - 1] = '?'; // Placeholder para o critério
        $coringa_criterio[] = $expressao;

        // Determina o nome do campo a ser usado
        $nome_campo = (count($expressao) < 4) ? $expressao[0] : $expressao[1];
        
        // Cria um nome único para evitar conflitos
        if (isset($nome_campo)) {
            $nome_campo = $nome_campo . '_' . rand();
        }

        $campos_criterio[] = $nome_campo;

        $$nome_campo = $dado;  
    }

    // Monta a instrução SQL de atualização
    $instrucao = update($entidade, $coringa_dados, $coringa_criterio);

    // Conecta ao banco de dados
    $conexao = conecta();

    // Prepara a instrução SQL
    $stmt = mysqli_prepare($conexao, $instrucao);

    // Vincula os parâmetros usando eval (prática arriscada)
    if (isset($tipo)) {
        $comando = 'mysqli_stmt_bind_param($stmt,';
        $comando .= "'" . implode('', $tipo) . "'";
        $comando .= ', $' . implode(', $', array_keys($dados));
        $comando .= ', $' . implode(', $', $campos_criterio);
        $comando .= ');';

        eval($comando);
    }

    // Executa a instrução
    mysqli_stmt_execute($stmt);

    // Verifica se a operação afetou alguma linha
    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    // Armazena erros, se houver
    $_SESSION['errors'] = mysqli_stmt_error_list($stmt);

    // Fecha a instrução
    mysqli_stmt_close($stmt);

    // Desconecta do banco de dados
    desconecta($conexao);

    return $retorno; // Retorna o status da operação
}

// Função para deletar registros de uma tabela
function deleta(string $entidade, array $criterio = []) : bool
{
    $retorno = false;
    $coringa_criterio = [];

    // Processa os critérios para a deleção
    foreach ($criterio as $expressao) {
        $dado = $expressao[count($expressao) - 1];

        $tipo[] = gettype($dado)[0];
        $expressao[count($expressao) - 1] = '?'; // Placeholder para o critério
        $coringa_criterio[] = $expressao;

        // Determina o nome do campo a ser usado
        $nome_campo = (count($expressao) < 4) ? $expressao[0] : $expressao[1];
        
        $campos_criterio[] = $nome_campo;

        $$nome_campo = $dado;  
    }

    // Monta a instrução SQL de deleção
    $instrucao = delete($entidade, $coringa_criterio);

    // Conecta ao banco de dados
    $conexao = conecta();

    // Prepara a instrução SQL
    $stmt = mysqli_prepare($conexao, $instrucao);

    // Vincula os parâmetros usando eval (prática arriscada)
    if (isset($tipo)) {
        $comando = 'mysqli_stmt_bind_param($stmt,';
        $comando .= "'" . implode('', $tipo) . "'";
        $comando .= ', $' . implode(', $', $campos_criterio);
        $comando .= ');';

        eval($comando);
    }

    // Executa a instrução
    mysqli_stmt_execute($stmt);

    // Verifica se a operação afetou alguma linha
    $retorno = (boolean) mysqli_stmt_affected_rows($stmt);

    // Armazena erros, se houver
    $_SESSION['errors'] = mysqli_stmt_error_list($stmt);

    // Fecha a instrução
    mysqli_stmt_close($stmt);

    // Desconecta do banco de dados
    desconecta($conexao);

    return $retorno; // Retorna o status da operação
}

// Função para buscar dados em uma tabela
function buscar(string $entidade, array $campos = ['*'], array $criterio = [], string $ordem = null) : array
{
    $retorno = false;
    $coringa_criterio = [];

    // Processa os critérios para a busca
    foreach ($criterio as $expressao) {
        $dado = $expressao[count($expressao) - 1];

        $tipo[] = gettype($dado)[0];
        $expressao[count($expressao) - 1] = '?'; // Placeholder para o critério
        $coringa_criterio[] = $expressao;

        // Determina o nome do campo a ser usado
        $nome_campo = (count($expressao) < 4) ? $expressao[0] : $expressao[1];
        
        // Cria um nome único para evitar conflitos
        if (isset($$nome_campo)) {
            $nome_campo = $nome_campo . '_' . rand();
        }

        $campos_criterio[] = $nome_campo;

        $$nome_campo = $dado;  
    }

    // Monta a instrução SQL de seleção
    $instrucao = select($entidade, $campos, $coringa_criterio, $ordem);
    
    // Conecta ao banco de dados
    $conexao = conecta();

    // Prepara a instrução SQL
    $stmt = mysqli_prepare($conexao, $instrucao);

    // Vincula os parâmetros usando eval (prática arriscada)
    if (isset($tipo)) {
        $comando = 'mysqli_stmt_bind_param($stmt,';
        $comando .= "'" . implode('', $tipo) . "'";
        $comando .= ', $' . implode(', $', $campos_criterio);
        $comando .= ');';

        eval($comando);
    }
    
    // Executa a instrução
    mysqli_stmt_execute($stmt);
    
    // Recupera os resultados da busca
    if ($result = mysqli_stmt_get_result($stmt)) {
        $retorno = mysqli_fetch_all($result, MYSQLI_ASSOC); // Formato associativo

        mysqli_free_result($result); // Libera memória
    }

    // Armazena erros, se houver
    $_SESSION['errors'] = mysqli_stmt_error_list($stmt);

    // Fecha a instrução
    mysqli_stmt_close($stmt);

    // Desconecta do banco de dados
    desconecta($conexao);

    return $retorno; // Retorna os resultados da busca
}
?>