window.onload = function () {
	document.getElementById('num').focus();
	function killErrors() {
		 return  true;
	}
	window.onerror = killErrors; 
	code();
	//登录验证
	var fm = document.getElementsByTagName('form')[0];

	fm.onsubmit = function () {
		if (fm.num.value=='') {
			alert('用户名不得为空');
			fm.num.value = ''; //清空
			fm.num.focus(); //将焦点以至表单字段
			return false;
		}
		if (/[<>\'\"\ \　]/.test(fm.num.value)) {
			alert('用户名不得包含非法字符');
			fm.num.value = ''; //清空
			fm.num.focus(); //将焦点以至表单字段
			return false;
		}
		//密码验证
		if (fm.password.value=='') {
			alert('密码不得为空');
			fm.password.value = ''; //清空
			fm.password.focus(); //将焦点以至表单字段
			return false;
		}
		//验证码验证
		if (fm.code.value.length != 4) {
			alert('验证码必须是4位');
			fm.code.value = ''; //清空
			fm.code.focus(); //将焦点以至表单字段
			return false;
		}
	};
};