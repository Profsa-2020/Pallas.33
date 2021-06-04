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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <script type="text/javascript" src="js/profsa.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Shopping</title>
</head>

<script>
var nro = 2; // Variável Global criada fora de qualquer função

$(window).scroll(function() {
     if ($(this).scrollTop() > 100) {
          $(".subir").fadeIn(500);
     } else {
          $(".subir").fadeOut(250);
     }
});

$(function() {
     $("#cgc").mask("00.000.000/0000-00");
     $("#cep").mask("00000-000");
     $("#num").mask("999.999", {
          reverse: true
     });
});

$(document).ready(function() {
     $('#log_carrega').bind("click", function () {
          $('#log_janela').click();
     });
     $('#log_janela').change(function () {
          var path = $('#log_janela').val();
          // $('#cam').val(path.replace(/^.*\\/, ""));
     });         

     $('#mais').click(function() {
          nro = nro + 1;
          var lin = '';
          lin = lin + '<div class="form-row">';
          lin = lin + '<div class="col-md-3">';
          lin = lin + '<label>Nome</label>';
          lin = lin + '<input type="text" class="form-control left" maxlength="50" id="nom_' + nro +
               '" name="nom_' + nro + '" value="" />';
          lin = lin + '</div>';
          lin = lin + '<div class="col-md-2">';
          lin = lin + '<label>Função</label>';
          lin = lin + '<input type="text" class="form-control left" maxlength="50" id="fun_' + nro +
               '" name="fun_' + nro + '" value="" />';
          lin = lin + '</div>';
          lin = lin + '<div class="col-md-2">';
          lin = lin + '<label>Departamento</label>';
          lin = lin + '<input type="text" class="form-control left" maxlength="55" id="dep_' + nro +
               '" name="dep_' + nro + '" value="" />';
          lin = lin + '</div>';
          lin = lin + '<div class="col-md-2">';
          lin = lin + '<label>Telefone</label>';
          lin = lin + '<input type="text" class="form-control left" maxlength="15" id="tel_' + nro +
               '" name="tel_' + nro + '" value="" />';
          lin = lin + '</div>';
          lin = lin + '<div class="col-md-2">';
          lin = lin + '<label>E-Mail</label>';
          lin = lin + '<input type="text" class="form-control left" maxlength="50" id="ema_' + nro +
               '" name="ema_' + nro + '" value="" />';
          lin = lin + '</div>';
          lin = lin + '<div class="col-md-1"></div>';
          lin = lin + '</div> ';
          $(lin).appendTo('#nomes');
     });

     $('#cep').blur(function() {
          var cep = $('#cep').val();
          var cep = cep.replace(/[^0-9]/g, '');
          if (cep != '') {
               var url = '//viacep.com.br/ws/' + cep + '/json/';
               $.getJSON(url, function(data) {
                    if ("error" in data) {
                         return;
                    }
                    if ($('#end').val() == "") {
                         $('#end').val(data.logradouro.substring(0, 50));
                    }
                    if ($('#cep').val() == "" || $('#cep').val() == "-") {
                         $('#cep').val(data.cep.replace('.', ''));
                    }
                    if ($('#bai').val() == "") {
                         $('#bai').val(data.bairro.substring(0, 50));
                    }
                    if ($('#cid').val() == "") {
                         $('#cid').val(data.localidade);
                    }
                    if ($('#est').val() == "") {
                         $('#est').val(data.uf);
                    }
               });
          }
     });

     $('#cgc').blur(function() {
          var cgc = $('#cgc').val();
          var cgc = cgc.replace(/[^0-9]/g, '');
          if (cgc != '') {
               $.ajax({
                    url: 'https://www.receitaws.com.br/v1/cnpj/' + cgc,
                    type: 'POST',
                    dataType: 'jsonp',
                    data: cgc,
                    success: function(data) {
                         if (data.nome != "") {
                              if ($('#raz').val() == "") {
                                   $('#raz').val(data.nome.substring(0, 75));
                              }
                              if ($('#fan').val() == "") {
                                   $('#fan').val(data.fantasia.substring(0, 50));
                              }
                              if ($('#end').val() == "") {
                                   $('#end').val(data.logradouro.substring(0, 50));
                              }
                              if ($('#num').val() == "" || $('#num').val() == ".") {
                                   $('#num').val(data.numero);
                              }
                              if ($('#cep').val() == "" || $('#cep').val() == "-") {
                                   $('#cep').val(data.cep.replace('.', ''));
                              }
                              if ($('#bai').val() == "") {
                                   $('#bai').val(data.bairro.substring(0, 50));
                              }
                              if ($('#com').val() == "") {
                                   $('#com').val(data.complemento);
                              }
                              if ($('#cid').val() == "") {
                                   $('#cid').val(data.municipio);
                              }
                              if ($('#est').val() == "") {
                                   $('#est').val(data.uf);
                              }
                              if ($('#con').val() == "") {
                                   $('#con').val(data.qsa[0].nome);
                              }
                              if ($('#fon').val() == "") {
                                   $('#fon').val(data.telefone.substring(0, 15));
                              }
                              if ($('#ema').val() == "") {
                                   $('#ema').val(data.email);
                              }
                         }
                    }
               });
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

<?php
     $ret = 00;
     $qtd = 00;
     $per = "";
     $cam = "";
     $bot = "Salvar";
     include_once "funcoes.php"; 
     $_SESSION['wrknompro'] = __FILE__; 
     if ( $_SESSION['wrktipusu'] <= 1) {
          echo '<script>alert("Nível de usuário não permite acesso a essa opção");</script>';
          echo '<script>history.go(-1);</script>';
     }
     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de manutenção de shopping do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrknumvol']) == false) { $_SESSION['wrknumvol'] = 1; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 0  : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 0  : $_REQUEST['sta']);
     $cgc = (isset($_REQUEST['cgc']) == false ? "" : $_REQUEST['cgc']);
     $ins = (isset($_REQUEST['ins']) == false ? "" : $_REQUEST['ins']);
     $inm = (isset($_REQUEST['inm']) == false ? "" : $_REQUEST['inm']);
     $tel = (isset($_REQUEST['tel']) == false ? "" : $_REQUEST['tel']);
     $cep = (isset($_REQUEST['cep']) == false ? "" : $_REQUEST['cep']);
     $end = (isset($_REQUEST['end']) == false ? "" : $_REQUEST['end']);
     $num = (isset($_REQUEST['num']) == false ? "" : $_REQUEST['num']);
     $com = (isset($_REQUEST['com']) == false ? "" : $_REQUEST['com']);
     $con = (isset($_REQUEST['con']) == false ? "" : $_REQUEST['con']);
     $bai = (isset($_REQUEST['bai']) == false ? "" : $_REQUEST['bai']);
     $cid = (isset($_REQUEST['cid']) == false ? "" : $_REQUEST['cid']);
     $est = (isset($_REQUEST['est']) == false ? "" : $_REQUEST['est']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $sit = (isset($_REQUEST['sit']) == false ? '' : $_REQUEST['sit']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     $raz = (isset($_REQUEST['raz']) == false ? '' : str_replace("'", "´", $_REQUEST['raz']));
     $fan = (isset($_REQUEST['fan']) == false ? '' : str_replace("'", "´", $_REQUEST['fan']));
     $nom0 = (isset($_REQUEST['nom0']) == false ? '' : $_REQUEST['nom0']);
     $fun0 = (isset($_REQUEST['fun0']) == false ? '' : $_REQUEST['fun0']);
     $dep0 = (isset($_REQUEST['dep0']) == false ? '' : $_REQUEST['dep0']);
     $tel0 = (isset($_REQUEST['tel0']) == false ? '' : $_REQUEST['tel0']);
     $ema0 = (isset($_REQUEST['ema0']) == false ? '' : $_REQUEST['ema0']);
     $nom1 = (isset($_REQUEST['nom1']) == false ? '' : $_REQUEST['nom1']);
     $fun1 = (isset($_REQUEST['fun1']) == false ? '' : $_REQUEST['fun1']);
     $dep1 = (isset($_REQUEST['dep1']) == false ? '' : $_REQUEST['dep1']);
     $tel1 = (isset($_REQUEST['tel1']) == false ? '' : $_REQUEST['tel1']);
     $ema1 = (isset($_REQUEST['ema1']) == false ? '' : $_REQUEST['ema1']);
     $nom2 = (isset($_REQUEST['nom2']) == false ? '' : $_REQUEST['nom2']);
     $fun2 = (isset($_REQUEST['fun2']) == false ? '' : $_REQUEST['fun2']);
     $dep2 = (isset($_REQUEST['dep2']) == false ? '' : $_REQUEST['dep2']);
     $tel2 = (isset($_REQUEST['tel2']) == false ? '' : $_REQUEST['tel2']);
     $ema2 = (isset($_REQUEST['ema2']) == false ? '' : $_REQUEST['ema2']);
     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de shopping informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_contato($cha, $t_con); 
               if (isset($t_con['nom']) == true) { $qtd = count($t_con['nom']); }
               $ret = ler_shopping($cha, $raz, $sta, $inm, $ema, $tel, $cel, $cep, $end, $num, $com, $bai, $cid, $est, $fan, $obs, $sit, $con, $ins, $cgc); 
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_sho();
               if ($ret == 0) {
                    $ret = upload_log($_FILES, $nom, $cam, $dir);   
                    $ret = incluir_sho($cam);
                    $ret = incluir_con($_SESSION['wrkcodreg']);
                    $ret = gravar_log(10,"Inclusão de novo shopping: " . $raz);
                    $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; $t_con = array();
                    $raz= ''; $ema = ''; $sta = 00; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = '';
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_sho();
               if ($ret == 0) {
                    $ret = upload_log($_FILES, $nom, $cam, $dir);   
                    $ret = alterar_sho($cam);
                    $ret = incluir_con($_SESSION['wrkcodreg']);
                    $ret = gravar_log(10,"Alteração de shopping existente: " . $raz);  $t_con = array();
                    $raz= ''; $ema = ''; $sta = 00; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = '';
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
              $ret = excluir_sho();
              $ret = gravar_log(10,"Exclusão de shopping existente: " . $raz); $t_con = array();
              $raz= ''; $ema = ''; $sta = 00; $fan = ''; $tel = ''; $cel = ''; $end = ''; $cep = ''; $bai = ''; $cid = ''; $est = ''; $com = ''; $con = ''; $sit = ''; $obs = ''; $cgc = ''; $ins = ''; $inm = '';
              echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
      }

?>

<body id="box01">
     <h1 class="cab-0">Shopping - Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container">
                    <div class="form-row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Shoppings</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-shopping.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo shopping no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <br />
                    <div class="row">
                         <div class="col-md-12">
                              <ul class="nav nav-pills nav-fill" id="TabG" role="tablist">
                                   <li class="nav-item">
                                        <a class="nav-link active" id="tab-d" data-toggle="tab" href="#TabD" role="tab"
                                             aria-controls="TabD" aria-selected="true"> <i class="fa fa-th-list fa-1g"
                                                  aria-hidden="true"></i> Dados do Shopping </a>
                                   </li>
                                   <li class="nav-item">
                                        <a class="nav-link" id="tab-c" data-toggle="tab" href="#TabC" role="tab"
                                             aria-controls="profile" aria-selected="false"> <i class="fa fa-users fa-1g"
                                                  aria-hidden="true"></i> Nomes de Contatos </a>
                                   </li>
                              </ul>
                         </div>
                    </div>
                    <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">
                         <div class="tab-content" id="TabGContent">
                              <div class="tab-pane fade show active" id="TabD" role="tabpanel" aria-labelledby="tab-d">
                                   <div class="form-row">
                                        <div class="col-md-2">
                                             <label>Código</label>
                                             <input type="text" class="form-control text-center" maxlength="6" id="cod"
                                                  name="cod" value="<?php echo $cod; ?>" disabled />
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                             <label>Número do C.n.p.j.</label>
                                             <input type="text" class="form-control" maxlength="50" id="cgc" name="cgc"
                                                  value="<?php echo $cgc; ?>" required />
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                             <label>Inscrição Estadual</label>
                                             <input type="text" class="form-control" maxlength="15" id="ins" name="ins"
                                                  value="<?php echo $ins; ?>" />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-7">
                                             <label>Razão Social</label>
                                             <input type="text" class="form-control" maxlength="75" id="raz" name="raz"
                                                  value="<?php echo $raz; ?>" required />
                                        </div>
                                        <div class="col-md-5">
                                             <label>Nome Fantasia</label>
                                             <input type="text" class="form-control" maxlength="60" id="fan" name="fan"
                                                  value="<?php echo $fan; ?>" required />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-2">
                                             <label>C.e.p.</label>
                                             <input type="text" class="form-control" maxlength="9" id="cep" name="cep"
                                                  value="<?php echo $cep; ?>" required />
                                        </div>
                                        <div class="col-md-5"></div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                             <label>Inscr. Municipal</label>
                                             <input type="text" class="form-control" maxlength="10" id="inm" name="inm"
                                                  value="<?php echo $inm; ?>" />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-10">
                                             <label>Endereço</label>
                                             <input type="text" class="form-control" maxlength="50" id="end" name="end"
                                                  value="<?php echo $end; ?>" />
                                        </div>
                                        <div class="col-md-2">
                                             <label>Número</label>
                                             <input type="text" class="form-control" maxlength="6" id="num" name="num"
                                                  value="<?php echo $num; ?>" />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-10">
                                             <label>Complemento</label>
                                             <input type="text" class="form-control" maxlength="50" id="com" name="com"
                                                  value="<?php echo $com; ?>" />
                                        </div>
                                        <div class="col-md-2"></div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-6">
                                             <label>Bairro</label>
                                             <input type="text" class="form-control" maxlength="50" id="bai" name="bai"
                                                  value="<?php echo $bai; ?>" />
                                        </div>
                                        <div class="col-md-5">
                                             <label>Município</label>
                                             <input type="text" class="form-control" maxlength="50" id="cid" name="cid"
                                                  value="<?php echo $cid; ?>" />
                                        </div>
                                        <div class="col-md-1">
                                             <label>Estado</label>
                                             <input type="text" class="form-control" maxlength="2" id="est" name="est"
                                                  value="<?php echo $est; ?>" />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-4">
                                             <label>Nº de Telefone</label>
                                             <input type="text" class="form-control" maxlength="15" id="tel" name="tel"
                                                  value="<?php echo $tel; ?>" required />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Nº de Celular</label>
                                             <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                                                  value="<?php echo $cel; ?>" />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Status</label>
                                             <select name="sta" class="form-control">
                                                  <option value="0"
                                                       <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                                       Normal</option>
                                                  <option value="1"
                                                       <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                                       Bloqueado</option>
                                                  <option value="2"
                                                       <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                                       Suspenso</option>
                                                  <option value="3"
                                                       <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                                       Cancelado</option>
                                             </select>
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-4">
                                             <label>E-Mail de Contato</label>
                                             <input type="email" class="form-control" maxlength="75" id="ema" name="ema"
                                                  value="<?php echo $ema; ?>" required />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Endereço do Site</label>
                                             <input type="text" class="form-control" maxlength="50" id="sit" name="sit"
                                                  value="<?php echo $sit; ?>" />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Nome do Contato</label>
                                             <input type="text" class="form-control" maxlength="50" id="con" name="con"
                                                  value="<?php echo $con; ?>" required />
                                        </div>
                                   </div>
                                   <div class="form-row">
                                        <div class="col-md-12">
                                             <label>Observação</label>
                                             <textarea class="form-control" rows="3" id="obs"
                                                  name="obs"><?php echo $obs ?></textarea>
                                        </div>
                                   </div>
                                   <br />
                                   <div class="form-row">
                                        <div class="col-md-1 text-center">
                                             <?php
                                                  $cam_a = 'upload/' . 'log_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . "jpg";
                                                  $cam_b = 'upload/' . 'log_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . "png";
                                                  $cam_c = 'upload/' . 'log_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . "jpeg";
                                                  if (file_exists($cam_a) == true) { echo '<img class="img-fluid" src="' . $cam_a . '" height="150" width="150">'; }     
                                                  if (file_exists($cam_b) == true) { echo '<img class="img-fluid" src="' . $cam_b . '" height="150" width="150">'; }     
                                                  if (file_exists($cam_c) == true) { echo '<img class="img-fluid" src="' . $cam_c . '" height="150" width="150">'; }     
                                             ?>
                                        </div>
                                        <div class="col-md-10 text-center">
                                             <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                                  class="bot-2"><?php echo $bot; ?></button>
                                        </div>
                                        <div class="col-md-1 text-center">
                                             <button type="button" class="bot-3" id="log_carrega" name="log" title="Upload de imagem de logotipo para o shopping cadastrado"><i class="fa fa-camera fa-3x" aria-hidden="true"></i><span></span> </button>                  
                                        </div>
                                   </div>
                                   <br />
                                   <div class="form-row">
                                        <div class="col-md-12 text-center">
                                             <?php
                                                  echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                             ?>
                                        </div>
                                   </div>
                              </div>

                              <div class="tab-pane fade" id="TabC" role="tabpanel" aria-labelledby="tab-c">
                                   <hr />
                                   <div id="nomes">
                                        <div class="form-row">
                                             <div class="col-md-3">
                                                  <label>Nome</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="nom_0"
                                                       name="nom_0"
                                                       value="<?php echo (isset($t_con['nom'][0]) == false ? "" : $t_con['nom'][0]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Função</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="fun_0"
                                                       name="fun_0"
                                                       value="<?php echo (isset($t_con['fun'][0]) == false ? "" : $t_con['fun'][0]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Departamento</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="dep_0"
                                                       name="dep_0"
                                                       value="<?php echo (isset($t_con['dep'][0]) == false ? "" : $t_con['dep'][0]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Telefone</label>
                                                  <input type="text" class="form-control left" maxlength="15" id="tel_0"
                                                       name="tel_0"
                                                       value="<?php echo (isset($t_con['tel'][0]) == false ? "" : $t_con['tel'][0]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>E-Mail</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="ema_0"
                                                       name="ema_0"
                                                       value="<?php echo (isset($t_con['ema'][0]) == false ? "" : $t_con['ema'][0]); ?>" />
                                             </div>
                                             <div class="col-md-1 text-center">
                                                  <br />
                                                  <button type="button" id="mais" class="bot-3" name="som"
                                                       title="Criação de linha para mais um contato"><i
                                                            class="fa fa-user-plus fa-2x" aria-hidden="true"></i>
                                                  </button>
                                             </div>
                                        </div>
                                        <div class="form-row">
                                             <div class="col-md-3">
                                                  <label>Nome</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="nom_1"
                                                       name="nom_1"
                                                       value="<?php echo (isset($t_con['nom'][1]) == false ? "" : $t_con['nom'][1]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Função</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="fun_1"
                                                       name="fun_1"
                                                       value="<?php echo (isset($t_con['fun'][1]) == false ? "" : $t_con['fun'][1]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Departamento</label>
                                                  <input type="text" class="form-control left" maxlength="55" id="dep_1"
                                                       name="dep_1"
                                                       value="<?php echo (isset($t_con['dep'][1]) == false ? "" : $t_con['dep'][1]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Telefone</label>
                                                  <input type="text" class="form-control left" maxlength="15" id="tel_1"
                                                       name="tel_1"
                                                       value="<?php echo (isset($t_con['tel'][1]) == false ? "" : $t_con['tel'][1]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>E-Mail</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="ema_1"
                                                       name="ema_1"
                                                       value="<?php echo (isset($t_con['ema'][1]) == false ? "" : $t_con['ema'][1]); ?>" />
                                             </div>
                                             <div class="col-md-1"></div>
                                        </div>
                                        <div class="form-row">
                                             <div class="col-md-3">
                                                  <label>Nome</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="nom_2"
                                                       name="nom_2"
                                                       value="<?php echo (isset($t_con['nom'][2]) == false ? "" : $t_con['nom'][2]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Função</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="fun_2"
                                                       name="fun_2"
                                                       value="<?php echo (isset($t_con['fun'][2]) == false ? "" : $t_con['fun'][2]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Departamento</label>
                                                  <input type="text" class="form-control left" maxlength="55" id="dep_2"
                                                       name="dep_2"
                                                       value="<?php echo (isset($t_con['dep'][2]) == false ? "" : $t_con['dep'][2]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Telefone</label>
                                                  <input type="text" class="form-control left" maxlength="15" id="tel_2"
                                                       name="tel_2"
                                                       value="<?php echo (isset($t_con['tel'][2]) == false ? "" : $t_con['tel'][2]); ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>E-Mail</label>
                                                  <input type="text" class="form-control left" maxlength="50" id="ema_2"
                                                       name="ema_2"
                                                       value="<?php echo (isset($t_con['ema'][2]) == false ? "" : $t_con['ema'][2]); ?>" />
                                             </div>
                                             <div class="col-md-1"></div>
                                        </div>
                                        <?php
                                        if ($qtd >= 3) { $ret = carrega_con($qtd, $t_con);  }
                                   ?>
                                   </div>
                              </div>
                         </div>
                         <input name="arq-log" type="file" id="log_janela" class="bot-h" />
                    </form>
               </div>

          </div>
     </div>
     <div id="box10">
          <img class="subir" src="img/subir.png" title="Volta a página para o seu topo." />
     </div>
</body>
<?php
function ultimo_cod() {
     $cod = 1;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select idshopping, shorazao from tb_shopping order by idshopping desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idshopping'] + 1;
     }
     return $cod;
}

 function consiste_sho() {
     $sta = 0;
     if (trim($_REQUEST['raz']) == "") {
         echo '<script>alert("Razão Social do shopping não pode estar em branco");</script>';
         return 1;
     }
     if (trim($_REQUEST['cgc']) == "" || trim($_REQUEST['cgc']) == "../-" || trim($_REQUEST['cgc']) == "..-") {
         echo '<script>alert("Número do C.n.p.j. do shopping pode estar em branco");</script>';
         return 7;
     }
     if (valida_est(strtoupper($_REQUEST['est'])) == 0) {
         echo '<script>alert("Estado da Federação do shopping informado não é válido");</script>';
         return 8;
     }
     if (strlen($_REQUEST['obs']) > 500) {
         echo '<script>alert("Observação do shopping não pode ter mais de 500 caracteres");</script>';
         $sta = 1;
     }   
     if ($_REQUEST['cgc'] != "") {
         $sta = valida_cgc($_REQUEST['cgc']);
         if ($sta != 0) {
             echo '<script>alert("Dígito de controle do C.n.p.j. não está correto");</script>';
             return 8;
         }
     }    
     if (trim($_REQUEST['cgc']) != "") {
         $cod = cnpj_exi(0, $_REQUEST['cgc'], $nom);
         if ($cod != 0 && $cod != $_SESSION['wrkcodreg']) {
             echo '<script>alert("C.n.p.j. informado para shopping já existe cadastrado");</script>';
             return 6;
         }    
     }
     return $sta;
 }

 function ler_shopping(&$cha, &$raz, &$sta, &$inm, &$ema, &$tel, &$cel, &$cep, &$end, &$num, &$com, &$bai, &$cid, &$est, &$fan, &$obs, &$sit, &$con, &$ins, &$cgc) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_shopping where idshopping = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do shopping informado não cadastrado");</script>';
         $nro = 1;
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idshopping'];
         $raz = $lin['shorazao'];
         $fan = $lin['shofantasia'];
         $sta = $lin['shostatus'];
         $cgc = $lin['shocnpj'];
         $ins = $lin['shoinsestadual'];
         $inm = $lin['shoinsmunicipal'];
         $con = $lin['shocontato'];
         $sit = $lin['showebsite'];
         $ema = $lin['shoemail'];
         $tel = $lin['shotelefone'];
         $cel = $lin['shocelular'];
         $cep = $lin['shocep'];
         $end = $lin['shoendereco'];
         $num = $lin['shonumeroend'];
         $com = $lin['shocomplemento'];
         $bai = $lin['shobairro'];
         $cid = $lin['shocidade'];
         $est = $lin['shoestado'];
         $obs = $lin['shoobservacao'];
         $_SESSION['wrkcodreg'] = $lin['idshopping'];
     }
     return $cha;
 }

 function incluir_sho($log) {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "insert into tb_shopping (";
     $sql .= "shocnpj, ";
     $sql .= "shostatus, ";
     $sql .= "shoinsestadual, ";
     $sql .= "shorazao, ";
     $sql .= "shofantasia, ";
     $sql .= "shocep, ";
     $sql .= "shoendereco, ";
     $sql .= "shonumeroend, ";
     $sql .= "shocomplemento, ";
     $sql .= "shobairro, ";
     $sql .= "shocidade, ";
     $sql .= "shoestado, ";
     $sql .= "shocelular, ";
     $sql .= "shotelefone, ";
     $sql .= "shoemail, ";
     $sql .= "shocontato, ";
     $sql .= "showebsite, ";
     $sql .= "shoinsmunicipal, ";
     $sql .= "shologotipo, ";
     $sql .= "shoobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . limpa_nro($_REQUEST['cgc']) . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['ins'] . "',";
     $sql .= "'" . $_REQUEST['raz'] . "',";
     $sql .= "'" . $_REQUEST['fan'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cep']) . "',";
     $sql .= "'" . $_REQUEST['end'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['num']) . "',";
     $sql .= "'" . $_REQUEST['com'] . "',";
     $sql .= "'" . $_REQUEST['bai'] . "',";
     $sql .= "'" . $_REQUEST['cid'] . "',";
     $sql .= "'" . $_REQUEST['est'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . $_REQUEST['con'] . "',";
     $sql .= "'" . $_REQUEST['sit'] . "',";
     $sql .= "'" . $_REQUEST['inm'] . "',";
     $sql .= "'" . $log . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = mysqli_query($conexao,$sql);
     $_SESSION['wrkcodreg'] = mysqli_insert_id($conexao); // Auto Increment Id
     if ($ret == true) {
         echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
     }else{
         print_r($sql);
         echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

 function alterar_sho($log) {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "update tb_shopping set ";
     $sql .= "shocnpj = '". limpa_nro($_REQUEST['cgc']) . "', ";
     $sql .= "shostatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "shoinsestadual = '". $_REQUEST['ins'] . "', ";
     $sql .= "shoinsmunicipal = '". $_REQUEST['inm'] . "', ";
     $sql .= "shorazao = '". $_REQUEST['raz'] . "', ";
     $sql .= "shofantasia = '". $_REQUEST['fan'] . "', ";
     $sql .= "shocep = '". limpa_nro($_REQUEST['cep']) . "', ";
     $sql .= "shoendereco = '". $_REQUEST['end'] . "', ";
     $sql .= "shonumeroend = '". limpa_nro($_REQUEST['num']) . "', ";
     $sql .= "shocomplemento = '". $_REQUEST['com'] . "', ";
     $sql .= "shobairro = '". $_REQUEST['bai'] . "', ";
     $sql .= "shocidade = '". $_REQUEST['cid'] . "', ";
     $sql .= "shoestado = '". $_REQUEST['est'] . "', ";
     $sql .= "shotelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "shocelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "shocontato =  '". $_REQUEST['con'] . "', ";
     $sql .= "shoemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "showebsite = '". $_REQUEST['sit'] . "', ";
     $sql .= "shoobservacao = '". $_REQUEST['obs'] . "', ";
     if ($log != "") { $sql .= "shologotipo = '". $log . "', "; }
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idshopping = " . $_SESSION['wrkcodreg'];
     $ret = mysqli_query($conexao,$sql);
     if ($ret == true) {
         echo '<script>alert("Registro alterado no sistema com Sucesso !");</script>';
     }else{
         print_r($sql);
         echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

 function excluir_sho() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_shopping where idshopping = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão do shopping solicitado !");</script>';
     }
     $sql  = "delete from tb_shopping_c where idshopping = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão dos contatos solicitados !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

function incluir_con($sho) {
     $sta = 00;
     $tab = $_REQUEST;
     include "lerinformacao.inc";
     $sql  = "delete from tb_shopping_c where idshopping = " . $sho;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão dos contatos do shopping solicitado !");</script>';
     }    
     foreach ($tab as $cpo => $dad) {
         if (strpos($cpo, "nom_") === 0) { 
             if ($dad != "") {
                 $nro = limpa_nro($cpo);
                 $sql  = "insert into tb_shopping_c (";
                 $sql .= "conempresa, ";
                 $sql .= "constatus, ";
                 $sql .= "idshopping, ";
                 $sql .= "connome, ";
                 $sql .= "condepto, ";
                 $sql .= "confuncao, ";
                 $sql .= "conemail, ";
                 $sql .= "contelefone, ";
                 $sql .= "keyinc, ";
                 $sql .= "datinc ";
                 $sql .= ") value ( ";
                 $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
                 $sql .= "'" . $_REQUEST['sta'] . "',";
                 $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
                 $sql .= "'" . $_REQUEST['nom_' . $nro] . "',";
                 $sql .= "'" . $_REQUEST['dep_' . $nro] . "',";
                 $sql .= "'" . $_REQUEST['fun_' . $nro] . "',";
                 $sql .= "'" . $_REQUEST['ema_' . $nro] . "',";
                 $sql .= "'" . $_REQUEST['tel_' . $nro] . "',";
                 $sql .= "'" . $_SESSION['wrkideusu'] . "',";
                 $sql .= "'" . date("Y-m-d H:i:s") . "')";
                 $ret = mysqli_query($conexao,$sql);
                 if ($ret == false) {
                     print_r($sql); $sta = 1;
                     echo '<script>alert("Erro na gravação dos contatos do shopping !");</script>';
                 }
             }
         }
     }
     $ret = desconecta_bco();
     return $sta;
}

function ler_contato($sho, &$t_con) {
 $sta = 0;
 include "lerinformacao.inc";
 $com = "Select * from tb_shopping_c where idshopping = " . $sho . " order by connome";
  $sql = mysqli_query($conexao, $com);
 while ($reg = mysqli_fetch_assoc($sql)) {        
     $t_con['nom'][] = $reg['connome'];
     $t_con['dep'][] = $reg['condepto'];
     $t_con['fun'][] = $reg['confuncao'];
     $t_con['ema'][] = $reg['conemail'];
     $t_con['tel'][] = $reg['contelefone'];
     $t_con['cel'][] = $reg['concelular'];
     $t_con['obs'][] = $reg['conobservacao'];
 }
 return $sta;
}

function carrega_con($qtd, $t_con) {
 $sta = 0;
 for ($ind = 3; $ind < $qtd; $ind++) {
     $txt = '<div class="form-row">
     <div class="col-md-3">
         <label>Nome</label>
         <input type="text" class="form-control left" maxlength="50" id="nom_2" name="nom_2" value="' . $t_con['nom'][$ind] .'" />   
     </div>
     <div class="col-md-2">
         <label>Função</label>
         <input type="text" class="form-control left" maxlength="50" id="fun_2" name="fun_2" value="' . $t_con['fun'][$ind] . '" />
     </div>
     <div class="col-md-2">
         <label>Departamento</label>
         <input type="text" class="form-control left" maxlength="55" id="dep_2" name="dep_2" value="' . $t_con['dep'][$ind] . '" />
     </div>
     <div class="col-md-2">
         <label>Telefone</label>
         <input type="text" class="form-control left" maxlength="15" id="tel_2" name="tel_2" value="' . $t_con['tel'][$ind] . '" />
     </div>
     <div class="col-md-2">
         <label>E-Mail</label>
         <input type="text" class="form-control left" maxlength="50" id="ema_2" name="ema_2" value="' . $t_con['ema'][$ind] . '" />
     </div>
     <div class="col-md-1"></div>
     </div>';
     echo $txt;
 }    
 return $sta;
}

function upload_log ($fil, &$nom, &$ima, &$cam) {
     $sta = 0; $nom = ""; $ima = "";
     $arq = (isset($fil['arq-log']) ? $fil['arq-log'] : false);
     if ($arq == false) {
          return 1;
     } else if ($arq['name'] == "") {
          return 2;
     }
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     if ($arq['error'] != 0) {
          echo "<script>alert(" . $erro[$arq['error']] . "')</script>";
          return 3; 
     }
     if ($sta == 0) {
         $tip = array('jpg', 'JPG', 'jpeg', 'JPEG', 'png', 'PNG');
         $nom = $arq['name'];
         $des = limpa_cpo($arq['name']);
         $tam = $arq['size'];
         $fim = explode('.', $des);
         $ext = end($fim);
         if (array_search($ext, $tip) === false) {
              echo "<script>alert('Extensão de arquivo de logotipo informado deve ser uma imagem')</script>";
              $sta = 4; 
         }
     }
     if ($sta == 0) {
         $tip = explode('.', $des);
         $des = $tip[0] . "." . $ext;
         $pas = "upload"; 
         if (file_exists($pas) == false) { mkdir($pas);  } 
         if (is_numeric($_SESSION['wrkcodreg']) == false) {
             $cam = $pas . "/" . $_SESSION['wrkcodreg']; $ima = $_SESSION['wrkcodreg'];
         } else {
             $ima = 'log_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . strtolower($ext);
             $cam = $pas . "/" . 'log_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . strtolower($ext);
         }
         $ret = move_uploaded_file($arq['tmp_name'], $cam);
         if ($ret == false) {
              echo "<script>alert('Erro no upload do logotipo informado para upload')</script>";
              $sta = 5; 
         } else {
             $sta = gravar_log(26,"UpLoad de logotipo do shopping Nome: " . $nom . " Tamanho: " . $tam);
         }      
     }    
     return $sta;
 }

?>

</html>