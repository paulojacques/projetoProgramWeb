function habilitarBotao() {
    var respostaSelecionada = document.querySelector('input[name="resposta"]:checked');
    document.getElementById("proximoBtn").disabled = !respostaSelecionada;
}

function proximoPergunta() {
    habilitarBotao(); // Certifique-se de verificar novamente antes de prosseguir
    var respostaSelecionada = document.querySelector('input[name="resposta"]:checked');

    if (respostaSelecionada) {
        document.getElementById("quizForm").submit(); // Envie o formulário quando uma opção for selecionada
    } else {
        alert("Por favor, escolha uma alternativa antes de prosseguir.");
    }
}