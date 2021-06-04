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

     <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
     <script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
     <script src="js/summernote-pt-BR.js"></script>

     <script type="text/javascript" src="js/jquery.mask.min.js"></script>

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <title>Gestão em Mall - Vistoria em Lojas - Texto</title>
</head>
<script>
$(function() {
     $("#num").mask("999");
});

$(function () {
     $('[data-toggle="popover"]').popover()
})

$(document).ready(function() {

     $('#summernote').summernote({
          lang: 'pt-BR',
          placeholder: 'Informe aqui o texto para sua carta ...',
          tabsize: 10,
          height: 400,
          toolbar: [
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['font', ['strikethrough', 'superscript', 'subscript']],
          ['fontsize', ['fontsize']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['view', ['fullscreen', 'codeview', 'help']],
          ['height', ['height']]
          ]                    
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
               $ret = gravar_log(1,"Entrada na página de manutenção de textos do sistema Pallas.33 - Gestão em Mall");  
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
     $con = (isset($_REQUEST['con']) == false ? 0  : $_REQUEST['con']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     $nom = (isset($_REQUEST['nom']) == false ? '' : str_replace("'", "´", $_REQUEST['nom']));

     if ($_SESSION['wrkopereg'] == 1) { 
          $cod = ultimo_cod();
          $_SESSION['wrkmostel'] = 1;
     }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de texto de carta informado em tela ?\')" ';
     }  
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; $_SESSION['wrkmostel'] = 1;
               $ret = ler_texto($cha, $nom, $sta, $des, $con);                
          }
     }
     if (isset($_REQUEST['salvar']) == true) {
          $_SESSION['wrknumvol'] = $_SESSION['wrknumvol'] + 1;
          if ($_SESSION['wrkopereg'] == 1) {
               $ret = consiste_tex();
               if ($ret == 0) {
                    $ret = incluir_tex();
                    $ret = gravar_log(10,"Inclusão de novo texto para carta: " . $nom);
                    $des = ''; $nom = ''; $con = 0; $sta = 0; 
               }
          }
          if ($_SESSION['wrkopereg'] == 2) {
               $ret = consiste_tex();
               if ($ret == 0) {
                    $ret = alterar_tex();
                    $ret = gravar_log(10,"Alteração de texto de carta existente: " . $nom); $_SESSION['wrkmostel'] = 0;
                    $des = ''; $nom = ''; $con = 0; $sta = 0; 
                    echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
               }
          }
          if ($_SESSION['wrkopereg'] == 3) {
               $ret = excluir_tex();
               $ret = gravar_log(10,"Exclusão de texto de carta existente: " . $nom); $_SESSION['wrkmostel'] = 0;
               $des = ''; $nom = ''; $con = 0; $sta = 0; 
               echo '<script>history.go(-' . $_SESSION['wrknumvol'] . ');</script>'; $_SESSION['wrknumvol'] = 1;
          }
     }
?>

<body id="box01">
     <h1 class="cab-0">Texto para Carta - Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <label>Manutenção de Textos para Cartas</label>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-texto.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo texto de carta no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <form class="tel-1" name="frmTelMan" action="" method="POST">
                         <div class="row">
                              <div class="col-md-2">
                                   <label>Número</label>
                                   <input type="text" class="form-control text-center" maxlength="6" id="cod" name="cod"
                                        value="<?php echo $cod; ?>" disabled />
                              </div>
                              <div class="col-md-8"></div>
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
                              <div class="col-md-2"></div>
                              <div class="col-md-8">
                                   <label>Descrição da Não Conformidade</label>
                                   <select id="con" name="con" class="form-control" >
                                             <?php $ret = carrega_con($con); ?>
                                   </select>
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-2 text-center">
                                   <br />
                                   <a tabindex="0" class="bot-3" role="button" data-toggle="popover" data-trigger="focus" title="Lista de campos ..." data-content="[local] - Cidade localizada o shopping, [data] - Data de emissão da carta, [funcao] - Função do vistoriador, [gerencia] - Nome do gerente, [vistoriador] - Nome do vistoriador, [logo] - Logotipo do shopping "><i class="fa fa-info-circle fa-2x" aria-hidden="true"></i></a>
                              </div>
                              <div class="col-md-8">
                                   <label>Identificação do Texto para a Carta</label>
                                   <input type="text" class="form-control" maxlength="75" id="nom" name="nom"
                                        value="<?php echo $nom; ?>" required />
                              </div>
                              <div class="col-md-2"></div>
                         </div>
                         <br />
                         <div class="row">
                              <div class="col-md-12">
                                   <label>Texto para Carta a Clientes</label>
                                   <textarea class="form-control" rows="10" id="summernote" name="des"><?php echo $des ?></textarea>
                              </div> 
                         </div>
                         <br />
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
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>'
                                   ?>
                              </div>
                         </div>
                         <br />
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
     $sql = mysqli_query($conexao,"Select idtexto, texnome from tb_texto order by idtexto desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $cod = $lin['idtexto'] + 1;
     }
     return $cod;
 }

 function carrega_con($con) {
     $sta = 0;
     include "lerinformacao.inc";    
     $com = "Select idconformidade, condescricao from tb_conformidade where constatus = 0 order by condescricao";
     $sql = mysqli_query($conexao, $com);
     if ($con == 0) {
          echo '<option value="0" selected="selected">Selecione não conformidade desejada ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idconformidade'] != $con) {
               echo  '<option value ="' . $reg['idconformidade'] . '">' . $reg['condescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idconformidade'] . '" selected="selected">' . $reg['condescricao'] . '</option>';
          }
     }
     return $sta;
}

