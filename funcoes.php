<?php
function conecta_bco() {
        include "lerinformacao.inc";
    
        $pas = criptografa(1, $pas);
		
		$_SESSION['wrknombco'] = $bco;
		
		if ($conexao == true and $banco == true) {return 0;}
		if ($conexao == false) {return 1;}
		if ($banco == false) {return 2;}
}

function desconecta_bco() {
    include "lerinformacao.inc";
    mysqli_close($conexao); 
}

function val_entrada($sen_usu,$ema_usu){
     $nro = 0;
     $nro += stripos($ema_usu,"'");
     $nro += stripos($sen_usu,"'");
     $nro += stripos($ema_usu,"=");
     $nro += stripos($sen_usu,"=");
     $nro += stripos($ema_usu,"\"");
     $nro += stripos($sen_usu,"\"");
     $nro += stripos($ema_usu,"<");
     $nro += stripos($sen_usu,"<");
     $nro += stripos($ema_usu,">");
     $nro += stripos($sen_usu,">");
     $nro += stripos(strtoupper($ema_usu),"DROP");
     $nro += stripos(strtoupper($sen_usu),"DROP");
     $nro += stripos(strtoupper($ema_usu),"UNION");
     $nro += stripos(strtoupper($sen_usu),"UNION");
     $nro += stripos(strtoupper($ema_usu),"SELECT");
     $nro += stripos(strtoupper($sen_usu),"SELECT");
     $nro += stripos(strtoupper($ema_usu),"DELETE");
     $nro += stripos(strtoupper($sen_usu),"DELETE");
     $nro += stripos(strtoupper($ema_usu),"WHERE");
     $nro += stripos(strtoupper($sen_usu),"WHERE");
     if ($nro > 0) {
          return 1;
     }
     include "lerinformacao.inc";    
     $sen_usu = base64_encode($sen_usu);
     $sql = mysqli_query($conexao,"Select * from tb_usuario where usuemail = '$ema_usu' and ususenha = '$sen_usu'");
    if (mysqli_num_rows($sql) == 1) {
        $lin = mysqli_fetch_array($sql);
        $_SESSION['wrkopereg'] = 0;
        $_SESSION['wrkideusu'] = $lin['idsenha']; 
        $_SESSION['wrknomusu'] = $lin['usunome'];
        $_SESSION['wrktipusu'] = $lin['usutipo'];
        $_SESSION['wrkemausu'] = $lin['usuemail'];
        $_SESSION['wrkstausu'] = $lin['usustatus'];
        $_SESSION['wrknumcgc'] = $lin['usucnpj'];
        $_SESSION['wrkcodemp'] = $lin['usuempresa'];
        $_SESSION['wrkdatval'] = $lin['usuvalidade'];
        $_SESSION['wrknummod'] = 1;
        $_SESSION['wrknomemp'] = empresa_nom();
        if (strpos($_SERVER['HTTP_USER_AGENT'],"Chrome") > 0) {$_SESSION['wrkbronav'] = 1;}
        return 0;
    } else if (mysqli_num_rows($sql) > 1) {
        $_SESSION['wrkopereg'] = 0;
        $_SESSION['wrktipusu'] = 8;
        $_SESSION['wrkidesen'] = 0;
        $_SESSION['wrkcodemp'] = 0;
        $_SESSION['wrknummod'] = 9;
        $_SESSION['wrkstausu'] = 2;
        $_SESSION['wrknomusu'] = "#";
        $_SESSION['wrknomemp'] = "#";
        return 2;
    } else {
        $_SESSION['wrkopereg'] = 0;
        $_SESSION['wrktipusu'] = 9;
        $_SESSION['wrkidesen'] = 0;
        $_SESSION['wrkcodemp'] = 0;
        $_SESSION['wrknummod'] = 9;
        $_SESSION['wrkstausu'] = 2;
        $_SESSION['wrknomusu'] = "*";
        $_SESSION['wrknomemp'] = "#";
        return 3;
    }
}

