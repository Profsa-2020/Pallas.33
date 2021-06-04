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
     <title>Gestão em Mall - Vistoria em Lojas - Usuários</title>
</head>

<script>
$(document).ready(function() {

});
</script>

<?php
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de consulta de shopping do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
 
?>

<body>
     <h1 class="cab-0">Shopping - Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container-fluid">
                    <div class="form-row lit-3">
                         <div class="col-md-11">
                              <label>Consulta de Usuários</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-usuario.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo usuário no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <div class="form-row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1 table-responsive">
                                   <table class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th>Alterar</th>
                                                  <th>Excluir</th>
                                                  <th class="text-center">Shopping</th>
                                                  <th class="text-center">Código</th>
                                                  <th>Nome</th>
                                                  <th>Status</th>
                                                  <th>E-Mail</th>
                                                  <th>Tipo</th>
                                                  <th>Telefone</th>
                                                  <th>Celular</th>
                                                  <th>Inclusão</th>
                                                  <th>Alteração</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_usu();  ?>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

</body>
<?php
function carrega_usu() {
     $nro = 0;
     include "lerinformacao.inc";
     if ($_SESSION['wrktipusu'] >= 3) {
          $com = "Select * from tb_usuario order by usunome, idsenha";
     } else {
          $com = "Select * from tb_usuario where usuempresa = " . $_SESSION['wrkcodemp'] . " and usutipo <= 3 order by usunome, idsenha";
     }
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
         $lin =  '<tr>';
         $lin .= '<td class="bot-3 text-center"><a href="man-usuario.php?ope=2&cod=' . $reg['idsenha'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
         $lin .= '<td class="bot-3 text-center"><a href="man-usuario.php?ope=3&cod=' . $reg['idsenha'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
         $lin .= '<td class="text-center">' . str_pad($reg['usuempresa'], 3, "0", STR_PAD_LEFT) . '</td>';
         $lin .= '<td class="text-center">' . $reg['idsenha'] . '</td>';
         $lin .= "<td>" . $reg['usunome'] . "</td>";
         if ($reg['usustatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
         if ($reg['usustatus'] == 1) {$lin .= "<td>" . "Bloqueado" . "</td>";}
         if ($reg['usustatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
         if ($reg['usustatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
         $lin .= "<td>" . $reg['usuemail'] . "</td>";
         if ($reg['usutipo'] == 0) {$lin .= "<td>" . "Visitante" . "</td>";}
         if ($reg['usutipo'] == 1) {$lin .= "<td>" . "Vistoriador" . "</td>";}
         if ($reg['usutipo'] == 2) {$lin .= "<td>" . "Cliente" . "</td>";}
         if ($reg['usutipo'] == 3) {$lin .= "<td>" . "Suporte" . "</td>";}
         if ($reg['usutipo'] == 4) {$lin .= "<td>" . "Administrador" . "</td>";}
         $lin .= '<td class="text-center">' . $reg['usutelefone'] . '</td>';
         $lin .= '<td class="text-center">' . $reg['usucelular'] . '</td>';
         if ($reg['datinc'] != null) {
             $lin .= "<td>" . date('d/m/Y H:m:s',strtotime($reg['datinc'])) . "</td>";
         }
         if ($reg['datalt'] == null) {
             $lin .= "<td>" . '' . "</td>";
         }else{
             $lin .= "<td>" . date('d/m/Y H:m:s',strtotime($reg['datalt'])) . "</td>";
         }
         $lin .= "</tr>";
         echo $lin;
     }
}

?>

</html>