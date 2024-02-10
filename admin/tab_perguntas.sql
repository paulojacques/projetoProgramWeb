CREATE TABLE perguntas (
    id SERIAL PRIMARY KEY,
    texto_pergunta TEXT NOT NULL,
    opcao1 VARCHAR(255) NOT NULL,
    opcao2 VARCHAR(255) NOT NULL,
    opcao3 VARCHAR(255) NOT NULL,
    opcao4 VARCHAR(255) NOT NULL,
    resposta VARCHAR(255) NOT NULL
);
