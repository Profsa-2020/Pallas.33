<?php
     $ope = 0;
     $cod = 0;
     $car = 0;
     $txt = '';
     $ema = '';
     $nom = '';
     $vis = '';
     $lis = '';
     $tab = array();
     session_start();
     error_reporting(E_ERROR | E_PARSE);
     include("mpdf.php");
     include_once "lerinformacao.inc";
     include_once "funcoes.php";
     if (isset($_REQUEST['ope']) == true) { $ope = $_REQUEST['ope']; }
     if (isset($_REQUEST['cod']) == true) { $cod = $_REQUEST['cod']; }
     if (isset($_REQUEST['car']) == true) { $car = $_REQUEST['car']; }

     $_SESSION['wrkopereg'] = $ope; $_SESSION['wrkcodreg'] = $cod;
     $nom = retorna_dad('empcontato','tb_empresa','idempresa','1'); 

     $com  = "Select V.*,T.tecnome, T.tecfuncao, T.tecemail, L.lojnome, L.lojnumero, L.lojpiso, L.lojtelefone, L.lojcelular, L.lojcontato1, L.lojcontato2, L.lojcontato3, L.lojemail from ((tb_vistoria V left join tb_tecnico T on V.vistecnico = T.idtecnico) left join tb_loja L on V.visloja = L.idloja) where V.idvistoria = " . $cod;
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $vis = $reg['tecnome'];
          $end = $reg['tecemail'];
          $ema = $reg['lojemail'];
          $nom = $reg['lojcontato2'];
          if ($ope == 7) {
               $txt = modelo_pad($nom, $reg);
          }
          if ($ope == 8) {
               $txt = modelo_cus($nom, $reg, $car);
          }
     }
     $tab['txt'] = $txt;

     if ($txt != "" && $ema != ""){
          $asu = "Relatório de Vistoria efetuada - Nº " . $cod;
          $ema = $ema . ';' . retorna_dad('empemail','tb_empresa','idempresa','1'); 
          $men = str_replace(__DIR__, "http://www.inatoshopp.com", $txt); 
          $men = str_replace('\\', '/', $men); 
          $ret = manda_email($ema, $end, $asu, $men, $nom, $vis, '', '');
     }

     $mpdf = new mPDF('s');

     $css = file_get_contents('css/pallas33p.css');
     $mpdf->WriteHTML($css, 1);

     $mpdf->WriteHTML($txt, 2);

     if ($ope == 7) {
          $cam = "doctos" . "/" . 'Pad_' . str_pad($cod, 8, "0", STR_PAD_LEFT) .  "." . "pdf";
     }else{
          $cam = "doctos" . "/" . 'Cus_' . str_pad($cod, 8, "0", STR_PAD_LEFT) .  "." . "pdf";
     }
     if (file_exists("doctos") == false) { mkdir("doctos");  }

     $mpdf->Output($cam,'F');  // I-Browser (Default), D-Browser e janela para salvar, F-Salva com nome dado, S-returna o documento como string

     if (file_exists($cam) == false) { 
          $tab['cam'] = '';
     } else {
          $tab['cam'] = $cam;
     }
     echo json_encode($tab);     

