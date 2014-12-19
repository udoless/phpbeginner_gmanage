addEvent(window,"load",function (){
	var open=$("open"),
		ajax=$("ajax"),
		condition=$("condition");
	addEvent(open,"click",function (){
		if(condition.style.display==="none")
			condition.style.display="block";
		else
			condition.style.display="none";
	})
	
	
	/*var form1=document.form1;
	var checks=[];
	var radios=document.getElementsByTagName("input");
	addEvent(form1,"submit",function (){
		for(var i=0;i<radios.length;i++){
			if(radios[i].getAttribute("checked")=="checked")
				checks.push(radios[i].getAttribute("value"));
		}
		alert(checks);
	})	*/
})

