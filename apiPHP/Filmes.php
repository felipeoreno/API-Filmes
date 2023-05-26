<?php
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
    header('Access-Control-Allow-Headers: Content-Type');

    if($_SERVER['REQUEST_METHOD'] === 'OPTIONS'){
        exit;
    }

    include 'conexao.php';

    // vai se pegar todos os filmes
    if($_SERVER['REQUEST_METHOD'] == 'GET'){
        $stmt = $conn->prepare("SELECT * FROM filmes;");
        $stmt->execute();
    
        // os dados recebidos do banco são atribuídos por meio do PDO à variável $filmes
        $filmes = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo(json_encode($filmes));
    }

    // rota para criar filmes
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $titulo = $_POST['titulo'];
        $diretor = $_POST['diretor'];
        $ano_lancamento = $_POST['ano_lancamento'];
        $genero = $_POST['genero'];

        $stmt = $conn->prepare("INSERT INTO filmes (titulo, diretor, ano_lancamento, genero) VALUES (:titulo, :diretor, :ano_lancamento, :genero);");
    } // a terminar
?>