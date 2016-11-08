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
		.xe{display: none;}
	</style>
	<script>
		(function($){
			$(document).ready(function(){
				$("#cms").change(function(){
					if($(this).val()=="xe")
					{
						$(".xe").show();
						$(".xe").html('<label class="col-md-2 control-label" for="xepath">XE 설치 위치</label><div class="col-md-10"><input class="form-control" type="text" id="xepath" name="xepath" placeholder="XE 설치 위치" required><span class="help-block">XE 설치 폴더명을 적어주세요. (최상단 폴더일 경우 ./ 를 넣어주세요.)</span></div>');
					}
					else
					{
						$(".xe").hide();
					}
				});
				$("#lang").change(function(){
					var tmpHref = window.location.href;
					var href = tmpHref.split('?')[0];
					window.location.href = href+"?lang="+$(this).val();
				});
			});
		})(jQuery);
	</script>
</head>
<body>
<div class="container">
	<div class="row col-md-12 col-lg-12">

		<div class="panel panel-default">
			<div class="panel-heading title">
				<h3>Chibi Tool BBS v2.0 Install</h3>
				<div id="license" class="well">

				</div>
			</div>
			<div class="panel-body">
				<?php if($permission == false) { ?>
				<div class="alert alert-danger">
					<?php echo lang('permission_failed', 'permission_failed'); ?>
					</div>
				<?php } ?>
				<?php echo form_open('Install', array('role'=>'form','id'=>'install', 'class'=>'form-horizontal')); ?>
					<div class="form-group">
						<?php echo lang('lang', 'lang', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<select name="lang" id="lang" class="form-control">
								<option value="korean" <?php if($lang == 'korean') echo 'selected';?>>한국어</option>
								<option value="english" <?php if($lang == 'english') echo 'selected';?>>English</option>
								<option value="japanese" <?php if($lang == 'japanese') echo 'selected';?>>日本語</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="cms">연동 CMS(툴)</label>
						<div class="col-md-10">
							<select name="cms" id="cms" class="form-control">
								<option value="none">연동 안함</option>
								<option value="xe">XE ( Xpress Engine )</option>
								<option value="gnu">그누보드</option>
							</select>
							<span class="help-block">Chibi Tool BBS 와 연동 할 프로그램을 선택 할 수 있습니다.</span>
						</div>
					</div>
					<div class="form-group xe">

					</div>
					<div class="form-group">
						<?php echo lang('host', 'host', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="text" id="host" name="host" value="<?php set_value('host');?>" placeholder="호스트명" >
							<span class="text-danger"><?php echo form_error('host'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<?php echo lang('dbname', 'dbname', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="text" id="dbname" name="dbname" value="<?php set_value('dbname');?>" placeholder="DB 이름" >
							<span class="text-danger"><?php echo form_error('dbname'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<?php echo lang('dbuser', 'dbuser', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="text" id="dbuser" name="dbuser" value="<?php set_value('dbuser');?>" placeholder="DB 유저 아이디" >
							<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 아이디를 입력하세요.</span>
							<span class="text-danger"><?php echo form_error('dbuser'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<?php echo lang('dbpass', 'dbpass', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="password" id="dbpass" name="dbpass" value="<?php set_value('dbpass');?>" placeholder="DB 패스워드" >
							<span class="help-block">호스팅업체 마이페이지에 나와있는 DB 패스워드를 입력하세요.</span>
							<span class="text-danger"><?php echo form_error('dbpass'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<?php echo lang('admin_id', 'admin_id', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="text" id="admin_id" name="admin_id" value="<?php set_value('admin_id');?>" placeholder="최고관리자 아이디"  >
							<span class="help-block">치비BBS 전체를 관리 할 수 있는 관리자 아이디를 입력하세요.</span>
							<span class="text-danger"><?php echo form_error('admin_id'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<?php echo lang('admin_pass', 'admin_pass', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="password" id="admin_pass" name="admin_pass" value="" placeholder="최고관리자 패스워드"  >
							<span class="text-danger"><?php echo form_error('admin_pass'); ?></span>
						</div>
					</div>
					<div class="form-group">
						<?php echo lang('admin_pass2', 'admin_pass2', array('class' => 'col-md-2 control-label')); ?>
						<div class="col-md-10">
							<input class="form-control" type="password" id="admin_pass2" name="admin_pass2" value="" placeholder="최고관리자 패스워드(확인)"  >
							<span class="help-block">최고 관리자패스워드를 다시 한번 적어주세요.</span>
							<span class="text-danger"><?php echo form_error('admin_pass2'); ?></span>
						</div>
					</div>
					<div class="form-group pull-right" style="margin-right: 5px;">
						<?php if($permission == true){ ?>
						<button type="submin" class="btn btn-primary">설치</button>
						<?php } ?>
					</div>
					<script type="text/javascript">
						/*
						(function($){
							$(document).ready(function(){
								$("form").submit(function(){
									var pattern = /^[a-z]+[a-z0-9]*$/;
									if($("#admin_id").val() == ""){
										alert("최고관리자 ID를 입력해 주세요.");
										$("#admin_id").focus();
										return false;
									}else if(!pattern.test($("#admin_id").val())){
										alert("최고관리자 ID는 영문 소문자 혹은 영문(소문자)+숫자로만 입력가능합니다.");
										$("#admin_id").focus();
										return false;
									}
									if($("#admin_pass").val() == ""){
										alert("최고관리자 패스워드를 입력해 주세요.");
										$("#admin_pass").focus();
										return false;
									}
									if($("#admin_pass").val() != $("#admin_pass2").val()){
										alert("최고관리자 패스워드가 동일하지 않습니다.");
										$("#admin_pass").focus();
										return false;
									}

									return true;
								});
							});
						})(jQuery);
						*/
					</script>
			</div>
		</div>
		</form>
	</div>
</div>
</body>
</html>