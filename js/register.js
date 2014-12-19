window.onload = function () {
	code();
	//注册验证
	var fm = document.getElementsByTagName('form')[0];

	fm.onsubmit = function () {
		if (fm.username.value=='') {
			alert('姓名不得为空');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
		if (/[<>\'\"\ \　]/.test(fm.username.value)) {
			alert('姓名不得包含非法字符');
			fm.username.value = ''; //清空
			fm.username.focus(); //将焦点以至表单字段
			return false;
		}
	
//		var year=fm.birth_y.value;
//		var month=fm.birth_m.value;
//		var date=fm.birth_d.value;
//		var d=new Date();
//		d.setFullYear(year);
//		d.setMonth(month-1);
//		d.setDate(date);
//		alert(year+month+date);
//		if(!(d.getFullYear==year && (d.getMonth()+1)==month && d.getDate()==date)){
//			alert('天啊！历史上尽然没有你出生的那天...');
//			fm.contact.focus(); //将焦点以至表单字段
//			return false;
//		}
	
		if(isNaN(fm.contact.value)){
			alert('联系方式必须是纯数字');
			fm.contact.value = ''; //清空
			fm.contact.focus(); //将焦点以至表单字段
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