function ler_texto(&$cha, &$nom, &$sta, &$des, &$con) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_texto where idtexto = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
          echo '<script>alert("Código do texto de carta informado não cadastrado");</script>';
          $nro = 1;
     }else{
          $linha = mysqli_fetch_array($sql);
          $cha = $linha['idtexto'];
          $nom = $linha['texnome'];
          $sta = $linha['texstatus'];
          $des = $linha['texdescricao'];
          $con = $linha['texconformidade'];
     }
     return $cha;
 }

 function consiste_tex() {
     $sta = 0;
     if (trim($_REQUEST['nom']) == "") {
          echo '<script>alert("Nome do texto para carta não pode estar em branco");</script>';
          return 1;
     }
     if (trim($_REQUEST['des']) == "") {
          echo '<script>alert("Texto da Carta informado não pode estar em branco");</script>';
          return 3;
     }
     return $sta;
 }    
     
 function incluir_tex() {
     $ret = 0; $tam = strlen(strip_tags($_REQUEST['des']));
     include "lerinformacao.inc";
     $sql  = "insert into tb_texto (";
     $sql .= "texempresa, ";
     $sql .= "texstatus, ";
     $sql .= "texconformidade, ";
     $sql .= "texnome, ";
     $sql .= "texdescricao, ";
     $sql .= "textamanho, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . $_REQUEST['con'] . "',";
     $sql .= "'" . $_REQUEST['nom'] . "',";
     $sql .= "'" . $_REQUEST['des'] . "',";
     $sql .= "'" . $tam . "',";
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
 function alterar_tex() {
     $ret = 0; $tam = strlen(strip_tags($_REQUEST['des']));
     include "lerinformacao.inc";
     $sql  = "update tb_texto set ";
     $sql .= "texnome = '". $_REQUEST['nom'] . "', ";
     $sql .= "texstatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "texdescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "texconformidade = '". $_REQUEST['con'] . "', ";
     $sql .= "textamanho = '". $tam . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idtexto = " . $_SESSION['wrkcodreg'];
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
     
 function excluir_tex() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_texto where idtexto = " . $_SESSION['wrkcodreg'] ;
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