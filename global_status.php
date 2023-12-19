<?php
//STATUS
if(isset($status)){
if($status=="1"){ //1 PENDENTE
    $statusclass="pendente"; 
    $statusdesc="Pendente";
}
elseif($status=="2"){ //2 PAGO AO CLIENTE
    $statusclass="pg_parcial";
    $statusdesc="Pago";
}
elseif($status=="7"){ //7 RECEBIDO  
    $statusclass="recebido";
    $statusdesc="Recebido";
}
else{
    $statusclass="error"; 
}
}


if(isset($status_pessoa)){
if($status_pessoa==1){ //ATIVO
    $statuspclass="recebido";
    $statuspdesc="Ativo";
}
elseif($status_pessoa=="0"){ // INATIVO
    $statuspclass="cancelada";
    $statuspdesc="Inativo";
}
}

//FINANCEIRO
if(isset($status_fin)){
    if($status_fin==2){ //PAGO
        $statusfclass="recebido";
        $statuspdesc="Ativo";
        $statusfdesc="Pago";
    }
    elseif($status_fin==1){ // PENDENTE
        $statusfclass="cancelada";
        $statuspdesc="Inativo";
        $statusfdesc="Pendente";
    }
    elseif($status_fin==7){// RECEBIDO
        $statusfclass="cancelada";
        $statuspdesc="Inativo";
        $statusfdesc="Pendente";
    }
    }



//3 CANCELADO

//7 CONCLUIDO
?>