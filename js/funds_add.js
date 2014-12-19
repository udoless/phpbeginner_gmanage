addEvent(window,"load",function (){
	var one=$("one"),
		two=$("two");	
	var flag=true;
	one.onclick=function (){
		flag=true;
		//初始化
		$("details").innerHTML="";
		$("last").innerHTML="";
		addClass(one,"show");
		delClass(two,"show");
		
		
	//个人操作	
	var center=$("center"),
		bottom=$("bottom");
	//调出表单
	Base.ajax({
		url:"action.php",
		data:{action:"one"},
		success:function (t){
			center.innerHTML=t;
			var submit=$("submit");
			var inputNum=$("inputNum");
			//添加实时显示学生信息功能
			document.onclick=function (){
				if(flag){
				if(inputNum.value!=""){
					Base.ajax({
						url:"action.php",
						data:{nums:inputNum.value,action:"details"},
						success:function (t){
							//直接放入结果，不必繁琐，因为就一条数据
							$("details").innerHTML=t;
//							if(t){
//							var txt = document.createTextNode(t);						
//							if((document.getElementById('details').firstChild)===null){							
//							document.getElementById("details").appendChild(txt);
//							}else{
//								//如果
//								oldTxt=document.getElementById('details').firstChild;
//								document.getElementById("details").replaceChild(txt, oldTxt);
//							}	
//							}						
						}						
					});
				}
				}
			};
			
		}
		
	});
	
	};
	two.onclick=function (){
		flag=false;
		//初始化
		$("details").innerHTML="";
		$("last").innerHTML="";
		addClass(two,"show");
		delClass(one,"show");
		//集体操作
		var center=$("center"),
			bottom=$("bottom");
		//调出筛选界面
		Base.ajax({
			url:"action.php",
			data:{action:"two"},
			success:function (t){
				center.innerHTML=t;
				var form=$("form1"),
					submit=$("submit");
				form.onsubmit=function (){
					return false;
				};
				submit.onclick=function (){
					var a=Array();
					for(var i=0;i<form.elements.length;i++){
						if(form.elements[i].type=="radio" && form.elements[i].checked==true && form.elements[i].value!="" ){
							a.push(form.elements[i].name+"'"+form.elements[i].value+"'");
						}
						
					}
				var s=a.join(" AND ");
				Base.ajax({
					url:"action.php",
					data:{get:s,action:"twoAdd"},
					success:function (t){
						t=t.split("#");
						$("details").innerHTML=t[0];
						$("last").innerHTML=t[1];	
						//点击删除功能<
						if($("details").firstChild.nodeName=="SPAN"){
							var spans=$("details").getElementsByTagName("span"),
								n=spans.length;
							for(var i=0;i<n;i++){
								spans[i].onclick=function (){									
									this.parentNode.removeChild(this);
									//删除时更新选择数据
									$("selectedspan").innerHTML--;
								};
							}
						}
						//点击删除功能>
						//开始录入数据库，只取details DIV里的
						//这里要判断一下，不然下面的会undefined
						if($("last").innerHTML){
						var form3=$("form3"),
							submit3=$("submit3");
						form3.onsubmit=function (){
							return false;
						};				
						submit3.onclick=function (){
							//取出details DIV里的学号
							if(!$("details").innerHTML){
								alert("还没有选择学生！");
								return false;
							}else{
								var spans=$("details").getElementsByTagName("span"),
								allnum=Array();
								for(var i=0;i<spans.length;i++){
									allnum.push(spans[i].innerHTML);
							}
							}						
							var money=document.getElementsByName("money")[0].value,
								type=document.getElementsByName("type")[0].value,
								details=document.getElementsByName("details")[0].value;
							if(!money || !type || !details){
								alert("信息填写不完整！");
								return false;
							}
							Base.ajax({
								url:"action.php",
								data:{
									action:"twoAddEnd",
									money:money,
									type:type,
									details:details,
									nums:allnum
								},
								success:function (t){
									$("last").innerHTML="";
									$("details").innerHTML=t;									
								}
							});
						};
					}
					}
				});
				
				
				
				};

			}
		});
	};
	
	
	
	
});