function lista_con($cod, &$pri) {
     $pri = 0;
     $lis = '<table class="lin-2"><thead>
     <tr>
          <th>Data</th>
          <th>Descrição da não Conformidade</th>
          <th>Ação Corretiva</th>
          <th class="text-center">Prioridade</th>
          <th>Observação da Vistoria</th>
     </tr>
</thead>';
     $lis .= '<tbody>';
     include "lerinformacao.inc";
     $com = "Select V.*, A.acodescricao, C.condescricao  from ((tb_vistoria_l V left join tb_acoes A on V.lisacao = A.idacoes) left join tb_conformidade C on V.lisconformidade = C.idconformidade) where lisvistoria = " . $cod . " order by lisvistoria, idlista";
     $sql = mysqli_query($conexao, $com);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $lis .=  '<tr>';          
          $lis .= '<td class="text-left">' . date('d/m/Y', strtotime($reg['datinc'])) . '</td>';
          $lis .= '<td class="text-left">' . limpa_cpo($reg['condescricao']) . '</td>';  // utf8_encode - utf8_decode
          $lis .= '<td class="text-left">' . limpa_cpo($reg['acodescricao']) . '</td>';  
          if($reg['lisprioridade'] == 0) { $lis .= '<td class="text-center">' . 'Imediatamente' . '</td>'; }
          if($reg['lisprioridade'] == 1) { $lis .= '<td class="text-center">' . '24 horas' . '</td>'; }
          if($reg['lisprioridade'] == 2) { $lis .= '<td class="text-center">' . '07 dias' . '</td>'; }
          if($reg['lisprioridade'] == 3) { $lis .= '<td class="text-center">' . '15 dias' . '</td>'; }
          if($reg['lisprioridade'] >= 4) { $lis .= '<td class="text-center">' . 'Assim que Possível' . '</td>'; }
          $lis .=  '</tr>';
          if ($reg['lisprioridade'] > $pri) { $pri = $reg['lisprioridade']; }
          $lis .= '<td class="text-left">' . limpa_cpo($reg['lisobservacao']) . '</td>';  // utf8_encode - utf8_decode
     }
     $lis .= '</tbody></table>';
     return $lis;
}

function conforme_qtd($cod) {
     $qtd = 0;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao, "Select idlista from tb_vistoria_l where lisvistoria = " . $cod);
     while ($reg = mysqli_fetch_assoc($sql)) {        
          $qtd = $qtd + 1;
     }
     return $qtd;
}

