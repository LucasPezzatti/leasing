<?php 
require "conn_MYSQL.php";

class localsql{
//AUTH	
function auth($email,$senha,$pdo){	
            $sql="SELECT * FROM tblcdsusu where login='$login' and senha='$senha' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//AUTH	
function about_text($pdo){	
            $sql="SELECT * FROM tblcdsabout where 1 ";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//INSER NEW USER
function insert_user($email,$nome,$fone,$senha,$cpf,$cnpj,$razao,$end_rua,$end_numero,$end_bairro,$end_complemento,$end_cep,$dtcad,$horacad,$pdo){
$sql="INSERT INTO tblcdsucl 
(email,nome,telefone,senha,cpf,cnpj,razao,end_rua,end_numero,end_bairro,end_complemento,end_cep,dtcad,horacad,status,tipo)
VALUES('$email','$nome','$fone','$senha','$cpf','$cnpj','$razao','$end_rua','$end_numero','$end_bairro','$end_complemento','$end_cep','$dtcad','$horacad','1','1')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//BUSCA CADASTRO DA EMPRESA
function busca_empresa_id($idempresa,$pdo){	
            $sql="SELECT * FROM tblcdsemp0 where IDEMPRESA='$idempresa';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}	
//BUSCA CADASTRO DA EMPRESA ALL
function busca_empresa_all($pdo){	
            $sql="SELECT * FROM tblcdsemp0 where 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CADASTRO DA EMPRESA ALL
function busca_empresa_uf_all($pdo){	
            $sql="SELECT distinct UF FROM tblcdsemp0 where 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}	
//BUSCA CONFIGURAÇÃO INTERNA PELO ID 	
function busca_cfg_id($idcfg,$pdo){	
            $sql="SELECT * FROM tblcfgint where idcfg='$idcfg';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA ITENS MAIS VENDIDOS
function busca_mais_vendidos($pdo){	
            $sql="SELECT `IDITEM`, sum(`QTDE`) as `QTD` FROM `tblmvmite0` GROUP BY `IDITEM` order by `QTD` DESC LIMIT 4";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA TIPOS DE ENTREGA	
function busca_tipo_entrega($pdo){	
            $sql="SELECT * FROM tblcfgent where status='1' order by 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA CONFIGURAÇÃO DE SALDO
function lista_cfg_mvm_sdo($pdo){	
            $sql="SELECT * FROM tblcfgsdo where 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA FORMA DE PAGAMENTO
function lista_fpg_ativa($pdo){	
            $sql="SELECT * FROM tblcfgfpg where status='a';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA SEÇÕES GLOBAL
function lista_secoes($lista,$pdo){	
            $sql="SELECT IDSECAO,SECAO FROM tblcdssec0 where IDSECAO in($lista) and IDGRUPO=0 order by field(IDSECAO,$lista);";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA SEÇÕES ALL (CADASTRO DE SEÇÕES)
function lista_secoes_all($pdo){	
            $sql="SELECT IDSECAO,SECAO FROM tblcdssec0 where IDGRUPO=0;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA SEÇÕES FOOTER
function lista_secoes_footer($pdo){	
            $sql="SELECT IDSECAO,SECAO FROM tblcdssec0 where IDGRUPO=0 limit 5;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA SEÇÕES LAST (CADASTRO DE SEÇÕES)
function lista_secoes_last($pdo){	
            $sql="SELECT IDSECAO FROM tblcdssec0 where IDGRUPO=0 order by idsecao desc limit 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA CLIENTE LAST (CADASTRO DE CLIENTES)
function busca_cliente_last($razao,$dtcad,$pdo){	
            $sql="SELECT IDCLIENTE FROM tblcdscli0 where RAZAO='$razao' and DTCAD='$dtcad'
			order by IDCLIENTE desc limit 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA ITENS (IN LISTA)
function lista_itens_in($lista,$pdo){	
            $sql="SELECT * FROM tblcdsite0 where IDITEM in($lista) 
			order by field(IDITEM,$lista);";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA ITENS (IDFATENT)
function lista_itens_mvm_idfatent($idfatent,$pdo){	
            $sql="SELECT * FROM tblmvmite0 where IDFATENT='$idfatent';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//SUM VLR TOTAL (IDFATENT)
function sum_vlr_idfatent($idfatent,$pdo){	
            $sql="SELECT sum(VLRTOTAL) as TOTALCHART FROM tblmvmite0 where IDFATENT='$idfatent';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA FORMAS DE PGTO (IDFATENT)
function busca_vlr_formapgto_idfatent($idfatent,$pdo){	
            $sql="SELECT * FROM tblmvmfat4 where IDFATENT='$idfatent';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA ITENS (POR ID SECAO)
function lista_item_idsecao($secao,$start_from,$iteperpage,$orderby,$tabela,$pdo){	
            $sql="SELECT tblcdsite0.IDITEM,tblcdsite0.NOMEPRO,tblcdsite0.NOMECOM,tblcdspre1.PRECO,tblcdsite0.UNDVEND1 FROM tblcdsite0 
            LEFT JOIN tblcdspre1 ON tblcdsite0.IDITEM = tblcdspre1.IDITEM where tblcdspre1.IDTABELA='$tabela' and IDSECAO='$secao' 
			$orderby LIMIT $start_from, $iteperpage ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT ITENS (POR ID SECAO)
function count_item_idsecao($secao,$pdo){	
            $sql="SELECT COUNT(*) as itenum FROM tblcdsite0 where IDSECAO='$secao';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT ITENS (SEARCH PRODUTO)
function count_item_search_prod($generica,$pdo){
            $genericaU=strtoupper($generica);	
            $genericaC=ucwords($generica);	
            $sql="SELECT COUNT(*) as itenum FROM tblcdsite0 where 
			NOMEPRO like '%$generica%' or
			NOMEPRO like '%$genericaU%' or
			NOMEPRO like '%$genericaC%' or
			NOMECOM like '%$generica%' or
			NOMECOM like '%$genericaU%' or
			NOMECOM like '%$genericaC%' 
			
			;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA ITENS (SEARCH ITEM)
function lista_item_search($generica,$start_from,$iteperpage,$orderby,$tabela,$pdo){	
            $genericaU=strtoupper($generica);	
            $genericaC=ucwords($generica);	
            $sql="SELECT tblcdsite0.IDITEM,tblcdsite0.NOMEPRO,tblcdsite0.NOMECOM,tblcdspre1.PRECO,tblcdsite0.UNDVEND1,tblcdsite0.IDSECAO
			FROM tblcdsite0 
            LEFT JOIN tblcdspre1 ON tblcdsite0.IDITEM = tblcdspre1.IDITEM 
			where tblcdspre1.IDTABELA in ('$tabela') and 
			
			NOMEPRO like '%$generica%' and
			tblcdspre1.IDTABELA in ('$tabela') or
			NOMEPRO like '%$genericaU%' and
			tblcdspre1.IDTABELA in ('$tabela') or
			NOMEPRO like '%$genericaC%' and
			tblcdspre1.IDTABELA in ('$tabela') or
			NOMECOM like '%$generica%' and
			tblcdspre1.IDTABELA in ('$tabela') or
			NOMECOM like '%$genericaU%' and 
			tblcdspre1.IDTABELA in ('$tabela') or
			NOMECOM like '%$genericaC%' 
			
			$orderby LIMIT $start_from, $iteperpage ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA SALDO DO ITEM(IDITEM)
function busca_saldo_iditem($iditem,$pdo){	
            $sql="SELECT * FROM tblsdoite1 where IDITEM='$iditem';";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCAR PREÇO POR IDITEM + IDTABELA 
function preco_item_tabela($iditem,$tabela,$pdo){	
            $sql="SELECT PRECO FROM tblcdspre1 where IDITEM='$iditem' and IDTABELA='$tabela';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCAR PREÇO POR IDITEM + IDTABELA 
function preco_item_tabela_cadweb($iditem,$tabela,$pdo){	
            $sql="SELECT PRECO FROM tblcdspre1 where IDITEM='$iditem' and IDTABELA='$tabela';";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCAR receituraio POR IDITEM + IDTABELA 
function busca_receituario_ite($iditem,$pdo){	
            $sql="SELECT MODOAPL FROM tblcdsite3 where IDITEM='$iditem' ;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA TABELAS DE PRECO 
function lista_tabelas_preco($pdo){	
            $sql="select idtabela,tabela from tblcdspre0;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA TABELAS DE PRECO NOT IN
function lista_tabelas_preco_notin($idtabela,$pdo){	
            $sql="select idtabela,tabela from tblcdspre0 where idtabela not in('$idtabela');";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA TABELAS DE PRECO (POR ID)
function lista_tabelas_preco_id($idtabela,$pdo){	
            $sql="select TABELA from tblcdspre0 where IDTABELA='$idtabela';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//INTEGRACAO - BUSCAR DATA/HORA DO SYNC	
function busca_sync_date($pdo){	
            $sql="SELECT * FROM tblcfgsync where 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//INTEGRACAO - SECAO (LIMPA TABELA)
function integra_secao_limpatbl($pdo){
			$sql="DELETE FROM tblcdssec0 where 1";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - SECAO 
function integra_secao($idsecao,$secao,$dtcad,$horacad,$usucad,$usualt,$dtalt,$horaalt,$idgrupo,$idsubgrupo,$idchavereg,$custoadi,$comissao,$descmax,$idobs,$tiposecao,$idcentro,$iddre,$idchaveregsolweb,$pdo){
			$sql="REPLACE INTO tblcdssec0 
(IDSECAO,SECAO,DTCAD,HORACAD,USUCAD,USUALT,DTALT,HORAALT,IDGRUPO,IDSUBGRUPO,IDCHAVEREG,CUSTOADI,COMISSAO,DESCMAX,IDOBS,TIPOSECAO,IDCENTRO,IDDRE,IDCHAVEREGSOLWEB) 
VALUES('$idsecao','$secao','$dtcad','$horacad','$usucad','$usualt','$dtalt','$horaalt','$idgrupo','$idsubgrupo','$idchavereg','$custoadi','$comissao','$descmax','$idobs','$tiposecao','$idcentro','$iddre','$idchaveregsolweb')
";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - SECAO UPDATE SYNC
function upd_sync_secao($pdo){
	        $syncdate=date('ymdHi');
			$sql="UPDATE tblcfgsync set sync_sec='$syncdate' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }		
//INTEGRACAO - ITEM (LIMPA TABELA)
function integra_item_limpatbl($pdo){
			$sql="DELETE FROM tblcdsite0 where 1";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - ITEM (LIMPA TABELA)
function integra_ite3_limpatbl($pdo){
			$sql="DELETE FROM tblcdsite3 where 1";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }		
//INTEGRACAO - ITEM 
function integra_item($iditem,$idempresa,$idlocal,$idsecao,$referencia,$nomepro,$nomecom,$marca,$undvend1,$pesoliq,$pesobru,$codservico,     
$horacad,$dtcad,$usucad,$prodacab,$idgrupo,$idsubgrupo,$idmarca,$idnumero,$idcor,$cardapio,$fatorfrac,$refaux1,$exppda,$edicao,$anoedicao,
$qtdfrac,$industrializado,$idgrupoprev,$comprimento,$largura,$altura,$pdo){

$sql="REPLACE INTO tblcdsite0 

(IDITEM,IDEMPRESA,IDLOCAL,IDSECAO,REFERENCIA,NOMEPRO,NOMECOM,MARCA,UNDVEND1,PESOLIQ,PESOBRU,CODSERVICO,HORACAD,DTCAD,USUCAD,PRODACAB,IDGRUPO,IDSUBGRUPO,
IDMARCA,IDNUMERO,IDCOR,CARDAPIO,FATORFRAC,REFAUX1,EXPPDA,EDICAO,ANOEDICAO,QTDFRAC,INDUSTRIALIZADO,IDGRUPOPREV,COMPRIMENTO,LARGURA,ALTURA) 
VALUES('$iditem','$idempresa','$idlocal','$idsecao','$referencia','$nomepro','$nomecom','$marca','$undvend1','$pesoliq','$pesobru','$codservico',     
'$horacad','$dtcad','$usucad','$prodacab','$idgrupo','$idsubgrupo','$idmarca','$idnumero','$idcor','$cardapio','$fatorfrac','$refaux1','$exppda',
'$edicao','$anoedicao','$qtdfrac','$industrializado','$idgrupoprev','$comprimento','$largura','$altura')
";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - ITEM TBLCDSITE3
function integra_item_tblcdsite3($iditem,$modoapl,$pdo){
$sql="REPLACE INTO tblcdsite3 (IDITEM,MODOAPL)VALUES('$iditem','$modoapl')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }				
//INTEGRACAO - ITEM UPDATE SYNC
function upd_sync_ite($pdo){
	        $syncdate=date('ymdHi');
			$sql="UPDATE tblcfgsync set sync_prod='$syncdate' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - ITEM UPDATE SYNC NEW
function upd_sync_ite_true($syncdate,$pdo){
			$sql="UPDATE tblcfgsync set sync_prod='$syncdate' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }		
//INTEGRACAO - PRECO (LIMPA TABELA)
function integra_preco_limpatbl($pdo){
			$sql="DELETE FROM tblcdspre1 where 1";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - PRECO 		
function integra_preco($idtabela,$preco,$dtcad,$horacad,$usucad,$usualt,$dtalt,$horaalt,$iditem,$idtabelameuspedidos1,$idtabelasolweb,$idchavemvi,
$precobarra,$precomt,$precobase,$precost,$sequenciacarga,$efetivado,$pdo){
			$sql="REPLACE INTO tblcdspre1 
(IDTABELA,PRECO,DTCAD,HORACAD,USUCAD,USUALT,DTALT,HORAALT,IDITEM,IDTABELAMEUSPEDIDOS1,IDTABELASOLWEB,IDCHAVEMVI,PRECOBARRA,PRECOMT,PRECOBASE,PRECOST,
SEQUENCIACARGA,EFETIVADO) 
VALUES('$idtabela','$preco','$dtcad','$horacad','$usucad','$usualt','$dtalt','$horaalt','$iditem','$idtabelameuspedidos1','$idtabelasolweb','$idchavemvi',
'$precobarra','$precomt','$precobase','$precost','$sequenciacarga','$efetivado')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
			
        }
//INTEGRACAO - PRECO (LIMPA ITEM X TABELA)
function integra_preco_limpatbl_itextab($iditem,$idtabela,$pdo){
			$sql="DELETE FROM tblcdspre1 where IDITEM='$iditem' and IDTABELA='$idtabela' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }		
//INTEGRACAO - PRECO UPDATE SYNC
function upd_sync_pre($pdo){
	        $syncdate=date('ymdHi');
			$sql="UPDATE tblcfgsync set sync_pre='$syncdate' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }		
//INTEGRACAO - CLIENTE 		
function integra_cliente($idcliente,$idcidadecli,$cnpj,$cei,$razao,$fantasia,$endereco,$cpf,$bairro,$cep,$fone,$celular,$clifor,$dtcad,$horacad,$usucad,
$usualt,$dtalt,$horaalt,$clasabc,$duvidoso,$numero,$rg,$vlrfrete,$tipotributacao,$ci,$clvctocartao,$situacaocli,$codigosituacao,$celular2,$celular3,
$clapelido,$complemento,$mei,$meirevendedor,$naoparticiparplanofidelidade,$pdo){
$sql="REPLACE INTO tblcdscli0 
(IDCLIENTE,IDCIDADECLI,CNPJ,CEI,RAZAO,FANTASIA,ENDERECO,CPF,BAIRRO,CEP,FONE,CELULAR,CLIFOR,DTCAD,HORACAD,USUCAD,USUALT,DTALT,HORAALT,CLASABC,DUVIDOSO,
NUMERO,RG,VLRFRETE,TIPOTRIBUTACAO,CI,CLVCTOCARTAO,SITUACAOCLI,CODIGOSITUACAO,CELULAR2,CELULAR3,CLAPELIDO,COMPLEMENTO,MEI,MEIREVENDEDOR,
NAOPARTICIPARPLANOFIDELIDADE) 

VALUES('$idcliente','$idcidadecli','$cnpj','$cei','$razao','$fantasia','$endereco','$cpf','$bairro','$cep','$fone','$celular','$clifor','$dtcad','$horacad',
'$usucad','$usualt','$dtalt','$horaalt','$clasabc','$duvidoso','$numero','$rg','$vlrfrete','$tipotributacao','$ci','$clvctocartao','$situacaocli',
'$codigosituacao','$celular2','$celular3','$clapelido','$complemento','$mei','$meirevendedor','$naoparticiparplanofidelidade')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();		
}
//INTEGRACAO - CLIENTE (LIMPA TABELA)
function integra_cliente_limpatbl($pdo){
			$sql="DELETE FROM tblcdscli0 where 1";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//INTEGRACAO - PRECO UPDATE SYNC
function upd_sync_cli($pdo){
	        $syncdate=date('ymdHi');
			$sql="UPDATE tblcfgsync set sync_cli='$syncdate' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//BUSCAR VENDA POR IDFATENT 
function busca_venda_idfatent($idfatent,$pdo){	
            $sql="SELECT * FROM tblmvmcart where IDFATENT='$idfatent' ;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}		
//BUSCAR VENDA POR CLIENTE 
function busca_venda_cli($idcliente,$pdo){	
            $sql="SELECT IDFATENT FROM tblmvmcart where IDCLIENTE='$idcliente' ;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCAR VENDA POR CLIENTE (IDUSUARIO)
function busca_venda_idusu($idusu,$pdo){	
            $sql="SELECT IDFATENT,HASH FROM tblmvmcart where IDUSU='$idusu' and STATUS='A' ;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCAR VENDA POR HASH (SESSION_HASH)
function busca_venda_hash($hash,$pdo){	
            $sql="SELECT IDFATENT FROM tblmvmcart where HASH='$hash' and STATUS='A';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//OPEN CART (HASH)
function open_cart_hash($dtcad,$hash,$pdo){
$sql="INSERT INTO tblmvmcart (DTCAD,HASH)VALUES('$dtcad','$hash')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//OPEN CART (HASH)
function open_cart_idusu($dtcad,$hash,$idusu,$pdo){
$sql="INSERT INTO tblmvmcart (DTCAD,HASH,IDUSU)VALUES('$dtcad','$hash','$idusu')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
			print_r($stmt->errorInfo());
}
//UPDATE CART ADD USU (ORIGIN -> LOGIN)
function upd_cart_addusu($idusu,$hash,$pdo){
			$sql="UPDATE tblmvmcart set IDUSU='$idusu' where HASH='$hash' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }
//UPDATE CART - STATUS TIPO_ENTREGA IDFPG VLRTOTAL IDCLIENTE (CHECKOUT)
function update_cart_checkout($idfatent,$status,$statusfat,$idfpg,$tipoentrega,$vlrtotal,$idcliente,$pdo){
			$sql="UPDATE tblmvmcart 
set STATUS='$status',STATUS_FAT='$statusfat',IDFPG='$idfpg',TIPO_ENTREGA='$tipoentrega',VLRTOTAL='$vlrtotal',IDCLIENTE='$idcliente'
			where IDFATENT='$idfatent' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
        }			
//BUSCAR CONFIGURAÇÕES DE MOVIMENTO
function load_cfg_mvm($pdo){	
            $sql="SELECT * FROM tblcfgmvm where 1;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//ADD ITE TO CHART 	
function add_ite_tblmvmite0($idfatent,$idlocal,$iditem,$qtde,$vlrunit,$vlrtotal,$usucad,$dtcad,$horacad,$usualt,$dtalt,$horaalt,$idcoi,$serie,$pdo){
			$sql="INSERT INTO tblmvmite0 
(IDFATENT,IDLOCAL,IDITEM,QTDE,VLRUNIT,VLRTOTAL,USUCAD,DTCAD,HORACAD,USUALT,DTALT,HORAALT,IDCOI,SERIE) 
VALUES('$idfatent','$idlocal','$iditem','$qtde','$vlrunit','$vlrtotal','$usucad','$dtcad','$horacad','$usualt','$dtalt','$horaalt','$idcoi','$serie')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
		
}
//INSERT MVMFAT0 	
function insert_mvmfat0($idfatent,$idempresa,$idcoi,$dtemissao,$vlrmerc,$vlrtotal,$horacad,$dtcad,$usucad,$idcliente,$fretepag,$pdo){
			$sql="INSERT INTO tblmvmfat0 
(IDFATENT,IDEMPRESA,IDCOI,DTEMISSAO,VLRMERC,VLRTOTAL,HORACAD,DTCAD,USUCAD,IDCLIENTE,FRETEPAG) 
VALUES('$idfatent','$idempresa','$idcoi','$dtemissao','$vlrmerc','$vlrtotal','$horacad','$dtcad','$usucad','$idcliente','$fretepag')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();		
}
//INSERT ADDRESS -> TBLMVMFAT5 
function insert_address_checkout($idfatent,$cep,$endereco,$numero,$bairro,$complemento,$idcidade,$uf,$pdo){
			$sql="INSERT INTO tblmvmfat5 (IDFATENT,CEP,ENDERECO,NUMERO,BAIRRO,COMPLEMENTO,IDCIDADE) 
VALUES('$idfatent','$cep','$endereco','$numero','$bairro','$complemento','$idcidade')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INSERT FORMA PG -> TBLMVMFAT4 
function insert_fat4_checkout($idfatent,$vlrdinheiro,$vlrduplicata,$vlrcartao,$vlrcartaodeb,$vlrcartaocre,$vlrpix,$pdo){
			$sql="INSERT INTO tblmvmfat4 
(IDFATENT,VLRDINHEIRO,VLRDUPLICATA,VLRCARTAO,VLRCARTAODEB,VLRCARTAOCRE,VLRPIX) 
VALUES('$idfatent','$vlrdinheiro','$vlrduplicata','$vlrcartao','$vlrcartaodeb','$vlrcartaocre','$vlrpix')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INSERT CLIENTE -> TBLCDSCLI0 
function insert_tblcdscli0_cadweb($idcidadecli,$razao,$cpf,$cnpj,$fone,$cep,$endereco,$numero,$bairro,$complemento,$dtcad,$horacad,$usucad,$clifor,$pdo){
			$sql="INSERT INTO tblcdscli0 
(IDCIDADECLI,RAZAO,FANTASIA,CPF,CNPJ,FONE,CEP,ENDERECO,NUMERO,BAIRRO,COMPLEMENTO,DTCAD,HORACAD,USUCAD,CLIFOR) 
VALUES('$idcidadecli','$razao','$razao','$cpf','$cnpj','$fone','$cep','$endereco','$numero','$bairro','$complemento','$dtcad','$horacad','$usucad','$clifor')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INSERT CLIENTE -> TBLCDSCLI29 
function insert_tblcdscli29_cadweb($idcliente,$endereco,$numero,$bairro,$idcidade,$complemento,$cep,$dtcad,$horacad,$usucad,$pdo){
			$sql="INSERT INTO tblcdscli29 
(IDCLIENTE,ENDERECO,NUMERO,BAIRRO,IDCIDADE,COMPLEMENTO,CEP,DTCAD,HORACAD,USUCAD,CADASTRO) 
VALUES('$idcliente','$endereco','$numero','$bairro','$idcidade','$complemento','$cep','$dtcad','$horacad','$usucad','1')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE QTDE ITE ON CART
function upd_cart_qtde_idite($idfatent,$iditem,$idchavemvi,$qtde,$vlrtotal,$pdo){
			$sql="UPDATE tblmvmite0 set QTDE='$qtde',VLRTOTAL='$vlrtotal' 
			where IDITEM='$iditem' and IDCHAVEMVI='$idchavemvi' and IDFATENT='$idfatent'  ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}	
//CARREGAR IDFATENT BY IDCHAVEMVI
function busca_idfatent_idchavemvi($idchavemvi,$pdo){
            $sql="SELECT IDFATENT FROM tblmvmite0 where IDCHAVEMVI='$idchavemvi'";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//CARREGAR IDFATENT BY IDUSU
function busca_idfatent_idusu($idusu,$idfatent,$pdo){
            $sql="SELECT IDFATENT as IDPER FROM tblmvmcart where IDUSU='$idusu' and IDFATENT='$idfatent' and STATUS='A'";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//CARREGAR IDFATENT BY HASH
function busca_idfatent_hash($hash,$idfatent,$pdo){
            $sql="SELECT IDFATENT as IDPER FROM tblmvmcart where HASH='$hash' and IDFATENT='$idfatent' and STATUS='A'";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//REMOVE ITEM BY IDCHAVEMVI
function rem_ite_idchavemvi($idchavemvi,$pdo){
			$sql="DELETE FROM tblmvmite0 where IDCHAVEMVI='$idchavemvi'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//BUSCA CLIENTE POR ID	(CHECKOUT)
function busca_cliente_id_checkout($idcliente,$pdo){	
            $sql="SELECT * FROM tblcdscli0 where IDCLIENTE='$idcliente' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}	
//BUSCA CLIENTE POR ID	(CHECKOUT)
function busca_cliente_id_checkout_end($idcliente,$pdo){	
            $sql="SELECT * FROM tblcdscli29 where IDCLIENTE='$idcliente' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}		
//BUSCA USUARIO POR ID	(CHECKOUT)
function busca_user_id_checkout($idusu,$pdo){	
            $sql="SELECT * FROM tblcdsucl where id='$idusu' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CIDADE / UF POR IDCIDADE (CHECKOUT)	
function busca_cidade_id_checkout($idcidade,$pdo){	
            $sql="SELECT CIDADE,UF FROM tblcdscid0 where idcidade='$idcidade' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//ADD ITE (CADASTRO WEB) CDSITE0 -----------------------------
function insert_ite0_cadweb($idempresa,$idsecao,$nomepro,$nomecom,$marca,$undvend1,$peso,$horacad,$dtcad,$usucad,$comprimento,$largura,$altura,$pdo){
$sql="INSERT INTO tblcdsite0 
(IDEMPRESA,IDSECAO,NOMEPRO,NOMECOM,MARCA,UNDVEND1,PESOLIQ,PESOBRU,HORACAD,DTCAD,USUCAD,COMPRIMENTO,LARGURA,ALTURA)
VALUES('$idempresa','$idsecao','$nomepro','$nomecom','$marca','$undvend1','$peso','$peso','$horacad','$dtcad','$usucad','$comprimento',
'$largura','$altura')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//BUSCA IDITEM (CADASTRO WEB) DTCAD/HORACAD (CDSITE0)
function busca_ite_dtcad_horacad($nomepro,$dtcad,$horacad,$pdo){	
            $sql="SELECT IDITEM FROM tblcdsite0 where nomepro='$nomepro' and DTCAD='$dtcad' and HORACAD='$horacad' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//ADD PRECO (CADASTRO WEB)
function insert_pre1_cadweb($idtabela,$preco,$dtcad,$horacad,$usucad,$iditem,$precobase,$pdo){
$sql="INSERT INTO tblcdspre1 
(IDTABELA,PRECO,DTCAD,HORACAD,USUCAD,USUALT,DTALT,HORAALT,IDITEM,PRECOBASE)
VALUES('$idtabela','$preco','$dtcad','$horacad','$usucad','$usucad','$dtcad','$horacad','$iditem','$precobase')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//ADD PRECO (CADASTRO WEB)
function insert_ite3_cadweb($iditem,$modoapl,$pdo){
$sql="INSERT INTO tblcdsite3 (IDITEM,MODOAPL) VALUES('$iditem','$modoapl')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//CADASTRO DE SECAO (CADASTRO WEB) ------------------
function insert_secao_cadweb($idsecao,$secao,$dtcad,$horacad,$usucad,$pdo){
$sql="INSERT INTO tblcdssec0 (IDSECAO,SECAO,DTCAD,HORACAD,USUCAD) VALUES('$idsecao','$secao','$dtcad','$horacad','$usucad')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE DE SECAO (CADASTRO WEB) ------------------
function update_secao_cadweb($idsecao,$secao,$dtalt,$horaalt,$usualt,$pdo){
$sql="UPDATE tblcdssec0 SET SECAO='$secao',DTALT='$dtalt',HORAALT='$horaalt',USUALT='$usualt' WHERE IDSECAO='$idsecao'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}		
//UPDATE CADASTRO EMPRESA (CADASTRO WEB) ------------------
function update_emp0_cadweb($idempresa,$razao,$fantasia,$cnpj,$fone,$email,$endereco,$numero,$bairro,$idcidade,$pdo){
$sql="UPDATE tblcdsemp0 
SET RAZAOSOCIAL='$razao',FANTASIA='$fantasia',CNPJ='$cnpj',FONE='$fone',EMAIL='$email',ENDERECO='$endereco',NUMERO='$numero',BAIRRO='$bairro',  
IDCIDADE='$idcidade'
WHERE IDEMPRESA='$idempresa'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}	
//UPDATE CFG INT ------------------
function update_cfg_int($idcfg,$valor,$pdo){
$sql="UPDATE tblcfgint SET valor='$valor' WHERE idcfg='$idcfg'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}	
//LISTA ITENS ALL (CADASTRO WEB)
function lista_itens_all($pdo){	
            $sql="SELECT * FROM tblcdsite0 where STATUS='A' and EXPPDA='1';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA ITENS ALL (CADASTRO WEB)
function busca_generica_itens($generica,$pdo){	
            $genericaU=strtoupper($generica);
            $genericaC=ucwords($generica);
            $genericaL=strtolower($generica);
            $sql="SELECT * FROM tblcdsite0 where
			NOMEPRO LIKE '%$generica%' or
            NOMEPRO LIKE '%$genericaU%' or
            NOMEPRO LIKE '%$genericaC%' or
            NOMEPRO LIKE '%$genericaL%' or
			
			NOMECOM LIKE '%$generica%' or
            NOMECOM LIKE '%$genericaU%' or
            NOMECOM LIKE '%$genericaC%' or
            NOMECOM LIKE '%$genericaL%' or 
			
			IDITEM LIKE '%$generica%'
			
			and STATUS='A' and EXPPDA='1';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT ITENS ALL (CADASTRO WEB)
function count_item_full_sync($pdo){	
            $sql="SELECT count(IDITEM) as itenum FROM tblcdsite0 where STATUS='A' and EXPPDA='1';";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT ITENS ALL (CADASTRO WEB)
function count_item_full($pdo){	
            $sql="SELECT count(IDITEM) as itenum FROM tblcdsite0 where STATUS='A'";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT ITENS CART 
function count_ite_cart_topbar($idfatent,$pdo){	
            $sql="SELECT count(*) as numite FROM tblmvmite0 where IDFATENT='$idfatent'";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT CLIENTES ALL (CHECKOUT)
function count_cliente_full($pdo){	
            $sql="SELECT count(IDCLIENTE) as numcli FROM tblcdscli0";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//COUNT FAT ALL (PEDIDOS)
function count_fat0_full($pdo){	
            $sql="SELECT count(IDFATENT) as numfat0 FROM tblmvmfat0";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA CLIENTES FULL PAGINATION(CHECKOUT)
function lista_cliente_full_pagination($start_from,$iteperpage,$pdo){	
            $sql="SELECT * FROM tblcdscli0 where CLIFOR in ('C','A') LIMIT $start_from, $iteperpage";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA FATURAMENTO FULL PAGINATION(PEDIDOS)
function lista_fat0_full_pagination($start_from,$iteperpage,$pdo){	
            $sql="SELECT * FROM tblmvmfat0 where 1 order by IDFATENT DESC LIMIT $start_from, $iteperpage";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CLIENTE CADASTRO DE CLIENTE 
function busca_cliente_id_all($idcliente,$pdo){	
            $sql="SELECT * FROM tblcdscli0 where IDCLIENTE='$idcliente' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CLIENTE CADASTRO DE CLIENTE 
function busca_cliente_id_fix($idcliente,$pdo){	
            $sql="SELECT * FROM tblcdscli0 where IDCLIENTE='$idcliente' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//LISTA ITENS FULL PAGINATION(CADASTRO WEB)
function lista_item_full_pagination($start_from,$iteperpage,$pdo){	
            $sql="SELECT * FROM tblcdsite0 where 1 LIMIT $start_from, $iteperpage";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA ITEM (POR ID)
function busca_item_id($iditem,$pdo){	
            $sql="SELECT * FROM tblcdsite0 where IDITEM='$iditem' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CUSTO DO ITEM (POR ID)
function busca_custo_item_id($iditem,$empresa,$pdo){	
            $sql="SELECT CUSTO FROM tblcdsite2 where IDITEM='$iditem' and IDEMPRESA='$empresa' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CUSTO DO ITEM (POR ID)
function busca_preco_item_xtabela($iditem,$idtabela,$pdo){	
            $sql="SELECT * FROM tblcdspre1 where IDITEM='$iditem' and IDTABELA='$idtabela' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//UPDATE ITEM CDSITE0 (CADASTRO WEB) -----------------------
function update_cdsite0_cadweb($iditem,$idempresa,$idsecao,$nomepro,$nomecom,$marca,$undvend1,$peso,$horaalt,$dtalt,$usualt,$comprimento,$largura,$altura,$pdo){
$sql="UPDATE tblcdsite0 SET IDEMPRESA='$idempresa',IDSECAO='$idsecao',NOMEPRO='$nomepro',NOMECOM='$nomecom',MARCA='$marca',
UNDVEND1='$undvend1',PESOBRU='$peso',PESOLIQ='$peso',DTALT='$dtalt',HORAALT='$horaalt',USUALT='$usualt',COMPRIMENTO='$comprimento',
LARGURA='$largura',ALTURA='$altura' WHERE IDITEM='$iditem'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INSERT CUSTO (CADASTRO WEB)
function insert_ite2_cadweb($iditem,$custo,$idempresa,$pdo){
$sql="INSERT INTO tblcdsite2 (IDITEM,IDEMPRESA,CUSTO)VALUES('$iditem','$idempresa','$custo')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE CUSTO (CADASTRO WEB)
function update_ite2_cadweb($iditem,$custo,$idempresa,$pdo){
$sql="UPDATE tblcdsite2 SET CUSTO='$custo' where IDITEM='$iditem' and IDEMPRESA='$idempresa' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE PRECO X TABELA (CADASTRO WEB)
function update_pre1_cadweb($idtabela,$preco,$dtalt,$horaalt,$usualt,$iditem,$precobase,$pdo){
$sql="UPDATE tblcdspre1 SET PRECO='$preco',DTALT='$dtalt',HORAALT='$horaalt',USUALT='$usualt',PRECOBASE='$precobase' 
where IDITEM='$iditem' and IDTABELA='$idtabela' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//LISTA SEÇÕES NOT IN (CADASTRO WEB)
function lista_secoes_not_in($lista,$pdo){	
            $sql="SELECT IDSECAO,SECAO FROM tblcdssec0 where IDGRUPO=0 and IDSECAO not in ('$lista');";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//UPDATE PRECO X TABELA (CADASTRO WEB)
function update_ite3_cadweb($iditem,$modoapl,$pdo){
$sql="UPDATE tblcdsite3 SET MODOAPL='$modoapl' where IDITEM='$iditem'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INATIVA ITEM CDSITE0 (CADASTRO WEB) -----------------------
function inativa_cdsite0_cadweb($iditem,$pdo){
$sql="UPDATE tblcdsite0 SET STATUS='I' WHERE IDITEM='$iditem'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INATIVA ITEM CDSITE0 (CADASTRO WEB) -----------------------
function ativa_cdsite0_cadweb($iditem,$pdo){
$sql="UPDATE tblcdsite0 SET STATUS='A' WHERE IDITEM='$iditem'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//LISTA ITENS P/ SECAO (CADASTRO WEB)
function lista_item_idsecao_full($idsecao,$pdo){	
            $sql="SELECT * FROM tblcdsite0 where IDSECAO='$idsecao'";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//BUSCA CIDADE / UF POR IDCIDADE (CONFIGURAÇÃO INTERNA)	
function busca_cidade_uf($pdo){	
            $sql="SELECT IDCIDADE,CIDADE,UF FROM tblcdscid0 where 1 order by CIDADE";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//UPDATE SALDO ITE CASDASTRO WEB -------------------------------
function update_tblsdoite1_cadweb($iditem,$idempresa,$saldo,$pdo){
$sql="UPDATE tblsdoite1 SET SALDO='$saldo',SALDOLIQ='$saldo' WHERE IDITEM='$iditem' and IDEMPRESA='$idempresa' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE LOG DE MOVIMENTO DE SALDO ITE CASDASTRO WEB -------------------------------
function insert_tblsdoitelog_cadweb($iditem,$qtd,$custo,$idempresa,$dtcad,$horacad,$usucad,$tipomvm,$motivo,$pdo){
$sql="INSERT INTO tblsdoitelog (iditem,qtd,custo,idempresa,dtcad,horacad,usucad,tipomvm,motivo)
VALUES('$iditem','$qtd','$custo','$idempresa','$dtcad','$horacad','$usucad','$tipomvm','$motivo')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//INSERE SALDO ITE INICIAL CASDASTRO WEB -------------------------------
function insert_tblsdoite1_cadweb($iditem,$idempresa,$saldo,$pdo){
$sql="INSERT INTO tblsdoite1 (IDEMPRESA,IDITEM,SALDO,SALDOLIQ)
VALUES('$idempresa','$iditem','$saldo','$saldo')";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
			print_r($stmt->errorInfo());
}
//LOAD DYNAMIC BANNER ----------------------------------------------------------------
function busca_banner_id($id,$pdo){	
            $sql="SELECT * FROM tblcdsbanner where id='$id' ;";
			$busca=$pdo->query($sql);
			$line=$busca->fetchAll(PDO::FETCH_ASSOC);
			return $line;
}
//UPDATE BANNER HEADER
function update_banner($id,$title,$descricao,$pdo){
$sql="UPDATE tblcdsbanner SET title='$title',descricao='$descricao' WHERE id='$id'  ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE BANNER MODO 
function update_banner_modo($id,$modo,$pdo){
$sql="UPDATE tblcdsbanner SET modo='$modo' WHERE id='$id'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE BANNER CATEGORIA 
function update_banner_categoria($id,$categoria,$pdo){
$sql="UPDATE tblcdsbanner SET idcategoria='$categoria' WHERE id='$id'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE BANNER IDITEM 
function update_banner_iditem($id,$iditem,$pdo){
$sql="UPDATE tblcdsbanner SET iditem='$iditem' WHERE id='$id'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
//UPDATE BANNER TERMO 
function update_banner_termo($id,$termo,$pdo){
$sql="UPDATE tblcdsbanner SET termo='$termo' WHERE id='$id'";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}


}

// print_r($stmt->errorInfo()); //debug
?>