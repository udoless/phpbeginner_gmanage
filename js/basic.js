
function killErrors() {
     return  true;
}
window.onerror = killErrors; 

function _confirm(msg,url){
	if(confirm(msg))
		document.location.href=url;
}


var Browser={
		isIE:!!window.ActiveXObject,
		isOpera:window.opera+"" =="[object Opera]"
	};
	String.prototype.repeat=function (n) {
		//n表示字符串重得的次数
		return new Array(n+1).join(this);
	};
	String.prototype.trim=function () {
		return this.replace(/^\s+/,"").replace(/\s+$/,"");
	};
	Number.prototype.inter=function (a,b) {//检测数字是否在区间之内
		var min=Math.min(a,b),max=Math.max(a,b);
		return this==a || this==b || (Math.max(this,min)==this && Math.min(this,max)==this);
	};
	var Base={};
	Base.extend=function (src,dest) {
		for (var i in src) {
			if (src[i]!=undefined) {
				dest[i]=src[i];
			}
		}
	};
	(function () {
		function jsonEncode(o) {
			if (window.JSON+""==="[object JSON]") {
				return JSON.stringify(o);
			}
			var t=typeof o;
			switch(t) {
				case "string":
					return '"'+addslashes(o)+'"';
				case "number":
				case "boolean":
					return o+"";
				case "undefined":
				case "function":
				case "unknow":
					return "null";
				case "object":
					if (!o) return "null";
					var ret=[];
					if (o instanceof Array) {
						for (var i=0;i<o.length;i++) {
							ret.push(jsonEncode(o[i]));
						}
						return "["+ret.join(",")+"]";
					} else {
						for (var i in o) {
							ret.push(jsonEncode(i)+":"+jsonEncode(o[i]));
						}
						return "{"+ret.join(",")+"}";
					}
					
			}
		}
		//
		
		var specialChars={
			'"':'\\"',
			'\\':'\\\\',
			"\n":"\\n",
			"\r":"\\r"
		};
		function addslashes(s) {//转义特殊字符
			return s.replace(/\\|\n|\r|"/g,function (m) {
				return specialChars[m];
			});
		}
		
		Base.jsonEncode=jsonEncode;
		Base.addslashes=addslashes;
	})();


	Base.init=function (Class,$this,args) {
		$this.originalArgs=args;
		for (var i in args) {
			$this[i]=args[i];
		}
		if (Class.defaultArgs) {
			for (i in Class.defaultArgs) {
				if (args[i]===undefined)
					$this[i]=Class.defaultArgs[i].valueOf($this);
			}
		}
		
		
	};

	//XMLDOM
	if (window.ActiveXObject) {
		//IE
		Base.getXMLDOM=function () {
			return new ActiveXObject("Microsoft.XmlDom");
		};
		Base.loadXMLFile=function (xmlDom,url,callback) {
			xmlDom.onreadystatechange=function () {
				if (xmlDom.readyState===4) {
					if (xmlDom.parseError.errorCode===0) {
						callback.call(xmlDom);
					} else {
						throw new Error("XML Parse Error:"+xmlDom.parseError.reason);
					}
				}
			};
			xmlDom.load(url);
			return xmlDom;
		};
		Base.loadXMLString=function (xmlDom,s) {
			xmlDom.loadXML(s);
			if (xmlDom.parseError.errorCode!==0) {
				throw new Error("XML Parse Error:"+xmlDom.parseError.reason);
			}
			return xmlDom;
		};
		Base.getXML=function (xmlNode) {
			return xmlNode.xml;
		};
	} else if (document.implementation && document.implementation.createDocument) {
		//W3C
		
		Base.getXMLDOM=function () {//获取一个XMLDOM对象
			return document.implementation.createDocument("","",null);
		};
		Base.loadXMLFile=function (xmlDom,url,callback) {
			if (xmlDom.async===true) {
				xmlDom.onload=function () {
					if (xmlDom.documentElement.nodeName=="parsererror") {
						throw new Error("XML Parse Error:"+xmlDom.documentElement.firstChild.nodeValue);
					} else {
						callback.call(xmlDom);
					}
				};
			}
			xmlDom.load(url);
			return xmlDom;
		};
		Base.loadXMLString=function (xmlDom,s) {
			var p = new DOMParser();
			var newDom=p.parseFromString(s,"text/xml");
			if (newDom.documentElement.nodeName=="parsererror") {
				throw new Error("XML Parse Error:"+newDom.documentElement.firstChild.nodeValue);
			}
			while (xmlDom.firstChild) {
				xmlDom.removeChild(xmlDom.firstChild);
			}
			for (var i=0,n;i<newDom.childNodes.length;i++) {
				n=xmlDom.importNode(newDom.childNodes[i],true);
				//importNode用于把其它文档中的节点导入到当前文档中
				//true参数同时导入子节点
				xmlDom.appendChild(n);
			}
			return xmlDom;
		};
		Base.getXML=function (xmlNode) {
			var s= new XMLSerializer();
			return s.serializeToString(xmlNode,"text/xml");
		};
		
	}
		
		

	Base.selectSingleNode=function (node,xpath) {
		if ("selectSingleNode" in node) {
			return node.selectSingleNode(xpath);
		} else {
			var eva = new XPathEvaluator();
			var result=eva.evaluate(xpath,xmlDom,null,XPathResult.ORDERED_NODE_ITERATOR_TYPE,null);
			if (result) {//XPath执行失败会返回null
				var node;
				while (node=result.iterateNext()) {
					return node;
				}
			}
		}
		
	};


	Base.selectNodes=function (node,xpath) {
		if ("selectNodes" in node) {
			return node.selectNodes(xpath);
		} else {
			var eva = new XPathEvaluator();
			var result=eva.evaluate(xpath,xmlDom,null,XPathResult.ORDERED_NODE_ITERATOR_TYPE,null);
			if (result) {//XPath执行失败会返回null
				var node,nodes=[];
				while (node=result.iterateNext()) {
					nodes.push(node);
				}
				return nodes;
			}
		}
	};

	Base.transform=function (xml,xslt,callback) {
		var xmlDom,xsltDom;
		if (typeof xml=="string") {
			xmlDom=Base.getXMLDOM();
			Base.loadXMLFile(xmlDom,xml,function () {
				xsltDom=Base.getXMLDOM();
				Base.loadXMLFile(xsltDom,xslt,function () {
					callback(trans());
				});
			});
		} else {
			xmlDom=xml;
			xsltDom=xslt;
		}
		
		
		
		
		function trans() {
			if ("transformNode" in xmlDom) {
				return xmlDom.transformNode(xsltDom);
			} else {
				var xsltpro=new XSLTProcessor();
				xsltpro.importStylesheet(xsltDom);
				var result=xsltpro.transformToDocument(xmlDom);
				return Base.getXML(result);
			}
		}
		
	};
		
	Base.createXHR=function () {
		return window.XMLHttpRequest?
			new XMLHttpRequest():
			new ActiveXObject("Microsoft.XMLHTTP");//IE6
	};	
	/**
	args {
		url
		method 默认值为get
		success Function
		data {key:value}
		cache Boolean true表示缓存,默认值为false
	}
	*/
	Base.ajax=function(args) {
		var xhr=Base.createXHR(),data=Base.params(args.data);
		args.method=args.method || "get";
		
		if (/get/i.test(args.method)) {
			args.url+="?"+data;
		}
		if (!args.cache) {
			if (args.url.indexOf("?")<0) args.url+="?";
			args.url+="&"+(+new Date());
		}
		xhr.open(args.method,args.url,true);
		
		xhr.onreadystatechange=function () {
			if (xhr.readyState===4 && xhr.status===200) {
				args.success(xhr.responseText,xhr.responseXML);
			}
		};
		if (/post/i.test(args.method)) {
			xhr.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
			xhr.send(data);
		} else {
			xhr.send();
		}
		
	};


	Base.params=function (o) {
		var a=[];
		for (var i in o) {
			if (o[i]!=undefined) {
				a.push(encodeURIComponent(i)+"="+encodeURIComponent(o[i]));
			}
		}
		return a.join("&");
	};
	Base.prefix=function (n,pos) {
		//接受一个数字，加前导0
		//pos 表示当数字少于pos位的时候，加前导0
		n=""+n;
		//n=12,pos=4; 0012
		if (n.length<pos) {
			n="0".repeat(pos-n.length)+n;
		}
		return n;
	};

	Base.swapNode =function (a,b) {
		//parentNode.insertBefore(要插入的节点,原来的节点)
		//parentNode.replaceChild(newNode,child)
		//parentNode.appendChild
		
		var tmp=document.createTextNode("");
		a.parentNode.replaceChild(tmp,a);
		b.parentNode.replaceChild(a,b);
		tmp.parentNode.replaceChild(b,tmp);
		
		
	};

	Base.delNode=function () {
		for (var i=0,node;i<arguments.length;i++) {
			node=arguments[i];
			node.parentNode.removeChild(node);
		}
	};


	function date(s,t) {
		//s Y-m-d H:i:s
		//t new Date()
		t=t || new Date();
		var re=/Y|m|d|H|i|s/g;
		return s.replace(re,function($1) {
			switch($1) {
				case "Y":return t.getFullYear();
				case "m":return t.getMonth()+1;
				case "d":return t.getDate();
				case "H":return t.getHours();
				case "i":return t.getMinutes();
				case "s":return t.getSeconds();
			}
			return $1;
		});
		
	}
	/*
	function $(id) {
		return document.getEementById(id);
	}*/

	function htmlEncode(html) {
		//return html.replace("<","&lt;").replace(">","&gt;")
		arguments.callee.textNode.nodeValue=html;
		return arguments.callee.div.innerHTML;
	}
	htmlEncode.div=document.createElement("div");
	htmlEncode.textNode=document.createTextNode("");
	htmlEncode.div.appendChild(htmlEncode.textNode);
	//命名冲突

	/*
	var htmlEncode=(function () {
		var div=document.createElement("div");
	  var t=document.createTextNode("");
		div.appendChild(t);
		return function (html) {
			//return html.replace("<","&lt;").replace(">","&gt;")
			t.nodeValue=html;
			return div.innerHTML;
		};
	})();
	*/



	function getByClass(className,context) {
		context=context || document;
		if (context.getElementsByClassName) {
			return context.getElementsByClassName(className);
		}
		var nodes=context.getElementsByTagName('*'),
				ret=[];
		for (var i=0;i<nodes.length;i++) {
			if (hasClass(nodes[i],className)) ret.push(nodes[i]);
		}
		return ret;
	}
	function $(id) {
		return document.getElementById(id);
	}

	function hasClass(node,className) {
		var names=node.className.split(/\s+/);
		for (var i=0;i<names.length;i++) {
			if (names[i]==className) return true;
		}
		return false;
	}

	function addClass(o,className) {
		if (!hasClass(o,className)) o.className += " "+className;
		return o;
	}
	function invoke(methodName,context) {
		var args=arguments;
		return function () {
			context[methodName].apply(context,[].slice.call(args,2));
		};
	}
	//invoke(fn,obj,1,2,3) 执行fn函数，并将obj设成fn内部的this指向的对象
	//1,2,3....都是传给fn的参数



	function delClass(o,className) {
		var names=o.className.split(/\s+/);
		for (var i=0;i<names.length;i++) {
			if (names[i]==className) delete names[i];
		}
		o.className=names.join(" ");
		return o;
	}


	function animate(o,start,alter,dur,fx) {
		var curTime=0;
		var t=setInterval(function () {
			if (curTime>=dur) clearInterval(t);
			for (var i in start) {
				o.style[i]=fx(start[i],alter[i],curTime,dur)+"px";
			}
			curTime+=40;
			
		},40);
		return function () {
				clearInterval(t);
		};
	}

	function addEvent(obj,evt,fn) {
		if (obj.addEventListener && !Browser.isOpera) {
			obj.addEventListener(evt,fn,false);
			return obj;
		}
			
			
		if (!obj.functions) obj.functions={};
		if (!obj.functions[evt])
			obj.functions[evt]=[];
			
			//obj.functions["mousedown"]=[]
		var functions=obj.functions[evt];
		for (var i=0;i<functions.length;i++) {
			if (functions[i]===fn) return obj;
		}
		functions.push(fn);
		//fn.index=functions.length-1;
		
		
		if (typeof obj["on"+evt]=="function") {
			//alert(obj["on"+evt]);//当这一行执行到时，obj["on"+evt] 就是handler
			//alert(obj["on"+evt]==handler);
			if (obj["on"+evt]!=handler)
				functions.push(obj["on"+evt]);
		}
		obj["on"+evt]=handler;
		return obj;
		
		
	}

	function delEvent(obj,evtype,fn) {
		if (obj.removeEventListener && !Browser.isOpera) {
			obj.removeEventListener(evtype,fn,false);
			return obj;
		}
		var fns=obj.functions || {};
		fns=fns[evtype] || [];
		for (var i=0;i<fns.length;i++) {
			if (fns[i]==fn) {
				fns.splice(i,1);
				return obj;
			}
		}
	}

	function handler(evt) {//哪个事件发生了?
		//对event对象标准化
		var evt=fixEvt(evt || window.event,this);
		var evtype=evt.type;
		var functions=this.functions[evtype];
		for (var i=0;i<functions.length;i++) {
			if (functions[i]) functions[i].call(this,evt);
		}
	}

	function fixEvt(evt,o) {
		if (!evt.target) {//IE
			evt.target=evt.srcElement;
			if (evt.type=="mouseover")
				evt.relatedTarget=evt.fromElement;
			else if ("mouseout"==evt.type)
				evt.relatedTarget=evt.toElement;
			
			evt.pageX=evt.clientX+document.documentElement.scrollLeft;
			evt.pageY=evt.clientY+document.documentElement.scrollTop;
			evt.stopPropagation=function () {
				evt.cancelBubble=true;
			};
			evt.preventDefault=function () {
				evt.returnValue=false;
			};
		}
		
		//IE与Opera的offsetX,offsetY没有将边框算进之内
		if (o!=window && o.nodeType) {//要求是一个DOM对象
			//evt.layerX=evt.offsetX+o.clientLeft;
			//evt.layerY=evt.offsetY+o.clientTop;
			//如何获取一个DOM元素在页面中的坐标
			var offset=getOffset(o);
			evt.layerX=evt.pageX-offset.x;
			evt.layerY=evt.pageY-offset.y;
			
		}
		
		
		return evt;
	}
	function getRealStyle(o,name) {
		if (window.getComputedStyle) {
			var style=window.getComputedStyle(o,null);
			return style.getPropertyValue(name);
		} else {
			var style=o.currentStyle;
			name=camelize(name);
			if (name=="float")
				name="styleFloat";
			return style[name];
		}
		
	}

	function camelize(s) {//将CSS属性名转换成驼峰式
		return s.replace(/-[a-z]/gi,function (c) {
			return c.charAt(1).toUpperCase();
		});
	}

	function getOffset(o) {
		//o.offsetLeft
		//o.offsetTop
		//o.offsetParent
		var x=y=0,de=document.documentElement;
		if (o==de) {
			return {
				x:de.scrollLeft,
				y:de.scrollTop
			};
		}
		while (o) {
			x+=o.offsetLeft;
			y+=o.offsetTop;
			o=o.offsetParent;
			if (o && o!=de && !Browser.isOpera) {
				x+=o.clientLeft;
				y+=o.clientTop;
			}
		}
		return {
			x:x,
			y:y
		};
	}

	var Tween = {
		Linear:function (start,alter,curTime,dur) {return start+curTime/dur*alter;},//最简单的线性变化,即匀速运动
		Quad:{//二次方缓动
			easeIn:function (start,alter,curTime,dur) {
				return start+Math.pow(curTime/dur,2)*alter;
			},
			easeOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur;
				return start-(Math.pow(progress,2)-2*progress)*alter;
			},
			easeInOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur*2;
				return (progress<1?Math.pow(progress,2):-((--progress)*(progress-2) - 1))*alter/2+start;
			}
		},
		Cubic:{//三次方缓动
			easeIn:function (start,alter,curTime,dur) {
				return start+Math.pow(curTime/dur,3)*alter;
			},
			easeOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur;
				return start-(Math.pow(progress,3)-Math.pow(progress,2)+1)*alter;
			},
			easeInOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur*2;
				return (progress<1?Math.pow(progress,3):((progress-=2)*Math.pow(progress,2) + 2))*alter/2+start;
			}
		},
		Quart:{//四次方缓动
			easeIn:function (start,alter,curTime,dur) {
				return start+Math.pow(curTime/dur,4)*alter;
			},
			easeOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur;
				return start-(Math.pow(progress,4)-Math.pow(progress,3)-1)*alter;
			},
			easeInOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur*2;
				return (progress<1?Math.pow(progress,4):-((progress-=2)*Math.pow(progress,3) - 2))*alter/2+start;
			}
		},
		Quint:{//五次方缓动
			easeIn:function (start,alter,curTime,dur) {
				return start+Math.pow(curTime/dur,5)*alter;
			},
			easeOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur;
				return start-(Math.pow(progress,5)-Math.pow(progress,4)+1)*alter;
			},
			easeInOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur*2;
				return (progress<1?Math.pow(progress,5):((progress-=2)*Math.pow(progress,4) +2))*alter/2+start;
			}
		},
		Sine :{//正弦曲线缓动
			easeIn:function (start,alter,curTime,dur) {
				return start-(Math.cos(curTime/dur*Math.PI/2)-1)*alter;
			},
			easeOut:function (start,alter,curTime,dur) {
				return start+Math.sin(curTime/dur*Math.PI/2)*alter;
			},
			easeInOut:function (start,alter,curTime,dur) {
				return start-(Math.cos(curTime/dur*Math.PI/2)-1)*alter/2;
			}
		},
		Expo: {//指数曲线缓动
			easeIn:function (start,alter,curTime,dur) {
				return curTime?(start+alter*Math.pow(2,10*(curTime/dur-1))):start;
			},
			easeOut:function (start,alter,curTime,dur) {
				return (curTime==dur)?(start+alter):(start-(Math.pow(2,-10*curTime/dur)+1)*alter);
			},
			easeInOut:function (start,alter,curTime,dur) {
				if (!curTime) {return start;}
				if (curTime==dur) {return start+alter;}
				var progress =curTime/dur*2;
				if (progress < 1) {
					return alter/2*Math.pow(2,10* (progress-1))+start;
				} else {
					return alter/2* (-Math.pow(2, -10*--progress) + 2) +start;
				}
			}
		},
		Circ :{//圆形曲线缓动
			easeIn:function (start,alter,curTime,dur) {
				return start-alter*Math.sqrt(-Math.pow(curTime/dur,2));
			},
			easeOut:function (start,alter,curTime,dur) {
				return start+alter*Math.sqrt(1-Math.pow(curTime/dur-1));
			},
			easeInOut:function (start,alter,curTime,dur) {
				var progress =curTime/dur*2;
				return (progress<1?1-Math.sqrt(1-Math.pow(progress,2)):(Math.sqrt(1 - Math.pow(progress-2,2)) + 1))*alter/2+start;
			}
		},
		Elastic: {//指数衰减的正弦曲线缓动
			easeIn:function (start,alter,curTime,dur,extent,cycle) {
				if (!curTime) {return start;}
				if ((curTime==dur)==1) {return start+alter;}
				if (!cycle) {cycle=dur*0.3;}
				var s;
				if (!extent || extent< Math.abs(alter)) {
					extent=alter;
					s = cycle/4;
				} else {s=cycle/(Math.PI*2)*Math.asin(alter/extent);}
				return start-extent*Math.pow(2,10*(curTime/dur-1)) * Math.sin((curTime-dur-s)*(2*Math.PI)/cycle);
			},
			easeOut:function (start,alter,curTime,dur,extent,cycle) {
				if (!curTime) {return start;}
				if (curTime==dur) {return start+alter;}
				if (!cycle) {cycle=dur*0.3;}
				var s;
				if (!extent || extent< Math.abs(alter)) {
					extent=alter;
					s =cycle/4;
				} else {s=cycle/(Math.PI*2)*Math.asin(alter/extent);}
				return start+alter+extent*Math.pow(2,-curTime/dur*10)*Math.sin((curTime-s)*(2*Math.PI)/cycle);
			},
			easeInOut:function (start,alter,curTime,dur,extent,cycle) {
				if (!curTime) {return start;}
				if (curTime==dur) {return start+alter;}
				if (!cycle) {cycle=dur*0.45;}
				var s;
				if (!extent || extent< Math.abs(alter)) {
					extent=alter;
					s =cycle/4;
				} else {s=cycle/(Math.PI*2)*Math.asin(alter/extent);}
				var progress = curTime/dur*2;
				if (progress<1) {
					return start-0.5*extent*Math.pow(2,10*(progress-=1))*Math.sin( (progress*dur-s)*(2*Math.PI)/cycle);
				} else {
					return start+alter+0.5*extent*Math.pow(2,-10*(progress-=1)) * Math.sin( (progress*dur-s)*(2*Math.PI)/cycle);
				}
			}
		},
		Back:{
			easeIn: function (start,alter,curTime,dur,s){
				if (typeof s == "undefined") {s = 1.70158;}
				return start+alter*(curTime/=dur)*curTime*((s+1)*curTime - s);
			},
			easeOut: function (start,alter,curTime,dur,s) {
				if (typeof s == "undefined") {s = 1.70158;}
				return start+alter*((curTime=curTime/dur-1)*curTime*((s+1)*curTime + s) + 1);
			},
			easeInOut: function (start,alter,curTime,dur,s){
				if (typeof s == "undefined") {s = 1.70158;}
				if ((curTime/=dur/2) < 1) {
					return start+alter/2*(Math.pow(curTime,2)*(((s*=(1.525))+1)*curTime- s));
				}
				return start+alter/2*((curTime-=2)*curTime*(((s*=(1.525))+1)*curTime+ s)+2);
			}
		},
		Bounce:{
			easeIn: function(start,alter,curTime,dur){
				return start+alter-Tween.Bounce.easeOut(0,alter,dur-curTime,dur);
			},
			easeOut: function(start,alter,curTime,dur){
				if ((curTime/=dur) < (1/2.75)) {
					return alter*(7.5625*Math.pow(curTime,2))+start;
				} else if (curTime < (2/2.75)) {
					return alter*(7.5625*(curTime-=(1.5/2.75))*curTime + .75)+start;
				} else if (curTime< (2.5/2.75)) {
					return alter*(7.5625*(curTime-=(2.25/2.75))*curTime + .9375)+start;
				} else {
					return alter*(7.5625*(curTime-=(2.625/2.75))*curTime + .984375)+start;
				}
			},
			easeInOut: function (start,alter,curTime,dur){
				if (curTime< dur/2) {
					return Tween.Bounce.easeIn(0,alter,curTime*2,dur) *0.5+start;
				} else {
					return Tween.Bounce.easeOut(0,alter,curTime*2-dur,dur) *0.5 + alter*0.5 +start;
				}
			}
		}
	};