<!DOCTYPE HTML>  
<html>
<head>
    <link rel="stylesheet" href="FormularioComPHP.css">
</head>
<body>  

<?php
// Aqui nós vamos declarar as variáveis que iremos utilizar e daremos à elas um valor nullo
// para poderem ser preenchidas durante o cadastro
$nomeErro = $sobrenomeErro = $nascimentoErro = $emailErro = $generoErro = "";
$nome = $sobrenome = $nascimento = $email = $genero = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
// Aqui criamos uma condição na qual "SE" a variável "nome" estiver vazia, irá aparecer
// uma mensagem de erro falando que este campo é obrigatório ser preenchido
  if (empty($_POST["nome"])) {
    $nomeErro = "* Campo Obrigatório";
  } 
// Caso o campo não esteja vazio verificaremos se estão sendo utilizados apenas letras
// maiúsculas, minúsculas e espaços. Se não aparecerá uma mensagem de erro.
  elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s]*$/", test_input($_POST["nome"]))){
        $nomeErro = "* Por Favor Insira Apenas Letras e Espaços"; 
      
    }
// Caso o campo não esteja vazio e o requisito de escrita esteja sendo atendido, então
// a variável "nome" ganhará o valor posto no input do formulário
  else {
    $nome = test_input($_POST["nome"]);
  }

// Aqui repetimos o mesmo processo que fizemos com o campo nome para o campo sobrenome  
  if (empty($_POST["sobrenome"])) {
    $sobrenomeErro = "* Campo Obrigatório";
  } 
  elseif (!preg_match("/^[A-Za-zÀ-ÖØ-öø-ÿ\s]*$/", test_input($_POST["sobrenome"]))){
        $sobrenomeErro = "* Por Favor Insira Apenas Letras e Espaços"; 
      
    }
  else {
    $sobrenome = test_input($_POST["sobrenome"]);
  }
 
// Novamente iremos conferir se o campo está vazio ou não
  if (empty($_POST["nascimento"])) {
    $nascimentoErro = "* Campo Obrigatório";
  } 
  else {
    $nascimento = test_input($_POST["nascimento"]);
  }  

// Aqui fazemos o mesmo processo de verificação com o email
  if (empty($_POST["email"])) {
    $emailErro = "* Campo Obrigatório";

// A unica diferença é que verificaremos se é um email válido (@, .com , etc) e não apenas
// se são utilizados certos caracteres
  }
  elseif (!filter_var(test_input($_POST["email"]), FILTER_VALIDATE_EMAIL)) {
    $emailErro = "* Por Favor Insira Um E-mail Válido";
  }

  else {
    $email = test_input($_POST["email"]);
  }

// Aqui também faremos a mesma verificação de campo vazio 
  if (empty($_POST["genero"])) {
    $generoErro = "* Campo Obrigatório";
  } 
  else {
    $genero = test_input($_POST["genero"]);
  }
}

// Nessa função nós pegamos o valor do input e:
function test_input($data) {
// trim: retiramos os espaços vazios antes e depois da string
  $data = trim($data);
// striplashes: removemos as barras invertidas ( \ ) e transformamos barras invesrtidas duplas ( \\ )
// em apenas uma barra invertida ( \ )
  $data = stripslashes($data);
// htmlspecialchars: convertemos caracteres especiais em entidades do html para poderem ser
// lidas como código
  $data = htmlspecialchars($data);
// Aqui retornamos o valor depois de todas as alterações
  return $data;
}

?>

<div id="cartaoCentral">
 
<h2>Tarefa 2 da 3ª Etapa de Programação Web IV</h2>

<!-- Formulário HTML -->
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">  

<div id="info">
  <label>Nome:</label> 
  <input type="text" name="nome" value="<?php echo $nome;?>">
  <span class="error"> <?php echo $nomeErro;?></span>
  <br><br>

  <label>Sobrenome:</label>
  <input type="text" name="sobrenome" value="<?php echo $sobrenome;?>">
  <span class="error"> <?php echo $sobrenomeErro;?></span>
  <br><br>

  <label>Data de nascimento: </label>
  <input type="date" name="nascimento" value="<?php echo $nascimento;?>">
  <span class="error"> <?php echo $nascimentoErro;?></span>
  <br><br>
  
  <label>E-mail:</label> 
  <input type="text" name="email" value="<?php echo $email;?>">
  <span class="error"> <?php echo $emailErro;?></span>
  <br><br>

  <label>Genero:</label>
  <input type="radio" name="genero" <?php if (isset($genero) && $genero=="Feminino") echo "checked";?> value="feminino">Feminino
  <input type="radio" name="genero" <?php if (isset($genero) && $genero=="Masculino") echo "checked";?> value="masculino">Masculino
  <input type="radio" name="genero" <?php if (isset($genero) && $genero=="Outro") echo "checked";?> value="outro">Outro 
  <span class="error"> <?php echo $generoErro;?></span>
  <br><br>

  <input id="botao" type="submit" name="cadastrar" value="Cadastrar">  
  
</div>
</form>

<?php
// Essa parte do código serve apenas para verificarmos os valores que estão sendo enviados
// quando apertamos o botão de cadastro
echo "<h3>Cadastro:</h3>";
echo "<div id='info'> Nome: " . $nome;
echo "<br>";
echo "Sobrenome: " . $sobrenome;
echo "<br>";
echo "Data de nascimento: " . $nascimento;
echo "<br>";

// Aqui fazemos um calculo simples da diferença entre o dia informado como o dia de nascimento
// e a data atual para podermos saber a idade da pessoa cadastrada 
$dataHoje = new DateTime($nascimento );
$intervalo = $dataHoje->diff( new DateTime( date('Y-m-d') ) );
echo "Idade: " . $intervalo->format( '%Y anos' );
echo "<br>";

echo "E-mail: " . $email;
echo "<br>";
echo "Genero: " . $genero;
echo "<br></div>";

?>
</div>
</body>
</html>