function envia_email($email_1, $asu_ema, $tex_env, $nom_usu, $des_usu){
     ini_set("smtp_port", 25);    // 25 - 587 - 465
    if ($asu_ema == "") {
        $asu_ema ="Re-envio de login e senha a usuário do sistema !";
    }
    $headers  = 'From: contato@gestaomall.com.br' . "\r\n";
    $headers .= 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
    $envio = mail($email_1, $asu_ema, $tex_env, $headers);
    if ($envio == true):
        return 1;
    else:
        return 0;
    endif;
 }
 
function manda_email($email_1, $email_2, $asu_ema, $tex_ema, $nom_usu, $des_usu, $anexo_1, $anexo_2){
    include_once "class.smtp.php"; $nro = 1;
    include_once "class.phpmailer.php";
    if ($asu_ema == "") {
        $asu_ema = "Re-envio de login e senha a usuário do sistema";
    }
     //$mail->AddCC('destinarario@dominio.com.br', 'Nome do Destinatario'); // Copia
     //$mail->AddBCC('destinatario_oculto@dominio.com.br', 'Destinatario2`'); // Cópia Oculta
     //$mail->AddAttachment('images/phpmailer.gif');      // Adicionar um anexo
    $mail = new PHPMailer();
    $mail->SMTPDebug = 0; // 1 = erros e mensagens || 2 = apenas mensagens

    if ($anexo_1 != "") { $mail->AddAttachment($anexo_1); }
    if ($anexo_2 != "") { $mail->AddAttachment($anexo_2); }
    date_default_timezone_set("America/Sao_Paulo");
    $mail->IsSMTP();	// $mail->IsMail();
    $mail->SMTPAuth = true;
    $mail->IsHTML(true);
    $mail->Port = 587;    // 587 - 465 - 995
    $mail->CharSet = 'UTF-8';
    $mail->Host = 'smtp.hostinger.com.br'; 
    $mail->Username = 'profsa@inatoshopp.com';
    $mail->Password = 'profsa1993';
    $mail->Subject = $asu_ema . " - ". date("d/m/Y H:i:s");
    $mail->SetFrom('profsa@inatoshopp.com', 'Gestão de Mall - ' . $des_usu);
    if (strpos($email_1, ";") == 0   ) {
        $mail->AddAddress($email_1, $nom_usu);
    } else {
        $ema = explode(";", $email_1);
        foreach ($ema as $key => $cpo) {
            if ($cpo != "") {
                $mail->AddCC(trim($cpo), 'Gestão de Vistorias ' . $nro); $nro += 1;            
            }
        }
    }
    if ($email_2 != "") { 
        if (strpos($email_2, ";") == 0   ) {
            $mail->AddCC($email_2, 'Vistoriador Responsavel'); 
        } else {
            $ema = explode(";", $email_2);
            foreach ($ema as $key => $cpo) {
                if ($cpo != "") {
                    $mail->AddCC(trim($cpo), 'Vistoriador Técnico' . $nro); $nro += 1;            
                }
            }
        }    
    }
    $mail->MsgHTML($tex_ema);
    $ret = $mail->Send();
    return $ret;
 }	

  function envio_email($email_1, $email_2, $asu_ema, $tex_ema, $nom_usu, $des_usu, $anexo_1, $anexo_2) {
    if (getenv("REMOTE_ADDR") == "127.0.0.1") {$email_1 = "suporte@profsa.com.br"; }
    include_once("PHPMailerAutoload.php");
    if ($asu_ema == "") {$asu_ema ="Re-envio de login e senha a usuário do sistema !!!";}
    $mail = new PHPMailer();
    $mail->IsSMTP();	// $mail->IsMail();
    $mail->CharSet = 'UTF-8';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "SSL";
    $mail->SMTPDebug = 0; // 1 = erros e mensagens || 2 = apenas mensagens
    $mail->IsHTML(true);
    $mail->Port = 25;    // 25 - 587 - 465 - 995
    $mail->Host = 'smtp.hostinger.com.br'; //  send.one.com - mailout.one.com
    $mail->Username = 'profsa@inatoshopp.com';
    $mail->Password = 'profsa1993';
    $mail->SetFrom('profsa@inatoshopp.com','Gestão de Mall');
    if ($arq_ane != "") { $mail->AddAttachment($arq_ane); }
    $mail->AddAddress($email_1, $nom_usu);
    if ($email_2 != "") { $mail->AddCC($email_2, 'Vistoriador Responsavel'); }
    $mail->Subject = $asu_ema;
    $mail->MsgHTML($tex_ema);
    $ret = $mail->Send();
    return $ret;
}	

  function criptografa($tipo,$texto) {
    $tex = "";
    $nro = strlen($texto) - 1;
    if ($tipo == 0) {	/* Tipo: 0 -> vai e 1 -> volta */
        for ($ind = 0;$ind <= $nro;$ind++) {
            $tex = $tex . chr(ord(substr($texto,$ind,1)) - 1);
        }
    }
    if ($tipo == 1) {
        for ($ind = 0;$ind <= $nro;$ind++) {
            $tex = $tex . chr(ord(substr($texto,$ind,1)) + 1);
        }
    }
    return $tex;
}

