CREATE DATABASE IF NOT EXISTS atelie_bordado CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE atelie_bordado;

CREATE TABLE IF NOT EXISTS orcamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome_peca VARCHAR(150) NOT NULL,
    etamine_largura DECIMAL(6,2),
    etamine_altura DECIMAL(6,2),
    acabamento_largura DECIMAL(6,2),
    acabamento_altura DECIMAL(6,2),
    qtd_cores INT,
    qtd_chaveiros INT,
    metros_linha DECIMAL(8,2),
    ml_cola DECIMAL(8,2),
    custo_materiais DECIMAL(10,2),
    preco_final DECIMAL(10,2),
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS configuracoes_precos ( /* aqui vc pode mudar para os precos da sua realidade. Eles estao em real */ 
    id INT PRIMARY KEY DEFAULT 1,
    preco_meada DECIMAL(10,2) DEFAULT 6.00,
    preco_cola DECIMAL(10,2) DEFAULT 13.78,
    preco_etamine DECIMAL(10,2) DEFAULT 20.00,
    preco_acabamento DECIMAL(10,2) DEFAULT 14.99,
    preco_pacote_chaveiro DECIMAL(10,2) DEFAULT 13.00
);

INSERT IGNORE INTO configuracoes_precos (id) VALUES (1);