function modelo_pad ($nom, $reg) {
     $sta = dados_sho($sho);
     $qtd = conforme_qtd($reg['idvistoria']); 

     if ($reg['tecnome'] != "") { $nom = $reg['tecnome']; }
     $txt  = '<table class="lit-3">';
     $txt .= '<tbody>';
     $txt .=  '<tr width="100%">';          
     $txt .=  '<td><h2>' . 'AVISO AO LOJISTA ' . '</h2></td>';

     $cam =  __DIR__ . '/' . 'upload/log_' . str_pad($_SESSION['wrkcodemp'], 6, "0", STR_PAD_LEFT) . '.jpg';
     if (file_exists($cam) == true) {
          $txt .=  '<td>';
          $txt .= '<img src="' . __DIR__ . '/' . 'upload/log_' . str_pad($_SESSION['wrkcodemp'], 6, "0", STR_PAD_LEFT) . '.jpg' . '" width="100px" align="right">';
          $txt .=  '</td>';     
     } else {
          $txt .=  '<td></td>';
     }

     $txt .=  '</tr>';
     $txt .=  '<br /><br />';
     $txt .=  '<tr>';          
     $txt .=  '<td colspan="2"><strong>' . 'Loja: ' . $reg['lojnome'] . '</strong></td>';
     $txt .=  '<td></td>';
     $txt .=  '</tr>';

     $txt .=  '<tr>';          
     $txt .=  '<td>' . 'Número: ' . $reg['lojnumero'] . '</td>';
     $txt .=  '<td>' . 'Piso: ' . $reg['lojpiso'] . '</td>';
     $txt .=  '</tr>';
     $txt .=  '<tr>';          
     $txt .=  '<td>' . 'Gerente: ' . $reg['lojcontato2'] . '</td>';
     $txt .=  '<td>' . 'Contato: ' . $reg['lojcontato1'] . '</td>';
     $txt .=  '</tr>';
     $txt .=  '<tr>';          
     $txt .=  '<td>' . 'Telefone: ' . $reg['lojtelefone'] . '</td>';
     $txt .=  '<td>' . 'Celular: ' . $reg['lojcelular'] . '</td>';
     $txt .=  '</tr>';
     $txt .= '</tbody>';
     $txt .= '</table>';
     $txt .=  '<br /><br />';
     $txt .=  '<span>' . 'Prezados Senhores,' . '</span><br /><br />';
     if ($qtd == 0) {
          $txt .=  '<span>' . 'Parabéns ! Comunicamos que, no dia AAAAA foi feita a vistoria em sua loja e verificado não haver nenhuma não conformidades conforme nossos vistoriadores. ' . '</span><br /><br /><br />';
          $txt .=  '<span>' . 'Em aproximadamente 30 (trinta) dias estaremos retornando para efetuar novas vistorias e esperamos que não haja não conformidades ou irregularidades e sua loja esteja 100% em conformidade.' . '</span><br /><br /><br />';
     } else {
          $txt .=  '<span>' . 'Comunicamos que, no dia AAAAA foi feita a vistoria em sua loja e verificado a existência de não conformidades conforme lista abaixo: ' . '</span><br />';
          $lis  = lista_con($reg['idvistoria'], $pri); 
          $txt .= $lis;
          $txt .=  '<br /><br />';
          $txt .=  '<span>' . 'Lembramos que a correção deverá ser feita até BBBBB, data que expira o prazo máximo.' . '</span><br /><br />';
          $txt .=  '<span>' . 'Salientamos a importância em se resolver essas irregularidades no prazo máximo já descrito, afim de que sua loja se encontre dentro das condições previstas na Escritura Declaratória de Normas Gerais.' . '</span><br /><br />';
          $txt .=  '<span>' . 'Caso a loja não solucione os problemas levantados pela vistoria e acima descritos, será encaminhada comunicação para a administração do shopping informando sobre as irregularidades encontradas na mesma.' . '</span><br /><br />';
     }
     $txt .=  '<span>' . 'Atenciosamente, ' . '</span><br />';
     $txt .=  '<span>' . ' CCCCC ' . '</span><br /><br /><br />';

     $txt .=  '<div style="text-align: center; ">';
     $txt .=  '<span style=" font-weight: bold;">' . 'R  E  C  I  B  O' . '</span><br /><br />';
     $txt .=  '<span>' . '_____/_____/_____' . '</span><br /><br /><br />';
     $txt .=  '<span>' . '______________________________________________' . '</span><br />';
     $txt .=  '<span>' . 'Assinatura do Lojista' . '</span><br />';
     $txt .= '</div>';


     $dat = date('d/m/Y', strtotime($reg['visdataefe']));
     if ($pri == 0) {
          $ven = date('d/m/Y', strtotime('+0 days', strtotime($reg['visdataefe'])));
     }
     if ($pri == 1) {
          $ven = date('d/m/Y', strtotime('+1 days', strtotime($reg['visdataefe'])));
     }
     if ($pri == 2) {
          $ven = date('d/m/Y', strtotime('+7 days', strtotime($reg['visdataefe'])));
     }
     if ($pri == 3) {
          $ven = date('d/m/Y', strtotime('+15 days', strtotime($reg['visdataefe'])));
     }
     $txt = str_replace("AAAAA", $dat, $txt); 
     $txt = str_replace("BBBBB", $ven, $txt); 
     $txt = str_replace("CCCCC", $nom, $txt); 

     $nro = fotos_qtd($reg['idvistoria'], $fot);
     if ($nro != 0) {
          $txt .= '<br />' . '<br />' . '<br />' . '<br />' . '<br />' . '<br />' . '<br />' . '<br />' . '<br />';
          $txt .= '<h3><strong>' . 'FOTOS DA VISTORIA ...' . '</strong></h3>';
          $txt .= '<table><tbody>';
          for ($ind = 0; $ind < $nro; $ind++) {
               $txt .= '<tr>';
               if (isset($fot[$ind]) == false) {
                    $txt .= '<td>' . '' . '</td>';
               } else {
                    $txt .= '<td>' . '<img src="' . __DIR__ . '/' . $fot[$ind] . '">' . '</td>';
               }
               if (isset($fot[$ind + 1]) == false) {
                    $txt .= '<td>' . '' . '</td>';
               } else {
                    $txt .= '<td>' . '<img src="' . __DIR__ . '/' . $fot[$ind + 1] . '">' . '</td>';
                    $ind = $ind + 1;
               }
               $txt .= '</tr>';
          }
          $txt .= '</tbody></table>';
     }
     $txt .= '<br />' . '<br />';
     $txt .=  '<div style="float: right;width: 100%; text-align: right; font-size: 12px; color: #8f8d8d; ">';
     $txt .=  '<hr />';
     $txt .= '<span>' . $sho['shoendereco'] . ', ' . $sho['shonumeroend'] . ' ' . $sho['shocomplemento'] . ' - ' . $sho['shobairro'] . '</span><br />';
     $txt .= '<span>' . $sho['shocidade'] . ' - ' . $sho['shoestado'] . ' - Brasil - Cep: ' . mascara_cpo($sho['shocep'], '     -   ') . '</span><br />';
     $txt .= '<span>' . $sho['shotelefone'] . ' - ' . $sho['shoemail'] . '</span><br />';
     $txt .=  '<hr />';
     $txt .=  '</div>';
     return $txt;
}

