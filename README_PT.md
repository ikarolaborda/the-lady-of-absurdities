# A Senhora dos Absurdos

Esta aplicação é um clone do Stack Overflow.
Foi criada como parte do curso Symfony 5: The Fast Track no SymfonyCasts.com.
Também foi atualizada para o Symfony 6.*.

Configuração
Este projeto utiliza PHP 8.2 e Symfony 6.*, e depende do Docker para uma configuração completa do ambiente de desenvolvimento.
Para fazê-lo funcionar, siga estes passos:

Faça a construção inicial do Docker para a aplicação

Certifica-te de ter o Docker instalado
e então execute:

```bash
Copy code
# Isso irá gerar um certificado SSL autoassinado para seu ambiente local. Execute apenas uma vez.
make generate-ssl
# Isso executará uma sequência de comandos necessários para a construção. Execute apenas uma vez.
make setup
# Se você já executou os comandos acima, pode executar o seguinte comando para iniciar a aplicação
make dup
```
Estes comandos executam um conjunto de instruções no Makefile para construir o teu projeto,
é uma forma automatizada de executar uma série de comandos. 
Podes verificar o que esta a ser feito ao abrir o Makefile e olhar o comando `build`.

Se não quiseres utilizar o Docker, certifica-te de iniciar o teu próprio
servidor de banco de dados e atualize a variável de ambiente DATABASE_URL em
.env ou .env.local antes de executar os comandos acima.

Inicie o servidor web Symfony

Podes utilizar o Nginx que vem com o Docker,
Entretanto, se não o tens, 
o servidor Web local do Symfony funciona.

(é necessario que tenhas o binário do symfony instalado, podes ver como em https://symfony.com/download)

Depois, para iniciar o servidor web, abra um terminal, mova-se para o
projeto e corre o seguinte comando:

```
symfony serve
```
(Se esta for a primeira vez que correres este comando, podes ver um
erro. Pra resolve-lo, precisas correr 
```bash
symfony server:ca:install
```

[Read in English](README.md)