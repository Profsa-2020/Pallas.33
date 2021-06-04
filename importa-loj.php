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
     $lid = 00;
     $gra = 00;
     include_once "funcoes.php";
     $_SESSION['wrknompro'] = __FILE__;

     $_SESSION['wrkdatide'] = date ("d/m/Y H:i:s", getlastmod());
     $_SESSION['wrknomide'] = get_current_user();
     if (isset($_SERVER['HTTP_REFERER']) == true) {
          if (limpa_pro($_SESSION['wrknompro']) != limpa_pro($_SERVER['HTTP_REFERER'])) {
               $_SESSION['wrkproant'] = limpa_pro($_SERVER['HTTP_REFERER']);
               $ret = gravar_log(1,"Entrada na página de menu principal do sistema Pallas.33 - Gestão em Mall");  
          }
     }
     date_default_timezone_set("America/Sao_Paulo");
     if (isset($_SESSION['wrknomemp']) == false) { $_SESSION['wrknomemp'] = ''; } 
     if (isset($_SESSION['wrkideusu']) == false) { $_SESSION['wrkideusu'] = 0; }
     if (isset($_REQUEST['gravar']) == true) {
          $ret = carregar_loj($lid, $gra);
  }

?>

<body>
     <h1 class="cab-0">Login Inicial Sistema Gestão em Mall - Vistoria em Lojas - Profsa Informática</h1>
     <?php include_once "cabecalho-1.php"; ?>
     <div class="row">
          <div class="qua-4 col-md-2">
               <?php include_once "cabecalho-2.php"; ?>
          </div>
          <div class="col-md-10 text-center">
               <span class="lit-4">Importação Excel - Lojas</span>
               <br /><br /><br />
               <form name="frmImpLoj" action="" method="POST" enctype="multipart/form-data">
                    <div class="row text-center">
                         <br /><br /><br />
                         <div class="col-md-12 text-center">
                              <h2>
                                   <?php 
                                        echo 'Lidos: ' . $lid . ' - Gravados: ' . $gra; 
                                   ?>
                              </h2>
                              <br /><br /><br />
                              <button type="submit" id="car" name="carrega" class="bot-2">Carregar</button>
                              <button type="submit" id="gra" name="gravar" class="bot-2">Gravar</button>
                         </div>
                    </div>
               </form>
          </div>
     </div>
</body>
<?php
function carregar_loj(&$lid, &$gra) {
     $ret = 0;
     $lid = 0;
     $gra = 0;
     include "lerinformacao.inc";
     $dir = "Lojas 2019-08-08.csv"; 
     if (file_exists($dir) == false) {
          echo '<script>alert("Arquivo com dados de lojas para importação não encontrado");</script>';
          return 1;        
     }
     $pos = fopen($dir, "r");
     while (!feof ($pos)) {
          $lid = $lid + 1;
          $reg = explode(";", fgets($pos));
          $qtd = count($reg);
          if ($qtd == 12) {
               $emp = $reg[3];
               $cgc = limpa_nro($reg[5]);
               if ($emp == "BS" && $cgc != "" && $cgc != "0") {
                    $exi = ler_loja($cgc);
                    if ($exi == 0) {
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
                         $sql .= "'" . limpa_nro($cgc) . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '' . "',";
                         $sql .= "'" . utf8_encode(str_replace("'", "´", $reg[4])) . "',";
                         $sql .= "'" . utf8_encode(str_replace("'", "´", $reg[2])) . "',";
                         $sql .= "'" . '000' . "',";
                         $sql .= "'" . 'Térreo' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . substr($reg[8], 0, 75) . "',";
                         $sql .= "'" . substr($reg[11], 0, 75) . "',";
                         $sql .= "'" . substr($reg[7], 0,  15) . "',";
                         $sql .= "'" . substr($reg[7], 14, 15)  . "',";
                         $sql .= "'" . '' . "',";
                         $sql .= "'" . substr(utf8_encode($reg[9]), 0, 50) . "',";
                         $sql .= "'" . substr(utf8_encode($reg[6]), 0, 50) . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . '0' . "',";
                         $sql .= "'" . utf8_encode('Segmento: ' . $reg[0] . ' Atividade: ' . $reg[1] . ' E-mail: ' . $reg[8] . ' Fones: ' . $reg[7]) . "',";
                         $sql .= "'" . $_SESSION['wrkideusu'] . "',";
                         $sql .= "'" . date("Y/m/d H:i:s") . "')";
                         $ret = mysqli_query($conexao,$sql);
                         $_SESSION['wrkcodreg'] = mysqli_insert_id($conexao); // Auto Increment Id
                         if ($ret == false) {
                              print_r($sql);
                              echo '<script>alert("Erro na gravação do registro solicitado !");</script>';
                         }                    
                         $gra = $gra + 1;
                    }
               }
          }
     }
     fclose ($pos);
     return $ret;
}

function ler_loja($cgc) {
     $exi = 0;
     include "lerinformacao.inc";
     $str = "Select idloja from tb_loja where  lojcnpj = '" . $cgc . "'";
     $reg = mysqli_query($conexao, $str) or die(mysqli_error($conexao));
     $vet = mysqli_fetch_array($reg);
     if (count($vet) > 0) {
          $exi = $vet['idloja'];
     }
     return $exi;
 }

?>

</html>