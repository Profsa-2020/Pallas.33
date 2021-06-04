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

     <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
     <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

     <script type="text/javascript" language="javascript"
          src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
     <link href="https://cdn.datatables.net/1.10.15/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />

     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="css/pallas33p.css" rel="stylesheet" type="text/css" media="print" />

     <title>Gestão em Mall - Vistoria em Lojas - Emissão de Cartas</title>
</head>

<script>
$(document).ready(function() {
     $(function() {
          $("#dti").mask("99/99/9999");
          $("#dtf").mask("99/99/9999");
          $("#dti").datepicker($.datepicker.regional["pt-BR"]);
          $("#dtf").datepicker($.datepicker.regional["pt-BR"]);
     });

     $('#loj').change(function() {
          $('#tab-0 tbody').empty();
     });
     $('#dti').change(function() {
          $('#tab-0 tbody').empty();
     });
     $('#dtf').change(function() {
          $('#tab-0 tbody').empty();
     });

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box00").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

});
</script>

<?php
     $ret = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;
     error_reporting (~ E_DEPRECATED); 
     include("mpdf.php"); 
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de relatório de vistoria detalhado Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     $dti = date('d/m/Y', strtotime('-30 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     $loj = (isset($_REQUEST['loj']) == false ? 0 : $_REQUEST['loj']);
     $tip = (isset($_REQUEST['tip']) == false ? 0 : $_REQUEST['tip']);
     if (isset($_REQUEST['printer']) == true) {
          echo '<script>window.print();</script>';
     } 
 
?>

<body id="box00">
     <h1 class="cab-0">Relatório de Vistorias Detalhado</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container-fluid">
                    <div class="row lit-3">
                         <div class="col-md-12">
                              <label>Relatório de Vistorias Detalhado</label>
                         </div>
                    </div>
                    <form name="frmTelMan" action="" method="POST">
                         <div class="row qua-4">
                              <div class="col-md-3">
                                   <label>Nome da Loja</label>
                                   <select id="loj" name="loj" class="form-control" required>
                                        <?php $ret = carrega_loj($loj); ?>
                                   </select>
                              </div>
                              <div class="col-md-2">
                                   <label>Data Inicial</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="dti"
                                        name="dti" value="<?php echo $dti; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Data Final</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="dtf"
                                        name="dtf" value="<?php echo $dtf; ?>" required />
                              </div>
                              <div class="col-md-3">
                                   <label>Tipo de Vistoria</label>
                                   <select id="tip" name="tip" class="form-control" required>
                                        <?php $ret = carrega_tip($tip); ?>
                                   </select>
                              </div>
                              <div class="col-md-1 text-center">
                                   <br />
                                   <button type="submit" id="con" name="consulta" class="bot-3"
                                        title="Carrega ocorrências conforme periodo solicitado pelo usuário."><i
                                             class="fa fa-search fa-2x" aria-hidden="true"></i></button>
                              </div>
                              <div class="col-md-1 text-center">
                                   <br />
                                   <button type="submit" class="bot-3" id="pri" name="printer"
                                        title="Abre janela para efetuar impressão de dados informados na página"><i
                                             class="fa fa-print fa-2x" aria-hidden="true"></i></button>
                              </div>
                         </div>
                    </form>

                    <div class="row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1">
                                   <table class="table table-sm">
                                        <thead class="thead-dark">
                                             <tr>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Tipo de Vistoria</th>
                                                  <th scope="col">Nome da Loja</th>
                                                  <th scope="col">Data Realizada</th>
                                                  <th scope="col">Nome do Vistoriador</th>
                                                  <th scope="col">Observação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_vis($loj, $dti, $dtf, $tip);  ?>
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
 function carrega_loj($loj) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_loja where lojstatus = 0 order by lojapelido";
     $sql = mysqli_query($conexao, $com);
     echo '<option value="0" selected="selected">Selecione loja a ser consultada ...</option>';
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idloja'] != $loj) {
               echo  '<option value ="' . $reg['idloja'] . '">' . $reg['lojapelido'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idloja'] . '" selected="selected">' . $reg['lojapelido'] . '</option>';
          }
     }
     return $sta;
}

