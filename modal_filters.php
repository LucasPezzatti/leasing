<!-- MODAL FILTRO 1 -->
<div class="modal fade" id="filterTipoDoc" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Filtrar Por Tipo Documento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" style="margin:auto"> 
        <div class="table-responsive align-right">
             <table class="table align-items-center" style="color:black;width:200px;margin:auto">
               <tbody>
               <tr>
               <td>
                 <a href="?filter=tp_doc&value=a"> <button class="btn btn-info btn_action_detalhes"><i class="zmdi zmdi-view-list"></i> Exibir Todos Títulos </button> </a> </td>
               </tr>
              <tr>
                 <td> <a href="?filter=tp_doc&value=c"> <button class="btn btn-warning btn_action_detalhes"><i class="zmdi zmdi-sort"></i> Exibir Apenas Cheques</button> </a> </td>
              </tr>
              <tr>
                 <td> <a href="?filter=tp_doc&value=d"> <button class="btn btn-primary btn_action_detalhes"><i class="zmdi zmdi-sort"></i> Exibir Apenas Duplicatas</button> </a> </td>
              </tr>
              <tr>
                 <td> <a href="?filter=tp_doc&value=f"> <button class="btn btn-danger btn_action_detalhes"><i class="zmdi zmdi-sort"></i> Exibir Apenas Carnês</button> </a> </td>
              </tr>
               </tbody>
             </table>
     
     
      </div>
      <button style="margin-top:50px" class="btn btn-dark btn-sm"><i class="icon-info" style="margin-right:2px"></i>  Clique em uma das opções para filtrar.</button>
    </div>
  </div>
</div>
</div>

<!-- MODAL FILTRO 2 -->
<div class="modal fade" id="filterSacado" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Filtrar Por Sacado</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-dark" style="margin:auto;"> 
      <form action="?filter=sacado&value=q" method="POST">
      <div class="form-group">
            <label class="text-dark"  for="input-4">Sacado</label>
            <div class="custom-select-form">
              <span style="font-size:11px">Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar</span>
						<input  onfocus="clearInput(this)" required style="border: 1px solid #fff;background-color:black!important" <?php if(isset($load_value)){ echo 'value="'.$idsacado.'"';}?> placeholder="Digite o ID , Nome ou CPF/CNPJ do sacado para pesquisar" 
						class="form-control" name="filter2" list="cedentes"  autocomplete="off">
						<datalist id="cedentes">
						<?php 
            $localsql=new localsql();
						$busca = $localsql->busca_sacado_only($pdom);
            foreach($busca as $line){
						$idsacado=$line['id'];	
						$razao=$line['razao'];		
						?>
	          <option value="<?php echo $idsacado.' - '.$razao;?>"></option>
						<?php 
            }
            ?>	
            </datalist>
            <script>function clearInput(target){
            if (target.name== 'filter2'){ target.value= "";}}
            </script>
             <div class="modal-footer">
                <button type="submit" class="btn btn-dark btn_action_detalhes"><i class="zmdi zmdi-sort"></i> Filtrar</button> </form>
         
          
             </div>
           
            
           </div>
           
           </div>
           <a href="?filter=sacado&value=a">  
            <button style="margin-top:10px"  type="button" class="btn btn-info btn_action_detalhes"><i class="icon icon-reload"></i> Exibir Títulos De Todos Sacados</button>
           </a>
          

      <button style="margin-top:30px" class="btn btn-dark btn-sm"><i class="icon-info" style="margin-right:2px"></i>  Clique em filtrar para confirmar a ação.</button>
    </div>
  </div>
</div>
</div>

<!-- MODAL FILTRO 3 -->
<div class="modal fade" id="filterVencimento" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-dark" id="exampleModalLabel">Filtrar Por Vencimento</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <a href="?filter=vencimento&value=a">  
            <button style="margin:10px;"  type="button" class="btn btn-info btn_action_detalhes"><i class="icon icon-reload"></i> Reiniciar Filtro </button>
           </a>
      <div class="modal-body text-dark" style="margin:auto;"> 
      <form action="?filter=vencimento&value=q" method="POST">
      <div class="form-group float-right">
            <label class="text-dark"  for="input-4">Data Inicial</label>
            <div class="custom-select-form">
              <input id="dateinput" type="date" style="width:220px;margin-top:5px;background-color:black!important" required value="<?php echo (isset($_SESSION['filter_dtini']) ? $_SESSION['filter_dtini'] : '');?>" name="filter_dtini" class="form-control" id="input-2" placeholder="Data Inicial"><br>
              <label class="text-dark"  for="input-4">Data Final</label>
              <input type="date" style="width:220px;margin-top:5px;background-color:black!important" required value="<?php echo (isset($_SESSION['filter_dtfin']) ? $_SESSION['filter_dtfin'] : '');?>" name="filter_dtfin" class="form-control" id="input-2" placeholder="Data Final">
            <br>
           
             <button style="margin-right:30px" type="submit" class="btn btn-primary px-5"><i class="icon-calendar"></i> Alterar Período</button> </form>
         
             </div>
             </div>
                    
      <button style="margin-top:30px" class="btn btn-dark btn-sm"><i class="icon-info" style="margin-right:2px"></i>  Clique em Alterar Período ou reiniciar filtro para confirmar. </button>
           </div>
           
           </div>
         
    </div>
  </div>
</div>
</div>