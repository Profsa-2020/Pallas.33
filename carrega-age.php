<?php
     $sta = 0;
     $dti = '';
     $dtf = '';
     $tit = '';
     $tab = array();
     session_start();
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['dti']) == true) { $dti = $_REQUEST['dti']; }
     if (isset($_REQUEST['dtf']) == true) { $dtf = $_REQUEST['dtf']; }
     $com  = "Select V.*,T.tecnome, L.lojnome, L.lojapelido from ((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) where V.idvistoria > 0 ";
     if ($dti != "" && $dtf != "") {
          $com .= " and visdataage between '" . $dti . "' and '" . $dtf . "' ";
     }
     $com .= " order by visloja, visdataage, idvistoria";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {
          $tit = primeiro_nom($reg['lojapelido'])  . "-" . primeiro_nom($reg['tecnome']);
          $cor_r = rand(0,254);
          $cor_g = rand(0,254);
          $cor_b = rand(0,254);
          $cor = 'rgb(' . $cor_r . ',' . $cor_g . ',' . $cor_b . ')';
          if ($reg['visdataage'] != null) {
               $tab[]  = [
                    'id' => $reg['idvistoria'],
                    'title' => $tit,
                    'start' => date('Y-m-d H:i',strtotime($reg['visdataage'])) ,
                    'end' => date('Y-m-d H:i',strtotime($reg['visdataage'])) ,
                    'color' => $cor
               ];     
          }
     }
     echo json_encode($tab);     

?>