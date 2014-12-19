(function () {
	String.prototype.trim=function () {
		return this.replace(/^\s+/,'').replace(/\s+$/,'');
	};
	function SortableTable(table) {
		this.table=table;
		
		var div=document.createElement("div");
		div.innerHTML='<img class="sortDirImage" src="images/desc.gif" />';
		this.table.sortDirImage=div.firstChild;
		
		this.headers=getElementsByClassName("sortableCol",table.tHead.rows[0]);
		this.tBody=table.tBodies[0];
		this.rows=this.tBody.rows;
		var i=0,vt,_this=this;
		for (;i<this.headers.length;i++) {
			vt=this.headers[i].getAttribute("valuetype") || "string";
			vt=vt.split(/\s+/);
			this.headers[i].compare=SortableTable.compareMethods[vt[0]];
			this.headers[i].compareParam=vt[1];
			addEvent(this.headers[i],"click",function (evt) {
				evt.preventDefault();
				_this.sortCol(this.cellIndex,-this.currentDir || 1);
			});
		}
		

	}
	extend(SortableTable,{
		compareMethods:{
			"string":function (a,b,param,dir) {
				return a.localeCompare(b)*dir;
			},
			"number":function (a,b,param,dir) {
				a=parseFloat(a);
				b=parseFloat(b);
				if (a>b) return dir;
				if (a<b) return -dir;
				return 0;
			},
			"date":function (a,b,param,dir) {
				a=dateDecode(a,param).getTime();
				b=dateDecode(b,param).getTime();
				if (a>b) return dir;
				if (a<b) return -dir;
				return 0;
			}
		}
	});
	SortableTable.prototype={
		sortCol:function (colIndex,dir) {
			var ary=this.collect(colIndex);
			var _this=this;
			dir = dir || 1;
			this.headers[colIndex].currentDir=dir;
			ary.sort(function (a,b) {
				return _this.headers[colIndex].compare(a.value,b.value,_this.headers[colIndex].compareParam,dir);
			});
			var frag=document.createDocumentFragment();
			for (var i=0;i<ary.length;i++) {
				frag.appendChild(ary[i].node);
			}
			this.tBody.appendChild(frag);
			//sortDirImage
			this.table.sortDirImage.src="images/"+(dir>0?"asc":"desc")+".gif";
			this.headers[colIndex].appendChild(this.table.sortDirImage);
			addClass(this.headers[colIndex],"sorting");
			for (i=0;i<this.headers.length;i++) {
				delClass(this.headers[i],"sorting");
			}
		},
		collect:function (colIndex) {
			var i=0,a=[];
			for (;i<this.rows.length;i++) {
				a.push({
					node:this.rows[i],
					value:getInnerText(this.rows[i].cells[colIndex])
				});
			}
			return a;
		}
	};


	addEvent(window,"load",function () {
		var tables=getElementsByClassName("sortableTable");
		for (var i=0;i<tables.length;i++)
			new SortableTable(tables[i]);
	});


	function getInnerText(node) {
		if (node.nodeType==3)
			return node.nodeValue.trim();
		else if (node.nodeType==1) {
			for (var i=0,t="";i<node.childNodes.length;i++) {
				t+=getInnerText(node.childNodes[i]);
			}
			return t;
		} else {
			return "";
		}
	}


	function getElementsByClassName(name,context) {
		context=context || document;
		if (context.getElementsByClassName) {
			return context.getElementsByClassName(name);
		} else {
			var nodes=context.getElementsByTagName("*"),ret=[];
			for (var i=0;i<nodes.length;i++) {
				if (hasClass(nodes[i],name)) ret.push(nodes[i]);
			}
			return ret;
		}
	}
	function hasClass(node,name) {
		var names=node.className.split(/\s+/);
		for (var i=0;i<names.length;i++)  {
			if (names[i]==name) return true;
		}
		return false;
	}
	
	function addClass(node,name) {
		if (!hasClass(node,name)) node.className += " "+name;
	}
	
	function delClass(node,name) {
		var names=node.className.split(/\s+/);
		for (var i=0;i<names.length;i++ ){
			if (names[i]==name) delete names[i];
		}
		node.className=names.join(" ");
	} 
	

	
	function addEvent(o,evtype,fn) {
		if (o.addEventListener) {
			o.addEventListener(evtype,fn,false);
		} else if (o.attachEvent) {
			o.attachEvent("on"+evtype,function () {
				fn.call(o,fixEvent(window.event));
			});
		} else {
			throw new Error("No event bind method can be used!!!");
		}
	}
	function fixEvent(evt) {
		evt.layerX=evt.offsetX;
		evt.layerY=evt.offsetY;
		evt.target=evt.srcElement;
		if (evt.type=="mouseout")
			evt.relatedTarget=evt.toElement;
		else if (evt.type=="mouseover")
			evt.relatedTarget=evt.fromElement;
		else 
			evt.relatedTarget=evt.target;
		
		evt.stopPropagation=function () {
			this.cancelBubble=true;
		};
		evt.preventDefault=function () {
			this.returnValue=false;
		};
		return evt;
	}
	
	function dateDecode(s,format) {
		var a=s.match(/\d+/g),d=new Date();
		format=format.split("");
		for (var i=0;i<format.length;i++) {
			switch(format[i]) {
				case "Y":d.setFullYear(a[i]);break;
				case "m":d.setMonth(a[i]-1);break;
				case "d":d.setDate(a[i]);break;
				case "H":d.setHours(a[i]);break;
				case "i":d.setMinutes(a[i]);break;
				case "s":d.setSeconds(a[i]);break;
			}
		}
		return d;
	}

	
	
	function extend(dest,src) {
		for (var i in src) {
			dest[i]=src[i];
		}
	}
	
	
	
	
	
	
	
})();