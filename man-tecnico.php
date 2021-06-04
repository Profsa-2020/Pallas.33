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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Técnico</title>
</head>
<script>
$(function() {
     $("#ace").mask("999.999");
     $("#cpf").mask("000.000.000-00");
});

$(document).ready(function() {
     $('#fot_carrega').bind("click", function() {
          $('#fot_janela').click();
     });
     $('#fot_janela').change(function() {
          var path = $('#fot_janela').val();
          // $('#cam').val(path.replace(/^.*\\/, ""));
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

});
</script>
<?php
     $ret = 00;
     $per = "";
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
               $ret = gravar_log(1,"Entrada na página de manutenção de vistoriador do sistema Pallas.33 - Gestão em Mall");  
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
     $fun = (isset($_REQUEST['fun']) == false ? 0  : $_REQUEST['fun']);
     $cpf = (isset($_REQUEST['cpf']) == false ? 0  : $_REQUEST['cpf']);
     $reg = (isset($_REQUEST['reg']) == false ? '' : $_REQUEST['reg']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $tel = (isset($_REQUEST['tel']) == false ? '' : $_REQUEST['tel']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $cep = (isset($_REQUEST['cep']) == false ? "" : $_REQUEST['cep']);
     $end = (isset($_REQUEST['end']) == false ? "" : $_REQUEST['end']);
     $num = (isset($_REQUEST['num']) == false ? "" : $_REQUEST['num']);
     $com = (isset($_REQUEST['com']) == false ? "" : $_REQUEST['com']);
     $bai = (isset($_REQUEST['bai']) == false ? "" : $_REQUEST['bai']);
     $cid = (isset($_REQUEST['cid']) == false ? "" : $_REQUEST['cid']);
     $est = (isset($_REQUEST['est']) == false ? "" : $_REQUEST['est']);
     $ape = (isset($_REQUEST['ape']) == false ? '' : str_replace("'", "´", $_REQUEST['ape']));
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de vistoriador informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
               $ret = ler_tecnico($cha, $nom, $sta, $fun, $reg, $ema, $tel, $cel, $cep, $end, $num, $cpf, $com, $bai, $cid, $est, $ape, $obs);                
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
              $ret = consiste_tec();
              if ($ret == 0) {
                  $ret = incluir_tec();
                  $ret = upload_fot($_FILES, $nom, $cam);                     
                  $ret = gravar_log(10,"Inclusão de novo vistoriador: " . $nom);
                  $end = ''; $nom = ''; $ema = ''; $sta = ''; $fun = ''; $tel = ''; $cel = ''; $reg = ''; $cpf = ''; $cep = ''; $end = ''; $num = ''; $bai = '';  $cid = ''; $est = '';  $ape = ''; $obs = '';
              }
          }
          if ($_SESSION['wrkopereg'] == 2) {
              $ret = consiste_tec();
              if ($ret == 0) {
                  $ret = alterar_tec();
                  $ret = upload_fot($_FILES, $nom, $cam);   
                  $ret = gravar_log(10,"Alteração de vistoriador existente: " . $nom); $_SESSION['wrkmostel'] = 0;
                  $end = ''; $nom = ''; $ema = ''; $sta = ''; $fun = ''; $tel = ''; $cel = ''; $reg = ''; $cpf = ''; $cep = ''; $end = ''; $num = ''; $bai = '';  $cid = ''; $est = '';  $ape = ''; $obs = '';
                  echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
              }
          }
          if ($_SESSION['wrkopereg'] == 3) {
              $ret = excluir_tec();
              $ret = gravar_log(10,"Exclusão de vistoriador existente: " . $nom); $_SESSION['wrkmostel'] = 0;
              $end = ''; $nom = ''; $ema = ''; $sta = ''; $fun = ''; $tel = ''; $cel = ''; $reg = ''; $cpf = ''; $cep = ''; $end = ''; $num = ''; $bai = '';  $cid = ''; $est = '';  $ape = ''; $obs = '';
              echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
      }
?>

<body id="box01">
     <h1 class="cab-0">Técnico - Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Vistoriadores</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-tecnico.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo vistoriador no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Código</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-10">
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-8">
                                   <label>Nome do Vistoriador</label>
                                   <input type="text" class="form-control" maxlength="50" id="nom" name="nom"
                                        value="<?php echo $nom; ?>" required />
                              </div>
                              <div class="col-md-2">
                                   <label>Apelido</label>
                                   <input type="text" class="form-control" maxlength="25" id="ape" name="ape"
                                        value="<?php echo $ape; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Status</label>
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>Normal
                                        </option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                             Bloqueado</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                             Suspenso</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                             Cancelado</option>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-3">
                                   <label>C.e.p.</label>
                                   <input type="text" class="form-control" maxlength="9" id="cep" name="cep"
                                        value="<?php echo $cep; ?>" />
                              </div>
                              <div class="col-md-3">
                                   <label>Número do C.p.f.</label>
                                   <input type="text" class="form-control" maxlength="14" id="cpf" name="cpf"
                                        value="<?php echo $cpf; ?>" />
                              </div>
                              <div class="col-md-3">
                                   <label>Número do R. G.</label>
                                   <input type="text" class="form-control" maxlength="15" id="reg" name="reg"
                                        value="<?php echo $reg; ?>" />
                              </div>
                              <div class="col-md-3">
                                   <label>Função</label>
                                   <select name="fun" class="form-control" required >
                                        <option value="0" <?php echo ($fun != 0 ? '' : 'selected="selected"'); ?>>
                                             Colaborador</option>
                                        <option value="1" <?php echo ($fun != 1 ? '' : 'selected="selected"'); ?>>
                                             Técnico</option>
                                        <option value="2" <?php echo ($fun != 2 ? '' : 'selected="selected"'); ?>>
                                             Lider</option>
                                        <option value="3" <?php echo ($fun != 3 ? '' : 'selected="selected"'); ?>>
                                             Bravo</option>
                                        <option value="4" <?php echo ($fun != 4 ? '' : 'selected="selected"'); ?>>
                                             Coordenador</option>
                                        <option value="5" <?php echo ($fun != 5 ? '' : 'selected="selected"'); ?>>
                                             GEOP</option>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
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
                         <div class="row">
                              <div class="col-md-10">
                                   <label>Complemento</label>
                                   <input type="text" class="form-control" maxlength="50" id="com" name="com"
                                        value="<?php echo $com; ?>" />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
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
                         <div class="row">
                              <div class="col-md-12">
                                   <label>E-Mail</label>
                                   <input type="text" class="form-control" maxlength="250" id="ema" name="ema"
                                        value="<?php echo $ema; ?>" required />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-3">
                                   <label>Telefone</label>
                                   <input type="text" class="form-control" maxlength="15" id="tel" name="tel"
                                        value="<?php echo $tel; ?>" />
                              </div>
                              <div class="col-md-6"></div>
                              <div class="col-md-3">
                                   <label>Celular</label>
                                   <input type="text" class="form-control" maxlength="15" id="cel" name="cel"
                                        value="<?php echo $cel; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-12">
                                   <label>Observação</label>
                                   <textarea class="form-control" rows="3" id="obs"
                                        name="obs"><?php echo $obs ?></textarea>
                              </div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-11 text-center">
                                   <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                        class="bot-2"><?php echo $bot; ?></button>
                              </div>
                              <div class="col-md-1 text-center">
                                   <button type="button" class="bot-3" id="fot_carrega" name="fot"
                                        title="Upload de foto do vistoriador para o sistema de Gestão de Mall"><i
                                             class="fa fa-camera fa-3x" aria-hidden="true"></i><span></span> </button>
                              </div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-11 text-center">
                                   <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                              </div>
                              <div class="col-md-1"></div>
                         </div>
                         <div class="form-row">
                                        <div class="col-md-11 text-center">
                                        <?php
                                             $cam_a = 'upload/' . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . "jpg";
                                             $cam_b = 'upload/' . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . "png";
                                             $cam_c = 'upload/' . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . "jpeg";
                                             if (file_exists($cam_a) == true) { echo '<img src="' . $cam_a . '" height="150" width="175">'; }     
                                             if (file_exists($cam_b) == true) { echo '<img src="' . $cam_b . '" height="150" width="175">'; }     
                                             if (file_exists($cam_c) == true) { echo '<img src="' . $cam_c . '" height="150" width="175">'; }     
                                        ?>
                                        </div>
                                        <div class="col-md-1 text-center"></div>
                                   </div>                                  
                         <input name="arq-fot" type="file" id="fot_janela" class="bot-h" />
                         <input type="hidden" id="mos" name="mos" value="<?php echo $_SESSION['wrkmostel']; ?>" />
                    </form>
               </div>
          </div>
     </div>

</body>
<?php
function ultimo_cod() {
     $cod = 1;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select idtecnico, tecnome from tb_tecnico order by idtecnico desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
         $lin = mysqli_fetch_array($sql);
         $cod = $lin['idtecnico'] + 1;
     }
     return $cod;
 }

 function ler_tecnico(&$cha, &$nom, &$sta, &$fun, &$reg, &$ema, &$tel, &$cel, &$cep, &$end, &$num, &$cpf, &$com, &$bai, &$cid, &$est, &$ape, &$obs) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_tecnico where idtecnico = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do vistoriador informada não cadastrada");</script>';
         $nro = 1;
     }else{
         $linha = mysqli_fetch_array($sql);
         $cha = $linha['idtecnico'];
         $nom = $linha['tecnome'];
         $sta = $linha['tecstatus'];
         $fun = $linha['tecfuncao'];
         $cep = $linha['teccep'];
         $reg = $linha['tecrg'];
         $cpf = $linha['teccpf'];
         $ema = $linha['tecemail'];
         $tel = $linha['tectelefone'];
         $cel = $linha['teccelular'];
         $end = $linha['tecendereco'];
         $num = $linha['tecnumeroend'];
         $com = $linha['teccomplemento'];
         $bai = $linha['tecbairro'];
         $cid = $linha['teccidade'];
         $est = $linha['tecestado'];
         $ape = $linha['tecapelido'];
         $obs = $linha['tecobservacao'];
     }
     return $cha;
 }

 function consiste_tec() {
     $sta = 0;
     if (trim($_REQUEST['nom']) == "") {
          echo '<script>alert("Nome do vistoriador não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['ema']) == "") {
          echo '<script>alert("E-mail do vistoriador não pode estar em branco");</script>';
          return 3;
     }
     if (strlen($_REQUEST['obs']) > 500) {
          echo '<script>alert("Observação para o vistoriador não pode ter mais de 500 caracteres");</script>';
          $sta = 1;
     }
     if (trim($_REQUEST['est']) != "") {
          if (valida_est(strtoupper($_REQUEST['est'])) == 0) {
               echo '<script>alert("Estado da Federação do vistoriador informado não é válido");</script>';
               return 8;
          }
     }
     return $sta;
 }    
     
 function incluir_tec() {
     $ret = 0;
     include "lerinformacao.inc";
     $num = str_replace(".", "", $_REQUEST['num']); $num = str_replace(",", ".", $num);
     $sql  = "insert into tb_tecnico (";
     $sql .= "tecempresa, ";
     $sql .= "tecstatus, ";
     $sql .= "tecnome, ";
     $sql .= "tecemail, ";
     $sql .= "teccpf, ";
     $sql .= "tecfuncao, ";
     $sql .= "tectelefone, ";
     $sql .= "teccelular, ";
     $sql .= "tecrg, ";
     $sql .= "teccep, ";
     $sql .= "tecendereco, ";
     $sql .= "teccomplemento, ";
     $sql .= "tecnumeroend, ";
     $sql .= "tecbairro, ";
     $sql .= "teccidade, ";
     $sql .= "tecestado, ";
     $sql .= "tecapelido, ";
     $sql .= "tecobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['nom'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cpf']) . "',";
     $sql .= "'" . $_REQUEST['fun'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['reg'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['cep']) . "',";
     $sql .= "'" . $_REQUEST['end'] . "',";
     $sql .= "'" . $_REQUEST['com'] . "',";
     $sql .= "'" . ($num == "" ? '0' : $num) . "',";
     $sql .= "'" . $_REQUEST['bai'] . "',";
     $sql .= "'" . $_REQUEST['cid'] . "',";
     $sql .= "'" . $_REQUEST['est'] . "',";
     $sql .= "'" . $_REQUEST['ape'] . "',";
     $sql .= "'" . $_REQUEST['obs'] . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = mysqli_query($conexao,$sql);
     if ($ret == true) {
         echo '<script>alert("Registro incluído no sistema com Sucesso !");</script>';
     }else{
         print_r($sql);
         echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }
 function alterar_tec() {
     $ret = 0;
     include "lerinformacao.inc";
     $num = str_replace(".", "", $_REQUEST['num']); $num = str_replace(",", ".", $num);
     $sql  = "update tb_tecnico set ";
     $sql .= "tecnome = '". $_REQUEST['nom'] . "', ";
     $sql .= "tecstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "tecfuncao = '". $_REQUEST['fun'] . "', ";
     $sql .= "teccep = '". limpa_nro($_REQUEST['cep']) . "', ";
     $sql .= "tecendereco = '". $_REQUEST['end'] . "', ";
     $sql .= "teccomplemento = '". $_REQUEST['com'] . "', ";
     $sql .= "tecbairro = '". $_REQUEST['bai'] . "', ";
     $sql .= "teccidade = '". $_REQUEST['cid'] . "', ";
     $sql .= "tecestado = '". $_REQUEST['est'] . "', ";
     $sql .= "teccpf = '". limpa_nro($_REQUEST['cpf']) . "', ";
     $sql .= "tecrg = '". $_REQUEST['reg'] . "', ";
     $sql .= "tecemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "tectelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "teccelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "tecnumeroend = '". ($num == "" ? '0' : $num) . "', ";
     $sql .= "tecapelido = '". $_REQUEST['ape'] . "', ";
     $sql .= "tecobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idtecnico = " . $_SESSION['wrkcodreg'];
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
     
 function excluir_tec() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_tecnico where idtecnico = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == true) {
          echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
}

function upload_fot ($fil, &$nom, &$ima) {
     $sta = 0; $nom = ""; $ima = "";
     $arq = (isset($fil['arq-fot']) ? $fil['arq-fot'] : false);
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
              echo "<script>alert('Extensão de arquivo de imagem informado deve ser uma imagem')</script>";
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
             $ima = 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . strtolower($ext);
             $cam = $pas . "/" . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "." . strtolower($ext);
         }
         $ret = move_uploaded_file($arq['tmp_name'], $cam);
         if ($ret == false) {
              echo "<script>alert('Erro no upload da foto informado para upload')</script>";
              $sta = 5; 
         } else {
             $sta = gravar_log(26,"UpLoad de foto do vistoriador Nome: " . $nom . " Tamanho: " . $tam);
         }      
     }    
     return $sta;
 }

?>

</html>