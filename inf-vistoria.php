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

     <link href="css/pallas33.css" rel="stylesheet" type="text/css" media="screen" />
     <link href="css/pallas33p.css" rel="stylesheet" type="text/css" media="print" />

     <title>Gestão em Mall - Vistoria em Lojas - Menu</title>
</head>

<script>
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
     $txt = '';
     $lis = '';
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de efetiva vistoria do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_SESSION['wrkcodtec']) == false) { $_SESSION['wrkcodtec'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $con = (isset($_REQUEST['con']) == false ? 0 : $_REQUEST['con']);
     $aca = (isset($_REQUEST['aca']) == false ? 0 : $_REQUEST['aca']);
     $pri = (isset($_REQUEST['pri']) == false ? 0 : $_REQUEST['pri']);
     $obs = (isset($_REQUEST['obs']) == false ? '' : str_replace("'", "´", $_REQUEST['obs']));
     if (isset($_REQUEST['salvar']) == true) { 
          $ret = 0;
          if (trim($_REQUEST['con']) == "" || trim($_REQUEST['con']) == "0") {
               echo '<script>alert("Código da não conformidade não pode estar em branco");</script>';
               $ret = 1;
          }
          if (strlen($_REQUEST['obs']) > 500) {
               echo '<script>alert("Observação para o vistoriador não pode ter mais de 500 caracteres");</script>';
               $ret = 1;
          }  
          if ($ret == 0) {
               include "lerinformacao.inc";
               $sql  = "insert into tb_vistoria_l (";
               $sql .= "lisempresa, ";
               $sql .= "lisstatus, ";
               $sql .= "lisvistoria, ";
               $sql .= "lisacao, ";
               $sql .= "lisconformidade, ";
               $sql .= "lisprioridade, ";
               $sql .= "listipo, ";
               $sql .= "lisobservacao, ";
               $sql .= "keyinc, ";
               $sql .= "datinc ";
               $sql .= ") value ( ";
               $sql .= "'" . $_SESSION['wrkcodemp'] . "',";
               $sql .= "'" . '0' . "',";
               $sql .= "'" . $_SESSION['wrkcodreg'] . "',";
               $sql .= "'" . $_REQUEST['aca'] . "',";
               $sql .= "'" . $_REQUEST['con'] . "',";
               $sql .= "'" . $_REQUEST['pri'] . "',";
               $sql .= "'" . '0' . "',";
               $sql .= "'" . $_REQUEST['obs'] . "',";
               $sql .= "'" . $_SESSION['wrkideusu'] . "',";
               $sql .= "'" . date("Y/m/d H:i:s") . "')";
               $ret = mysqli_query($conexao,$sql);
               $_SESSION['wrknumreg'] = mysqli_insert_id($conexao); // Auto Increment Id 
               if ($ret == true) {
                    echo '<script>alert("Registro de ocorrência incluído no sistema com Sucesso !");</script>';
               }else{
                    print_r($sql);
                    echo '<script>alert("Erro na gravação do registro de ocorrência solicitada !");</script>';
               }
               $sql  = "update tb_vistoria set ";
               $sql .= "visstatus = '". '2' . "', ";
               $sql .= "visdataefe = '". date('Y-m-d H:i:s') . "', ";
               $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
               $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
               $sql .= "where idvistoria = " . $_SESSION['wrkcodreg'];
               $ret = mysqli_query($conexao,$sql);
               if ($ret == false) {
                    print_r($sql);
                    echo '<script>alert("Erro na regravação da vistoria solicitada !");</script>';
               }          
               $ret = desconecta_bco();
               $ret = upload_fot($cam, $res, $tam, $ext);                     
               $obs = ''; $aca = 0; $con = 0; $pri = 0; $_SESSION['wrknumreg'] = 0;
          }        
     }
     if ($_SESSION['wrkcodreg'] != 0) {
          if (isset($_REQUEST['imprime']) == false) { 
               $txt = ler_vistoria();                
          }
     }

?>

<body>
     <h1 class="cab-0">Efetiva Vistoria do Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="tel-1 qua-3 container">
                    <div class="row lit-3">
                         <div class="col-md-11">
                              <span>Informação de Vistoria Efetuada</span>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="inf-vistoria.php" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="imp" name="imprime"
                                             title="Efetua impressão de dados da vistoria efetuada pelo técnico no sistema"><i
                                                  class="fa fa-print fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>
                    <br />
                    <div class="row text-center">
                         <div class="lit-6 col-md-12">
                              <?php echo $txt; ?>
                         </div>
                    </div>
                    <br />
                    <hr />
                    <form name="frmTelNov" action="inf-vistoria.php" method="POST" enctype="multipart/form-data">
                         <div class="row">
                              <div class="col-md-6">
                                   <label>Não Conformidade</label>
                                   <select id="con" name="con" class="form-control" required>
                                        <?php $ret = carrega_con($con); ?>
                                   </select>
                              </div>
                              <div class="col-md-6">
                                   <label>Ação Corretiva</label>
                                   <select id="aca" name="aca" class="form-control">
                                        <?php $ret = carrega_aca($aca); ?>
                                   </select>
                              </div>
                         </div>
                         <div class="row">
                              <div class="col-md-4"></div>
                              <div class="col-md-4">
                                   <label>Prioridade</label>
                                   <select id="pri" name="pri" class="form-control">
                                        <option value="0" <?php echo ($pri != 0 ? '' : 'selected="selected"'); ?>>
                                             Imediatamente</option>
                                        <option value="1" <?php echo ($pri != 1 ? '' : 'selected="selected"'); ?>>
                                             24 horas</option>
                                        <option value="2" <?php echo ($pri != 2 ? '' : 'selected="selected"'); ?>>
                                             07 dias</option>
                                             <option value="3" <?php echo ($pri != 2 ? '' : 'selected="selected"'); ?>>
                                             15 dias</option>
                                   </select>
                              </div>
                              <div class="col-md-4"></div>
                         </div>
                         <div class="row">
                              <div class="col-md-1"></div>
                              <div class="col-md-10">
                                   <label>Observação</label>
                                   <textarea class="form-control" rows="5" id="obs"
                                        name="obs"><?php echo $obs ?></textarea>
                              </div>
                              <div class="col-md-1 text-center">
                                   <br /><br /><br />
                                   <button type="button" class="bot-3" id="fot_carrega" name="fot"
                                        title="Upload de fotos da vistoria efetuada para o sistema de Gestão de Mall"><i
                                             class="fa fa-camera fa-3x" aria-hidden="true"></i><span></span> </button>
                              </div>
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
                                        echo '<a class="tit-2" href="' . $_SESSION['wrkproant'] . '.php" title="Volta a página anterior deste processamento.">Voltar</a>' ?>
                              </div>
                         </div>
                         <input name="arq-fot[]" type="file" id="fot_janela" class="bot-h" accept="image/*" multiple="multiple" />
                    </form>
                    <hr /><br />
                    <?php echo lista_oco(); ?>
               </div>
          </div>
     </div>

</body>
<?php
 function ler_vistoria() {
     $txt = ''; 
     include "lerinformacao.inc";
     $com = "Select V.*, T.tecnome, L.lojnome, X.tipdescricao  from (((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) left join tb_tipovis X on V.vistipo = X.idtipo) where idvistoria = " . $_SESSION['wrkcodreg'];
     $sql = mysqli_query($conexao,$com);
     if (mysqli_num_rows($sql) == 0) {
          echo '<script>alert("Número da vistoria informada não cadastrada");</script>';
          $nro = 1;
     }else{
          $lin = mysqli_fetch_array($sql);
          $txt .= '<span>' . 'Número da Vistoria: ' . $lin['idvistoria'] . '</span>' . '<br />';
          $txt .= '<span>' . 'Nome da Loja: ' . $lin['lojnome']  . '</span>' . '<br />';
          $txt .= '<span>' . 'Nome do Vistoriador: ' . $lin['tecnome']  . '</span>' . '<br />';
          $txt .= '<span>' . 'Tipo de Vistoria: ' . $lin['tipdescricao']  . '</span>' . '<br />';
          if ($lin['visdataage'] != null) {
               $txt .= '<span>' . 'Data do Agendamento: ' . date('d/m/Y H:i', strtotime($lin['visdataage']))  . '</span>' . '<br />';
          }
          if ($lin['visdataefe'] != null) {
               $txt .= '<span>' . 'Data da Vistoria: ' . date('d/m/Y H:i', strtotime($lin['visdataefe']))  . '</span>' . '<br />';
          }
          $txt .= '<span>' . 'Observação: ' . $lin['visobservacao']  . '</span>' . '<br />';          
     }
     return $txt;
}

function carrega_con($con) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_conformidade where constatus = 0 order by condescricao";
     $sql = mysqli_query($conexao, $com);
     if ($con == 0) {
          echo '<option value="0" selected="selected">Selecione a não conformidade desejada ...</option>';
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

function carrega_aca($aca) {
     $sta = 0;
     include "lerinformacao.inc";    
    $com = "Select * from tb_acoes where acostatus = 0 order by acodescricao";
     $sql = mysqli_query($conexao, $com);
     if ($aca == 0) {
          echo '<option value="0" selected="selected">Selecione a ação corretiva desejada ...</option>';
     }
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($reg['idacoes'] != $aca) {
               echo  '<option value ="' . $reg['idacoes'] . '">' . $reg['acodescricao'] . '</option>'; 
          }else{
               echo  '<option value ="' . $reg['idacoes'] . '" selected="selected">' . $reg['acodescricao'] . '</option>';
          }
     }
     return $sta;
}

function upload_fot(&$cam, &$res, &$tam, &$ext) {
     $sta = 0; 
     include "lerinformacao.inc";
     $arq = isset($_FILES['arq-fot']) ? $_FILES['arq-fot'] : false;
     if ($arq == false) {
          return 2;
     }else if ($arq['name'][0] == "") {
          if ($_SESSION['wrkopereg'] == 1) {
               if ($arq['name'][0] != "") {
                    return 3;
               }
          }else{
               return 0;
          }
     }            
     $num = count($arq['name']);
     $erro[0] = 'Não houve erro encontrado no Upload do arquivo';
     $erro[1] = 'O arquivo informado no upload é maior do que o limite da plataforma';
     $erro[2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
     $erro[3] = 'O upload do arquivo foi feito parcialmente, tente novamente';
     $erro[4] = 'Não foi feito o upload do arquivo corretamente !';
     $erro[5] = 'Não foi feito o upload do arquivo corretamente !!';
     $erro[6] = 'Pasta temporária ausente para Upload do arquuivo informado';
     $erro[7] = 'Falha em escrever o arquivo para upload informado em disco';
     for ($ind = 0;$ind < $num; $ind++) {
          if ($arq['error'][$ind] != 0) {
               if ($_SESSION['wrkopereg'] == 1) {
                    if ($arq['name'][$ind] != "") {
                         echo "<script>alert(" . $erro[$arq['error'][$ind]] . "')</script>";
                    }
                    $sta = 4; 
               }else{
                    return 0;
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
                    echo "<script>alert('Extensão do arquivo informado para Upload não é permitida')</script>";
                    $sta = 5; 
               }
          }
          if ($sta == 0) {
               $tip = explode('.', $des);
               $des = $tip[0] . "." . $ext;
               $nro = ultima_cha();
               $nom = "vis_" . str_pad($_SESSION['wrkcodreg'], 6, "0", STR_PAD_LEFT)  . "_" . str_pad($_SESSION['wrknumreg'], 3, "0", STR_PAD_LEFT) . "_" . str_pad($nro, 3, "0", STR_PAD_LEFT) . "." .  $ext;
               $pas = "upload"; 
               if (file_exists($pas) == false) { mkdir($pas); }
               $cam = $pas . "/" . $nom;
               $ret = move_uploaded_file($arq['tmp_name'][$ind], $cam);
               if ($ret == false) {
                    echo "<script>alert('Erro na cópia da foto (" . $ind . ") informado para upload')</script>";
                    $sta = 6; 
               }      
          } 
     }   
     return $sta;
}

function ultima_cha() {
     $nro = 1;
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

function lista_oco() {
     $lis = '';
     include "lerinformacao.inc";
     $com = "Select V.*, A.acodescricao, C.condescricao  from ((tb_vistoria_l V left join tb_acoes A on V.lisacao = A.idacoes) left join tb_conformidade C on V.lisconformidade = C.idconformidade) where lisvistoria = " . $_SESSION['wrkcodreg'] . " order by lisvistoria, idlista";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          if ($lis == '') {
               $lis .= '
               <div class="tab-1 table-responsive">
               <table class="table table-sm table-striped">
                    <thead>
                         <tr>
                              <th scope="col">Vistoria</th>
                              <th scope="col">Número</th>
                              <th scope="col">Não Conformidade</th>
                              <th scope="col">Ação Corretiva</th>
                              <th scope="col">Data da Vistoria</th>
                              <th scope="col">Prioridade</th>
                              <th scope="col">Fotos</th>
                              <th scope="col">Observação</th>
                         </tr>
                    </thead>
                    <tbody>';
          }
          $lis .=  '<tr>';
          $lis .= '<td class="text-center">' . $reg['lisvistoria'] . '</td>';
          $lis .= '<td class="text-center">' . $reg['idlista'] . '</td>';
          $lis .= '<td class="text-left">' . $reg['condescricao'] . '</td>';
          $lis .= '<td class="text-left">' . $reg['acodescricao'] . '</td>';
          $lis .= '<td class="text-center">' . date('d/m/Y H:i', strtotime($reg['datinc'])) . '</td>';
          $lis .= '<td class="text-center">' . $reg['lisprioridade'] . '</td>';
          $qtd = fotos_qtd($reg['lisvistoria'], $reg['idlista']);
          if ($qtd == 0) {
               $lis .= '<td class="text-center">' . '***' . "</td>";
          } else {
               $lis .= '<td class="text-center">' . str_pad($qtd, 3, "0", STR_PAD_LEFT) . "</td>";
          }
          $lis .= '<td class="text-left">' . $reg['lisobservacao'] . '</td>';
     }
     if ($lis != "") {
          $lis .= '
          </tbody>
          </table>
          </div>';
     }
     return $lis;
}

function fotos_qtd($vis, $lis) {
     $qtd = 0;
     $cha = str_pad($vis, 6, "0", STR_PAD_LEFT) . '_' . str_pad($lis, 3, "0", STR_PAD_LEFT);
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