function gravar_log($ope = 0, $obs = "", $cod = "") {
    date_default_timezone_set("America/Sao_Paulo");
    include "lerinformacao.inc";    

    $ser = substr(getenv("REMOTE_ADDR") . "|" . getenv("HTTP_USER_AGENT") . "|" . getenv("REMOTE_HOST") . "|" . getenv("SERVER_NAME") . "|" . getenv("SERVER_SOFTWARE") ,0,255) ;

    $ip  = getenv("REMOTE_ADDR");
    $nav = getenv("HTTP_USER_AGENT");
    $nom = "";
    $cid = "";
    $est = "";
    $sta = "";
    $sen = 00;
    $emp = 00;
    $ema = "";
    $ant = "";
    $cam = "";
    $prg = "";
    $tam = 00;
    $mod = 02;
    $ext = "";
    $end = buscar_ip($ip);
    $pro = getenv("SERVER_SOFTWARE");
    $tip = 00;
    $gap = 00;

    if (isset($_SESSION['wrkcodemp']) == true) {$emp = $_SESSION['wrkcodemp'];}
    if (isset($_SESSION['wrkstasen']) == true) {$sta = $_SESSION['wrkstasen'];}
    if (isset($_SESSION['wrknomusu']) == true) {$nom = $_SESSION['wrknomusu'];}
    if (isset($_SESSION['wrkideusu']) == true) {$sen = $_SESSION['wrkideusu'];}
    if (isset($_SESSION['wrktipusu']) == true) {$tip = $_SESSION['wrktipusu'];}
    if (isset($_SESSION['wrkemausu']) == true) {$ema = $_SESSION['wrkemausu'];}
    if (isset($_SESSION['wrknompro']) == true) {$prg = $_SESSION['wrknompro'];}
    if (isset($_SESSION['wrknomant']) == true) {$ant = $_SESSION['wrknomant'];}
    if (isset($_SESSION['wrkcidusu']) == true) {$cid = $_SESSION['wrkcidusu'];}
    if (isset($_SESSION['wrkestusu']) == true) {$est = $_SESSION['wrkestusu'];}

    if ($tam == "") { $tam = 0; }
    $prg = str_replace(__DIR__ . "\\", "", $prg);

    $dat = date("Y/m/d H:i:s");
    $sql = "Insert into tb_log ";
    $sql .= "(logdatahora, logempresa, logmodulo, logusuario, logtipo, logidsenha, logemail, logip, lognavegador, logprovedor, logoperacao,  logprograma, loganterior, logcidade, logestado, logobservacao)";
    $sql .= " values " . "(";
    $sql .= "'" . $dat . "',";
    $sql .= "'" . $emp . "',";
    $sql .= "'" . $mod . "',";
    $sql .= "'" . $nom . "',";
    $sql .= "'" . $tip . "',";
    $sql .= "'" . $sen . "',";
    $sql .= "'" . $ema . "',";
    $sql .= "'" . $ip  . "',";		
    $sql .= "'" . $nav . "',";
    $sql .= "'" . $pro . "',";
    $sql .= "'" . $ope . "',";
    $sql .= "'" . limpa_pro($prg) . "',";
    $sql .= "'" . limpa_pro($ant) . "',";
    $sql .= "'" . $cid . "',";
    $sql .= "'" . $est . "',";
    $sql .= "'" . $obs . "')";
    $ret = mysqli_query($conexao,$sql);
    $lin = mysqli_affected_rows($conexao); // Número de linhas afetadas/atualizadas no UpDate
    $cha = mysqli_insert_id($conexao); // Auto Increment Id 
    if ($ret == false) {
        print_r($sql);
        echo '<script>alert("Erro na gravação de Log de acessos ao sistema !");</script>'; exit();
    } 
    $ret = desconecta_bco();
}

