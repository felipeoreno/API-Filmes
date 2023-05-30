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
        // são atribuídos os dados do POST a variáveis que serão usadas no bindParam
        $titulo = $_POST['titulo'];
        $diretor = $_POST['diretor'];
        $ano_lancamento = $_POST['ano_lancamento'];
        $genero = $_POST['genero'];

        // é preparada a linha de inserção de dados no banco, utilizando o método bindParam para evitar sql injection
        $stmt = $conn->prepare("INSERT INTO filmes (titulo, diretor, ano_lancamento, genero) VALUES (:titulo, :diretor, :ano_lancamento, :genero);");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':ano_lancamento', $ano_lancamento);
        $stmt->bindParam(':genero', $genero);

        if($stmt->execute()){
            echo("Filme criado com sucesso!!");
        } else{
            echo("Erro ao criar filme");
        }
    }

    // rota para excluir um filme
    if($_SERVER['REQUEST_METHOD'] === 'DELETE' && isset($_GET['id'])){
        $id = $_GET['id'];
        $stmt = $conn->prepare("DELETE FROM filmes WHERE id = :id;");
        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            echo("Filme excluído com sucesso!!");
        } else{
            echo("Erro ao excluir filme");
        }
    }

    // rota para atualizar um filme já existente
    if($_SERVER['REQUEST_METHOD'] === 'PUT' && isset($_GET['id'])){
        parse_str(file_get_contents("php://input"), $_PUT);

        // são atribuídos os dados do POST a variáveis que serão usadas no bindParam
        $id = $_GET['id'];
        $novoTitulo = $_PUT['titulo'];
        $novoDiretor = $_PUT['direto'];
        $novoAno = $_PUT['ano_lancamento'];
        $novoGenero = $_PUT['genero'];

        $stmt = $conn->prepare("UPDATE filmes SET titulo = :titulo, diretor = :diretor, ano_lancamento = :ano_lancamento, genero = :genero WHERE id = :id;");
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':diretor', $diretor);
        $stmt->bindParam(':ano_lancamento', $ano_lancamento);
        $stmt->bindParam(':genero', $genero);
        $stmt->bindParam(':id', $id);

        if($stmt->execute()){
            echo("Filme atualizado com sucesso!!");
        } else{
            echo("Erro ao atualizar filme");
        }
    }
?>