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
     <title>Gestão em Mall - Vistoria em Lojas - Menu</title>
</head>

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
               $ret = gravar_log(1,"Entrada na página de consulta de ações corretivas do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrkopereg']) == false) { $_SESSION['wrkopereg'] = 0; }
     if (isset($_SESSION['wrkcodreg']) == false) { $_SESSION['wrkcodreg'] = 0; }
     if (isset($_REQUEST['ope']) == true) { $_SESSION['wrkopereg'] = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $_SESSION['wrkcodreg'] = $_REQUEST['cod']; }
     $cod = (isset($_REQUEST['cod']) == false ? 00 : $_REQUEST['cod']);
     $sta = (isset($_REQUEST['sta']) == false ? 00 : $_REQUEST['sta']);
     $des = (isset($_REQUEST['des']) == false ? '' : str_replace("'", "´", $_REQUEST['des']));
     if ($_SESSION['wrkopereg'] == 1) { 
           $cod = ultimo_cod();
     }
     if ($_SESSION['wrkopereg'] >= 2) {
          if (isset($_REQUEST['salvar']) == false) { 
               $cha = $_SESSION['wrkcodreg']; 
               $ret = ler_acoes($cha, $des, $sta); 
          }
      }
     if ($_SESSION['wrkopereg'] == 3) { 
          $bot = 'Deletar'; 
          $per = ' onclick="return confirm(\'Confirma exclusão de ação corretiva informado em tela ?\')" ';
     }

 if (isset($_REQUEST['salvar']) == true) {
      if ($_SESSION['wrkopereg'] == 1) {
           $sta = consiste_aco();
           if ($sta == 0) {
                $ret = incluir_aco();
                $cod = ultimo_cod();
                $ret = gravar_log(1, 10,"Inclusão de novo ação corretiva: " . $des); 
                $des = ''; $sta = 00;  $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = $cod;
           }
      }
      if ($_SESSION['wrkopereg'] == 2) {
           $sta = consiste_aco();
           if ($sta == 0) {
                $ret = alterar_aco();
                $cod = ultimo_cod(); 
                $ret = gravar_log(1, 20,"Alteração de ação corretiva cadastrado: " . $des); 
                $des = ''; $sta = 00;  $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = $cod;
           }
      }
      if ($_SESSION['wrkopereg'] == 3) {
           $ret = excluir_aco(); $bot = 'Salvar'; $per = '';
           $cod = ultimo_cod(); 
           $ret = gravar_log(1, 30,"Exclusão de ação corretiva cadastrado: " . $des); 
           $des = ''; $sta = 00;  $_SESSION['wrkopereg'] = 1; $_SESSION['wrkcodreg'] = $cod;
      }
} 
?>

<body>
     <h1 class="cab-0">Ação Corretiva - Gestão em Mall - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10">
               <div class="qua-3 container-fluid">
                    <div class="form-row lit-3">
                         <div class="col-md-11">
                              <span>Manutenção de Ações Corretivas</span>
                         </div>
                         <div class="col-md-1">
                              <form name="frmTelNov" action="man-acoes.php?ope=1&cod=0" method="POST">
                                   <div class="text-center">
                                        <button type="submit" class="bot-3" id="nov" name="novo"
                                             title="Mostra campos para criar novo ação corretiva no sistema"><i
                                                  class="fa fa-plus-circle fa-1g" aria-hidden="true"></i></button>
                                   </div>
                              </form>
                         </div>
                    </div>

                    <div class="form-row">
                         <div class="container-fluid">
                              <div class="col-md-12 text-center">
                                   <form class="tel-1" name="frmTelMan" action="" method="POST">
                                        <div class="form-row">
                                             <div class="col-md-2">
                                                  <label>Código</label>
                                                  <input type="text" class="form-control text-center" maxlength="6"
                                                       id="cod" name="cod" value="<?php echo $cod; ?>" disabled />
                                             </div>
                                             <div class="col-md-7">
                                                  <label>Descrição da Ação Corretiva</label>
                                                  <input type="text" class="form-control" maxlength="99" id="des"
                                                       name="des" value="<?php echo $des; ?>" required />
                                             </div>
                                             <div class="col-md-3">
                                                  <label>Status</label><br />
                                                  <select name="sta" class="form-control">
                                                       <option value="0"
                                                            <?php echo ($sta != 0 ? '' : 'selected="selected"'); ?>>
                                                            Normal
                                                       </option>
                                                       <option value="1"
                                                            <?php echo ($sta != 1 ? '' : 'selected="selected"'); ?>>
                                                            Bloqueado
                                                       </option>
                                                       <option value="2"
                                                            <?php echo ($sta != 2 ? '' : 'selected="selected"'); ?>>
                                                            Suspenso
                                                       </option>
                                                       <option value="3"
                                                            <?php echo ($sta != 3 ? '' : 'selected="selected"'); ?>>
                                                            Cancelado
                                                       </option>
                                                  </select>
                                             </div>
                                        </div>
                                        <br />
                                        <div class="form-row text-center">
                                             <div class="col-md-6"></div>
                                             <div class="col-md-6 text-right">
                                                  <button type="submit" name="salvar" <?php echo $per; ?>
                                                       class="bot-2"><?php echo $bot; ?></button>
                                             </div>
                                        </div>
                                        <br />
                                   </form>
                              </div>
                         </div>
                         <div class="container-fluid">
                              <div class="col-md-12 text-center">
                                   <br />
                                   <div class="tab-1 table-responsive">
                                        <table class="table table-sm table-striped">
                                             <thead>
                                                  <tr>
                                                       <th scope="col">Alterar</th>
                                                       <th scope="col">Excluir</th>
                                                       <th scope="col">Código</th>
                                                       <th scope="col">Descrição da Ação Corretiva</th>
                                                       <th scope="col">Status</th>
                                                       <th scope="col">Inclusão</th>
                                                       <th scope="col">Alteração</th>
                                                  </tr>
                                             </thead>
                                             <tbody>
                                                  <?php $ret = carrega_aco();  ?>
                                             </tbody>
                                        </table>
                                   </div>
                              </div>
                         </div>
                    </div>
               </div>
          </div>
     </div>

</body>
<?php

if ($_SESSION['wrkopereg'] == 1 && $_SESSION['wrkcodreg'] == $cod) {
     exit('<script>location.href = "man-acoes.php?ope=1&cod=0"</script>');
}

function ultimo_cod() {
     $cod = 1;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select idacoes, acodescricao from tb_acoes order by idacoes desc Limit 1");
     if (mysqli_num_rows($sql) == 1) {
         $lin = mysqli_fetch_array($sql);
         $cod = $lin['idacoes'] + 1;
     }
     return $cod;
}

function consiste_aco() {
     $sta = 0;
     if (trim($_REQUEST['des']) == "") {
         echo '<script>alert("Descrição do ação não pode estar em branco");</script>';
         return 1;
     }
     return $sta;
 }

function carrega_aco() {
     $nro = 0;
     include "lerinformacao.inc";
     $com = "Select * from tb_acoes where idacoes > 0 order by acodescricao, idacoes";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
         $lin =  '<tr>';
         $lin .= '<td class="bot-3 text-center"><a href="man-acoes.php?ope=2&cod=' . $reg['idacoes'] . '" title="Efetua alteração do registro informado na linha"><i class="bot-1a large material-icons">healing</i></a></td>';
         $lin .= '<td class="bot-3 text-center"><a href="man-acoes.php?ope=3&cod=' . $reg['idacoes'] . '" title="Efetua exclusão do registro informado na linha"><i class="bot-1e large material-icons">delete_forever</i></a></td>';
         $lin .= '<td class="text-center">' . $reg['idacoes'] . '</td>';
         $lin .= '<td class="text-left">' . $reg['acodescricao'] . "</td>";
         if ($reg['acostatus'] == 0) {$lin .= "<td>" . "Normal" . "</td>";}
         if ($reg['acostatus'] == 1) {$lin .= "<td>" . "Bloqueado" . "</td>";}
         if ($reg['acostatus'] == 2) {$lin .= "<td>" . "Suspenso" . "</td>";}
         if ($reg['acostatus'] == 3) {$lin .= "<td>" . "Cancelado" . "</td>";}
         if ($reg['datinc'] == null) {
               $lin .= "<td>" . '' . "</td>";
          }else{
               $lin .= "<td>" . date('d/m/Y H:m:s',strtotime($reg['datinc'])) . "</td>";
          }
          if ($reg['datalt'] == null) {
               $lin .= "<td>" . '' . "</td>";
          }else{
               $lin .= "<td>" . date('d/m/Y H:m:s',strtotime($reg['datalt'])) . "</td>";
          }
          $lin .= "</tr>";
         echo $lin;
     }
}

