const form = document.querySelector('#filmesForm');
const tituloInput = document.querySelector('#tituloInput');
const diretorInput = document.querySelector('#diretorInput');
const anoLanInput = document.querySelector('#anoLanInput');
const generoInput = document.querySelector('#generoInput');
const tableBody = document.querySelector('#filmesTable');
const URL = 'http://localhost:8080/apiPHP/Filmes.php';

function carregarFilmes(){
    fetch(URL, {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        },
        mode: 'cors'
    })
        .then(response => response.json())
        .then(filmes => {
            tableBody.innerHTML = ''

            for(let i = 0; i <= filmes.length; i++){
                const tr = document.createElement('tr');
                const filme = filmes[i];
                tr.innerHTML = `
                    <td>${filme.id}</td>
                    <td>${filme.titulo}</td>
                    <td>${filme.diretor}</td>
                    <td>${filme.ano_lancamento}</td>
                    <td>${filme.genero}</td>
                    <td>
                        <button data-id="${filme.id}" class="btn btn-secondary" onclick="atualizarFilme(${filme.id})">Editar</button>
                        <button class="btn btn-secondary" onclick="excluirFilme(${filme.id})">Excluir</button>
                    </td>
                `
                tableBody.appendChild(tr);
            }
        })
}


function adicionarFilmes(event){
    event.preventDefault;

    const titulo = tituloInput.value;
    const diretor = diretorInput.value;
    const ano_lancamento = anoLanInput.value;
    const genero = generoInput.value;

    fetch(URL, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `titulo=${encodeURIComponent(titulo)}&diretor=${encodeURIComponent(diretor)}&ano_lancamento=${encodeURIComponent(ano_lancamento)}&genero=${encodeURIComponent(genero)}`
    })
        .then(response => {
            if(response.ok){
                carregarFilmes();
                tituloInput.value = '';
                diretorInput.value = '';
                anoLanInput.value = '';
                generoInput.value = '';
            } else{
                console.error('Erro ao adicionar Filme');
                alert('Erro ao adicionar Filme');
            }
        })
}

function atualizarFilme(id){
    const novoTitulo = prompt("Digite o novo título");
    const novoDiretor = prompt("Digite o novo diretor");
    const novoAno = prompt("Digite o novo ano de lançamento");
    const novoGenero = prompt("Digite o novo gênero");

    if(novoTitulo && novoAno && novoDiretor && novoGenero){
        fetch(`${URL}?id=${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `titulo=${encodeURIComponent(novoTitulo)}&diretor=${encodeURIComponent(novoDiretor)}&ano_lancamento=${encodeURIComponent(novoAno)}&genero=${encodeURIComponent(novoGenero)}`
        })
            .then(response => {
                if(response.ok){
                    carregarFilmes();
                    alert('Filme atualizado com sucesso!');
                } else{
                    console.error('Erro ao atualizar filme');
                    alert('Erro ao atualizar filme');
                }
            }
        )
    }
}

function excluirFilme(id){
    if(confirm('Deseja excluir esse filme?')){
        fetch(`${URL}?id=${id}`, {
            method: 'DELETE'
        })
            .then(response => {
                if(response.ok) {
                    carregarFilmes();
                } else{
                    console.error('Erro ao excluir Filme');
                    alert('Erro ao excluir Filme');
                }
            })
    }
}

form.addEventListener('submit', adicionarFilmes);

carregarFilmes(); 