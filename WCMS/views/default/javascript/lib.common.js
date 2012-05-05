/*
 * LIB Common Classes v1.0 beta build 090210 Copyright (c) 2009 iLwave CE. http://ilwave.spaces.live.com
 *
 * this class is part of LIB - a javascript library which is still on designing, and is an extend copy of class "object" in LIB.
 *
 */

var object = { // 类的最基本原型

	extend: function(oDefine)
	{
		!oDefine && (oDefine = {}); // 如果oDefine参数为空则返回的是一个object副本

		var oExtendClass = function() {
			for (var eachMember in oDefine) this[eachMember] = oDefine[eachMember];
		}

		oExtendClass.prototype = this; //这里的this是指object

		return (new oExtendClass());
	},

	New: function()
	{
		var aParams = [];
		
		for (var i=0; i<arguments.length; i++) {
			aParams.push(arguments[i]);
		}

		var oNewInstance = function() { //将arguments对象转换成aParams数组之后传入到新实例中作为构造参数
			this.construct && this.construct.apply(this, aParams);
		};

		oNewInstance.prototype = this;
		
		return (new oNewInstance());
	}
	
};

var Page = object.extend({
	
	/*
	 * 检测浏览器环境，根据不同浏览器的特有内置对象支持来判断，结果如下：
	 *
	 * 1: ie6 或更早版本
	 * 2: ie7 或更新版本
	 * 3: firefox
	 * 4: safari 或 chrome
	 * 5: opera
	 *
	 * 使用方法：var iNav = Page.navigator;
	 *
	 */
	
	navigator: window.ActiveXObject ? window.XMLHttpRequest ? 2 : 1 : window.opera ? 5 : navigator.userAgent.indexOf("KHTML") == -1 ? 3 : 4,


	/*
	 * 页面载入完成之后要运行的函数队列
	 *
	 * 使用方法：Page.onload.push(function(){...});
	 *
	 */
	
	onload: [],
	
	
	/*
	 *
	 *
	 *
	 */
	
	jobList: [],
	
	
	/*
	 *
	 *
	 *
	 */
	 
	_oJobTimeout: null,


	/*
	 * 获取DOM中的HEAD元素
	 *
	 * 使用方法：var oHead = Page.getHeadElement();
	 *
	 */
	
	getHeadElement: function()
	{
		return document.getElementsByTagName('head')[0];
	},
	
	
	/*
	 * 动态添加HEAD中的元素
	 *
	 * sTagName 元素名称，如 link、script等；
	 * oAttrs 属性列表，如 {"type": "text/javascript", "src": "common.js"}；
	 * fOnload (可选) 回调函数，元素载入完成后执行
	 *
	 */
	
	loadHeadElement: function(sTagName, oAttrs, fOnload)
	{
		var newElement = document.createElement(sTagName);
		
		for (var sEachAttr in oAttrs)
		{
			newElement.setAttribute(sEachAttr, oAttrs[sEachAttr]);
		}
		
		if (typeof(fOnload) == "function")
		{
			if(this.navigator < 3) // ie
			{
				newElement.onreadystatechange = function()
				{
					if (this.readyState == 'loaded' || this.readyState == 'complete')
					{
						fOnload();
					}
				};
			}
			else // mozilla like
			{
				newElement.onload = function()
				{
					fOnload();
				};
			}
		}
		
		this.getHeadElement().appendChild(newElement);
	},
	
	/*
	 * 载入 js 脚本
	 *
	 * sSrc 脚本路径
	 * fOnload (可选) 回调函数
	 *
	 */
	
	loadScript: function(sSrc, fOnload)
	{
		this.loadHeadElement("script", {"type": "text/javascript", "src": sSrc}, fOnload);
	},
	
	
	/*
	 * 载入 css 样式表
	 *
	 * sHref 样式表路径
	 * fOnload (可选) 回调函数
	 *
	 */
	
	loadStyle: function(sHref, fOnload)
	{	
		this.loadHeadElement("link", {"type": "text/css", "rel": "stylesheet", "href": sHref}, fOnload);
	},
	
	/*
	 * 设置 Cookie
	 *
	 * oItems = {
	 *	name: "sName",
	 *	value: "sValue",
	 *	expires: nDays,
	 *	path: "sPath"
	 *	domain: "sDomain"
	 * };
	 *
	 */
	
	setCookie: function(oItems)
	{
		var sDate = (new Date()).getTime() + (oItems.expires || 0) * 86400000;
		
		var aCookie = [];
		
			oItems.name && aCookie.push(oItems.name + "=" + escape(oItems.value));
			oItems.expires && aCookie.push("expires=" + (new Date(sDate)).toGMTString());
			oItems.path && aCookie.push("path=" + oItems.path);
			oItems.domain && aCookie.push("domain=" + oItems.domain);
		
		document.cookie = aCookie.join(";");
	},
	
	/*
	 * 获取 Cookie 的值
	 *
	 */
	
	getCookie: function(sName)
	{
		var sValue = document.cookie.match(new RegExp("(^| )" + sName + "=([^;]*)(;|$)"));
		
		return sValue ? unescape(sValue[2]) : null;
	},
	
	/*
	 * 删除 Cookie
	 *
	 */
	
	delCookie: function(sName)
	{
		this.setCookie({name: sName, value: "", expires: -1});
	},
	
	doJob: function()
	{
		if (this.jobList.length ==0) {
			return false;
		}

		var arrCurrJob = this.jobList.shift();
		this._oJobTimeout = window.setTimeout(function(){eval(arrCurrJob[0]); Page.doJob();}, arrCurrJob[1]);
	}

});

var Style = object.extend({
	
	pick: function(oElement, sProperty)
	{
		var bIsW3cMode = document.defaultView && document.defaultView.getComputedStyle;
		var _sProperty = sProperty;
		
		if (_sProperty == "float") _sProperty = bIsW3cMode ? "cssFloat" : "styleFloat";
		
		if (bIsW3cMode) {

			var oStyle = document.defaultView.getComputedStyle(oElement, '');
			
			return oElement.style[sProperty] || oStyle[sProperty];
		}
		else
		{
			return(oElement.style[sProperty] || oElement.currentStyle[sProperty]);
		}
	}
	
});

window.onload = function()
{
	for(var eachFunction in Page.onload)
	{
		Page.onload[eachFunction]();
	}
};

var _ = function(sId){return document.getElementById(sId);};
