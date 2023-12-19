
<!-- MODAL STATUS OPERACAO -->
<div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Legenda De Status Da Operação</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div class="table-responsive">
             <table class="table align-items-center" style="color:black;width:200px">
               <tbody>
                 <tr>
                   <td>Pendente</td>
                   <td><div id="status_pendente"></div></td>
                 </tr>
                 <tr>
                   <td>Pago</td>
                   <td><div id="status_pg_parcial"></div></td>
                 </tr>
                 <tr>
                   <td>Recebido</td>
                   <td><div id="status_recebido"></div></td>
                 </tr>
                 <tr>
                   <td>Cancelada</td>
                   <td><div id="status_cancelada"></div></td>
                 </tr>
               </tbody>
             </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- MODAL STATUS PESSSOA -->
<div class="modal fade" id="statusModalPessoa" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Legenda De Status De Pessoas</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div class="table-responsive">
             <table class="table align-items-center" style="color:black;width:200px">
               <tbody>
                 <tr>
                   <td>Ativo</td>
                   <td><div id="status_recebido"></div></td>
                 </tr>
                 <tr>
                   <td>Inativo</td>
                   <td><div id="status_cancelada"></div></td>
                 </tr>
                 <tr>
                   <td>Bloqueado</td>
                   <td><div id="status_error"></div></td>
                 </tr>
               </tbody>
             </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- MODAL STATUS FINACEIRO -->
<div class="modal fade" id="statusModalFinanceiro" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text_dark" id="exampleModalLabel">Legenda De Status De Financeiro</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body"> 
        <div class="table-responsive">
             <table class="table align-items-center" style="color:black;width:200px">
               <tbody>
                 <tr>
                   <td>Pago</td>
                   <td><div id="status_recebido"></div></td>
                 </tr>
                 <tr>
                   <td>Pendente</td>
                   <td><div id="status_cancelada"></div></td>
                 </tr>
               </tbody>
             </table>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
</div>

<!-- MODAL STATUS OPERACAO -->
<div class="modal fade" id="versionNewModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" style="color:black" id="exampleModalLabel">Novidades Da Versão</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text_dark"> 
      <?php 
      require "version_notes.php";
      ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
      </div>
    </div>
  </div>
</div>
</div>