<?php
// Verifique se um arquivo foi enviado
if (isset($_FILES["arquivo"])) {
    $arquivo_nome = $_FILES["arquivo"]["name"];
    $arquivo_tmp = $_FILES["arquivo"]["tmp_name"];

    // Mova o arquivo para uma pasta no servidor
    $destino = "uploads/" . $arquivo_nome;
    move_uploaded_file($arquivo_tmp, $destino);

    // Calcule o MD5 do arquivo
    $md5_hash = md5_file($destino);

    // Conecte-se ao banco de dados MySQL
    $conn = new mysqli("localhost", "root", "", "assinaturas_md5");

    // Insira os dados na tabela
    $sql = "INSERT INTO assinaturas (arquivo_nome, md5_hash) VALUES ('$arquivo_nome', '$md5_hash')";
    $conn->query($sql);
    
    // Feche a conexão com o banco de dados
    $conn->close();

    echo "Arquivo enviado com sucesso e MD5 calculado!";
} else {
    echo "Erro ao enviar o arquivo.";
}
?>