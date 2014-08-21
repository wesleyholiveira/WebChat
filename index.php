<?
require "php/config.php";
require "classes/DataBase.class.php";

if(isset($_POST) && sizeof($_POST) == 2){
    $m->query("INSERT INTO conversa (nome, email, data_hora_inicio) values ('".$m->trata($_POST['nome'])."', '".$m->trata($_POST['email'])."', now())");
    $_SESSION['chat'] = $m->find("last", "conversa");
    file_put_contents (
        "logs/".$_SESSION['chat']['id'].".txt", 
        "Inicio: ".$_SESSION['chat']['data_hora_inicio']."\r\n"
    );

    header("location: cliente.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>WebChat</title>

        <!-- Bootstrap core CSS -->
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="css/signin.css" rel="stylesheet">

        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
          <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body>

        <div class="container">
            <?
            if(!isset($_SESSION['chat'])){
            ?>
            <form class="form-signin" role="form" action="index.php" method="post">
                <h2 class="form-signin-heading">Preencha os campos para ser atendido</h2>
                <input type="text" class="form-control" placeholder="Nome" required="" autofocus="" name="nome">
                <input type="email" class="form-control" placeholder="Email" required="" name="email">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            </form>
            <?}else{?>
            <h1>Em instantes você será atendido</h1>
            <script type="text/javascript">
            setTimeout(function(){
                window.location = "cliente.php";
            }, 2000);
            </script>
            <?}?>

        </div> <!-- /container -->


        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
    </body>
</html>