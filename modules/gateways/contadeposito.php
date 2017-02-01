<?php
	function contadeposito_config() {
		$configarray = array(
			"FriendlyName" => array(
			"Type" => "System",
			"Value" => "Contas para depósito"
			),
	    );
		return $configarray;
	}
	function contadeposito_link($params) {
		$query = mysql_query("SELECT * FROM mod_cfg_contadeposito WHERE id_contadeposito = '1';");
		$cfg = mysql_fetch_array($query);
		$code = "";
		if($cfg['modo_contadeposito'] == "modal")
		{
			$query = mysql_query("SELECT * FROM mod_contadeposito WHERE ativo_contadeposito = '1';");
			while($row = mysql_fetch_array($query))
			{
				$code .= '
				<div class="modal fade" id="modal'.$row['id_contadeposito'].'" tabindex="-1" role="dialog" style="color:#000;">
				  <div class="modal-dialog" role="document">
				    <div class="modal-content">
				      <div class="modal-header">
				        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				        <h4 class="modal-title" id="myModalLabel">'.$row['banco_contadeposito'].'</h4>
				      </div>
				      <div class="modal-body">
		                <div class="panel panel-primary">
		                    <div class="panel-heading">Dados da conta</div>
		                    <div class="panel-body">'.html_entity_decode($row['dados_contadeposito']).'</div>
		                </div>
		                <div class="panel panel-primary">
		                    <div class="panel-heading">Instruções</div>
		                    <div class="panel-body">'.html_entity_decode($row['instrucoes_contadeposito']).'<hr/>'.html_entity_decode($cfg['instrucoes_contadeposito']).'</div>
		                </div>
				      </div>
				      <div class="modal-footer">
				        <button type="button" class="btn btn-default btn-block" data-dismiss="modal">Fechar</button>
				      </div>
				    </div>
				  </div>
				</div>
				';
				if($row['botao_contadeposito'] == "texto")
				{
					$code .= '<button type="button" data-toggle="modal" data-target="#modal'.$row['id_contadeposito'].'" class="btn btn-block btn-success">'.$row['botaocon_contadeposito'].'</button>';
				}
				else {
					$code .= '<br /><img src="'.$row['botaocon_contadeposito'].'" style="cursor: pointer;" data-toggle="modal" data-target="#modal'.$row['id_contadeposito'].'" class="img-responsive" />';
				}
			}
		}
        $code .='<script
              src="https://code.jquery.com/jquery-1.12.4.min.js"
              integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="
              crossorigin="anonymous"></script><script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>';
    	return $code;
    }
?>