function modelo_cus ($nom, $reg, $car) {
     $txt = '';
     $sta = dados_sho($sho);
     $cid = retorna_dad('empcidade','tb_empresa','idempresa','1'); 
     include "lerinformacao.inc";

     $cam =  __DIR__ . '/' . 'upload/log_' . str_pad($_SESSION['wrkcodemp'], 6, "0", STR_PAD_LEFT) . '.jpg';
     if (file_exists($cam) == true) {
          $txt .=  '<div style="width: 100%; text-align: center; margin: 0px auto; ">';
          $txt .=  '<td>';
          $txt .= '<img src="' . __DIR__ . '/' . 'upload/log_' . str_pad($_SESSION['wrkcodemp'], 6, "0", STR_PAD_LEFT) . '.jpg' . '" width="100px" align="right">';
          $txt .=  '</td>';     
          $txt .=  '</div>';     

     } else {
          $txt .=  '<td></td>';
     }
     $txt .=  '</ br></ br>';

     $sql = mysqli_query($conexao,"Select * from tb_texto where idtexto = " . $car);
     if (mysqli_num_rows($sql) == 1) {
          $lin = mysqli_fetch_array($sql);
          $txt .= $lin['texdescricao'];
     }

     
     $hoj = date('d/m/Y');
     $dat = date('d/m/Y', strtotime($reg['visdataefe']));
     $txt = str_replace("[vistoriador]", $reg['tecnome'], $txt); 
     $txt = str_replace("[contato]", $reg['lojcontato1'], $txt); 
     $txt = str_replace("[gerencia]", $reg['lojcontato2'], $txt); 
     $txt = str_replace("[local]", $cid, $txt); 
     $txt = str_replace("[data]", $hoj, $txt); 
     $txt = str_replace("[vistoria]", $dat, $txt); 

     $txt .= '<br />' . '<br />';
     $txt .=  '<div style="float: right;width: 100%; text-align: right; font-size: 12px; color: #8f8d8d; ">';
     $txt .=  '<hr />';
     $txt .= '<span>' . $sho['shoendereco'] . ', ' . $sho['shonumeroend'] . ' ' . $sho['shocomplemento'] . ' - ' . $sho['shobairro'] . '</span><br />';
     $txt .= '<span>' . $sho['shocidade'] . ' - ' . $sho['shoestado'] . ' - Brasil - Cep: ' . mascara_cpo($sho['shocep'], '     -   ') . '</span><br />';
     $txt .= '<span>' . $sho['shotelefone'] . ' - ' . $sho['shoemail'] . '</span><br />';
     $txt .=  '<hr />';
     $txt .=  '</div>';

     return $txt;
}

function fotos_qtd($cha, &$fot) {
     $qtd = 0;
     $fot = array();
     $cha = str_pad($cha, 6, "0", STR_PAD_LEFT);
     foreach (new DirectoryIterator('upload/') as $dad) {
          if ($dad->isDir() == false) {
               $cam = $dad->getPathname();
               if (strpos($cam, $cha) > 0 ) {
                    $qtd = $qtd + 1;
                    $fot[] = $cam;
               }
          }
     }
     return $qtd;
}

function dados_sho(&$sho) {
     $sta = 0;
     $sho['idshopping'] = 0;
     include "lerinformacao.inc";
     $sql = mysqli_query($conexao,"Select * from tb_shopping where idshopping = " . $_SESSION['wrkcodemp']);
     if (mysqli_num_rows($sql) == 1) {
          $sho = mysqli_fetch_array($sql);
          $sta = $sho['idshopping'];
     }
     return $sta;
}
?>