function limpa_cpo($string){
return preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ç)/","/(Ç)/"),explode(" ","a A e E i I o O u U c C"),$string);
}

function limpa_nro($string){ 
$str = preg_replace('/[^0-9]/','',$string); 
return ($str == '' ? 0 : $str);
}

function mascara_cpo($cpo, $mas) {	// Formata campos com máscara
if ($cpo == "") { return '#'; }    
$ret = '';
$nro = 00;
$tmc = strlen($cpo);
$tmm = strlen($mas);
if ($tmm == 0) { $tmm = $tmc; }
for ($ind = 0; $ind < $tmm; $ind++) {
    if (trim($mas[$ind]) == "") {
        if (isset($cpo[$nro]) == true) {
            $ret = $ret . $cpo[$nro];
        }
        $nro = $nro + 1;
    }else{
        $ret = $ret . $mas[$ind];
    }
}
return $ret;
}

function buscar_cnpj($cgc) {
	$pro = curl_init("https://www.receitaws.com.br/v1/cnpj/".$cgc);
	curl_setopt($pro, CURLOPT_RETURNTRANSFER, true);    
	curl_setopt($pro, CURLOPT_SSL_VERIFYPEER, false);
	$ret = curl_exec($pro);
	$dad = json_decode($ret);
	curl_close($pro);    
	return $dad;
}

function buscar_ip($ip) {
    $end = curl_init('http://ipinfo.io/' . $ip . '/json');
    curl_setopt($end, CURLOPT_RETURNTRANSFER, true);    
    curl_setopt($end, CURLOPT_SSL_VERIFYPEER, false);
    $ret = curl_exec($end);
    $dad = json_decode($ret);
    curl_close($end);    
    $_SESSION['wrkcidusu'] = 'sâo paulo';
    $_SESSION['wrkestusu'] = 'sp';
    if (isset($dad->bogon) == true) {
        $_SESSION['wrkcidusu'] = 'Sâo Paulo';
        $_SESSION['wrkestusu'] = 'Sp';
    }else if (isset($dad->city) == true) {
        $_SESSION['wrkcidusu'] = $dad->city;
        $_SESSION['wrkestusu'] = $dad->region;
        if ($_SESSION['wrkestusu'] == "Sao Paulo") { $_SESSION['wrkestusu'] = "SP"; }
        if ($_SESSION['wrkestusu'] == "Minas Gerais") { $_SESSION['wrkestusu'] = "MG"; }
    }
    return $dad;
}

function diferenca_dat($dat_i = "", $dat_f = "") {
$dia = 0;
if ($dat_i == "") { $dat_i = date("Y-m-d"); }
$dat_f = substr($dat_f,6,4) . "-" . substr($dat_f,3,2) . "-" . substr($dat_f,0,2);

$data1 = new DateTime($dat_i);
$data2 = new DateTime($dat_f);
$intervalo = $data1->diff($data2);
$dia = $intervalo->days;
if ($dat_i > $dat_f) { $dia = $dia * -1; }
return $dia;
}

