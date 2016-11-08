<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="ko">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0,maximum-scale=3.0">
	<meta name="robots" content="noindex,nofollow">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<link rel="stylesheet" href="./common/css/bootstrap.min.css">
	<script src="./common/js/jquery.min.js"></script>
	<script src="./common/js/bootstrap.min.js"></script>
	<title>Chibi Tool BBS v2.0 Install</title>
	<style>
		body{background-color: #666666;font-family: "나눔 고딕","Nanum Gothic","돋움","Dotum",Helvetica,Arial,sans-serif;padding:10px;}
		h3{margin:3px;}
		.panel-body{padding:0px;}
		.table{margin-bottom:0px;}
	</style>
</head>
<body>
<div class="container">
	<div class="row">
		<?php
		if(empty($server_config['is_connect_error'])){/* DB 정보가 틀렸을 경우 */
			?>
			<div id="installed" class="alert alert-danger">
				<a class="close" href="javascript:history.go(-1);">&times;</a>
				<p class="text-danger"><?php echo lang('db_invalid_connection_str'); ?></p><br/><br/>
				<a class="btn btn-danger" href="javascript:history.go(-1);">X</a>
			</div>
			<script type="text/javascript">
				$('#installed').bind('closed', function () {
					history.go(-1);
				})
			</script>
		<?php
		}else{
		?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3> </h3>
			</div>
			<div class="panel-body">
				<table class="table table-bordered">
					<thead>
					<tr class="info">
						<th></th>
						<th><?php echo lang('server_info');?></th>
						<th><?php echo lang('install_info_minimum');?></th>
						<th><?php echo lang('check_install_result');?></th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td><p class="text-info"><?php echo lang('php_version');?></p></td>
						<td><p class="text-info"><?php echo $server_config['php_version'];?></p></td>
						<td><p class="text-info"><?php echo lang('chibi_php_version');?></p></td>
						<td><?php if( !empty($server_config['is_php_minimum']) || !empty($server_config['is_php_recommend']) ){ echo "<p class=\"text-success\"><b>".lang('installable')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('uninstallable')."</b></p>";}?></td>
					</tr>
					<tr>
						<td><p class="text-info"><?php echo lang('mysql_version');?></p></td>
						<td><p class="text-info"><?php echo $server_config['db_version'];?></p></td>
						<td><p class="text-info">5.0</p></td>
						<td><?php if( !empty($server_config['is_db_minimum']) ){ echo "<p class=\"text-success\"><b>".lang('installable')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('uninstallable')."</b></p>";}?></td>
					</tr>
					<tr>
						<td><p class="text-info"><?php echo lang('mysql_support_utf8');?></p></td>
						<td colspan="3"><?php if(!empty($server_config['is_utf8'])){ echo "<p class=\"text-success\"><b>".lang('support_utf8')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('not_support_utf8')."</b></p>";}?></td>
					</tr>
					<tr>
						<td colspan="4">
							<div class="control-group pull-right">
								<p style="text-align: right;"><a class="btn btn-primary" href="javascript:history.go(-1);"><?php echo lang('return');?></a></p>
								<p style="text-align: right;"><span class="help-block text-danger"><?php echo lang('check_error');?></span></p>

							</div>
						</td>
					</tr>
					</tbody>
				</table>
				<?php
				}
				?>
			</div>
		</div>
	</div>
</div>
</body>
</html>