function incluir_aco() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "insert into tb_acoes (";
     $sql .= "acostatus, ";
     $sql .= "acotipo, ";
     $sql .= "acodescricao, ";
     $sql .= "keyinc, ";
     $sql .= "datinc ";
     $sql .= ") value ( ";
     $sql .= "'" . $_REQUEST['sta'] . "',";
     $sql .= "'" . '1' . "',";
     $sql .= "'" . str_replace("'", "´", $_REQUEST['des']) . "',";
     $sql .= "'" . $_SESSION['wrkideusu'] . "',";
     $sql .= "'" . date("Y/m/d H:i:s") . "')";
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
}

function ler_acoes(&$cha, &$des, &$sta) {
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_acoes where idacoes = " . $cha);
     if (mysqli_num_rows($sql) == 0) {
         echo '<script>alert("Código do ação informado não cadastrada no sistema");</script>';
     }else{
         $lin = mysqli_fetch_array($sql);
         $cha = $lin['idacoes'];
         $des = $lin['acodescricao'];
         $sta = $lin['acostatus'];
     }
     return $cha;
 }

 function alterar_aco() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "update tb_acoes set ";
     $sql .= "acostatus = '". $_REQUEST['sta'] . "', ";
     $sql .= "acodescricao = '". $_REQUEST['des'] . "', ";
     $sql .= "keyalt = '" . $_SESSION['wrkideusu'] . "', ";
     $sql .= "datalt = '" . date("Y/m/d H:i:s") . "' ";
     $sql .= "where idacoes = " . $_SESSION['wrkcodreg'];
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na regravação do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 } 

 function excluir_aco() {
     $ret = 0;
     include "lerinformacao.inc";
     $sql  = "delete from tb_acoes where idacoes = " . $_SESSION['wrkcodreg'] ;
     $ret = mysqli_query($conexao,$sql);
     if ($ret == false) {
         print_r($sql);
         echo '<script>alert("Erro na exclusão do registro solicitado !");</script>';
     }
     $ret = desconecta_bco();
     return $ret;
 }

?>

</html>