function carrega_tip($tip) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_tipovis where tipstatus = 0 order by tipdescricao";
     $sql = mysqli_query($conexao, $com);
     if ($tip == 0) {
          echo '<option value="0" selected="selected">Selecione tipo de vistoria desejado ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idtipo'] != $tip) {
               echo  '<option value ="' . $reg['idtipo'] . '">' . $reg['tipdescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idtipo'] . '" selected="selected">' . $reg['tipdescricao'] . '</option>';
          }
     }
     return $sta;
}

function carrega_vis($loj, $dti, $dtf, $tip) {
     $nro = 0;
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     include "lerinformacao.inc";
     $com = "Select V.*, T.tecnome, L.lojnome, X.tipdescricao  from (((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) left join tb_tipovis X on V.vistipo = X.idtipo) ";
     $com .= " where visempresa = " . $_SESSION['wrkcodemp'] . " and visdataefe between '" . $dti . "' and '" . $dtf . "' ";
     if ($loj != 0) { $com .= " and V.visloja = " . $loj; }     
     if ($tip != 0) { $com .= " and V.vistipo = " . $tip; }
     $com .= " order by idvistoria desc, visloja, visdataage";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr class="lit-7">';
          $lin .= '<td class="text-center">' . $reg['idvistoria'] . '</td>';
          if ($reg['visstatus'] == 0) {$lin .= "<td>" . "Nor" . "</td>";}
          if ($reg['visstatus'] == 1) {$lin .= "<td>" . "Age" . "</td>";}
          if ($reg['visstatus'] == 2) {$lin .= "<td>" . "Efe" . "</td>";}
          if ($reg['visstatus'] == 3) {$lin .= "<td>" . "Sus" . "</td>";}
          if ($reg['visstatus'] == 4) {$lin .= "<td>" . "Can" . "</td>";}
          $lin .= "<td>" . $reg['tipdescricao'] . "</td>";
          $lin .= "<td>" . $reg['lojnome'] . "</td>";
          if ($reg['visdataefe'] == null) {
               $lin .= "<td>" . '' . "</td>";
          }else{
               $lin .= '<td class="text-center">' . date('d/m/Y H:i:s',strtotime($reg['visdataefe'])) . "</td>";
          }
          $lin .= "<td>" . $reg['tecnome'] . "</td>";
          $lin .= "<td>" . $reg['visobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
          $lin =  '<tr>';
          $lin .=  '<td colspan="7">';
          $lin .= carrega_ite($reg['idvistoria']);
          $lin .=  '</td>';
          $lin .=  '</tr>';
          echo $lin;
     }
}

function carrega_ite($cod) {
     $txt = '<table><tbody>';
     include "lerinformacao.inc";
     $com = "Select V.*, A.acodescricao, C.condescricao  from ((tb_vistoria_l V left join tb_acoes A on V.lisacao = A.idacoes) left join tb_conformidade C on V.lisconformidade = C.idconformidade) where lisvistoria = " . $cod . " order by lisvistoria, idlista";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $txt .=  '<tr>';
          $txt .= '<td>' . str_repeat(" &nbsp; ", 17) . '</td>';
          $txt .= '<td>' . '<i class="fa fa-arrow-right" aria-hidden="true"></i>' . '</td>';
          $txt .= '<td class="text-left">' .  $reg['idlista'] . '</td>';
          $txt .= '<td class="text-left">' . date('d/m/Y', strtotime($reg['datinc'])) . '</td>';
          $txt .= '<td class="text-left">' .  $reg['condescricao'] . '</td>';
          if ($reg['acodescricao'] == null) {
               $txt .= '<td class="text-left">' . '' . '</td>';
          } else {
               $txt .= '<td class="text-left">' . $reg['acodescricao'] . '</td>';
          }
          if ($reg['lisobservacao'] == null) {
               $txt .= '<td class="text-left">' . '' . '</td>';
          } else {
               $txt .= '<td class="text-left">' . $reg['lisobservacao'] . '</td>';
          }
          $txt .= '<td>' . str_repeat(" &nbsp; ", 190) . '</td>';
          $txt .=  '</tr>';
     }
     $txt .= '</tbody></table>';
     return $txt;
}

?>