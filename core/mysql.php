<?php 
//LEASING SQL 
require "conn_MYSQL.php";

class localsql{
//AUTH	
function auth($login,$senha,$pdo){	
            $sql="SELECT * FROM tblcdsusu where login='$login' and senha='$senha' ";
			$busca=$pdo->query($sql);
			$line=$busca->fetch(PDO::FETCH_ASSOC);
			return $line;
}
//INSERT CEDENTE
function cadastro_pessoa($cpf,$cnpj,$razao,$rgie,$telefone,$celular,$email,$tipo,$limite_credito,$dias_min_op_cheque,$dias_min_op_duplicata,$fator_cheque,$multa_boleto,$juros_dia_boleto,$cep,$endereco,$complemento,$bairro,$cidade,$status,$pdo){
	$sql="INSERT INTO tblcdsced1 
	(cpf,cnpj,razao,rgie,telefone,celular,email,tipo,limite_credito,dias_min_op_cheque,dias_min_op_duplicata,fator_cheque,multa_boleto,juros_dia_boleto,cep,endereco,complemento,bairro,cidade,status)
	VALUES('$cpf','$cnpj','$razao','$rgie','$telefone','$celular','$email','$tipo','$limite_credito','$dias_min_op_cheque','$dias_min_op_duplicata','$fator_cheque','$multa_boleto','$juros_dia_boleto','$cep','$endereco','$complemento','$bairro','$cidade','$status')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//INSERT CEDENTE
function cadastro_operacao($tipo_op,$juros,$calculo,$idcedente,$data,$pdo){
	$sql="INSERT INTO tblmvmope1 
	(tipo_ope,tipo_juros,tipo_calculo,idcedente,data)
	VALUES('$tipo_op','$juros','$calculo','$idcedente','$data')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//BUSCA CEDENTES ALL
function busca_cendente($pdo){	
	$sql="SELECT * FROM tblcdsced1 where 1;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
function busca_pessoa_id($id,$pdo){	
	$sql="SELECT * FROM tblcdsced1 where id='$id';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA CEDENTES ONLY
function busca_cendente_only($pdo){	
	$sql="SELECT * FROM tblcdsced1 where tipo in ('C','A');";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA SACADO ONLY
function busca_sacado_only($pdo){	
	$sql="SELECT * FROM tblcdsced1 where tipo in ('S','A') ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA CEDENTES ID
function busca_cendente_id($idcedente,$pdo){	
	$sql="SELECT razao FROM tblcdsced1 where id='$idcedente';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA SACADO ID
function busca_sacado_id($idsacado,$pdo){	
	$sql="SELECT razao FROM tblcdsced1 where id='$idsacado';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA LAST OPERACAO
function busca_ultima_ope_idcedente($idcedente,$pdo){	
	$sql="SELECT idope FROM tblmvmope1 where idcedente='$idcedente' order by idope desc limit 1;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA LAST OPERACAO
function busca_ope_idpessoa($id,$pdo){	
	$sql="SELECT idope FROM tblmvmope1 where idcedente='$id' order by idope desc limit 1;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA BANCOS ALL
function busca_bancos($pdo){	
	$sql="SELECT * FROM tblcdsban1 where 1;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA BANCOS ID
function busca_bancos_id($idbanco,$pdo){	
	$sql="SELECT * FROM tblcdsban1 where idbanco='$idbanco';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//INSERT DUPLICATA
function mvm_duplicata($idmvmop1,$nroduplicata,$valor,$fator,$iof,$advalorem,$maisdias,$idsacado,$dt_emissao,$dt_vencimento,$status,$dt_status,$pdo){
	$sql="INSERT INTO tblmvmdup1 
	(idmvmop1,nroduplicata,valor,dt_vencimento,fator,iof,advalorem,maisdias,dt_emissao,idsacado,status,dt_status)
	VALUES('$idmvmop1','$nroduplicata','$valor','$dt_vencimento','$fator','$iof','$advalorem','$maisdias','$dt_emissao','$idsacado','$status','$dt_status')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	print_r($stmt->errorInfo()); //debug
}
//INSERT CHEQUE
function mvm_cheque($idmvmop1,$idbanco,$agencia,$nroconta,$nrocheque,$valor,$fator,$iof,$advalorem,$maisdias,$numero_parcelas,$idsacado,$dt_emissao,$dt_vencimento,$status,$dt_status,$pdo){
	$sql="INSERT INTO tblmvmche1 
	(idmvmop1,idbanco,agencia,nroconta,nrocheque,valor,fator,iof,advalorem,maisdias,numero_parcelas,idsacado,dt_emissao,dt_vencimento,status,dt_status)
	VALUES('$idmvmop1','$idbanco','$agencia','$nroconta','$nrocheque','$valor','$fator','$iof','$advalorem','$maisdias','$numero_parcelas','$idsacado','$dt_emissao','$dt_vencimento','$status','$dt_status')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	print_r($stmt->errorInfo()); //debug
}
//BUSCA OPERACOES DASHBOARD
function busca_ope_dashboard($dashnumreg,$pdo){	
	$sql="SELECT * FROM tblmvmope1 where 1 order by idope DESC limit $dashnumreg;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA OPERACOES DASHBOARD
function busca_ope_dashboard_filter_date($pdo){	
	$dsini=$_SESSION['dtini'];
    $dsfin=$_SESSION['dtfin']; 
	$sql="SELECT * FROM tblmvmope1 where  data >= '$dsini' and data <='$dsfin'  order by idope DESC;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA INFO PARA RELATORIO
function busca_relatorio_1($dateini, $datefin, $pdo){	
	$sql="SELECT * FROM tblmvmope1 where  data >= '$dateini' and data <='$datefin' and status='2'  order by idope DESC;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SUM LUCRO PREVISTO DASH
function relatorio1_lucro_previsto($dateini,$datefin,$pdo){	
	$sql="SELECT sum(vlr_operacao) as totalope,sum(vlr_pago) as totalpg FROM tblmvmope1 where data >= '$dateini' and data <='$datefin' and status in ('2') ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SUM RECEITA PREVISTO DASH
function relatorio1_soma_receitas_only($dateini,$datefin,$pdo){	
	$sql="SELECT sum(valor) as totalrece FROM tblmvmfin1 where historico not in ('2','3') and emissao >= '$dateini' and emissao <='$datefin' and tipo_mvm='E' and status='2' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//COUNT DUPLICATAS POR IDOPE
function count_duplicata_idope($idope,$pdo){	
	$sql="SELECT COUNT(*) as countdup FROM tblmvmdup1 where idmvmop1='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SOMA VALOR DAS DUPLICATAS POR IDOPE
function sum_duplicata_idope($idope,$pdo){	
	$sql="SELECT sum(`valor`) as `sumduplicatadas` FROM `tblmvmdup1` where idmvmop1='$idope' ";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//COUNT CHEQUE POR IDOPE
function count_cheque_idope($idope,$pdo){	
	$sql="SELECT COUNT(*) as countche FROM tblmvmche1 where idmvmop1='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SOMA VALOR DOS CHEQUES POR IDOPE
function sum_cheque_idope($idope,$pdo){	
	$sql="SELECT sum(`valor`) as `sumcheques` FROM `tblmvmche1` where idmvmop1='$idope' ";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//COUNT PARCELAS DO CARNE POR IDOPE
function count_carne_idope($idope,$pdo){	
	$sql="SELECT COUNT(*) as countcar FROM tblmvmfinprop2 where idope='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SOMA VALOR DAS PARCELAS DO CARNE POR IDOPE
function sum_carne_idope($idope,$pdo){	
	$sql="SELECT sum(`valor`) as `sumparcelas` FROM `tblmvmfinprop2` where idope='$idope' ";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA OPERACAO POR ID
function busca_ope_idope($idope,$pdo){	
	$sql="SELECT * FROM tblmvmope1 where idope='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DUPLICATAS POR IDOPE
function busca_duplicata_idope($idope,$pdo){	
	$sql="SELECT * FROM tblmvmdup1 where idmvmop1='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA CHEQUE POR IDOPE
function busca_cheque_idope($idope,$pdo){	
	$sql="SELECT * FROM tblmvmche1 where idmvmop1='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA CFG POR ID
function busca_cfgint_id($idcfg,$pdo){	
	$sql="SELECT * FROM tblcfgint where idcfg='$idcfg' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE CFG ID
function update_cfg_id($idcfg,$value,$pdo){
			$sql="UPDATE tblcfgint set value='$value' where idcfg='$idcfg' ";
			$stmt=$pdo->prepare($sql);
			$stmt->execute();
}
// UPDATE VLR_OPERACAO , VLR_PAGO 
function update_vlr_idope($idope,$vlr_operacao,$vlr_pago,$pdo){
	$sql="UPDATE tblmvmope1 set vlr_pago='$vlr_pago',vlr_operacao='$vlr_operacao' where idope='$idope' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//INSERT CHEQUE
function insert_tblmvmope1_log($idmvmop1,$acao,$date,$idlogin,$pdo){
	$sql="INSERT INTO tblmvmope1_log 
	(idmvmop1,acao,date,idlogin)
	VALUES('$idmvmop1','$acao','$date','$idlogin')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	//print_r($stmt->errorInfo()); //debug
}

//lista log idope
function lista_log_idope($idope,$pdo){	
	$sql="SELECT * FROM tblmvmope1_log where idmvmop1='$idope' order by seq desc;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE STATUS
function update_status_idope($status,$idope,$pdo){
	$sql="UPDATE tblmvmope1 set status='$status' where idope='$idope' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//BUSCA PESSOAS ALL
function busca_pessoas_all($pdo){	
	$sql="SELECT * FROM tblcdsced1 where 1 ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE PESSOA
function update_pessoa($id,$cpf,$cnpj,$razao,$rgie,$telefone,$celular,$email,$tipo,$limite_credito,$dias_min_op_cheque,$dias_min_op_duplicata,$fator_cheque,$multa_boleto,$juros_dia_boleto,$cep,$endereco,$complemento,$bairro,$cidade,$status,$pdo){
	$sql="UPDATE tblcdsced1 set cpf='$cpf',cnpj='$cnpj',razao='$razao',rgie='$rgie',telefone='$telefone',celular='$celular',email='$email',tipo='$tipo',limite_credito='$limite_credito',
	dias_min_op_cheque='$dias_min_op_cheque',dias_min_op_duplicata='$dias_min_op_duplicata',fator_cheque='$fator_cheque',multa_boleto='$multa_boleto',juros_dia_boleto='$juros_dia_boleto',
	cep='$cep',endereco='$endereco',complemento='$complemento',bairro='$bairro',cidade='$cidade',status='$status' where id='$id' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
function busca_nome_login_log($idlogin,$pdo){	
	$sql="SELECT nome FROM tblcdsusu where id='$idlogin'";
	$busca=$pdo->query($sql);
	$line=$busca->fetch(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA OPERACOES LAST 5 IDCEDENTE
function last_ope_idcedente($idcedente,$pdo){	
	$sql="SELECT * FROM tblmvmope1 where idcedente='$idcedente' order by idope DESC limit 7;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS ALL
function busca_despesas_all($pdo){	
	$sql="SELECT * FROM tblmvmfin1 where 1 ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS ALL
function busca_despesas_date($dtini,$dtfin,$pdo){	
	$sql="SELECT * FROM tblmvmfin1 where  emissao >= '$dtini' and emissao <='$dtfin' and tipo_mvm='S' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS ALL
function busca_mvm_financeiro_all($dtini,$dtfin,$pdo){	
	$sql="SELECT * FROM tblmvmfin1 where 1 and emissao >= '$dtini' and emissao <='$dtfin' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS ALL
function busca_despesas_date_tela_saida($dtini,$dtfin,$pdo){	
	$sql="SELECT * FROM tblmvmfin1 where historico not in ('600','601') and emissao >= '$dtini' and emissao <='$dtfin' and tipo_mvm='S' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA RECEITAS ALL
function busca_receitas_date($dtini,$dtfin,$pdo){	
	$sql="SELECT * FROM tblmvmfin1 where  emissao >= '$dtini' and emissao <='$dtfin' and tipo_mvm='E' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA RECEITAS TELA DE ENTRADAS
function busca_receitas_date_tela_entrada($dtini,$dtfin,$pdo){	
	$sql="SELECT * FROM tblmvmfin1 where  historico not in ('2','3') and emissao >= '$dtini' and emissao <='$dtfin' and tipo_mvm='E' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA HISTORICOS ALL
function busca_historicos_all($pdo){	
	$sql="SELECT * FROM tblcdshis1 where 1 ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS ALL
function busca_historicos_despesa_all($pdo){	
	$sql="SELECT * FROM tblcdshis1 where tipo_mvm='S' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS ALL
function busca_historicos_receita_all($pdo){	
	$sql="SELECT * FROM tblcdshis1 where tipo_mvm='E' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SUM LUCRO PREVISTO DASH
function dash_lucro_previsto($dsini,$dtfin,$pdo){	
	$sql="SELECT sum(vlr_operacao) as totalope,sum(vlr_pago) as totalpg FROM tblmvmope1 where data >= '$dsini' and data <='$dtfin' and status in ('2') ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SUM TOTAL ENTRADA DASH
function dash_soma_receitas($dsini,$dtfin,$pdo){	
	$sql="SELECT sum(valor) as totalrece FROM tblmvmfin1 where emissao >= '$dsini' and emissao <='$dtfin' and tipo_mvm='E' and status='2' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//SUM RECEITA PREVISTO DASH
function dash_soma_receitas_only($dsini,$dtfin,$pdo){	
	$sql="SELECT sum(valor) as totalrece FROM tblmvmfin1 where historico not in ('2','3') and emissao >= '$dsini' and emissao <='$dtfin' and tipo_mvm='E' and status='2' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS DASH
function dash_despesas($dsini,$dtfin,$pdo){	
	$sql="SELECT sum(valor) as totaldesp FROM tblmvmfin1 where emissao >= '$dsini' and emissao <='$dtfin' and status='2' and tipo_mvm='S' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DUPLICATA POR SEQ
function busca_duplicata_seq($seq,$pdo){	
	$sql="SELECT * FROM tblmvmdup1 where seq='$seq';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA CHEQUE POR SEQ
function busca_cheque_seq($seq,$pdo){	
	$sql="SELECT * FROM tblmvmche1 where seq='$seq';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE MVM DUPLICATA
function upd_mvm_duplicata($seq,$nroduplicata,$valor,$fator,$iof,$advalorem,$maisdias,$idsacado,$dt_emissao,$dt_vencimento,$status,$dt_status,$pdo){
	$sql="UPDATE tblmvmdup1 set nroduplicata='$nroduplicata',valor='$valor',fator='$fator',iof='$iof',advalorem='$advalorem',maisdias='$maisdias',idsacado='$idsacado',
	dt_emissao='$dt_emissao',dt_vencimento='$dt_vencimento',status='$status',dt_status='$dt_status' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
// UPDATE MVM CHEQUE
function upd_mvm_cheque($seq,$idbanco,$agencia,$nroconta,$nrocheque,$valor,$fator,$iof,$advalorem,$maisdias,$idsacado,$dt_emissao,$dt_vencimento,$status,$dt_status,$pdo){
	$sql="UPDATE tblmvmche1 set idbanco='$idbanco',agencia='$agencia',nroconta='$nroconta',nrocheque='$nrocheque',valor='$valor',fator='$fator',iof='$iof',advalorem='$advalorem',maisdias='$maisdias',idsacado='$idsacado',
	dt_emissao='$dt_emissao',dt_vencimento='$dt_vencimento',status='$status',dt_status='$dt_status' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//DELETE CHEQUES por id
function delete_cheque_idmvmop1($idmvmop1,$pdo){
	$sql="DELETE FROM tblmvmche1 where idmvmop1='$idmvmop1' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//DELETE CHEQUES por seq
function delete_cheque_seq($seq,$pdo){
	$sql="DELETE FROM tblmvmche1 where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//DELETE DUPLICATAS por id
function delete_duplicata_idmvmop1($idmvmop1,$pdo){
	$sql="DELETE FROM tblmvmdup1 where idmvmop1='$idmvmop1' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//DELETE DUPLICATAS por seq
function delete_duplicata_seq($seq,$pdo){
	$sql="DELETE FROM tblmvmdup1 where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//DELETE OPERACOES
function delete_operacao_idope($idope,$pdo){
	$sql="DELETE FROM tblmvmope1 where idope='$idope' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//INSERT DESPESA
function add_despesa($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdo){
	$sql="INSERT INTO tblmvmfin1 
	(historico,descricao,valor,emissao,idlogin,tipo_mvm,status)
	VALUES('$historico','$descricao','$valor','$emissao','$idlogin','$tipo_mvm','$status')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	print_r($stmt->errorInfo()); //debug
}
//INSERT MVM FINANCEIRO
function add_movimento_financeiro($historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdo){
	$sql="INSERT INTO tblmvmfin1 
	(historico,descricao,valor,emissao,idlogin,tipo_mvm,status)
	VALUES('$historico','$descricao','$valor','$emissao','$idlogin','$tipo_mvm','$status')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	//print_r($stmt->errorInfo()); //debug
}
//BUSCA HISTORICO POR ID
function busca_historico_id($idhistorico,$pdo){	
	$sql="SELECT * FROM tblcdshis1 where idhistorico='$idhistorico';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DESPESAS POR ID
function busca_despesa_seq($seq,$pdo){	
	$sql="SELECT * FROM tblmvmfin1 where seq='$seq';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE DESPESAS POR SEQ
function upd_despesa_seq($seq,$historico,$descricao,$valor,$emissao,$idlogin,$tipo_mvm,$status,$pdo){
	$sql="UPDATE tblmvmfin1 set historico='$historico',descricao='$descricao',valor='$valor',emissao='$emissao',idlogin='$idlogin',tipo_mvm='$tipo_mvm',status='$status' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
// UPDATE DESPESAS POR SEQ (EXCLUIR)
function upd_mvmfin1_seq_excluir($seq,$idlogin,$pdo){
	$sql="UPDATE tblmvmfin1 set cancelado='1',idlogin_cancel='$idlogin' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//COUNT PESSOAL ALL (PAGINATION)
function count_pessoas_full($pdo){	
	$sql="SELECT count(id) as numpessoas FROM tblcdsced1 where 1";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA PESSOAS ALL
function busca_pessoas_all_pagination($start_from,$iteperpage,$pdo){	
	$sql="SELECT * FROM tblcdsced1 where 1 LIMIT $start_from, $iteperpage;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA GENERICA DE PESSOAS
function busca_generica_pessoas($generica,$pdo){	
	$sql="SELECT * FROM tblcdsced1 where UPPER(razao) like '%$generica%';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DE PESSOAS POR ID
function busca_generica_pessoas_id($id,$pdo){	
	$sql="SELECT * FROM tblcdsced1 where id='$id' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//LISTA TITULOS - DEFAULT
function lista_titulos_tela_baixa($pdo){	
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop, valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status
	from tblmvmche1 c 
	where 1 
	
	union all 
	
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status
	from tblmvmdup1 d 
	where 1
    
    union all 
    
    select seq, idope as idmvmop1, null as nrocheque,  null as nroduplicata,idmvmfinprop,valor,null as fator,null as iof,null as advalorem,emissao as dt_emissao,dt_vencimento,idsacado,status
	from tblmvmfinprop2 
	where 1
       
	order by dt_emissao DESC LIMIT 20
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//LISTA TITULOS - DEFAULT
function lista_titulos_tela_baixa_filter($filter1,$filter2,$filter3,$pdo){	
	if($filter3==""){
		$orderby=" order by dt_emissao DESC ";
	}
	else{
		$orderby=" order by dt_vencimento";
	}
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop, valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status
	from tblmvmche1 c 
	$filter1 $filter2 $filter3
	
	union all 
	
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status
	from tblmvmdup1 d 
	$filter1 $filter2 $filter3
    
    union all 
    
    select seq, idope as idmvmop1, null as nrocheque,  null as nroduplicata,idmvmfinprop,valor,null as fator,null as iof,null as advalorem,emissao as dt_emissao,dt_vencimento,idsacado,status
	from tblmvmfinprop2 
	$filter1 $filter2 $filter3
       
	$orderby
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//LISTA TITULOS - TELA DE BAIXA
function lista_titulos_tela_baixa_seq($seq,$nrocheque,$nroduplicata,$pdo){	
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status
	from tblmvmche1 c 
	where  c.nrocheque='$nrocheque' and seq='$seq'
	
	union all 
	
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status
	from tblmvmdup1 d 
	where d.nroduplicata='$nroduplicata' and seq='$seq'
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//LISTA TITULOS - TELA DE BAIXA
function lista_titulos_tela_baixa_seq_full($seq,$nrocheque,$nroduplicata,$idmvmfinprop,$pdo){	
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,null as parcela,status
	from tblmvmche1 c 
	where  c.nrocheque='$nrocheque' and seq='$seq'
	
	union all 
	
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,null as parcela,status
	from tblmvmdup1 d 
	where d.nroduplicata='$nroduplicata' and seq='$seq'
	
	union all 
	
	select seq, f.idope as idmvmop1, null as nrocheque, null as nroduplicata,f.idmvmfinprop, valor, null as fator,null as iof, null as advalorem, emissao as dt_emissao,dt_vencimento,idsacado,parcela,status
	from tblmvmfinprop2 f
	where f.idmvmfinprop='$idmvmfinprop' and seq='$seq'
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE MVM CHEQUE BAIXA
function upd_cheque_baixa($seq,$dt_status,$pdo){
	$sql="UPDATE tblmvmche1 set status='2',dt_status='$dt_status' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
// UPDATE MVM DUPLICATA BAIXA
function upd_duplicata_baixa($seq,$dt_status,$pdo){
	$sql="UPDATE tblmvmdup1 set status='2',dt_status='$dt_status' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
// UPDATE MVM CARNE BAIXA
function upd_carne_baixa($seq,$dt_status,$pdo){
	$sql="UPDATE tblmvmfinprop2 set status='2',dt_status='$dt_status' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//BUSCA DESPESAS DASH
function sum_titulos_recebidos_periodo($pdo){	
	$dtini=$_SESSION['dtini'];
    $dsfin=$_SESSION['dtfin']; 
	$sql="SELECT sum(valor) as totalbaixa FROM tblmvmfin1 where historico in ('2','3') and emissao >= '$dtini' and emissao <='$dsfin' and status='2' and cancelado='0' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA OPERACOES ID - DETALHES PESSOA
function busca_generica_operacoes_pessoas_id($id,$pdo){	
	$dtini=$_SESSION['dtini'];
    $dsfin=$_SESSION['dtfin']; 
	$sql="SELECT  `idope` as idmvmope1 FROM `tblmvmope1` WHERE `idcedente`='$id' and data >= '$dtini' and data <='$dsfin'
	UNION ALL
	SELECT distinct `idmvmop1`  FROM `tblmvmche1` WHERE `idsacado`='$id'  and `idmvmop1` not in (SELECT  `idope` as idmvmope1 FROM `tblmvmope1` WHERE `idcedente`='$id')
	UNION ALL
	SELECT distinct `idmvmop1`  FROM `tblmvmdup1` WHERE `idsacado`='$id'  and `idmvmop1` not in (SELECT  `idope` as idmvmope1 FROM `tblmvmope1` WHERE `idcedente`='$id')
    and `idmvmop1` not in (SELECT distinct `idmvmop1`  FROM `tblmvmche1` WHERE `idsacado`='$id') 
	UNION ALL
	SELECT distinct `idope` as idmvmop1  FROM `tblmvmfinprop1` WHERE `idsacado`='$id'  
	and `idope` not in (SELECT  `idope` as idmvmope1 FROM `tblmvmope1` WHERE `idcedente`='$id') 
	and `idope` not in (SELECT distinct `idmvmop1`  FROM `tblmvmche1` WHERE `idsacado`='$id') 
	and `idope` not in (SELECT distinct `idmvmop1`  FROM `tblmvmdup1` WHERE `idsacado`='$id') 
    
    group by idmvmop1
    order by 1 DESC;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
	print_r($pdo->errorInfo()); //debug

}
//BUSCA OPERACOES CEDENTE ID - DETALHES PESSOA
function busca_generica_operacoes_x_cedente($id,$pdo){	
	$dtini=$_SESSION['dtini'];
    $dsfin=$_SESSION['dtfin']; 
	$sql="SELECT  `idope` as idmvmope1 FROM `tblmvmope1` WHERE `idcedente`='$id' and data >= '$dtini' and data <='$dsfin'
    order by 1 DESC;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//COUNT CEDENTES
function count_cedentes_ativos($pdo){	
	$sql="SELECT count(id) as totalnumcedente FROM tblcdsced1 where tipo in ('C') and status='1' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//COUNT SACADOS
function count_sacados_ativos($pdo){	
	$sql="SELECT count(id) as totalnumsacado FROM tblcdsced1 where tipo in ('S') and status='1' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//COUNT AMBOS
function count_ambos_ativos($pdo){	
	$sql="SELECT count(id) as totalnumambos FROM tblcdsced1 where tipo in ('A') and status='1' ;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
// UPDATE DT VENCIMENTO CHEQUE
function upd_cheque_pro_vencimento($seq,$dt_vencimento,$pdo){
	$sql="UPDATE tblmvmche1 set dt_vencimento='$dt_vencimento' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
// UPDATE DT VENCIMENTO DUPLICATA BAIXA
function upd_duplicata_pro_vencimento($seq,$dt_vencimento,$pdo){
	$sql="UPDATE tblmvmdup1 set dt_vencimento='$dt_vencimento' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
// UPDATE DT VENCIMENTO DUPLICATA BAIXA
function upd_carne_pro_vencimento($seq,$dt_vencimento,$pdo){
	$sql="UPDATE tblmvmfinprop2 set dt_vencimento='$dt_vencimento' where seq='$seq' ";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
}
//INSERT FINANCIAMENTO HEADER
function add_tblmvmfinprop1($idope,$idsacado,$valor,$fator,$iof,$advalorem,$numero_parcelas,$primeira_parcela,$intervalo_parcelas,$valor_parcela,$total,$emissao,$status,$pdo){
	$sql="INSERT INTO tblmvmfinprop1 
	(idope,idsacado,valor,fator,iof,advalorem,numero_parcelas,primeira_parcela,intervalo_parcelas,valor_parcela,total,emissao,status)
	VALUES('$idope','$idsacado','$valor','$fator','$iof','$advalorem','$numero_parcelas','$primeira_parcela','$intervalo_parcelas','$valor_parcela','$total','$emissao','$status')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
	//print_r($stmt->errorInfo()); //debug
}
//BUSCA HISTORICO POR ID
function busca_idmvmfinprop($idope,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop1 where idope='$idope' order by idmvmfinprop DESC limit 1;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//INSERT FINANCIAMENTO PERCELAS
function add_tblmvmfinprop2($idope,$idmvmfinprop,$idsacado,$parcela,$valor,$dt_vencimento,$emissao,$status,$pdo){
	$sql="INSERT INTO tblmvmfinprop2 
	(idope,idmvmfinprop,idsacado,parcela,valor,dt_vencimento,emissao,status,dt_status)
	VALUES('$idope','$idmvmfinprop','$idsacado','$parcela','$valor','$dt_vencimento','$emissao','$status','$emissao')";
	$stmt=$pdo->prepare($sql);
	$stmt->execute();
//	print_r($stmt->errorInfo()); //debug
}
//BUSCA FINPRO HEADER
function busca_tblmvmfinprop1_idope($idope,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop1 where idope='$idope';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA DUPLICATAS POR IDOPE
function busca_tblmvmfinprop2($idmvmfinprop,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop2 where idmvmfinprop='$idmvmfinprop' order by parcela;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA tblmvmfinprop2 
function busca_tblmvmfinprop2_seq($idmvmfinprop,$seq,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop2 where idmvmfinprop='$idmvmfinprop' and seq='$seq';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA tblmvmfinprop2 
function busca_tblmvmfinprop2_seq_only($seq,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop2 where seq='$seq';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA tblmvmfinprop1
function busca_tblmvmfinprop1_seq($idmvmfinprop,$seq,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop1 where idmvmfinprop='$idmvmfinprop';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//BUSCA tblmvmfinprop1
function busca_tblmvmfinprop1_idmvmfinprop($idmvmfinprop,$pdo){	
	$sql="SELECT * FROM tblmvmfinprop1 where idmvmfinprop='$idmvmfinprop';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 2 - TITULOS A VENCER
function relatorio2_titulos_a_vencer($pdo){	
	$current_date=date('ymd');
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop, valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status from tblmvmche1 c 
	where `dt_vencimento` > '$current_date' and status='1'
	union all 
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status from tblmvmdup1 d 
	where `dt_vencimento` > '$current_date' and status='1'
	union all 
	select seq, idope as idmvmop1, null as nrocheque, null as nroduplicata,idmvmfinprop,valor,null as fator,null as iof,null as advalorem,emissao as dt_emissao,dt_vencimento,idsacado,status from tblmvmfinprop2 
	where `dt_vencimento` > '$current_date' and status='1'
	order by dt_vencimento 
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//REALTORIO 3 - TITULOS VENCIDOS 
function relatorio3_titulos_vencidos($pdo){	
	$current_date=date('ymd');
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop, valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status from tblmvmche1 c 
	where `dt_vencimento` < '$current_date' and status='1'
	union all 
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status from tblmvmdup1 d 
	where `dt_vencimento` < '$current_date' and status='1'
	union all 
	select seq, idope as idmvmop1, null as nrocheque, null as nroduplicata,idmvmfinprop,valor,null as fator,null as iof,null as advalorem,emissao as dt_emissao,dt_vencimento,idsacado,status from tblmvmfinprop2 
	where `dt_vencimento` < '$current_date' and status='1'
	order by dt_vencimento 
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}

//REALTORIO 4 LISTA OPERAÇÔES 
function relatorio4_ope_idcedente($idcedente,$pdo){	
	$sql="SELECT * FROM tblmvmope1 where idcedente='$idcedente' order by idope;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - TITULOS A VENCER
function relatorio4_titulos_a_vencer($idope,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop, valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status from tblmvmche1 c 
	where `dt_vencimento` > '$current_date' and status='1' and idmvmop1='$idope'
	union all 
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status from tblmvmdup1 d 
	where `dt_vencimento` > '$current_date' and status='1'  and idmvmop1='$idope'
	union all 
	select seq, idope as idmvmop1, null as nrocheque, null as nroduplicata,idmvmfinprop,valor,null as fator,null as iof,null as advalorem,emissao as dt_emissao,dt_vencimento,idsacado,status from tblmvmfinprop2 
	where `dt_vencimento` > '$current_date' and status='1'  and idope='$idope'
	order by dt_vencimento 
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}

//RELATORIO 4 - TITULOS VENCIDOS 
function relatorio4_titulos_vencidos($idope,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT seq, idmvmop1, c.nrocheque, null as nroduplicata,null as idmvmfinprop, valor,fator,iof,advalorem ,dt_emissao,dt_vencimento,idsacado,status from tblmvmche1 c 
	where `dt_vencimento` < '$current_date' and status='1' and idmvmop1='$idope'
	union all 
	select seq, idmvmop1, null as nrocheque, d.nroduplicata,null as idmvmfinprop,valor,fator,iof,advalorem,dt_emissao,dt_vencimento,idsacado,status from tblmvmdup1 d 
	where `dt_vencimento` < '$current_date' and status='1' and idmvmop1='$idope'
	union all 
	select seq, idope as idmvmop1, null as nrocheque, null as nroduplicata,idmvmfinprop,valor,null as fator,null as iof,null as advalorem,emissao as dt_emissao,dt_vencimento,idsacado,status from tblmvmfinprop2 
	where `dt_vencimento` < '$current_date' and status='1' and idope='$idope'
	order by dt_vencimento 
	;";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - SUM CHEQUES VENCIDOS 
function relatorio4_sum_che_vencido($listaop,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_che from tblmvmche1 where  `dt_vencimento` < '$current_date' and status='1' and idmvmop1 in ($listaop);";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - SUM DUPLICATAS VENCIDOS 
function relatorio4_sum_dup_vencido($listaop,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_dup from tblmvmdup1 where `dt_vencimento` < '$current_date' and status='1' and idmvmop1 in ($listaop);";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - SUM CARNÊS VENCIDOS 
function relatorio4_sum_emp_vencido($listaop,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_emp from tblmvmfinprop2 where `dt_vencimento` < '$current_date' and status='1' and idope in ($listaop);";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - SUM CHEQUES A VENCER 
function relatorio4_sum_che_avencer($listaop,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_che from tblmvmche1 where  `dt_vencimento` > '$current_date' and status='1' and idmvmop1 in ($listaop);";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - SUM DUPLICATAS A VENCER  
function relatorio4_sum_dup_avencer($listaop,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_dup from tblmvmdup1 where `dt_vencimento` > '$current_date' and status='1' and idmvmop1 in ($listaop);";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 4 - SUM CARNÊS A VENCER   
function relatorio4_sum_emp_avencer($listaop,$pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_emp from tblmvmfinprop2 where `dt_vencimento` > '$current_date' and status='1' and idope in ($listaop);";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 2 - SUM CHEQUES A VENCER 
function relatorio2_sum_che_avencer($pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_che from tblmvmche1 where  `dt_vencimento` > '$current_date' and status='1';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 2 - SUM DUPLICATAS A VENCER  
function relatorio2_sum_dup_avencer($pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_dup from tblmvmdup1 where `dt_vencimento` > '$current_date' and status='1';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 2 - SUM CARNÊS A VENCER   
function relatorio2_sum_emp_avencer($pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_emp from tblmvmfinprop2 where `dt_vencimento` > '$current_date' and status='1';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 3 - SUM CHEQUES VENCIDOS 
function relatorio3_sum_che_vencido($pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_che from tblmvmche1 where  `dt_vencimento` < '$current_date' and status='1';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 3 - SUM DUPLICATAS VENCIDOS 
function relatorio3_sum_dup_vencido($pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_dup from tblmvmdup1 where `dt_vencimento` < '$current_date' and status='1';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
//RELATORIO 3 - SUM CARNÊS VENCIDOS 
function relatorio3_sum_emp_vencido($pdo){	
	$current_date=date('ymd');
	$sql="SELECT COALESCE(SUM(valor),0) as tot_venc_emp from tblmvmfinprop2 where `dt_vencimento` < '$current_date' and status='1';";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}
function count_pendencias($idmvmop1,$pdo){	
	$sql="select COUNT(idmvmop1) as pendentes from tblmvmche1 where idmvmop1='$idmvmop1' and status=1
	UNION ALL
	select COUNT(idmvmop1) as pendentes from tblmvmdup1 where idmvmop1='$idmvmop1' and status=1
	UNION ALL
	select COUNT(idope) as pendentes from tblmvmfinprop2 where idope='$idmvmop1' and status=1";
	$busca=$pdo->query($sql);
	$line=$busca->fetchAll(PDO::FETCH_ASSOC);
	return $line;
}



//$dsini=$_SESSION['fbdatai'];
//$dsfin=$_SESSION['fbdataf'];

//print_r($stmt->errorInfo()); //debug
}