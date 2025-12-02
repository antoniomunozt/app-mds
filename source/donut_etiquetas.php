<div class="col-md-6 col-sm-6 col-xs-12">
    <div class="x_panel">
        <div class="x_title">
            <h2>Top 5 Manipuladores en Impresión de Etiquetas <small>Por Fecha</small></h2>
            <ul class="nav navbar-right panel_toolbox">
                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
            </ul>
            <div class="clearfix"></div>
        </div>
        <div class="x_content">
            <canvas id="chart-area-donut-etiquetas"></canvas>            
        </div>                    
        <div class="x_content">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerdesdeet">Fecha Desde</label>
            <div class='input-group date' id='myDatepickerdesdeet'>
                <input type='text' class="form-control" name="fechadesdeet" id="fechadesdeet" value="<?php echo date("d/m/Y",strtotime(date("Y/m/d")."- 1 year")) ?>" />                
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>

            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="myDatepickerhastaet">Fecha Hasta</label>
            <div class='input-group date' id='myDatepickerhastaet'>
                <input type='text' class="form-control" name="fechahastaet" id="fechahastaet" value="<?php echo date('d/m/Y') ?>" />
                <span class="input-group-addon">
                <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>                                
            <button id="button" onclick="recargar_donut_etiquetas();">Recargar</button>
        </div>
        
    </div>   
</div>