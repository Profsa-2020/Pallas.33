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

     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
          integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
     </script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
          integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
     </script>

     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Menu</title>
</head>

<?php
     $ret = 00;
     $dad = array();
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de menu principal do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     $ret = carrega_das($dad);
     $_SESSION['wrkcamlog'] = 'upload/' . retorna_dad('shologotipo','tb_shopping','idshopping',$_SESSION['wrkcodemp']); 
?>

<body>
     <h1 class="cab-0">Login Inicial Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-center">

               <span class="lit-4">DashBoard</span>
               <br /><br /><br />
               <div class="container-fluid">
                    <div class="row text-center">
                         <div class="col-md-1"></div>
                         <div class="qua-5 col-md-2">
                         <?php
                         echo '<p>' . 'Usuários' . '</p>';
                         echo '<span>' . number_format($dad['usu'], 0, ",", ".") . '</span>';
                         ?>
                         </div>
                         <div class="qua-5 col-md-2">
                         <?php
                         echo '<p>' . 'Shoppings' . '</p>';
                         echo '<span>' . number_format($dad['sho'], 0, ",", ".") . '</span>';
                         ?>
                         </div>
                         <div class="qua-5 col-md-2">
                        <?php
                         echo '<p>' . 'Vistoriadores' . '</p>';
                         echo '<span>' . number_format($dad['tec'], 0, ",", ".") . '</span>';
                         ?>
                         </div>
                         <div class="qua-5 col-md-2">
                        <?php
                         echo '<p>' . 'Lojas' . '</p>';
                         echo '<span>' . number_format($dad['loj'], 0, ",", ".") . '</span>';
                         ?>
                         </div>
                         <div class="qua-5 col-md-2">
                        <?php
                         echo '<p>' . 'Vistorias' . '</p>';
                         echo '<span>' . number_format($dad['vis'], 0, ",", ".") . '</span>';
                         ?>
                         </div>
                         <div class="col-md-1"></div>
                    </div>
               </div>

          </div>
     </div>
</body>
<?php
function carrega_das(&$dad) {
     $ret = 0;
     $dad['usu'] = 0;
     $dad['sho'] = 0;
     $dad['tec'] = 0;
     $dad['loj'] = 0;
     $dad['vis'] = 0;
     include "lerinformacao.inc";
     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select count(*) as qtde from tb_usuario";
     } else {
          $com = "Select count(*) as qtde from tb_usuario where usuempresa = " . $_SESSION['wrkcodemp'];
     }
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['usu'] += $reg['qtde'];
     }
     if ($_SESSION['wrktipusu'] >= 4) {
          $com = "Select count(*) as qtde from tb_shopping";
     } else {
          $com = "Select count(*) as qtde from tb_shopping where idshopping = " . $_SESSION['wrkcodemp'];
     }
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['sho'] += $reg['qtde'];
     }
     $com = "Select count(*) as qtde from tb_tecnico" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where tecempresa = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['tec'] += $reg['qtde'];
     }
     $com = "Select count(*) as qtde from tb_loja" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where idshopping = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['loj'] += $reg['qtde'];
     }
     $com = "Select count(*) as qtde from tb_vistoria" . ($_SESSION['wrktipusu'] >= 4 ? '' : ' where visempresa = ' . $_SESSION['wrkcodemp']) ;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $dad['vis'] += $reg['qtde'];
     }

     return $ret;
}

?>

</html>