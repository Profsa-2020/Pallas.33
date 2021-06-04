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
     <title>Gestão em Mall - Vistoria em Lojas - Emissão de Cartas</title>
</head>

<script>
$(document).ready(function() {
     $(function() {
          $("#dti").mask("99/99/9999");
          $("#dtf").mask("99/99/9999");
          $("#dti").datepicker( $.datepicker.regional[ "pt-BR" ] ); 
          $("#dtf").datepicker( $.datepicker.regional[ "pt-BR" ] ); 
     });

     $('.bot-3 a').click(function() {
          var cod = $(this).attr("cod");
          var ope = $(this).attr("ope");
          if (ope == 7) {
               $.getJSON("imprime-pad.php", { ope: ope, cod: cod })
               .done(function(data) {
                    if (data.cam != "") {
                         $('#tel-pad').empty().text('Carta de Aviso ao Lojista Nº ' + cod);
                         $('#dad_pad').attr('src', data.cam); 
                         $('#pdf-pad').modal('show');
                    }
               }).fail(function(data){
                    console.log(data);
                    alert("Erro ocorrido na carta padrão: " + JSON.stringify(data));
               });
          }
          if (ope == 8) {
               $('#ope_c').val(ope);
               $('#cod_c').val(cod);
               $('#tel-cus').empty().text('Carta de Aviso à Lojista Nº ' + cod);
               $('#pdf-cus').modal('show');
          }
          return false;
     });

     $('#gra').click(function() {
          var car = $('#car').val();
          var ope = $('#ope_c').val();
          var cod = $('#cod_c').val();
          if (car == 0) {
               alert('Não foi selecionada padrão de carta para impressão da mesma');
          } else {
               $.getJSON("imprime-pad.php", { ope: ope, cod: cod, car: car })
               .done(function(data) {
                    if (data.cam != "") {
                         $('#tel-cus').empty().text('Carta de Aviso à Lojista Nº ' + cod);
                         $('#dad_cus').attr('height', '1100'); 
                         $('#dad_cus').attr('src', data.cam); 

                    }
               }).fail(function(data){
                    console.log(JSON.stringify(data));
                    alert("Erro ocorrido no processamento da carta padrão de vistoria");
               });
          }
     });

     $('#tip').change(function() {
          $('#tab-0 tbody').empty();
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

     $('#tab-0').DataTable({
          "pageLength": 25,
          "aaSorting": [
               [4, 'desc'],
               [3, 'asc']
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
     date_default_timezone_set("America/Sao_Paulo");
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de emissão de cartas do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     $dti = date('d/m/Y', strtotime('-30 days'));
     $dtf = date('d/m/Y');
     $dti = (isset($_REQUEST['dti']) == false ? $dti : $_REQUEST['dti']);
     $dtf = (isset($_REQUEST['dtf']) == false ? $dtf : $_REQUEST['dtf']);
     $loj = (isset($_REQUEST['loj']) == false ? 0 : $_REQUEST['loj']);
     $tip = (isset($_REQUEST['tip']) == false ? 0 : $_REQUEST['tip']);
     $car = (isset($_REQUEST['car']) == false ? 0 : $_REQUEST['car']);

 
?>

<body id="box00">
     <h1 class="cab-0">Emissão de Cartas Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-center">
               <div class="qua-3 container-fluid">
                    <div class="row lit-3">
                         <div class="col-md-12">
                              <label>Emissão de Cartas</label>
                         </div>
                    </div>
                    <form name="frmTelMan" action="" method="POST">
                         <div class="row">
                              <div class="col-md-4">
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
                                             class="fa fa-search fa-3x" aria-hidden="true"></i></button>
                              </div>
                         </div>
                         <br />
                    </form>

                    <div class="form-row">
                         <div class="col-md-12">
                              <br />
                              <div class="tab-1 table-responsive">
                                   <table id="tab-0" class="table table-sm table-striped">
                                        <thead>
                                             <tr>
                                                  <th scope="col">Padrão</th>
                                                  <th scope="col">Carta</th>
                                                  <th scope="col">Pdf</th>    
                                                  <th scope="col">Nome da Loja</th>
                                                  <th scope="col">Número</th>
                                                  <th scope="col">Status</th>
                                                  <th scope="col">Tipo de Vistoria</th>
                                                  <th scope="col">Data Agenda</th>
                                                  <th scope="col">Data Realizada</th>
                                                  <th scope="col">Nome do Vistoriador</th>
                                                  <th scope="col">Fotos</th>
                                                  <th scope="col">Observação</th>
                                             </tr>
                                        </thead>
                                        <tbody>
                                             <?php $ret = carrega_vis($loj, $tip, $dti, $dtf);  ?>
                                        </tbody>
                                   </table>
                              </div>
                         </div>
                    </div>
                    <br />
               </div>
          </div>
     <!----------------------------------------------------------------------------------->
     <div class="modal fade" id="pdf-pad" tabindex="-1" role="dialog" aria-labelledby="tel-pad" aria-hidden="true"
          data-backdrop="true">
          <div class="modal-dialog modal-lg" role="document"> <!-- modal-sm modal-lg modal-xl -->
               <form id="frmMosPad" name="frmMosPad" action="emi-carta.php" method="POST">
                    <div class="modal-content">
                         <div class="modal-header">
                              <h5 class="modal-title" id="tel-pad">Carta de Aviso ao Lojista</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="row text-center">
                                   <div class="col-md-12">
                                        <embed id="dad_pad" src="" width="100%" height="1100" type="application/pdf">
                                   </div>
                              </div>
                              <br />
                         </div>
                         <div class="modal-footer">
                              <button type="button" id="clo" name="close" class="btn btn-outline-danger"
                                   data-dismiss="modal">Fechar</button>
                         </div>
                    </div>
               </form>
          </div>
     </div>
     <!----------------------------------------------------------------------------------->
     <div class="modal fade" id="pdf-cus" tabindex="-1" role="dialog" aria-labelledby="tel-cus" aria-hidden="true"
          data-backdrop="true">
          <div class="modal-dialog modal-lg" role="document"> <!-- modal-sm modal-lg modal-xl -->
               <form id="frmMosCus" name="frmMosCus" action="emi-carta.php" method="POST">
                    <div class="modal-content">
                         <div class="modal-header">
                              <h5 class="modal-title" id="tel-cus">Carta de Aviso ao Lojista</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                   <span aria-hidden="true">&times;</span>
                              </button>
                         </div>
                         <div class="modal-body">
                              <div class="row text-center">
                                   <div class="col-md-3"></div>
                                   <div class="col-md-12">
                                        <label>Descrição da Carta</label>
                                        <select id="car" name="car" class="form-control" required>
                                             <?php $ret = carrega_car($car); ?>
                                        </select>
                                   </div>
                                   <div class="col-md-3"></div>
                              </div>
                              <br />
                              <div class="row text-center">
                                   <div class="col-md-12">
                                        <embed id="dad_cus" src="" width="100%" height="100" type="application/pdf">
                                   </div>
                              </div>
                              <br />
                         </div>
                         <div class="modal-footer">
                              <button type="button" id="gra" name="salvar"
                                   class="btn btn-outline-success">Gerar</button>
                              <button type="button" id="clo" name="close" class="btn btn-outline-danger"
                                   data-dismiss="modal">Fechar</button>
                         </div>
                    </div>
                    <input type="hidden" id="ope_c" name="ope_c" value="<?php echo $_SESSION['wrkopereg']; ?>">
                    <input type="hidden" id="cod_c" name="cod_c" value="<?php echo $_SESSION['wrkcodreg']; ?>">
               </form>
          </div>
     </div>
     <!----------------------------------------------------------------------------------->

</body>
<?php
 function carrega_loj($loj) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_loja where idshopping = " . $_SESSION['wrkcodemp'] . " and lojstatus = 0 order by lojnome";
     $sql = mysqli_query($conexao, $com);
     echo '<option value="0" selected="selected">Selecione loja a ser consultada ...</option>';
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idloja'] != $loj) {
               echo  '<option value ="' . $reg['idloja'] . '">' . $reg['lojnome'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idloja'] . '" selected="selected">' . $reg['lojnome'] . '</option>';
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

function carrega_car($car) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_texto where texempresa = " . $_SESSION['wrkcodemp'] . " and texstatus = 0 order by texnome";
     $sql = mysqli_query($conexao, $com);
     if ($car == 0) {
          echo '<option value="0" selected="selected">Selecione padrão de carta desejada ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idtexto'] != $car) {
               echo  '<option value ="' . $reg['idtexto'] . '">' . $reg['texnome'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idtexto'] . '" selected="selected">' . $reg['texnome'] . '</option>';
          }
     }
     return $sta;
}
function carrega_vis($loj, $tip, $dti, $dtf) {
     $nro = 0;
     $dti = substr($dti,6,4) . "-" . substr($dti,3,2) . "-" . substr($dti,0,2) . " 00:00:00";
     $dtf = substr($dtf,6,4) . "-" . substr($dtf,3,2) . "-" . substr($dtf,0,2) . " 23:59:59";
     include "lerinformacao.inc";
     $com = "Select V.*, T.tecnome, L.lojapelido, X.tipdescricao  from (((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) left join tb_tipovis X on V.vistipo = X.idtipo) ";
     $com .= " where visempresa = " . $_SESSION['wrkcodemp'] . " and visdataefe between '" . $dti . "' and '" . $dtf . "' ";
     if ($loj != 0) { $com .= " and V.visloja = " . $loj; }     
     if ($tip != 0) { $com .= " and V.vistipo = " . $tip; }
     $com .= " order by idvistoria desc, visloja, visdataage";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lin =  '<tr>';
          $lin .= '<td class="bot-3 text-center"><a href="#" ope=7 cod="' . $reg['idvistoria'] . '" title="Efetua criação de carta padrão e envio de e-mail com dados da vistoria informado na linha"><i class="fa fa-print fa-2x" aria-hidden="true"></i></a></td>';
          $lin .= '<td class="bot-3 text-center"><a href="#" ope=8 cod="' . $reg['idvistoria'] . '" title="Efetua criação de carta customizada e envio de e-mail com parâmetros do usuário informado na linha"><i class="fa fa-cogs fa-2x" aria-hidden="true"></i></a></td>';
          $pad = "doctos" . "/" . 'Pad_' . str_pad($reg['idvistoria'], 8, "0", STR_PAD_LEFT) .  "." . "pdf";
          $cus = "doctos" . "/" . 'Cus_' . str_pad($reg['idvistoria'], 8, "0", STR_PAD_LEFT) .  "." . "pdf";
          if (file_exists($cus) == true) { 
               $lin .= '<td class="bot-4 text-center"><a href="' . $cus . '" target="_blank" title="Abre nova guia com PDF customizada que foi criado anteriormente para vistoria"><i class="fa fa-search fa-2x" aria-hidden="true"></i></a></td>';
          } else if (file_exists($pad) == true) { 
               $lin .= '<td class="bot-4 text-center"><a href="' . $pad . '" target="_blank" title="Abre nova guia com PDF padrão que foi criado anteriormente para vistoria"><i class="fa fa-search fa-2x" aria-hidden="true"></i></a></td>';
          } else{
               $lin .= '<td class="bot-4 text-center"><i class="fa fa-search fa-2x" aria-hidden="true"></i></td>';
          }
          $lin .= '<td class="text-left">' . $reg['lojapelido'] . "</td>";
          $lin .= '<td class="text-center">' . $reg['idvistoria'] . '</td>';
          if ($reg['visstatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
          if ($reg['visstatus'] == 1) {$lin .= "<td>" . "Agendada" . "</td>";}
          if ($reg['visstatus'] == 2) {$lin .= "<td>" . "Efetivada" . "</td>";}
          if ($reg['visstatus'] == 3) {$lin .= "<td>" . "Suspensa" . "</td>";}
          if ($reg['visstatus'] == 4) {$lin .= "<td>" . "Cancelada" . "</td>";}
          $lin .= "<td>" . $reg['tipdescricao'] . "</td>";
          $lin .= '<td class="text-center">' . date('d/m/Y H:i:s',strtotime($reg['visdataage'])) . "</td>";
          if ($reg['visdataefe'] == null) {
               $lin .= "<td>" . '' . "</td>";
          }else{
               $lin .= '<td class="text-center">' . date('d/m/Y H:i:s',strtotime($reg['visdataefe'])) . "</td>";
          }
          $lin .= "<td>" . $reg['tecnome'] . "</td>";
          $qtd = fotos_qtd($reg['idvistoria']);
          $lin .= '<td class="text-center">' . str_pad($qtd, 3, "0", STR_PAD_LEFT) . "</td>";
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