<?php
     $qtd = 0;
     $cod = 0;
     $nro = 0;
     $txt = '';
     $ima = '';
     $tab = array();
     session_start();
     include "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     $com = "Select V.*, T.tecnome, L.lojnome, X.tipdescricao  from (((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) left join tb_tipovis X on V.vistipo = X.idtipo) where idvistoria = " . $cod;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {
          $txt .= '<span>' . 'Número da Vistoria: ' . $reg['idvistoria'] . '</span>' . '<br />';
          $txt .= '<span>' . 'Nome da Loja: ' . $reg['lojnome']  . '</span>' . '<br />';
          $txt .= '<span>' . 'Nome do Vistoriador: ' . $reg['tecnome']  . '</span>' . '<br />';
          $txt .= '<span>' . 'Tipo de Vistoria: ' . $reg['tipdescricao']  . '</span>' . '<br />';
          if ($reg['visdataage'] != null) {
               $txt .= '<span>' . 'Data do Agendamento: ' . date('d/m/Y H:i', strtotime($reg['visdataage']))  . '</span>' . '<br />';
          }
          if ($reg['visdataefe'] != null) {
               $txt .= '<span>' . 'Data da Vistoria: ' . date('d/m/Y H:i', strtotime($reg['visdataefe']))  . '</span>' . '<br />';
          }
          $txt .= '<span>' . 'Observação: ' . $reg['visobservacao']  . '</span>' . '<br />';          
     }
     $tab['txt'] = $txt;

     $cha = str_pad($cod, 6, "0", STR_PAD_LEFT);
     foreach (new DirectoryIterator('upload/') as $dad) {
          if ($dad->isDir() == false) {
               $cam = $dad->getPathname();
               if (strpos($cam, $cha) > 0 ) {
                    $qtd = $qtd + 1;
               }
          }
     }

     $ima .= '
     <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
     <ol class="carousel-indicators">';
     for ($ind = 0; $ind < $qtd; $ind++) {
          if ($ind == 0) {
               $ima .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $ind . '" class="active"></li>';
          } else {
               $ima .= '<li data-target="#carouselExampleIndicators" data-slide-to="' . $ind . '"></li>';
          }
     }
     $ima .= '</ol>
     <div class="carousel-inner">';
     $nro = 0;
     $cha = str_pad($cod, 6, "0", STR_PAD_LEFT);
     foreach (new DirectoryIterator('upload/') as $dad) {
          if ($dad->isDir() == false) {
               $cam = $dad->getPathname();
               if (strpos($cam, $cha) > 0 ) {
                    if ($nro == 0) {
                         $ima .= '
                         <div class="carousel-item active">
                         <img class="d-block w-100" src="' . $cam . '?auto=yes&bg=777&fg=555" >
                         </div>';
                    } else {
                         $ima .= '
                         <div class="carousel-item">
                              <img class="d-block w-100" src="' . $cam . '?auto=yes&bg=666&fg=444" >
                         </div>';
                    }
                    $nro = $nro + 1;
               }
          }
     }
     $ima .= '
     </div>
     <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
     <span class="carousel-control-prev-icon" aria-hidden="true"></span>
     <span class="sr-only">Anterior</span>
     </a>
     <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
     <span class="carousel-control-next-icon" aria-hidden="true"></span>
     <span class="sr-only">Próximo</span>
     </a>
     </div>';

     $tab['ima'] = $ima;
     echo json_encode($tab);     

?>