function valida_dat($tes) {
    $sta = 0;
    if ($tes == "" || $tes == "//") { return 1; }
    $dat = explode("/",substr($tes, 0, 10));  
    if (is_numeric($dat[0]) == false || is_numeric($dat[1]) == false || is_numeric($dat[2]) == false) {
        $sta = 2;
    }
    if ($sta == 0) {
        if (checkdate($dat[1],$dat[0],$dat[2]) == false) {
            $sta = 3;
        }
    }
    return $sta;
}

function valida_hor($tes) {
    $sta = 0;
    $hor = explode(":", $tes);  
    if (is_numeric($hor[0]) == false || is_numeric($hor[1]) == false) {
        $sta = 1;
    }
    if (count($hor) == 2) {
        if ($hor[0] > 23) { $sta = 2; }
        if ($hor[1] > 59) { $sta = 3; }
    }else{
        $sta = 4;
    }
    return $sta;
}

function dia_mes($dat) {
$dia = 0;
$mes = substr($dat, 3, 2);
$ano = substr($dat, 6, 4);
if ($mes == 1)  { $dia = 31; }
if ($mes == 2)  { $dia = 28; }
if ($mes == 3)  { $dia = 31; }
if ($mes == 4)  { $dia = 30; }
if ($mes == 5)  { $dia = 31; }
if ($mes == 6)  { $dia = 30; }
if ($mes == 7)  { $dia = 31; }
if ($mes == 8)  { $dia = 31; }
if ($mes == 9)  { $dia = 30; }
if ($mes == 10) { $dia = 31; }
if ($mes == 11) { $dia = 30; }
if ($mes == 12) { $dia = 31; }
if ($mes == 2 && ($ano % 4) == 0) { $dia = 29; }
return $dia;
}

function inverte_dat($dat) {
    $bar = strpos($dat,'/');
    $tra = strpos($dat,'-');
    if ($bar > 0) {
        if ($bar == 2) {
            $dat = substr($dat,6,4) . '/' . substr($dat,3,2) . '/' . substr($dat,0,2);
        }
        if ($bar == 4) {
            $dat = substr($dat,8,2) . '/' . substr($dat,5,2) . '/' . substr($dat,0,4);
        }
    }
    if ($tra > 0) {
        if ($tra == 2) {
            $dat = substr($dat,6,4) . '-' . substr($dat,3,2) . '-' . substr($dat,0,2);
        }
        if ($tra == 4) {
            $dat = substr($dat,8,2) . '-' . substr($dat,5,2) . '-' . substr($dat,0,4);
        }
    }
    return $dat;
}

function limpa_pro($nom)  {
    $ind = strrpos ($nom,"/");
    if ($ind > 0) {
        $nom = substr($nom,$ind + 1);  
        $ind = strrpos ($nom,".php");
        $nom = substr($nom,0, $ind);  
    } 
    $ind = strrpos ($nom,"\\");
    if ($ind > 0) {
        $nom = substr($nom,$ind + 1);  
        $ind = strrpos ($nom,".php");
        $nom = substr($nom,0, $ind);  
    }
    return $nom;
}

function retorna_dad($cpo, $tab, $cha, $cod) {
    $dad = '';
    $sql = "Select " . $cpo . " as campo from " . $tab . " where " . $cha . " = " . $cod;
    include "lerinformacao.inc";
    $sql = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($sql) == 1) {
        $linha = mysqli_fetch_array($sql);
        $dad = $linha['campo'];
    }
    return $dad;
}

function valida_est($est) {
    $sta = 0;
    $lis = array('AC', 'AL', 'AM', 'AP', 'BA', 'CE', 'DF', 'ES', 'GO', 'MA', 'MG', 'MS', 'PA', 'PB', 'PE', 'PI', 'PR', 'RJ', 'RN', 'RO', 'RR', 'RS', 'SC', 'SE', 'SP', 'TO');
    $sta = array_search(trim($est), $lis);
    return $sta;
}

