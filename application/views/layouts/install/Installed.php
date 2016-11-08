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
		<div class="panel panel-default">
			<div class="panel-heading">
				<h3>서버 환경 체크</h3>
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
					</tbody>
				</table>
				<table class="table table-bordered">
					<thead>
					<tr class="info">
						<th colspan="3">DB 정보 파일 생성 결과</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td colspan="3"></td>
					</tr>
					</tbody>
					<thead>
					<tr class="info">
						<th class="col-md-3">DB 테이블 명</th>
						<th class="col-md-2">상태</th>
						<th class="col-md-7">상세</th>
					</tr>
					</thead>
					<tbody>
					<tr>
						<td>chibi_admin(게시판)</td>
						<td>
							<?php if(!empty($exist_tables['admin'])){ echo "<p class=\"text-success\"><b>".lang('create_table_success')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('create_table_fail')."</b></p>";}?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>chibi_skin(스킨)</td>
						<td>
							<?php if(!empty($exist_tables['skin'])){ echo "<p class=\"text-success\"><b>".lang('create_table_success')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('create_table_fail')."</b></p>";}?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>chibi_post(그림)</td>
						<td>
							<?php if(!empty($exist_tables['post'])){ echo "<p class=\"text-success\"><b>".lang('create_table_success')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('create_table_fail')."</b></p>";}?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>chibi_comment(코멘트)</td>
						<td>
							<?php if(!empty($exist_tables['comment'])){ echo "<p class=\"text-success\"><b>".lang('create_table_success')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('create_table_fail')."</b></p>";}?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>chibi_log(로그)</td>
						<td>
							<?php if(!empty($exist_tables['log'])){ echo "<p class=\"text-success\"><b>".lang('create_table_success')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('create_table_fail')."</b></p>";}?>
						</td>
						<td></td>
					</tr>
					<tr>
						<td>chibi_emoticon(이모티콘)</td>
						<td>
							<?php if(!empty($exist_tables['emoticon'])){ echo "<p class=\"text-success\"><b>".lang('create_table_success')."</b></p>";}else{ echo "<p class=\"text-danger\"><b>".lang('create_table_fail')."</b></p>";}?>
						</td>
						<td></td>
					</tr>
					</tbody>
					<thead>
					<tr class="info">
						<th colspan="3">환경 설정파일 생성 결과</th>
					</tr>

					</thead>

					<tbody>
					<tr>
						<td colspan="3">
							<?php
								echo "<a class=\"btn btn-primary\" href=\"../../index.php?mid=admin\">설치완료</a>";

								echo "<a class=\"btn btn-primary\" href=\"install.php\">돌아가기</a><span class=\"help-block\">오류 항목이 있습니다. 오류 항목을 확인하세요.</span>";
							?>
						</td>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
</body>
</html>