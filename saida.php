<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt_br">
	<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
     <meta name="description" content="Profsa Informática - Gestão em Mall - Vistorias" />
     <meta name="author" content="Paulo Rogério Souza" />
     <meta name="viewport" content="width=device-width, initial-scale=1" />

     <link href="https://fonts.googleapis.com/css?family=Lato:300,400" rel="stylesheet" type="text/css" />
     <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400" rel="stylesheet" type="text/css" />

     <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">

     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.css">

     <link rel="shortcut icon" href="http://www.profsa.com.br/pallas33/img/logo06.png" />

     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Menu</title>    </head>
<?php
    $sta = 00;
    $ret = 00;
    include_once "funcoes.php";
    date_default_timezone_set("America/Sao_Paulo");
    if (isset($_SESSION['wrknomusu']) == false) { $_SESSION['wrknomusu'] = ''; }
    if (isset($_SESSION['wrkemausu']) == false) { $_SESSION['wrkemausu'] = ''; }
    $nom = $_SESSION['wrknomusu'];
    $ema = $_SESSION['wrkemausu'];
    $ret = gravar_log(99, "Saída do sistema Pallas.33 - Gestão em Mall - Vistoria em Lojas");
    $_SESSION['wrkcodreg'] = 0; $_SESSION['wrkopereg'] = 0; $_SESSION['wrktipusu'] = 0;  $_SESSION['wrkideusu'] = 0;
    session_destroy();  
    $sem_c = date("w");
    if ($sem_c == 0) { $hoj_c = 'Domingo '; }
    if ($sem_c == 1) { $hoj_c = 'Segunda-feira  - '; }
    if ($sem_c == 2) { $hoj_c = 'Terça-feira  - '; }
    if ($sem_c == 3) { $hoj_c = 'Quarta-feira  - '; }
    if ($sem_c == 4) { $hoj_c = 'Quinta-feira  - '; }
    if ($sem_c == 5) { $hoj_c = 'Sexta-feira  - '; }
    if ($sem_c == 6) { $hoj_c = 'Sábado  - '; }
    $hoj_c = $hoj_c . date('d/m/Y H:i:s') . ' hs';
    if (isset($_REQUEST['atual']) == true) {
        setcookie("k_ent"); setcookie("k_end");  
    }    
?>
    <body>
        <h1 class="cab-0">Página de Saída do Sistema Administração de Vistorias - Gestão em Mall</h1> 
        <div  id="particles-js" class="sai-1 text-center">
            <div class="ima-1 animated zoomInUp text-center">
                <div class="row text-center">
                    <div class="col-md-12">
                    <a href="login.php">
                        <img class="img-fluid" src="img/logo08.png" class="img-responsive center-block" alt="Logotipo da empresa Gestão em Mall" title="Acesso ao site principal de Gestão em Mall"/>
                    </a>                
                    </div>
                </div>
            </div>
            <hr />
            <div class="animated fadeInUp text-center">
                <h2><strong>Obrigado por utilizar o sistema de Gestão em Mall - Vistorias</strong></h2>
                <br />
                <h4><strong><?php echo $nom; ?></strong></h4>
                <h5><strong><?php echo $ema; ?></strong></h5>
                <h5><?php echo $hoj_c; ?></h5>
                <br />
                <div class="row text-center">
                    <div class="col-md-12 text-center">
                        <br />
                        <form name="frmSaiSis" action="saida.php" method="POST">
                            <button type="submit" name="atual" class="bot-1" >Desabilita Login</button>
                        </form>            
                    </div>    
                </div>
            </div>
        </div>
    <script type="text/javascript" src="js/particles.js"></script>
    <script type="text/javascript" src="js/app.js"></script>
    </body>
</html>