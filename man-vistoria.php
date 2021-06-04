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
     $("#hra").mask("00:00");
     $("#hre").mask("00:00");
     $("#age").mask("00/00/0000");
     $("#efe").mask("00/00/0000");
     $("#age").datepicker({ minDate: -30, maxDate: "+5M +30D" });
     $("#efe").datepicker({ minDate: -30, maxDate: "+5M +30D" });

});

$(document).ready(function() {
     $('#fot_carrega').bind("click", function() {
          $('#fot_janela').click();
     });
     $('#fot_janela').change(function() {
          var path = $('#fot_janela').val();
          // $('#cam').val(path.replace(/^.*\\/, ""));
     });

});
</script>
<?php
     $ret = 00;
     $per = "";
     $bot = "Salvar";
      include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

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
     $age = (isset($_REQUEST['age']) == false ? ''  : $_REQUEST['age']);
     $efe = (isset($_REQUEST['efe']) == false ? date('d/m/Y') : $_REQUEST['efe']);
     $hra = (isset($_REQUEST['hra']) == false ? '' : $_REQUEST['hra']);
     $hre = (isset($_REQUEST['hre']) == false ? date('H:i') : $_REQUEST['hre']);
     $tip = (isset($_REQUEST['tip']) == false ? 0 : $_REQUEST['tip']);
     $loj = (isset($_REQUEST['loj']) == false ? 0 : $_REQUEST['loj']);
     $aca = (isset($_REQUEST['aca']) == false ? 0 : $_REQUEST['aca']);
     $con = (isset($_REQUEST['con']) == false ? 0 : $_REQUEST['con']);
     $tec = (isset($_REQUEST['tec']) == false ? 0 : $_REQUEST['tec']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de vistoria informada em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
               $ret = ler_vistoria($cha, $sta, $age, $efe, $hra, $hre, $tip, $loj, $aca, $con, $tec, $obs);                
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_vis();
               if ($ret == 0) {
                    $ret = incluir_vis();
                    $ret = upload_fot($_FILES, $nom, $cam);   
                    $ret = gravar_log(10,"Inclusão de nova vistoria: " . $nom);
                    $sta = 0; $age = ''; $efe = ''; $hra = ''; $hre = ''; $tip = 0; $loj = 0; $aca = 0; $con = 0; $tec = 0; $obs = '';
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
              $ret = consiste_vis();
              if ($ret == 0) {
                  $ret = alterar_vis();
                  $ret = upload_fot($_FILES, $nom, $cam);   
                  $ret = gravar_log(10,"Alteração de vistoria existente: " . $nom); $_SESSION['wrkmostel'] = 0;
                  $sta = 0; $age = ''; $efe = ''; $hra = ''; $hre = ''; $tip = 0; $loj = 0; $aca = 0; $con = 0; $tec = 0; $obs = '';
                  echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
              }
          }
          if ($_SESSION['wrkopereg'] == 3) {
              $ret = excluir_vis();
              $ret = gravar_log(10,"Exclusão de vistoria existente: " . $nom); $_SESSION['wrkmostel'] = 0;
              $sta = 0; $age = ''; $efe = ''; $hra = ''; $hre = ''; $tip = 0; $loj = 0; $aca = 0; $con = 0; $tec = 0; $obs = '';
              echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
      }
?>

<body id="box01">
     <h1 class="cab-0">Vistoria - Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Vistorias</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-vistoria.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar nova vistoria no sistema"><i
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
                              <div class="col-md-8"></div>
                              <div class="col-md-2">
                                   <label>Status</label>
                                   <select name="sta" class="form-control">
                                        <option value="0" <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                             Normal</option>
                                        <option value="1" <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                             Agendada</option>
                                        <option value="2" <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                             Efetivada</option>
                                        <option value="3" <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                             Suspenso</option>
                                        <option value="4" <?php echo ($sta != 4 ? '' : 'selected="selected"'); ?>>
                                             Cancelado</option>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-6">
                                   <label>Nome do Vistoriador</label>
                                   <select id="tec" name="tec" class="form-control" required>
                                        <?php $ret = carrega_tec($tec); ?>
                                   </select>
                              </div>
                              <div class="col-md-6">
                                   <label>Nome da Loja</label>
                                   <select id="loj" name="loj" class="form-control" required>
                                        <?php $ret = carrega_loj($loj); ?>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Data de Agenda</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="age"
                                        name="age" value="<?php echo $age; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Hora de Agenda</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="hra"
                                        name="hra" value="<?php echo $hra; ?>" />
                              </div>
                              <div class="col-md-4">
                                   <label>Tipo de Vistoria</label>
                                   <select id="tip" name="tip" class="form-control" required>
                                        <?php $ret = carrega_tip($tip); ?>
                                   </select>                         
                              </div>
                              <div class="col-md-2">
                                   <label>Data da Vistoria</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="efe"
                                        name="efe" value="<?php echo $efe; ?>" />
                              </div>
                              <div class="col-md-2">
                                   <label>Hora da Vistoria</label>
                                   <input type="text" class="form-control text-center" maxlength="10" id="hre"
                                        name="hre" value="<?php echo $hre; ?>" />
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-12">
                                   <label>Observação</label>
                                   <textarea class="form-control" rows="5" id="obs"
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
                                             $cam_a = 'upload/' . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "_000." . "jpg";
                                             $cam_b = 'upload/' . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "_000." . "png";
                                             $cam_c = 'upload/' . 'fot_' . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "_000." . "jpeg";
                                             if (file_exists($cam_a) == true) { echo '<img src="' . $cam_a . '" width="175">'; }     
                                             if (file_exists($cam_b) == true) { echo '<img src="' . $cam_b . '" width="175">'; }     
                                             if (file_exists($cam_c) == true) { echo '<img src="' . $cam_c . '" width="175">'; }     
                                        ?>
                              </div>
                              <div class="col-md-1 text-center"></div>
                         </div>
                         <input name="arq-fot[]" type="file" id="fot_janela" accept="image/*" class="bot-h" multiple="multiple" />
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
     $sql = mysqli_query($conexao,"Select idvistoria, visdataage from tb_vistoria order by idvistoria desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idvistoria'] + 1;
     }
     return $cod;
 }

 function carrega_loj($loj) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_loja where lojstatus = 0 order by lojapelido";
     $sql = mysqli_query($conexao, $com);
     if ($loj == 0) {
          echo '<option value="0" selected="selected">Selecione loja a ser agendada ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idloja'] != $loj) {
               echo  '<option value ="' . $reg['idloja'] . '">' . $reg['lojapelido'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idloja'] . '" selected="selected">' . $reg['lojapelido'] . '</option>';
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

 function ler_vistoria(&$cha, &$sta, &$age, &$efe, &$hra, &$hre, &$tip, &$loj, &$aca, &$con, &$tec, &$obs) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_vistoria where idvistoria = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
          echo '<script>alert("Código da vistoria informada não cadastrada");</script>';
          $nro = 1;
     }else{
          $lin = mysqli_fetch_array($sql);
          $cha = $lin['idvistoria'];
          $sta = $lin['visstatus'];
          $age = date('d/m/Y',strtotime($lin['visdataage'])); 
          $efe = date('d/m/Y',strtotime($lin['visdataefe'])); 
          $hra = date('H:i',strtotime($lin['visdataage'])); 
          $hre = date('H:i',strtotime($lin['visdataefe'])); 
          $tip = $lin['vistipo'];
          $loj = $lin['visloja'];
          $aca = $lin['visacao'];
          $con = $lin['visconformidade'];
          $tec = $lin['vistecnico'];
          $obs = $lin['visobservacao'];
     }
     return $cha;
 }

 function consiste_vis() {
     $sta = 0;
     if ($_REQUEST['tip'] == "" || $_REQUEST['tip'] == "0") {
          echo '<script>alert("Tipo de vistoria para agendamento não pode ficar em branco");</script>';
          $sta = 1;
     }
     if ($_REQUEST['loj'] == "" || $_REQUEST['loj'] == "0") {
          echo '<script>alert("Código da loja para agendamento não pode ficar em branco");</script>';
          $sta = 1;
     }
     if ($_REQUEST['tec'] == "" || $_REQUEST['tec'] == "0") {
          echo '<script>alert("Código do vistoriador para agendamento não pode ficar em branco");</script>';
          $sta = 1;
     }
     if ($_REQUEST['age'] != "") {
          if (valida_dat($_REQUEST['age']) != 0) {
               echo '<script>alert("Data de agendamento informada no sistema não é valida");</script>';
               $sta = 1;
          }
     }     
     if ($_REQUEST['hra'] != "") {
          if (valida_hor(str_replace(' ','',$_REQUEST['hra'])) != 0) {
               echo '<script>alert("Hora de agendamento informada no sistema não é valida");</script>';
               $sta = 1;
          }
     }     
     if ($_REQUEST['efe'] != "") {
          if (valida_dat($_REQUEST['efe']) != 0) {
               echo '<script>alert("Data de vistoria informada no sistema não é valida");</script>';
               $sta = 1;
          }
     }     
     if ($_REQUEST['hre'] != "") {
          if (valida_hor(str_replace(' ','',$_REQUEST['hre'])) != 0) {
               echo '<script>alert("Hora de vistoria informada no sistema não é valida");</script>';
               $sta = 1;
          }
     }     
     if (strlen($_REQUEST['obs']) > 500) {
          echo '<script>alert("Observação para a vistoria não pode ter mais de 500 caracteres");</script>';
          $sta = 1;
     }
     return $sta;
 }    
     
 function incluir_vis() {
     $ret = 0;
     $hra = str_replace(' ','',$_REQUEST['hra']); $age = substr($_REQUEST['age'],6,4) . "-" . substr($_REQUEST['age'],3,2) . "-" . substr($_REQUEST['age'],0,2);     
     $hre = str_replace(' ','',$_REQUEST['hre']); $efe = substr($_REQUEST['efe'],6,4) . "-" . substr($_REQUEST['efe'],3,2) . "-" . substr($_REQUEST['efe'],0,2);     
     include "lerinformacao.inc";
     $sql  = "insert into tb_vistoria (";
     $sql .= "visempresa, ";
     $sql .= "visstatus, ";
     $sql .= "visdataage, ";
     $sql .= "visdataefe, ";
     $sql .= "visloja, ";
     $sql .= "vistipo, ";
     $sql .= "vistecnico, ";
     $sql .= "visobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= " " . ($age == "" || $age == "--" ? 'null' : "'" . $age .  " " . $hra . "'") . " ,";
     $sql .= " " . ($efe == "" || $efe == "--" ? 'null' : "'" . $efe  . " " . $hre . "'"). " ,";
     $sql .= "'" . $_REQUEST['loj'] . "',";
     $sql .= "'" . $_REQUEST['tip'] . "',";
     $sql .= "'" . $_REQUEST['tec'] . "',";
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
 function alterar_vis() {
     $ret = 0;
     include "lerinformacao.inc";
     $hra = str_replace(' ','',$_REQUEST['hra']); $age = substr($_REQUEST['age'],6,4) . "-" . substr($_REQUEST['age'],3,2) . "-" . substr($_REQUEST['age'],0,2);     
     $hre = str_replace(' ','',$_REQUEST['hre']); $efe = substr($_REQUEST['efe'],6,4) . "-" . substr($_REQUEST['efe'],3,2) . "-" . substr($_REQUEST['efe'],0,2);     
     $sql  = "update tb_vistoria set ";
     $sql .= "visstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "visdataage = ". ($age == "" || $age == "--" ? 'null' : "'" . $age . " " . $hra . "'") . ", ";
     $sql .= "visdataefe =  ". ($efe == "" || $efe == "--" ? 'null' : "'" . $efe . " " . $hre . "'") . ", ";
     $sql .= "visloja = '". $_REQUEST['loj'] . "', ";
     $sql .= "vistipo = '". $_REQUEST['tip'] . "', ";
     $sql .= "vistecnico = '". $_REQUEST['tec'] . "', ";
     $sql .= "visobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idvistoria = " . $_SESSION['wrkcodreg'];
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
     
 function excluir_vis() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_vistoria_l where lisvistoria = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
          print_r($sql);
          echo '<script>alert("Erro na exclusão do detalhe de vistoria solicitado !");</script>';
     }
     $sql  = "delete from tb_vistoria where idvistoria = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == true) {
          echo '<script>alert("Registro excluído no sistema com Sucesso !");</script>';
     }else{
          print_r($sql);
          echo '<script>alert("Erro na exclusão de vistoria solicitado por usuário !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
}

