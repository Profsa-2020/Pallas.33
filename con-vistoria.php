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

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Técnico</title>
</head>

<script>
$(document).ready(function() {
     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [3, 'desc'],
               [6, 'asc']
          ],
          "language": {
               "lengthMenu": "Demonstrar _MENU_ linhas por páginas",
               "zeroRecords": "Não existe registros a demonstar ...",
               "info": "Mostrada página _PAGE_ de _PAGES_",
               "infoEmpty": "Sem registros de Log",
               "sSearch": "Buscar:",
               "infoFiltered": "(Consulta de _MAX_ total de linhas)",
               "oPaginate": {
                    sFirst: "Primeiro",
                    sLast: "Último",
                    sNext: "Próximo",
                    sPrevious: "Anterior"
               }
          }
     });

     $(window).scroll(function() {
          if ($(this).scrollTop() > 100) {
               $(".subir").fadeIn(500);
          } else {
               $(".subir").fadeOut(250);
          }
     });

     $(".subir").click(function() {
          $topo = $("#box01").offset().top;
          $('html, body').animate({
               scrollTop: $topo
          }, 1500);
     });

     $('.fotos').click(function() {
          var cod = $(this).attr("codigo");
          $.getJSON("carrega-vis.php", { cod: cod })
          .done(function(data) {
               if (data.txt != "") {
                    $('#tit-fot').empty().html(data.txt);
               }
               if (data.ima != "") {
                    $('#lis-fot').empty().html(data.ima);
               }
          }).fail(function(data){
               console.log(data);
               alert("Erro ocorrido no processamento dos dados da vistoria solicitada");
          });

          $('#fot-vis').modal('show')
     });

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
               $ret = gravar_log(1,"Entrada na página de consulta de vistorias do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_REQUEST['novo']) == true) {
          exit('<script>location.href = "man-vistoria.php?ope=1&cod=0"</script>');
     }
     if (isset($_REQUEST['agenda']) == true) {
          exit('<script>location.href = "man-agenda.php"</script>');
     }
?>

<body id="box01">
     <h1 class="cab-0">Vistorias - Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container-fluid">
                    <form name="frmTelNov" action="con-vistoria.php?ope=1&cod=0" method="POST">
                         <div class="form-row lit-3">
                              <div class="col-md-10">
                                   <label>Consulta de Vistorias</label>
                              </div>
                              <div class="col-md-1">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="age" name="agenda"
                                             title="Abre janela para ver e criar agenda de visitas as lojas no sistema"><i
                                                  class="fa fa-calendar fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                              <div class="col-md-1">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar nova vistoria no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </div>
                         </div>
                    </form>
                    <div class="row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1 table-responsive-md">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th scope="col">Alterar</th>
                                                  <th scope="col">Excluir</th>
                                                  <th scope="col">Vistoria</th>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Tipo de Vistoria</th>
                                                  <th scope="col">Nome da Loja</th>
                                                  <th scope="col">Data Agenda</th>
                                                  <th scope="col">Data Realizada</th>
                                                  <th scope="col">Nome do Vistoriador</th>
                                                  <th scope="col">Fotos</th>
                                                  <th scope="col">Observação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_vis();  ?>
                                        </tbody>
                                   </table>
                                   <br />
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>

     <!-- Modal grande -->
     <div id="fot-vis" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
          aria-hidden="true">
          <div class="modal-dialog modal-lg">     <!-- modal-xl modal-lg -->
               <div class="modal-content">
                    <div class="modal-header">
                         <h4 class="modal-title" id="myLargeModalLabel">Fotos da Vistoria Efetuada</h4>
                         <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                              <span aria-hidden="true">&times;</span>
                         </button>
                    </div>
                    <div class="modal-body">
                         <div class="lit-6 row text-center">
                              <div class="col-md-12">
                                   <div id="tit-fot"></div>
                              </div>
                         </div>
                         <br />
                         <div id="lis-fot"></div>
                    </div>
               </div>
          </div>
     </div>
     <!--------------------->

</body>
<?php
function carrega_vis() {
     $nro = 0;
     include "lerinformacao.inc";
     $com = "Select V.*, T.tecnome, L.lojapelido, X.tipdescricao  from (((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) left join tb_tipovis X on V.vistipo = X.idtipo) where visempresa = " . $_SESSION['wrkcodemp'] . " order by idvistoria desc, visloja, visdataage";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="bot-3 text-center"><a href="man-vistoria.php?ope=2&cod=' . $reg['idvistoria'] . '" title="Efetua alteração do registro informado na linha"><i class="large material-icons">healing</i></a></td>';
          $lin .= '<td class="bot-3 text-center"><a href="man-vistoria.php?ope=3&cod=' . $reg['idvistoria'] . '" title="Efetua exclusão do registro informado na linha"><i class="large material-icons">delete_forever</i></a></td>';
          $lin .= '<td class="bot-3 text-center"><a href="inf-vistoria.php?ope=5&cod=' . $reg['idvistoria'] . '" title="Abre janela para informar ocorrências da vistoria efetuadaua pelo técnico"><i class="large material-icons">assignment</i></a></td>';
          $lin .= '<td class="text-center">' . $reg['idvistoria'] . '</td>';
          if ($reg['visstatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
          if ($reg['visstatus'] == 1) {$lin .= "<td>" . "Agendada" . "</td>";}
          if ($reg['visstatus'] == 2) {$lin .= "<td>" . "Efetivada" . "</td>";}
          if ($reg['visstatus'] == 3) {$lin .= "<td>" . "Suspensa" . "</td>";}
          if ($reg['visstatus'] == 4) {$lin .= "<td>" . "Cancelada" . "</td>";}
          $lin .= "<td>" . $reg['tipdescricao'] . "</td>";
          $lin .= "<td>" . $reg['lojapelido'] . "</td>";
          if ($reg['visdataage'] == null) {
               $lin .= "<td>" . '' . "</td>";
          } else {
               $lin .= '<td class="text-center">' . date('d/m/Y H:i:s',strtotime($reg['visdataage'])) . "</td>";
          }
          if ($reg['visdataefe'] == null) {
               $lin .= "<td>" . '' . "</td>";
          }else{
               $lin .= '<td class="text-center">' . date('d/m/Y H:i:s',strtotime($reg['visdataefe'])) . "</td>";
          }
          $lin .= "<td>" . $reg['tecnome'] . "</td>";
          $qtd = fotos_qtd($reg['idvistoria']);
          if ($qtd == 0) {
               $lin .= '<td class="text-center">' . '***' . "</td>";
          } else {
               $lin .= '<td class="text-center">' . '<button class="fotos bot-3" codigo="' . $reg['idvistoria'] . '">' . str_pad($qtd, 3, "0", STR_PAD_LEFT) . "</button></td>";
          }
          $lin .= "<td>" . $reg['visobservacao'] . "</td>";
          $lin .= "</tr>";
          echo $lin;
     }
}

function fotos_qtd($cha) {
     $qtd = 0;
     $cha = str_pad($cha, 6, "0", STR_PAD_LEFT);
     foreach (new DirectoryIterator('upload/') as $dad) {
          if ($dad->isDir() == false) {
               $cam = $dad->getPathname();
               if (strpos($cam, $cha) > 0 ) {
                    $qtd = $qtd + 1;
               }
          }
     }
     return $qtd;
}

?>

</html>