function valida_cgc ($cgc) {
    $sta = 0;
    $som = 0;
    $cgc = preg_replace('/[^0-9]/','',$cgc);    // Troca não numeros por branco.
    for ($ind = 0, $nro = 5; $ind <= 11 ; $ind++, $nro--) {
        $som = $som + $cgc[$ind] * $nro;
        if ($nro == 2) {$nro = 10; }
    }
    $res1 = 11 - $som % 11;
    if ($res1 == 10 || $res1 == 11) { $res1 = 0; }
    $cgc = $cgc . $res1;
    $som = 0;
    for ($ind=0, $nro=6; $ind <= 11 ; $ind++, $nro--) {
        $som = $som + $cgc[$ind] * $nro;
        if ($nro == 2) {$nro = 10; }
    }
    $som = $som + $res1 * 2;
    $res2 = 11 - $som % 11;
    if ($res2 == 10 || $res2 == 11) { $res2 = 0; }
    if ($res1 != $cgc[12] || $res2 != $cgc[13]) { $sta = 1; }
    return $sta;
}

function valida_cpf ($cpf) {
    $sta = 0;
    $som = 0;
    $cpf = preg_replace('/[^0-9]/','',$cpf);  // Troca não numeros por branco.
    for ($ind=0, $nro=10; $ind <= 8 ; $ind++, $nro--) {
        $som = $som + $cpf[$ind] * $nro;
    }
    $res1 = 11 - $som % 11;
    if ($res1 == 10 || $res1 == 11) { $res1 = 0; }
    $cpf = $cpf . $res1;
    $som = 0;
    for ($ind=0, $nro=11; $ind <= 9 ; $ind++, $nro--) {
        $som = $som + $cpf[$ind] * $nro;
    }
    $res2 = 11 - $som % 11;
    if ($res2 == 10 || $res2 == 11) { $res2 = 0; }
    if ($res1 != $cpf[9] || $res2 != $cpf[10]) { $sta = 1; }
    return $sta;
}

function email_exi($ema) {
    $cha = 0;
    include "lerinformacao.inc";
    $sql = mysqli_query($conexao,"Select idsenha from tb_usuario where usuemail = '" . $ema . "'");
    if (mysqli_num_rows($sql) == 1) {
        $linha = mysqli_fetch_array($sql);
        $cha = $linha['idsenha'];
    }
    return $cha;
}

function cnpj_exi($tip, $cgc, &$nom) {
    $cod = 0;
    include "lerinformacao.inc";
    if ($tip == 0) {
        $sql = "Select idshopping as codigo, shorazao as nome  from tb_shopping where shocnpj = '" . limpa_nro($cgc) . "'";
    }
    if ($tip == 1) {
        $sql = "Select idloja as codigo, lojnome as nome  from tb_loja where lojcnpj = '" . limpa_nro($cgc) . "'";
    }
    $sql = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($sql) == 1) {
        $lin = mysqli_fetch_array($sql);
        $cod = $lin['codigo'];
        $nom = $lin['nome'];
    }
    return $cod;
}

function empresa_nom() {
    $nom = '';
    include "lerinformacao.inc";
    if ($_SESSION['wrktipusu'] >= 4) {
        $sql = "Select idempresa, emprazao as nome from tb_empresa where idempresa = 1";
    } else {
        $sql = "Select idshopping, shorazao as nome from tb_shopping where idshopping = " . $_SESSION['wrkcodemp'];
    }
    $sql = mysqli_query($conexao, $sql);
    if (mysqli_num_rows($sql) == 1) {
        $lin = mysqli_fetch_array($sql);
        $nom = $lin['nome'];
    }
    if ($nom == "") { $nom = "******************************"; }
    return $nom;
}

function primeiro_nom($nom) {
    $pos = strpos($nom," "); 
    if ($pos > 0) {
         $nom = trim(substr($nom, 0, $pos));
    }
    return $nom;
}

 ?>