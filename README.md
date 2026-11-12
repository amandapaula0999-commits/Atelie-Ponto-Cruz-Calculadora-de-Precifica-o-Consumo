Ateliê Ponto Cruz — Calculadora de Precificação & Consumo

Uma aplicação web artesanal e inteligente criada para ajudar artesãos de Ponto Cruz a calcular exatamente quanto cobrar por cada peça ou chaveiro, estimando automaticamente o consumo de linha (meadas), cola de silicone, tecido étamine e tecido de acabamento.

Nota / Adendo: Esse projeto foi feito com a ajuda de IA.

COMO FAZER FUNCIONAR (PASSO A PASSO RÁPIDO)

Você pode rodar este projeto de duas maneiras no seu computador:

Opção 1: Modo Completo com Banco de Dados (Recomendado — Usando XAMPP)

Ideal para salvar seu histórico de peças e tabela de preços permanentemente no banco de dados MySQL.

Baixe os arquivos do repositório

Baixe este projeto (ou clone com git clone) e garanta que você tenha os arquivos cit.html (ou calculadora_bordado.html), api.php e crieUmSQL.SQL.

Instale e inicie o XAMPP

Baixe e instale o XAMPP no seu computador.

Abra o XAMPP Control Panel e clique em Start nos módulos Apache e MySQL.

Coloque os arquivos na pasta do servidor

Vá até onde o XAMPP foi instalado (geralmente fica dentro do seu disco local ou dentro da pasta usuário).

Procure por uma pasta chamada htdocs dentro do XAMPP e abra ela.

Coloque a pasta do projeto que você acabou de baixar lá dentro do htdocs.

Crie o Banco de Dados

Abra o navegador e acesse: http://localhost/phpmyadmin (ou instale o MySQL diretamente na sua máquina, também funciona, é só configurar).

Clique na aba SQL no menu superior, cole todo o código SQL abaixo (ou importe o arquivo crieUmSQL.SQL) e clique em Executar (ou Go):

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

CREATE TABLE IF NOT EXISTS configuracoes_precos ( /* aqui você pode mudar para os preços da sua realidade. Eles estão em real */ 
    id INT PRIMARY KEY DEFAULT 1,
    preco_meada DECIMAL(10,2) DEFAULT 6.00,
    preco_cola DECIMAL(10,2) DEFAULT 13.78,
    preco_etamine DECIMAL(10,2) DEFAULT 20.00,
    preco_acabamento DECIMAL(10,2) DEFAULT 14.99,
    preco_pacote_chaveiro DECIMAL(10,2) DEFAULT 13.00
);

INSERT IGNORE INTO configuracoes_precos (id) VALUES (1);


Abra o Aplicativo no Navegador

Importante: Não abra o arquivo clicando duas vezes nele! Abra pelo navegador digitando o endereço:

http://localhost/atelie/cit.html

No topo da tela aparecerá a etiqueta verde: Conectado ao MySQL (XAMPP).

Opção 2: Modo Rápido Sem Instalação (Offline / LocalStorage)

Se você não quiser instalar o XAMPP ou quiser testar imediatamente:

Basta dar um duplo clique no arquivo cit.html para abri-lo no seu navegador (Chrome, Edge, Firefox, etc.).

O sistema detectará automaticamente que o servidor PHP/MySQL não está ativo, exibirá Modo Offline (LocalStorage) no topo e salvará seu histórico e preços na memória do próprio navegador (quando você fechar o navegador ou desligar o PC, o histórico poderá ser apagado).

Estrutura do Projeto

atelie/
├── api.php           # API em PHP para conectar o front-end ao banco de dados MySQL
├── cit.html          # Interface completa, estilos (Tailwind CSS), graficos (Chart.js) e logica de calculo
├── crieUmSQL.SQL     # Este e o codigo do SQL com o que esta acima
└── README.md         # Este manual de instrucoes


Como o Sistema Funciona por Dentro

1. Tabela de Custos Configurável

No botão "Preços dos Materiais" no topo da tela, você pode ajustar quanto paga em cada insumo. Os valores padrão pré-configurados são:

Meada de Linha (8m / 6 fios): R$ 6,00 (rende 24 metros úteis usando 2 fios).

Cola de Silicone (100 ml): R$ 13,78 (~R$ 0,14 por ml).

Tecido Etamine: R$ 20,00 o metro linear (base 1,40m de largura).

Tecido de Acabamento (Forro): R$ 14,99 o metro linear (base 1,40m de largura).

Argolas de Chaveiro: Pacote com 25 unidades por R$ 13,00 (R$ 0,52 por unidade).

2. Cálculo Automático de Consumo

A partir das medidas em centímetros (Largura x Altura) do Etamine e do Tecido de Acabamento, da quantidade de cores e do nível de preenchimento (Leve 25%, Médio 50% ou Cheio 82%), a calculadora estima:

Metros de Linha: Calcula a metragem gasta nos pontos cruz de acordo com a área preenchida e soma uma margem realista de arremate/troca de agulha para cada cor utilizada.

Mililitros de Cola: Estima o consumo necessário para selar as bordas do etamine (evitando desfiar) e colar o tecido de acabamento no verso.

Proporção de Tecidos: Calcula exatamente quanto em cm² e em percentual do metro foi utilizado de cada tecido.

3. Regra Automática para Chaveiros

Sempre que o campo Quantidade de Chaveiros for maior que zero:

O sistema inclui o custo unitário da argola metálica nos materiais.

Acrescenta automaticamente +R$ 1,00 por chaveiro diretamente no valor final sugerido ao cliente.

4. Recursos Extras

Gráfico de Divisão de Custos: Visualização em tempo real do peso de cada material no custo total.

Copiar Orçamento: Gera um resumo formatado pronto para colar e enviar no WhatsApp do cliente.

Histórico Salvo: Permite guardar peças prontas e recarregar suas medidas com um clique quando precisar fazer uma encomenda parecida.