function upload_fot ($fil, &$nom, &$ima) {
     $sta = 0; $nom = ""; $ima = "";
     $arq = (isset($fil['arq-fot']) ? $fil['arq-fot'] : false);
     if ($arq == false) {
          return 1;
     }else if ($arq['name'][0] == "") {
          $sta = 2; 
     }            
     $num = count($arq['name']);
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     for ($ind = 0;$ind < $num; $ind++) {
          if ($arq['error'][$ind] != 0) {
               if ($_SESSION['wrkopereg'] == 1) {
                    if ($arq['name'][$ind] != "") {
                         echo "<script>alert(" . $erro[$arq['error'][$ind]] . "')</script>";
                    }
                    $sta = 3; 
               }else{
                    return 4;
               }
          }
          if ($sta == 0) {
               $tip = array('jpg','png','jpeg','JPG','PNG','JPEG');
               $des = limpa_cpo($arq['name'][$ind]);
               $tam = $arq['size'][$ind];
               $lim = $tam / 1024;  // Byte - Kbyte - MegaByte
               $fim = explode('.', $des);
               $ext = end($fim);
               if (array_search($ext, $tip) === false) {
                    echo "<script>alert('Extensão do arquivo informado para Upload não é permitido')</script>";
                    $sta = 5; 
               }
          }
          if ($sta == 0) {
               $tip = explode('.', $des);
               $des = $tip[0] . "." . $ext;
               $pas = "upload"; 
               if (file_exists($pas) == false) { mkdir($pas); }
               $nro = ultima_cha();
               $nom = "fot_" . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT) . "_" . str_pad($nro, 3, "0", STR_PAD_LEFT) . "." .  $ext;
               $cam = $pas . "/" . $nom;
               $ret = move_uploaded_file($arq['tmp_name'][$ind], $cam);
               if ($ret == false) {
                    echo "<script>alert('Erro na cópia do arquivo (" . $ind . ") informado para upload')</script>";
                    $sta = 6; 
               }      
          } 
     }   
     return $sta;
}

function ultima_cha() {
     $nro = 0;
     $cha = str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT);
     foreach (new DirectoryIterator('upload/') as $dad) {
          if ($dad->isDir() == false) {
               $cam = $dad->getPathname();
               if (strpos($cam, $cha) > 0 ) {
                    $nro = $nro + 1;
               }
          }
     }
     return $nro;
}

?>

</html>