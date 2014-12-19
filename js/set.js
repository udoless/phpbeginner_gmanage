window.onload=function (){
	$("sysset").onclick=function (){
		Base.ajax({
			url:"action.php",
			data:{action:"sysset"},
			success:function (t){
				$("right_in").innerHTML=t;
			}			
		});	
	};
	$("page").onclick=function (){
		Base.ajax({
			url:"action.php",
			data:{action:"page"},
			success:function (t){
				$("right_in").innerHTML=t;
			}			
		});	
	};
	$("csstype").onclick=function (){
		alert("敬请期待！");
	}
	
	
};