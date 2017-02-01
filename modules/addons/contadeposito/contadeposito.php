<?php
	function contadeposito_config() {
		$configarray = array(
			"name" => "Contas de Deposito",
			"description" => "Gerenciamento do módulo de Contas para Depósito WHMCS.",
			"version" => "0.1",
			"author" => "Victor Hugo - WHMCSRed",
		);
		return $configarray;
	}
	function contadeposito_activate() {
	    $query = "CREATE TABLE IF NOT EXISTS `mod_cfg_contadeposito` (`id_contadeposito` bigint(20) unsigned NOT NULL AUTO_INCREMENT,`modo_contadeposito` varchar(20) NOT NULL,`instrucoes_contadeposito` text NOT NULL,UNIQUE KEY `id_contadeposito` (`id_contadeposito`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	    mysql_query($query);
	    $query = "INSERT INTO mod_cfg_contadeposito VALUES('1','modal','');";
	    mysql_query($query);
	    $query = "CREATE TABLE IF NOT EXISTS `mod_contadeposito` (`id_contadeposito` bigint(20) unsigned NOT NULL AUTO_INCREMENT,`banco_contadeposito` varchar(40) NOT NULL,`botao_contadeposito` varchar(10) NOT NULL,`botaocon_contadeposito` varchar(200) NOT NULL,`dados_contadeposito` text NOT NULL,`ativo_contadeposito` int(1) NOT NULL,`instrucoes_contadeposito` text NOT NULL,UNIQUE KEY `id_contadeposito` (`id_contadeposito`)) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
	    mysql_query($query);
	    return array('status'=>'success','description'=>'O Módulo Contas de Depósito foi instalado com sucesso.');
	    return array('status'=>'error','description'=>'Erro ao instalar o Módulo WHMCSKeys.');
	}
	function contadeposito_deactivate() {
	    $query = "DROP TABLE  `mod_contadepositos`;";
	    mysql_query($query);
	    $query = "DROP TABLE  `mod_cfg_contadeposito`;";
	    mysql_query($query);
		return array('status'=>'success','description'=>'O Módulo Contas de Depósito foi desinstalado com sucesso.');
		return array('status'=>'error','description'=>'Erro ao desinstalar o Módulo WHMCSKeys.');
	}
	function contadeposito_output(){
		$module = contadeposito_config();
		if(isset($_POST['txt-link']))
		{
			$queryup = mysql_query("UPDATE mod_whmcskeys SET link_whmcskeys = '".$_POST['txt-link']."';");
		}
		$query = mysql_query("SELECT * FROM mod_whmcskeys;");
		$row = mysql_fetch_array($query);
		?>
        <style>.navbar-red{background-color:#005F8F;color:#fff;box-shadow:0 0 5px rgba(0,0,0,.2);border:none;width:100%}.navbar-brand{color:#fff;padding:8px}.navbar-nav li a{color:#fff;font-size:16px}.navbar-nav .active,.navbar-nav li a:focus,.navbar-nav li a:hover{background-color:#01527A}.jumbotron{padding:20px}h1{font-size:24px!important;border-bottom:none!important}.formulario{background-color:#FAFAFA;border-radius:5px;border:1px solid #EDEDED;padding:10px}.navbar-brand h1{color:#fff;font-size:30px !important;}</style>
		<nav class="navbar navbar-red">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="addonmodules.php?module=contadeposito"><h1>Contas de Depósito</h1></a>
			</div>
			<div id="navbar" class="collapse navbar-collapse navbar-right">
				<ul class="nav navbar-nav">
					<li <?=isset($_GET['pagina'])?null:'class="active"'?>><a href="addonmodules.php?module=contadeposito"><span class="fa fa-dollar"></span> Contas cadastradas</a></li>
					<li <?=$_GET['pagina']=="configuracoes"?'class="active"':null?>><a href="?module=contadeposito&pagina=configuracoes"><span class="fa fa-cogs"></span> Configurações</a></li>
					<li <?=$_GET['pagina']=="sobre"?'class="active"':null?>><a href="?module=contadeposito&pagina=sobre"><span class="fa fa-question-circle"></span> Sobre</a></li>
					<li><a href="http://whmcs.red" target="_blank"><span class="fa fa-home"></span> Nosso site</a></li>
				</ul>
			</div>
		</nav>
		<?php
			if(isset($_GET['pagina']))
			{
				if($_GET['pagina'] == 'configuracoes')
				{
					if(isset($_POST['txt-modo']))
					{
						if($query = mysql_query("UPDATE mod_cfg_contadeposito SET modo_contadeposito = '".$_POST['txt-modo']."', instrucoes_contadeposito = '".$_POST['txt-instrucoes']."' WHERE id_contadeposito = '1';"))
						{
							echo '<div class="alert alert-success">Configurações atualizadas com sucesso!</div>';
						}
						else {
							echo '<div class="alert alert-danger">Erro ao atualizar configuracoes.</div>';
						}
					}
					$query = mysql_query("SELECT * FROM mod_cfg_contadeposito WHERE id_contadeposito = '1';");
					$row = mysql_fetch_array($query);
			?>
	        <div class="row">
	            <div class="col-md-6 col-md-offset-3">
	                <div class="panel panel-primary">
	                    <div class="panel-heading">Configurações</div>
	                    <div class="panel-body">
							<form method="post" action="addonmodules.php?module=contadeposito&pagina=configuracoes">
					            <div class="input-group">
					              <span class="input-group-addon" id="basic-addon1"><span class="fa fa-link"></span> Modo de abertura</span>
					              <select name="txt-modo" required class="form-control">
					              	<option value="modal" <?=$row['modo_contadeposito']=="modal"?'selected':null?>>Modal</option>
					              </select>
					            </div>
					            <hr/>
					            <div class="input-group">
					              <span class="input-group-addon" id="basic-addon1"><span class="fa fa-list"></span> Instruções gerais</span>
					              <textarea name="txt-instrucoes" class="form-control" placeholder="Instruções que se aplicam a todos os bancos."><?=$row['instrucoes_contadeposito']?></textarea>
					            </div>
					            <hr/>
								<button class="btn btn-block btn-success" type="submit">
									Salvar
								</button>
							</form>
	                    </div>
	                </div>
	            </div>
	        </div>
			<?php
				}
				else if($_GET['pagina'] == 'sobre')
				{
			?>
	        <div class="row">
	            <div class="col-md-6 col-md-offset-3">
	                <div class="panel panel-primary">
	                    <div class="panel-heading">Sobre</div>
	                    <div class="panel-body">
							<p>
								Módulo de configuração do método de pagamento de depósitos e transferências.<br />
								<strong>Criador:</strong> Victor Hugo Scatolon de Souza <br/>
								<strong>Versão:</strong> 0.1<br/>
								<strong>Data:</strong> 23/08/2016<br/>
							</p>
	                    </div>
	                </div>
	            </div>
	        </div>
			<?php
				}
			}
			else
			{
				if(isset($_POST['txt-nome']))
				{
					$_POST['txt-dados'] = str_replace("\n","<br />", addslashes($_POST['txt-dados']));
					$_POST['txt-instrucoes'] = str_replace("\n","<br />", addslashes($_POST['txt-instrucoes']));
					if(isset($_GET['editar']))
					{
						if($query = mysql_query("UPDATE mod_contadeposito SET banco_contadeposito = '".$_POST['txt-nome']."', dados_contadeposito = '".$_POST['txt-dados']."', instrucoes_contadeposito = '".$_POST['txt-instrucoes']."', botao_contadeposito = '".$_POST['txt-botao']."', botaocon_contadeposito = '".$_POST['txt-botaocon']."' WHERE id_contadeposito = '".$_GET['editar']."';"))
						{
							echo '<div class="alert alert-success">Banco editado com sucesso!</div>';
						}
						else {
							echo '<div class="alert alert-danger">Erro ao editar o banco.</div>';
						}
					}
					else
					{
						if($query = mysql_query("INSERT INTO mod_contadeposito(banco_contadeposito,dados_contadeposito,instrucoes_contadeposito,botao_contadeposito,botaocon_contadeposito,ativo_contadeposito) VALUES('".$_POST['txt-nome']."','".$_POST['txt-dados']."','".$_POST['txt-instrucoes']."','".$_POST['txt-botao']."','".$_POST['txt-botaocon']."','1');"))
						{
							echo '<div class="alert alert-success">Banco cadastrado com sucesso!</div>';
						}
						else {
							echo '<div class="alert alert-danger">Erro ao cadastrar o banco.</div>';
						}
					}
				}
				if(isset($_GET['desativar']) || isset($_GET['ativar']))
				{
					isset($_GET['desativar'])?$op=array('0',$_GET['desativar'],'Desativado'):$op=array('1',$_GET['ativar'],'Ativado');
					if($query = mysql_query("UPDATE mod_contadeposito SET ativo_contadeposito = '".$op[0]."' WHERE id_contadeposito = '".$op[1]."'"))
					{
						echo '<div class="alert alert-success">Banco '.$op[2].' com sucesso!</div>';
					}
					else {
						echo '<div class="alert alert-danger">Erro ao '.$op[2].' o banco.</div>';
					}
				}
				else if(isset($_GET['excluir']))
				{
					if($query = mysql_query("DELETE FROM mod_contadeposito WHERE id_contadeposito = '".$_GET['excluir']."'"))
					{
						echo '<div class="alert alert-success">Banco excluido com sucesso!</div>';
					}
					else {
						echo '<div class="alert alert-danger">Erro ao excluir o banco.</div>';
					}
				}
				else if(isset($_GET['editar']))
				{
					$query = mysql_query("SELECT * FROM mod_contadeposito WHERE id_contadeposito = '".$_GET['editar']."';");
					$row = mysql_fetch_array($query);
				}
		?>
        <div class="row">
            <div class="col-md-5">
                <div class="panel panel-primary">
                    <div class="panel-heading">Adicionar nova conta</div>
                    <div class="panel-body">
						<form method="post" action="addonmodules.php?module=contadeposito<?=isset($_GET['editar'])?"&editar=".$_GET['editar']:null?>">
				            <div class="form-group">
				              <label><span class="fa fa-dollar"></span> Nome do banco</label>
				              <input type="text" class="form-control" required name="txt-nome" placeholder="Intermedium" <?=isset($_GET['editar'])?'value="'.$row['banco_contadeposito'].'"':null?>>
				            </div>
				            <div class="form-group">
				              <label><span class="fa fa-list"></span> Dados do banco <small>(HTML)</small></label>
				              <textarea name="txt-dados" class="form-control" required placeholder="Conta corrente, Favorecido, CPF, etc"><?=isset($_GET['editar'])?str_replace("<br />","\n",$row['dados_contadeposito']):null?></textarea>
				            </div>
				            <div class="form-group">
				              <label><span class="fa fa-file"></span> Instruções <small>(HTML)</small></label>
				              <textarea name="txt-instrucoes" class="form-control" required placeholder="Após o pagamento abrir um ticket informando"><?=isset($_GET['editar'])?str_replace("<br />","\n",$row['instrucoes_contadeposito']):null?></textarea>
				            </div>
				            <div class="form-group">
				              <label><span class="fa fa-mouse-pointer"></span> Modo do botão</label>
				              <select name="txt-botao" required class="form-control">
				            	<option value="texto" <?=isset($_GET['editar'])?$row['botao_contadeposito']=='texto'?'selected':null:null?>>Texto</option>
				            	<option value="imagem" <?=isset($_GET['editar'])?$row['botao_contadeposito']=='imagem'?'selected':null:null?>>Imagem</option>
				              </select>
				            </div>
				            <div class="form-group">
				              <label><span class="fa fa-link"></span> Botão</label>
				              <input type="text" class="form-control" required name="txt-botaocon" placeholder="Texto ou URL da imagem" <?=isset($_GET['editar'])?'value="'.$row['botaocon_contadeposito'].'"':null?>>
				            </div>
				            <hr/>
							<button class="btn btn-block btn-warning" type="submit">
								<?=isset($_GET['editar'])?'Editar conta':'Criar conta'?>
							</button>
						</form>
                    </div>
                </div>
            </div>
            <div class="col-md-7">
                <div class="panel panel-primary">
                    <div class="panel-heading">Contas bancárias cadastradas</div>
                    <div class="panel-body">
						<table class="table table-striped table-bordered table-hover">
							<thead>
								<th>Nome do banco</th>
								<th>Dados</th>
								<th>Gerênciar</th>
							</thead>
							<tbody>
								<?php
									$query = mysql_query("SELECT * FROM mod_contadeposito;");
									while($row = mysql_fetch_array($query))
									{
								?>
								<tr>
									<td><?=$row['banco_contadeposito']?></td>
									<td><?=$row['dados_contadeposito']?></td>
									<td>
										<a href="addonmodules.php?module=contadeposito&editar=<?=$row['id_contadeposito']?>" class="btn btn-xs btn-info btn-block"><span class="fa fa-edit"></span> Editar</a>
										<?php
											if($row['ativo_contadeposito'] == "0")
											{
										?>
										<a href="addonmodules.php?module=contadeposito&ativar=<?=$row['id_contadeposito']?>" class="btn btn-xs btn-success btn-block"><span class="fa fa-sun-o"></span> Ativar</a>
										<?php
											}
											else
											{
										?>
										<a href="addonmodules.php?module=contadeposito&desativar=<?=$row['id_contadeposito']?>" class="btn btn-xs btn-warning btn-block"><span class="fa fa-ban"></span> Desativar</a>
										<?php
											}
										?>
										<a href="addonmodules.php?module=contadeposito&excluir=<?=$row['id_contadeposito']?>" class="btn btn-xs btn-danger btn-block"><span class="fa fa-edit"></span> Excluir</a>
									</td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
                    </div>
                </div>
            </div>
        </div>
		<?php	
			}
		?>
		<?php
	}
?>
