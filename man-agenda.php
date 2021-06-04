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
     <script type="text/javascript" src="js/datepicker-pt-BR.js"></script>

     <script type="text/javascript" src="js/wickedpicker.js"></script>
     <link href="css/wickedpicker.css" rel="stylesheet" type="text/css" media="screen" />

     <link href='core/main.min.css' rel='stylesheet' />
     <link href='daygrid/main.min.css' rel='stylesheet' />
     <link href='list/main.min.css' rel='stylesheet' />
     <script src='core/main.min.js'></script>
     <script src='interaction/main.min.js'></script>
     <script src='daygrid/main.min.js'></script>
     <script src='list/main.min.js'></script>
     <script src='core/locales/pt-br.js'></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Menu</title>
</head>

<script>
$(function() {
     var options = {
          twentyFour: true,
          title: 'Hora da Visita',
          minutesInterval: 10,
          upArrow: 'wickedpicker__controls__control-up',
          downArrow: 'wickedpicker__controls__control-down',
          close: 'wickedpicker__close',
     };
     $('#hor').wickedpicker(options);
     $("#dat").mask("00/00/0000");
     $("#dat").datepicker({
          minDate: -0,
          maxDate: "+5M +30D"
     });
});

$(document).ready(function() {

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

});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
     var calendarEl = document.getElementById('calendar');

     var calendar = new FullCalendar.Calendar(calendarEl, {
          plugins: ['interaction', 'dayGrid', 'list'],
          header: {
               left: 'prev,next today',
               center: 'title',
               right: 'dayGridMonth,listYear'
          },
          businessHours: true,
          displayEventTime: true,
          locale: 'pt-br',
          editable: false,
          themeSystem: 'bootstrap',
          eventLimit: true, // allow "more" link when too many events
          events: 'carrega-age.php',
     });
     calendar.render();
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
               $ret = gravar_log(1,"Entrada na página de agendamento de visitas as lojas do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrkcodtec']) == false) { $_SESSION['wrkcodtec'] = 0; }

     $loj = (isset($_REQUEST['loj']) == false ? 0 : $_REQUEST['loj']);
     $tec = (isset($_REQUEST['tec']) == false ? $_SESSION['wrkcodtec'] : $_REQUEST['tec']);
     $hor = (isset($_REQUEST['hor']) == false ? '' : $_REQUEST['hor']);
     $dat = (isset($_REQUEST['dat']) == false ? date('d/m/Y')  : $_REQUEST['dat']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if (isset($_REQUEST['salvar']) == true) {
          $ret = 0;
          if ($_REQUEST['loj'] == "" || $_REQUEST['loj'] == "0") {
               echo '<script>alert("Código da loja para agendamento não pode ficar em branco");</script>';
               $ret = 1;
          }
          if ($_REQUEST['tec'] == "" || $_REQUEST['tec'] == "0") {
               echo '<script>alert("Código do vistoriador para agendamento não pode ficar em branco");</script>';
               $ret = 1;
          }
          if ($_REQUEST['dat'] == "" || $_REQUEST['hor'] == "") {
               echo '<script>alert("Data/Hora de agendamento informada não pode ficar em branco");</script>';
               $ret = 1;
          }     
          if ($_REQUEST['dat'] != "") {
               if (valida_dat($_REQUEST['dat']) != 0) {
                    echo '<script>alert("Data de agendamento informada no sistema não é valida");</script>';
                    $ret = 1;
               }
          }     
          if ($_REQUEST['hor'] != "") {
               if (valida_hor(str_replace(' ','',$_REQUEST['hor'])) != 0) {
                    echo '<script>alert("Hora de agendamento informada no sistema não é valida");</script>';
                    $ret = 1;
               }
          }     
          if ($ret == 0) {
               include "lerinformacao.inc";
               $hor = str_replace(' ','',$_REQUEST['hor']);
               $dat = substr($_REQUEST['dat'],6,4) . "-" . substr($_REQUEST['dat'],3,2) . "-" . substr($_REQUEST['dat'],0,2);     
               $sql  = "insert into tb_vistoria (";
               $sql .= "visempresa, ";
               $sql .= "visstatus, ";
               $sql .= "visdataage, ";
               $sql .= "visloja, ";
               $sql .= "vistecnico, ";
               $sql .= "visobservacao, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . '1' . "',";
               $sql .= "'" . $dat . " " . $hor . "',";
               $sql .= "'" . $_REQUEST['loj'] . "',";
               $sql .= "'" . $_REQUEST['tec'] . "',";
               $sql .= "'" . $_REQUEST['obs'] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y-m-d H:i:s") . "')";
               $ret = mysqli_query($conexao,$sql);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na gravação do agendamento solicitado !");</script>';
               }
               $ret = desconecta_bco();
               $_SESSION['wrkcodtec'] = $tec; $tec = 0; $dat = date('d/m/Y'); $hor = ''; $obs = '';
          }
     }
?>

<body id="box01">
     <h1 class="cab-0">Login Inicial Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">

               <div class="tel-1 qua-3 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <span>Manutenção de Agendamentos</span>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-agenda.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo tipo de vistoria no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <form name="frmTelNov" action="man-agenda.php?ope=1&cod=0" method="POST">

                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Nome do Vistoriador</label>
                                   <select id="tec" name="tec" class="cpo-1 form-control" required>
                                        <?php $ret = carrega_tec($tec); ?>
                                   </select>
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Descrição da Loja</label>
                                   <select id="loj" name="loj" class="cpo-1 form-control" required>
                                        <?php $ret = carrega_loj($loj); ?>
                                   </select>
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-4"></div>
                              <div class="col-md-2">
                                   <label>Data da Vistoria</label>
                                   <input type="text" class="cpo-1 form-control text-center" maxlength="10" id="dat"
                                        name="dat" value="<?php echo $dat; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Hora da Vistoria</label>
                                   <input type="text" class="cpo-1 form-control text-center" maxlength="10" id="hor"
                                        name="hor" value="<?php echo $hor; ?>" />
                              </div>
                              <div class="col-md-4"></div>
                         </div>
                         <div class="form-row">
                              <div class="col-md-1"></div>
                              <div class="col-md-10">
                                   <label>Observação</label>
                                   <textarea class="form-control" rows="3" id="obs"
                                        name="obs"><?php echo $obs ?></textarea>
                              </div>
                              <div class="col-md-1"></div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-12 text-center">
                                   <button type="submit" id="env" name="salvar" class="bot-2">Salvar</button>
                              </div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-12 text-center">
                                   <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                              </div>
                         </div>
                    </form>
                    <br />
               </div>
               <br />
               <hr /><br />
               <div class="container-fluid">
                    <div class="row">
                         <div class="col-md-1"></div>
                         <div class="col-md-10">
                              <div id='calendar'></div>
                         </div>
                         <div class="col-md-1"></div>
                    </div>
               </div>

          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>
<?php

function carrega_loj($loj) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_loja where lojstatus = 0 order by lojnome";
     $sql = mysqli_query($conexao, $com);
     if ($loj == 0) {
          echo '<option value="0" selected="selected">Selecione loja a ser agendada ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idloja'] != $loj) {
               echo  '<option value ="' . $reg['idloja'] . '">' . $reg['lojnome'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idloja'] . '" selected="selected">' . $reg['lojnome'] . '</option>';
          }
     }
     return $sta;
}

function carrega_tec($tec) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_tecnico where tecstatus = 0 order by tecnome";
     $sql = mysqli_query($conexao, $com);
     if ($tec == 0) {
          echo '<option value="0" selected="selected">Selecione vistoriador desejado ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idtecnico'] != $tec) {
               echo  '<option value ="' . $reg['idtecnico'] . '">' . $reg['tecnome'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idtecnico'] . '" selected="selected">' . $reg['tecnome'] . '</option>';
          }
     }
     return $sta;
}


?>

</html>