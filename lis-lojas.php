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
     <link href="css/pallas33p.css" rel="stylesheet" type="text/css" media="print" />
     <title>Gestão em Mall - Vistoria em Lojas</title>
</head>

<?php
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de lista de shopping do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     if (isset($_REQUEST['printer']) == true) {
          echo '<script>window.print();</script>';
     }
 
?>

<body>
     <h1 class="cab-0">Lista de Lojas - Vistoria em Lojas</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-center">
          <div class="qua-3 container">
                    <div class="form-row lit-3">
                         <div class="col-md-11">
                              <label>Relatório de Lojas</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelRel" action="lis-lojas.php" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="pri" name="printer"
                                             title="Abre janela para efetuar impressão de dados informados na página"><i
                                                  class="fa fa-print fa-1g" aria-hidden="true"></i></button>
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
                                                  <th scope="col">Código</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Nome da Loja</th>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Piso</th>
                                                  <th scope="col">E-Mail</th>
                                                  <th scope="col">Telefone</th>
                                                  <th scope="col">Celular</th>
                                                  <th scope="col">Nomes de Contatos</th>
                                                  <th scope="col">Inclusão</th>
                                                  <th scope="col">Alteração</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_loj();  ?>
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
function carrega_loj() {
     $nro = 0;
     include "lerinformacao.inc";
     $com = "Select * from tb_loja where idshopping = " . $_SESSION['wrkcodemp'] . " order by lojnome, idloja";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="text-center">' . $reg['idloja'] . '</td>';
          if ($reg['lojstatus'] == 0) {$lin .= "<td>" . "Abe" . "</td>";}
          if ($reg['lojstatus'] == 1) {$lin .= "<td>" . "Obr" . "</td>";}
          if ($reg['lojstatus'] == 2) {$lin .= "<td>" . "Fec" . "</td>";}
          $lin .= "<td>" . $reg['lojnome'] . "</td>";
          $lin .= "<td>" . $reg['lojnumero'] . "</td>";
          $lin .= "<td>" . $reg['lojpiso'] . "</td>";
          $lin .= "<td>" . $reg['lojemail'] . "</td>";
          $lin .= "<td>" . $reg['lojtelefone'] . "</td>";
          $lin .= "<td>" . $reg['lojcelular'] . "</td>";
          $lin .= "<td>" . $reg['lojcontato1'] . '-' . $reg['lojcontato2'] . '-' . $reg['lojcontato3'] . "</td>";
          if ($reg['datinc'] == null) {
          $lin .= "<td>" . '*****' . "</td>";
          }else{
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
