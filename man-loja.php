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

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Menu</title>
</head>

<script>
$(function() {
     $("#tel").mask("(99) 9999-9999");
     $("#cel").mask("(99)9-9999-9999");
     $("#cgc").mask("00.000.000/0000-00");
     $(".num").mask("999.999", { reverse: true });
     $("#are1").mask("0.000,00", { reverse: true });
     $("#are2").mask("0.000,00", { reverse: true });
     $("#cdi1").mask("0.000,00", { reverse: true });
});

$(document).ready(function() {
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
});
</script>

<?php
     $ret = 00;
     $qtd = 00;
     $per = "";
     $bot = "Salvar";
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de manutenção de lojas do sistema Pallas.33 - Gestão em Mall");  
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
     $tel = (isset($_REQUEST['tel']) == false ? "" : $_REQUEST['tel']);
     $cel = (isset($_REQUEST['cel']) == false ? '' : $_REQUEST['cel']);
     $ema = (isset($_REQUEST['ema']) == false ? '' : $_REQUEST['ema']);
     $sit = (isset($_REQUEST['sit']) == false ? '' : $_REQUEST['sit']);
     $loj = (isset($_REQUEST['loj']) == false ? '' : $_REQUEST['loj']);
     $pis = (isset($_REQUEST['pis']) == false ? '' : $_REQUEST['pis']);
     $fun = (isset($_REQUEST['fun']) == false ? '' : $_REQUEST['fun']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : $_REQUEST['obs']);
     $are1 = (isset($_REQUEST['are1']) == false ? 0 : $_REQUEST['are1']);
     $are2 = (isset($_REQUEST['are2']) == false ? 0 : $_REQUEST['are2']);
     $cdi1 = (isset($_REQUEST['cdi1']) == false ? 0 : $_REQUEST['cdi1']);
     $ele1 = (isset($_REQUEST['ele1']) == false ? 0 : $_REQUEST['ele1']);
     $ele2 = (isset($_REQUEST['ele2']) == false ? 0 : $_REQUEST['ele2']);
     $ele3 = (isset($_REQUEST['ele3']) == false ? 0 : $_REQUEST['ele3']);
     $inc1 = (isset($_REQUEST['inc1']) == false ? 0 : $_REQUEST['inc1']);
     $inc2 = (isset($_REQUEST['inc2']) == false ? 0 : $_REQUEST['inc2']);
     $hid1 = (isset($_REQUEST['hid1']) == false ? 0 : $_REQUEST['hid1']);
     $hid2 = (isset($_REQUEST['hid2']) == false ? 0 : $_REQUEST['hid2']);
     $hid3 = (isset($_REQUEST['hid3']) == false ? 0 : $_REQUEST['hid3']);
     $raz = (isset($_REQUEST['raz']) == false ? '' : str_replace("'", "´", $_REQUEST['raz']));
     $fan = (isset($_REQUEST['fan']) == false ? '' : str_replace("'", "´", $_REQUEST['fan']));     
     $con1 = (isset($_REQUEST['con1']) == false ? '' : str_replace("'", "´", $_REQUEST['con1']));
     $con2 = (isset($_REQUEST['con2']) == false ? '' : str_replace("'", "´", $_REQUEST['con2']));
     $con3 = (isset($_REQUEST['con3']) == false ? '' : str_replace("'", "´", $_REQUEST['con3']));
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
               $ret = ler_loja($cha, $sta, $cgc, $ins, $tel, $cel, $ema, $sit, $loj, $pis, $fun, $obs, $are1, $are2, $cdi1, $ele1, $ele2, $ele3, $inc1, $inc2, $hid1, $hid2, $hid3, $raz, $fan, $con1, $con2, $con3); 
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_loj();
               if ($ret == 0) {
                    $ret = incluir_loj();
                    $ret = gravar_log(10,"Inclusão de nova loja: " . $raz);
                    $cod = ultimo_cod(); $_SESSION['wrkcodreg'] = $cod; 
                    $raz= ''; $ema = ''; $sta = 00; $fan = ''; $tel = ''; $cel = ''; $loj = ''; $pis = ''; $fun = ''; $obs = ''; $are1 = ''; $are2 = ''; $cdi1 = ''; $ele1 = ''; $ele2 = ''; $cgc = ''; $ins = ''; $inc1 = ''; $inc2 = ''; $hid1 = ''; $hid2 = ''; $hid3 = '';  $con1 = ''; $con2 = ''; $con3 = '';
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_loj();
               if ($ret == 0) {
                    $ret = alterar_loj();
                    $ret = gravar_log(10,"Alteração de loja existente: " . $raz);  
                    $raz= ''; $ema = ''; $sta = 00; $fan = ''; $tel = ''; $cel = ''; $loj = ''; $pis = ''; $fun = ''; $obs = ''; $are1 = ''; $are2 = ''; $cdi1 = ''; $ele1 = ''; $ele2 = ''; $cgc = ''; $ins = ''; $inc1 = ''; $inc2 = ''; $hid1 = ''; $hid2 = ''; $hid3 = '';  $con1 = ''; $con2 = ''; $con3 = '';
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_loj();
               $ret = gravar_log(10,"Exclusão de loja existente: " . $raz); 
               $raz= ''; $ema = ''; $sta = 00; $fan = ''; $tel = ''; $cel = ''; $loj = ''; $pis = ''; $fun = ''; $obs = ''; $are1 = ''; $are2 = ''; $cdi1 = ''; $ele1 = ''; $ele2 = ''; $cgc = ''; $ins = ''; $inc1 = ''; $inc2 = ''; $hid1 = ''; $hid2 = ''; $hid3 = '';  $con1 = ''; $con2 = ''; $con3 = '';
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
     }

?>

<body>
     <h1 class="cab-0">Login Inicial Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">


               <div class="qua-3 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Lojas</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-loja.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar nova loja no sistema"><i
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
                                             aria-controls="TabD" aria-selected="true"> <i
                                                  class="fa fa-shopping-bag fa-1g" aria-hidden="true"></i> Dados da
                                             Loja</a>
                                   </li>
                                   <li class="nav-item">
                                        <a class="nav-link" id="tab-c" data-toggle="tab" href="#TabC" role="tab"
                                             aria-controls="profile" aria-selected="false"> <i class="fa fa-tags fa-1g"
                                                  aria-hidden="true"></i> Dados Complementares </a>
                                   </li>
                              </ul>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST" enctype="multipart/form-data">
                         <div class="tab-content" id="TabGContent">
                              <div class="tab-pane fade show active" id="TabD" role="tabpanel" aria-labelledby="tab-d">
                                   <div class="row">
                                        <div class="col-md-2">
                                             <label>Código</label>
                                             <input type="text" class="form-control text-center" maxlength="6" id="cod"
                                                  name="cod" value="<?php echo $cod; ?>" disabled />
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                             <label>Número do C.n.p.j.</label>
                                             <input type="text" class="form-control" maxlength="50" id="cgc" name="cgc"
                                                  value="<?php echo $cgc; ?>" />
                                        </div>
                                        <div class="col-md-2"></div>
                                        <div class="col-md-3">
                                             <label>Inscrição Estadual</label>
                                             <input type="text" class="form-control" maxlength="15" id="ins" name="ins"
                                                  value="<?php echo $ins; ?>" />
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-7">
                                             <label>Razão Social da Loja</label>
                                             <input type="text" class="form-control" maxlength="75" id="raz" name="raz"
                                                  value="<?php echo $raz; ?>" required />
                                        </div>
                                        <div class="col-md-5">
                                             <label>Nome Fantasia</label>
                                             <input type="text" class="form-control" maxlength="50" id="fan" name="fan"
                                                  value="<?php echo $fan; ?>" required />
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-3">
                                             <label>Nº da Loja</label>
                                             <input type="text" class="form-control" maxlength="10" id="loj" name="loj"
                                                  value="<?php echo $loj; ?>" />
                                        </div>
                                        <div class="col-md-6">
                                             <label>Nome do Piso</label>
                                             <input type="text" class="form-control" maxlength="20" id="pis" name="pis"
                                                  value="<?php echo $pis; ?>" />
                                        </div>
                                        <div class="col-md-3">
                                             <label>Nº de Funcionários</label>
                                             <input type="text" class="form-control" maxlength="3" id="fun" name="fun"
                                                  value="<?php echo $fun; ?>" />
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-4">
                                             <label>Nº de Telefone</label>
                                             <input type="text" class="form-control" maxlength="15" id="tel" name="tel"
                                                  value="<?php echo $tel; ?>" />
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
                                                       Loja Aberta</option>
                                                  <option value="1"
                                                       <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                                       Loja em Obra</option>
                                                  <option value="2"
                                                       <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                                       Loja Fechada</option>
                                             </select>
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-8">
                                             <label>E-Mail de Contato</label>
                                             <input type="text" class="form-control" maxlength="250" id="ema" name="ema"
                                                  value="<?php echo $ema; ?>" required />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Endereço do Site</label>
                                             <input type="text" class="form-control" maxlength="50" id="sit" name="sit"
                                                  value="<?php echo $sit; ?>" />
                                        </div>
                                   </div>
                                   <div class="row">
                                        <div class="col-md-4">
                                             <label>Nome do Colaborador</label>
                                             <input type="text" class="form-control" maxlength="50" id="con1"
                                                  name="con1" value="<?php echo $con1; ?>" />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Nome do Gerente</label>
                                             <input type="text" class="form-control" maxlength="50" id="con2"
                                                  name="con2" value="<?php echo $con2; ?>" />
                                        </div>
                                        <div class="col-md-4">
                                             <label>Nome do Proprietário</label>
                                             <input type="text" class="form-control" maxlength="50" id="con3"
                                                  name="con3" value="<?php echo $con3; ?>" />
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

                              </div>

                              <div class="tab-pane fade" id="TabC" role="tabpanel" aria-labelledby="tab-c">
                                   <hr />
                                   <div id="comple">
                                        <div class="row">
                                             <div class="col-md-4"></div>
                                             <div class="col-md-2">
                                                  <label>Área da Loja (m²)</label>
                                                  <input type="text" class="num form-control text-center" maxlength="6"
                                                       id="are1" name="are1" value="<?php echo $are1; ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Área do Mezanino (m²)</label>
                                                  <input type="text" class="num form-control text-center" maxlength="6"
                                                       id="are2" name="are2" value="<?php echo $are2; ?>" />
                                             </div>
                                             <div class="col-md-4"></div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-5"></div>
                                             <div class="col-md-2">
                                                  <label>Ar Condicionado (TR)</label>
                                                  <input type="text" class="num form-control text-center" maxlength="6"
                                                       id="cdi1" name="cdi1" value="<?php echo $cdi1; ?>" />
                                             </div>
                                             <div class="col-md-5"></div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-3"></div>
                                             <div class="col-md-2">
                                                  <label>Tensão (V)</label>
                                                  <input type="text" class="num form-control text-center" maxlength="6"
                                                       id="are1" name="ele1" value="<?php echo $ele1; ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Cabo de Entrada (mm²)</label>
                                                  <input type="text" class="num form-control text-center" maxlength="6"
                                                       id="are2" name="ele2" value="<?php echo $ele2; ?>" />
                                             </div>
                                             <div class="col-md-2">
                                                  <label>Disjunto Geral (A)</label>
                                                  <input type="text" class="num form-control text-center" maxlength="6"
                                                       id="are2" name="ele3" value="<?php echo $ele3; ?>" />
                                             </div>
                                             <div class="col-md-3"></div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-3"></div>
                                             <div class="col-md-3">
                                                  <label>Incêndio Entrada SPK (")</label>
                                                  <input type="text" class="form-control text-center" maxlength="6"
                                                       id="inc1" name="inc1" value="<?php echo $inc1; ?>" />
                                             </div>
                                             <div class="col-md-3">
                                                  <label>Incêndio Entrada Hidrante (")</label>
                                                  <input type="text" class="form-control text-center" maxlength="6"
                                                       id="inc2" name="inc2" value="<?php echo $inc2; ?>" />
                                             </div>
                                             <div class="col-md-3"></div>
                                        </div>
                                        <div class="row">
                                             <div class="col-md-3"></div>
                                             <div class="col-md-3">
                                                  <label>Hidráulica Água Potável (")</label>
                                                  <input type="text" class="form-control text-center" maxlength="6"
                                                       id="hid1" name="hid1" value="<?php echo $hid1; ?>" />
                                             </div>
                                             <div class="col-md-3">
                                                  <label>Hidráulica Entrada Gás (")</label>
                                                  <input type="text" class="form-control text-center" maxlength="6"
                                                       id="hid2" name="hid2" value="<?php echo $hid2; ?>" />
                                             </div>
                                             <div class="col-md-3"></div>
                                        </div>
                                        <br /><br /><br /><br /><br /><br /><br />
                                   </div>
                              </div>

                         </div>
                         <div class="row">
                              <div class="col-md-12 text-center">
                                   <button type="submit" id="env" name="salvar" <?php echo $per; ?>
                                        class="bot-2"><?php echo $bot; ?></button>
                              </div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-12 text-center">
                                   <?php
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>' ?>
                              </div>
                         </div>
                         <br />
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
     $sql = mysqli_query($conexao,"Select idloja, lojnome from tb_loja order by idloja desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idloja'] + 1;
     }
     return $cod;
}

function ler_loja(&$cha, &$sta, &$cgc, &$ins, &$tel, &$cel, &$ema, &$sit, &$loj, &$pis, &$fun, &$obs, &$are1, &$are2, &$cdi1, &$ele1, &$ele2, &$ele3, &$inc1, &$inc2, &$hid1, &$hid2, &$hid3, &$raz, &$fan, &$con1, &$con2, &$con3) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_loja where idloja = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código da loja informada não cadastrada");</script>';
         $nro = 1;
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idloja'];
         $raz = $lin['lojnome'];
         $fan = $lin['lojapelido'];
         $sta = $lin['lojstatus'];
         $cgc = $lin['lojcnpj'];
         $ins = $lin['lojinsestadual'];
         $con1 = $lin['lojcontato1'];
         $con2 = $lin['lojcontato2'];
         $con3 = $lin['lojcontato3'];
         $sit = $lin['lojsite'];
         $ema = $lin['lojemail'];
         $tel = $lin['lojtelefone'];
         $cel = $lin['lojcelular'];
         $loj = $lin['lojnumero'];
         $pis = $lin['lojpiso'];
         $are1 = $lin['lojarea1'];
         $are2 = $lin['lojarea2'];
         $cdi1 = $lin['lojarcondic1'];
         $fun = $lin['lojnumerofun'];
         $ele1 = $lin['lojeletrica1'];
         $ele2 = $lin['lojeletrica2'];
         $ele3 = $lin['lojeletrica3'];
         $inc1 = $lin['lojincendio1'];
         $inc2 = $lin['lojincendio2'];
         $hid1 = $lin['lojhidra1'];
         $hid2 = $lin['lojhidra2'];
         $hid3 = $lin['lojhidra3'];
         $obs = $lin['lojobservacao'];
         $_SESSION['wrkcodreg'] = $lin['idloja'];
     }
     return $cha;
 }

 function consiste_loj() {
     $sta = 0;
     if (trim($_REQUEST['raz']) == "") { 
          echo '<script>alert("Razão Social da loja não pode estar em branco");</script>';
          return 1;
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
          $cod = cnpj_exi(1, $_REQUEST['cgc'], $nom);
          if ($cod != 0 && $cod != $_SESSION['wrkcodreg']) {
               echo '<script>alert("C.n.p.j. informado para loja já existe cadastrado");</script>';
               return 6;
          }    
     }
     return $sta;
 }

 function incluir_loj() {
     $ret = 0;
     $are1 = str_replace(".", "", $_REQUEST['are1']); $are1 = str_replace(",", ".", $are1);
     $are2 = str_replace(".", "", $_REQUEST['are2']); $are2 = str_replace(",", ".", $are2);
     $cdi1 = str_replace(".", "", $_REQUEST['cdi1']); $cdi1 = str_replace(",", ".", $cdi1);
     include "lerinformacao.inc";
     $sql  = "insert into tb_loja (";
     $sql .= "idshopping, ";
     $sql .= "lojcnpj, ";
     $sql .= "lojstatus, ";
     $sql .= "lojinsestadual, ";
     $sql .= "lojnome, ";
     $sql .= "lojapelido, ";
     $sql .= "lojnumero, ";
     $sql .= "lojpiso, ";
     $sql .= "lojarea1, ";
     $sql .= "lojarea2, ";
     $sql .= "lojarcondic1, ";
     $sql .= "lojnumerofun, ";
     $sql .= "lojsite, ";
     $sql .= "lojemail, ";
     $sql .= "lojcelular, ";
     $sql .= "lojtelefone, ";
     $sql .= "lojcontato1, ";
     $sql .= "lojcontato2, ";
     $sql .= "lojcontato3, ";
     $sql .= "lojeletrica1, ";
     $sql .= "lojeletrica2, ";
     $sql .= "lojeletrica3, ";
     $sql .= "lojincendio1, ";
     $sql .= "lojincendio2, ";
     $sql .= "lojhidra1, ";
     $sql .= "lojhidra2, ";
     $sql .= "lojobservacao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";     
     $sql .= "'" . limpa_nro($_REQUEST['cgc']) . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['ins'] . "',";
     $sql .= "'" . $_REQUEST['raz'] . "',";
     $sql .= "'" . $_REQUEST['fan'] . "',";
     $sql .= "'" . $_REQUEST['loj'] . "',";
     $sql .= "'" . $_REQUEST['pis'] . "',";
     $sql .= "'" . ($are1 == "" || $are1 == "." ? '0': $are1) . "',";
     $sql .= "'" . ($are2 == "" || $are2 == "." ? '0': $are2) . "',";
     $sql .= "'" . ($cdi1 == "" || $cdi1 == "." ? '0': $cdi1) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['fun']) . "',";
     $sql .= "'" . $_REQUEST['sit'] . "',";
     $sql .= "'" . $_REQUEST['ema'] . "',";
     $sql .= "'" . $_REQUEST['cel'] . "',";
     $sql .= "'" . $_REQUEST['tel'] . "',";
     $sql .= "'" . $_REQUEST['con1'] . "',";
     $sql .= "'" . $_REQUEST['con2'] . "',";
     $sql .= "'" . $_REQUEST['con3'] . "',";
     $sql .= "'" . limpa_nro($_REQUEST['ele1']) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['ele2']) . "',";
     $sql .= "'" . limpa_nro($_REQUEST['ele3']) . "',";
     $sql .= "'" . $_REQUEST['inc1'] . "',";
     $sql .= "'" . $_REQUEST['inc2'] . "',";
     $sql .= "'" . $_REQUEST['hid1'] . "',";
     $sql .= "'" . $_REQUEST['hid2'] . "',";
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

function alterar_loj() {
     $ret = 0;
     $are1 = str_replace(".", "", $_REQUEST['are1']); $are1 = str_replace(",", ".", $are1);
     $are2 = str_replace(".", "", $_REQUEST['are2']); $are2 = str_replace(",", ".", $are2);
     $cdi1 = str_replace(".", "", $_REQUEST['cdi1']); $cdi1 = str_replace(",", ".", $cdi1);
     include "lerinformacao.inc";
     $sql  = "update tb_loja set ";
     $sql .= "lojcnpj = '". limpa_nro($_REQUEST['cgc']) . "', ";
     $sql .= "lojstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "lojinsestadual = '". $_REQUEST['ins'] . "', ";
     $sql .= "lojnome = '". $_REQUEST['raz'] . "', ";
     $sql .= "lojapelido = '". $_REQUEST['fan'] . "', ";
     $sql .= "lojnumero = '". $_REQUEST['loj'] . "', ";
     $sql .= "lojpiso = '". $_REQUEST['pis'] . "', ";
     $sql .= "lojarea1 = '". ($are1 == "" || $are1 == "." ? '0': $are1) . "', ";
     $sql .= "lojarea2 = '". ($are2 == "" || $are2 == "." ? '0': $are2) . "', ";
     $sql .= "lojarcondic1 = '". ($cdi1 == "" || $cdi1 == "." ? '0': $cdi1) . "', ";
     $sql .= "lojnumerofun = '". limpa_nro($_REQUEST['fun']) . "', ";
     $sql .= "lojemail = '". $_REQUEST['ema'] . "', ";
     $sql .= "lojsite = '". $_REQUEST['sit'] . "', ";
     $sql .= "lojtelefone = '". $_REQUEST['tel'] . "', ";
     $sql .= "lojcelular = '". $_REQUEST['cel'] . "', ";
     $sql .= "lojcontato1 =  '". $_REQUEST['con1'] . "', ";
     $sql .= "lojcontato2 =  '". $_REQUEST['con2'] . "', ";
     $sql .= "lojcontato3 =  '". $_REQUEST['con3'] . "', ";
     $sql .= "lojeletrica1 = '". limpa_nro($_REQUEST['ele1']) . "', ";
     $sql .= "lojeletrica2 = '". limpa_nro($_REQUEST['ele2']) . "', ";
     $sql .= "lojeletrica3 = '". limpa_nro($_REQUEST['ele3']) . "', ";
     $sql .= "lojincendio1 = '". $_REQUEST['inc1'] . "', ";
     $sql .= "lojincendio2 = '". $_REQUEST['inc2'] . "', ";
     $sql .= "lojhidra1 = '". $_REQUEST['hid1'] . "', ";
     $sql .= "lojhidra2 = '". $_REQUEST['hid2'] . "', ";
     $sql .= "lojobservacao = '". $_REQUEST['obs'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idloja = " . $_SESSION['wrkcodreg'];
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

 function excluir_loj() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_loja where idloja = " . $_SESSION['wrkcodreg'] ;
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


?>

</html>