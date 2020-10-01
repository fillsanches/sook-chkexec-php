Documentação disponível em &#x1f1e7;&#x1f1f7; / Documentation available in  &#127482;&#127480; (after portuguese)


# LEIA-ME &#x1f1e7;&#x1f1f7;
### CONTEÚDO DESSE ARQUIVO
---
 * O que é sook-chkexec
 * Requisitos
 * Instalação / Configuração
 * Teste inicial
 * Classes, Métodos e Exemplos de uso
 
### O QUE É SOOK-CHKEXEC
sook-chkexec-php é uma coleção de código PHP POO, incluindo algumas Classes e Métodos que podem ser facilmente adicionados a um projeto PHP.

SOOK, é uma brincadeira com a frase "So, Ok".

Sua função é através de classes e métodos alcançar um modo de checar se multiplos arquivos php foram executados com sucesso. Note que por se tratar de simplesmente código PHP, aqui não há nehuma programação de baixo nível, só temos algumas classes e métodos que através de funções nativas do PHP trazem uma melhor organização e facilidade para resolver o problema proposto. 

Veja o que é possível fazer e como fazer, no item: **Classes, Métodos e Exemplos de uso.**

### REQUISITOS
---
### Softwares necessários para esse projeto:
 * php 7.0 ou mais novo

 ### INSTALAÇÃO / CONFIGURAÇÃO
 ---
No diretório raiz, clone ou baixe o projeto:
```
git clone https://github.com/fillsanches/sook-chkexec-php.git
```
Não há necessidade de nenhuma instalação extra, configuração ou resolução de dependências, Chkexec é apenas uma Classe PHP, use-a!

 ### TESTES INICIAIS


Existem no repósitorio 4 arquivos que compooe um exemplo, nomeados como file{x}.php. Execute o file1.php para fazer um teste utilizando todos os métodos disponíveis, e se certificar de que tudo está funcionando como esperado. A maneira mais simples de fazer isso é executar o servidor web embutido, para isso no diretório onde baixou o repositório:
```
php -S 127.0.0.1:8000
```
A aplicação agora está disponível através do navegador em  http://127.0.0.1:8000/

### CLASSES, MÉTODOS E EXEMPLOS DE USO
####  Instanciando um novo objeto Chkexec
Nesse exemplo vamos trabalhar com 3 arquivos, sendo index.php o arquivo principal que verifica a si mesmo e aos demais, my_file1 e my_file2.php, os arquivos a serem verificados.

Para iniciar qualquer verificação, e acompanhar a execução de scrips php vamos instanciar em index.php um novo objeto da classse Chkexec:

```
<?php
//index.php
require_once 'Autoload.php';

$execution = new Chkexec('execution001');
```
### Adicionando arquivos de forma individual para verificação
Vamos adicionar ***index.php, my_file1 e my_file2.php*** a lista de arquivos a serem verificados, fazemos isso com o método ***addFileToCheck()***:

