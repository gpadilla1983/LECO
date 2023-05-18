<?= $this->extend('MasterPage/MasterPage'); ?>
<?= $this->section('Title') ?>Usuarios
<?= $this->endSection() ?>

<?= $this->section('MainContent'); ?>

<div class="app-title">
    <div>
        <h1><i class="fas fa-folder"></i>&nbsp;&nbsp;Expedientes</h1>
        <br />
        <br />
        <button class="btn btn-primary" type="button" id="btn_agregar_file" onclick="buscarExpedientePrincipal();"><i
                class="fa fa-search"></i>&nbsp;&nbsp;Buscar Expediente</button> &nbsp;
        <button class="btn btn-primary" type="button" id="btn_agregar_file" onclick="CapturaExpediente();"><i
                class="fas fa-plus-circle"></i>&nbsp;&nbsp;Nuevo Expediente</button>
    </div>
    <ul class="app-breadcrumb breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>Home"><i class="fa fa-home fa-lg"></i></a></li>
        <li class="breadcrumb-item"><a href="#">Caso legal</a></li>
    </ul>
</div>

<div class="tile" id="div_buscar_Exp">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Número de Expediente:</label>
                <input type="text" class="form-control" id="tbx_numExpdiente" name="tbx_numExpdiente">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Asunto:</label>
                <input type="text" class="form-control" id="tbx_asunto" name="tbx_asunto">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
            <br>
                <button class="btn btn-primary" type="button" id="btn_buscar" onclick="buscarExpediente()"><i
                        class="fa fa-search"></i>&nbsp;&nbsp;Buscar expediente</button>
            </div>
        </div>
    </div>
</div>

<div class="tile" id="divCapturaExp">
    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Número de Expediente:</label>
                <input type="text" class="form-control" id="tbx_numExpdienteCap" name="tbx_numExpdiente">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Asunto:</label>
                <input type="text" class="form-control" id="tbx_asuntoCap" name="tbx_asunto">
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label class="control-label">Archivo:</label><br>
                <input type="file"  id="file_expediente" name="file_expediente" accept=".pdf" onchange="text_change(this)">
            </div>
        </div>
        <div class="col-md-12" align="right">
            <button class="btn btn-primary" type="button" id="btn_guardar" onclick="SubirArchivo();"><i
                    class="fas fa-file-upload"></i>&nbsp;&nbsp;Subir archivo</button>
        </div>
    </div>
</div>


<div class="tile" id="div_resultados">
    <div class="row">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover table-bordered" id="table-expediente">
                    <thead>
                        <tr style="background-color:gray; color:white">
                            <th class="text-center">Num.</th>
                            <th class="text-center">Expediente</th>
                            <th class="text-center">Asunto</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div> 
    
</div>





<div class="modal fade modalVisor" id="modalVisor" tabindex="-1" role="dialog" aria-labelledby="myExtraLargeModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title h4">Archivo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">x</span>
        </button>
      </div>
      <div class="modal-body">
        
            <div class="col-md-12">
                <iframe id="iframe_visor" src="" frameborder="0" height="600" width="100%"></iframe>
            </div>
      </div>
      <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
             </div>
  </div>
</div>



<?= $this->endSection(); ?>

<?= $this->section('FooterContent'); ?>
<script src="<?= base_url(); ?>Assets/js/functions_FilesCliente.js"></script>
<?= $this->endSection(); ?>