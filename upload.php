<?php
// Verificando se um arquivo foi enviado
if (isset($_FILES["arquivo"])) {
    $arquivo_nome = $_FILES["arquivo"]["name"];
    $arquivo_tmp = $_FILES["arquivo"]["tmp_name"];

    // Movendo o arquivo para uma pasta no servidor
    $destino = "uploads/" . $arquivo_nome;
    move_uploaded_file($arquivo_tmp, $destino);

    // Calculando o MD5 do arquivo
    $md5_hash = md5_file($destino);

    // Conectando ao banco de dados MySQL
    $conn = new mysqli("servidor", "usuario", "senha", "nome_do_banco");

    // Inserindo os dados na tabela
    $sql = "INSERT INTO assinaturas (arquivo_nome, md5_hash) VALUES ('$arquivo_nome', '$md5_hash')";
    $conn->query($sql);
    
    // Fechando a conexão com o banco de dados
    $conn->close();

    echo "Arquivo enviado com sucesso e MD5 calculado!";
} else {
    echo "Erro ao enviar o arquivo.";
}
?>