```
$execution->addFileToCheck(__DIR__.'/index.php');
$execution->addFileToCheck(__DIR__.'/my_file1.php');
$execution->addFileToCheck(__DIR__.'/my_file2.php');
```
Para montar o caminho completo dos arquivos, usamos a [constante mágica](https://www.php.net/manual/language.constants.predefined.php) 
 ***\__DIR__*** que obterá o caminho do arquivo ***index.php***, que neste caso é o mesmo caminho para os arquivos ***my_file1*** e ***my_file2.php***. Se houvesse um arquivo em um subdiretório, este deveria ser informado, seria algo como:
```
$execution->addFileToCheck(__DIR__.'/subdirectory/file3.php');
```
Levando em considereção que a constante ***\__DIR__*** sempre irá retornar o caminho do arquivo no qual foi chamada, para facilitar o cadastro dos demais arquivos do projeto, recomendo sempre colocar o código principal de verificação - com ***addFileToCheck()*** - na raíz do projeto.

### Adicionando múltiplos arquivos para verificação

Caso prefira, você pode passar vários arquivos de uma vez para ***addFileToCheck()***. Há duas formas de fazer isso, vamos vê-las a seguir:
***Modo manual*** -  passe todos os arquivos desejados para verificação dentro um array:
```
$files = array(
    __DIR__.'/index.php',
    __DIR__.'/my_file1.php',
    __DIR__.'/my_file2.php'
);

$execution->addFileToCheck($files);
```
A vantagem de fazer isso de forma manual é ter mais controle sobre o que está sendo verificado.

***Modo automático*** - se quiser gerar um array com os nomes dos arquivos incluídos ou requeridos em ***index.php*** use a função nativa do php [get_included_files()](https://www.php.net/manual/en/function.get-included-files.php), nesse caso talvez outros arquivos php não desejados sejam obtidos, como arquivos de classes. Vamos criar na raíz do projeto e incluir em index.php os arquivos abaixo:
```
require_once 'my_file1.php';
require_once 'my_file2.php';
```
Vejamos a saída da função nativa ***get_included_files()***:
```
Array
(
    [0] => /home/fellipe/Documents/sook/chkexec/index.php
    [1] => /home/fellipe/Documents/sook/chkexec/Autoload.php
    [2] => /home/fellipe/Documents/sook/chkexec/classes/Chkexec.php
    [3] => /home/fellipe/Documents/sook/chkexec/my_file1.php
    [4] => /home/fellipe/Documents/sook/chkexec/my_file2.php
)
```
Como visto na saída de ***get_included_files()*** há arquivos que não fazem parte de nossa verificação, é possível ignorá-los, para isso basta passar um segundo parâmetro ***$ignore*** ao método ***addFileToCheck()*** com uma string no caso de um arquivo, ou array no caso de vários arquivos a serem ignorados:
```
$ignore = array(
    '/home/fellipe/Documents/sook/chkexec/Autoload.php',
    '/home/fellipe/Documents/sook/chkexec/classes/Chkexec.php',
);

$execution->addFileToCheck(get_included_files(), $ignore);
```
Pronto, dessa forma passamos a ***addFileToCheck()*** apenas ***index.php, my_file1.php e my_file2.php***, ignorando os arquivos ***Autoload.php*** e ***Chkexec.php***.

A vantagem de trabalhar com ***get_included_files()*** é ter o mapeamento automático de novos arquivos que possam ser incluídos mais tarde no projeto, a desvantagem é arquivos não desejados podem ser incluídos sem querer, além de você ser obrigado a fazer o ***require_once*** ou ***include_once*** dos arquivos antes do ***addFileToCheck()***, o que impossibilita por exemplo contar as linhas dos arquivos sem de fato também executá-los.

Neste exemplo para melhor entendimento de todos os recursos envolvidos até o processo final, vamos continuar seguindo com um array criado de forma manual.

####  Listando arquivos mapeados para verificação
Para checar ou recuperar todos os arquivos mapeados para verificação use o método ***listFilesToCheck()***, ele retorna por padrão um array, ou caso um valor true seja passado como parâmetro, uma string com os arquivos separados por vírgulas:
```
print_r($execution->listFilesToCheck()); //array
echo ($execution->listFilesToCheck(true)); //string
```


Agora vamos ver todo o código que temos até aqui, bem como usar o método ***linesToLoad()*** para  verificar o total de linhas a serem executadas quando se somam todos os arquivos:
```
<?php
//index.php
require_once 'Autoload.php';

$execution = new Chkexec('execution001');

$files = array(
    __DIR__.'/index.php',
    __DIR__.'/my_file1.php',
    __DIR__.'/my_file2.php'
);

$execution->addFileToCheck($files);

//print_r($execution->listFilesToCheck()); //array
//echo ($execution->listFilesToCheck(true)); //string

echo $execution->linesToLoad(); //18
```
O retorno de ***linesToLoad()*** será um tipo inteiro com valor ***18***, que é o total de linhas do arquivo ***index.php***, uma vez que ***my_file1.php e my_file2.php*** ainda estão vazios.

Vamos abrí-los agora e adicionar algum código para melhor ver ***linesToLoad()*** em funcionamento:
```
<?php
//my_file1.php
echo 'my file 1 was opened<br>';
```
```
<?php
//my_file2.php
echo 'my file 2 was opened<br>';
```
Atualize o arquivo ***index.php***, o total retornado por ***linesToLoad()*** agora será ***25***, resultado da soma das linhas dos três arquivos.

Obs: Linhas extras em qualquer um dos seus arquivos vão fazer o resultado obtido por ***linesToLoad()*** mudar em relação ao total de linhas escrito nesse exemplo, não há problema nisso, desde que o número retornado por ***linesToLoad()*** condiga com o total de linhas de todos os seus arquivos.

Voltemos agora ao nosso arquivo ***index.php***, vamos incluir o arquivo ***my_file1.php*** e verificar o que o acontece. Para isso, abaixo do código já escrito inclua:
```
echo "<pre>";
require_once 'my_file1.php';
print_r($execution->listFilesToCheck()); //array
```
E então na última linha de ***my_file1.php*** inclua:
```
$execution->registerFinal(__FILE__, __LINE__);
```
A tag html \<pre> foi utilizada apenas para formatar melhor a saída na tela, que será exibida como a saída abaixo.
(**Saída**):
```
my file 1 was opened
Array
(
    [/home/fellipe/Documents/sook/chkexec/index.php] => Array
        (
            [name] => /home/fellipe/Documents/sook/chkexec/index.php
            [lines] => 22
            [lines_loaded] => 0
        )

    [/home/fellipe/Documents/sook/chkexec/my_file1.php] => Array
        (
            [name] => /home/fellipe/Documents/sook/chkexec/my_file1.php
            [lines] => 4
            [lines_loaded] => 4
        )

    [/home/fellipe/Documents/sook/chkexec/my_file2.php] => Array
        (
            [name] => /home/fellipe/Documents/sook/chkexec/my_file2.php
            [lines] => 4
            [lines_loaded] => 0
        )

)
```
O retorno dessa saída é um array multidimensional, com dois níveis, contendo o primeiro nível a definição dos caminhos dos arquivos mapeados, e o segundo nível as seguintes chaves:
***name:*** novamente o caminho do arquivo
***lines:*** total de linhas do arquivo
***lines_loaded:*** total de linhas do arquivo executadas

Note então que após fazermos o ***require_once*** do arquivo ***my_file1.php***, agora temos o valor ***4*** atribuido as suas chaves ***lines*** e ***lines_loaded***, isso signifca que de um total de 4 linhas deste arquivo 4 foram lidas.

A leitura de quantas linhas ***my_file1.php*** tem, feito na adição dele com ***addFileToCheck()*** já a informação de quantas linhas foram executadas se deu na inclusão de ***registerFinal()*** na última linha do arquivo ***my_file1.php***.

Em ***index.php*** faça o ***require_once*** também do arquivo ***my_file2.php***, além disso adicione o método ***registerFinal()*** da mesma forma que fez anteriormente, na última linha de todos os arquivos:
```
<?php
//index.php
require_once 'Autoload.php';

$execution = new Chkexec('execution001');

$files = array(
    __DIR__.'/index.php',
    __DIR__.'/my_file1.php',
    __DIR__.'/my_file2.php'
);

$execution->addFileToCheck($files);

echo $execution->linesToLoad();

echo "<pre>";
require_once 'my_file1.php';
require_once 'my_file2.php';
$execution->registerFinal(__FILE__, __LINE__); print_r($execution->listFilesToCheck());
```
***(Saída):***
```
28
my file 1 was opened
my file 2 was opened
Array
(
    [/home/fellipe/Documents/sook/chkexec/index.php] => Array
        (
            [name] => /home/fellipe/Documents/sook/chkexec/index.php
            [lines] => 20
            [lines_loaded] => 20
        )

    [/home/fellipe/Documents/sook/chkexec/my_file1.php] => Array
        (
            [name] => /home/fellipe/Documents/sook/chkexec/my_file1.php
            [lines] => 4
            [lines_loaded] => 4
        )

    [/home/fellipe/Documents/sook/chkexec/my_file2.php] => Array
        (
            [name] => /home/fellipe/Documents/sook/chkexec/my_file2.php
            [lines] => 4
            [lines_loaded] => 4
        )

)
```
Agora temos total de linhas carregadas em cada arquivo sendo: ***index.php (20/20), my_file1.php (4/4) e my_file2.php (4/4)***.

####  Vericando totalidade dos arquivos carregados
Podemos obter da informação totalidade dos arquivos carregados em quantidade de linhas ou porcentagem, para isso vamos usar o método ***execution()*** encadeado de ***linesLoaded()*** ou ***percent()***.

Em ***index.php*** logo antes do método ***registerFinal()*** adicione:
```
echo $execution->execution(__LINE__)->percent() . " % loaded at this point<br>";
echo $execution->execution(__LINE__)->linesLoaded()  . " loaded at this point<br>";
```
***(Saída):***
```
91 % loaded at this point
30 lines loaded at this point
```
Note que o retorno da totalidade do carregamento se deu exatamente no ponto onde o método ***execution()*** foi chamado, ou seja em 91% do total de linhas, ou na linha 30 de um total de 32, graças a constante ***\__LINE__*** que foi passada como parêmetro.
Assim sendo, sempre que chamar o método ***execution()*** após um método ***registerFinal()***, não se deve passar ***\__LINE__*** como parâmetro de quantidade de linhas, uma vez que as linhas já vão ser contabilizadas pelo método  ***registerFinal()***, nesse cenário caso ***\__LINE__*** seja passado em ambos os métodos um erro será retornado.

Um cenário real típico onde um ***execution()*** após um ***registerFinal()*** é encontrado, se dá para se obter o retorno do carreganto de 100% dos arquivos.

Vamos mexer no nosso código, em ***index.php*** altere o final do arquivo para:
```
echo $execution->linesToLoad();

echo "<pre>";
require_once 'my_file1.php';
require_once 'my_file2.php';

$execution->registerFinal(__FILE__, __LINE__); echo $execution->execution()->percent() . " % loaded";
```
Perceba que na última linhas temos separados por ";" um ***execution()*** após um ***registerFinal()***, dessa forma conseguimos tanto registrar o final do arquivo na linha correta, quanto obter a totalidade correta do carregamento.

Veja também que neste caso não foi passado ***\__LINE__*** como parâmetro de ***execution()***.

***(Saída):***
```
29
my file 1 was opened
my file 2 was opened
100 % loaded
```
