var $ = function(id){return document.getElementById(id)};

function showDiv(lab,num,len){
	$(lab+"ti").src="/views/default/skin/default/images/l_"+lab+num+".png";
	for(var i=1; i<=len; i++){
		$(lab+i).style.display="none";
	}
	$(lab+num).style.display="block";
}


<!--/设为首页 加入收藏 兼容Firefox IE-->
// 加入收藏


//------------------------------
// 设为首页
function setHomepage() {
	
	if(document.all) {
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage('http://www.baidu.com');
	}
	else if(window.sidebar) {
		if(window.netscape) {
			try{
				netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
			}
			catch(e) {
				alert("该操作被浏览器拒绝，假如想启用该功能，请在地址栏内输入 about:config,然后将项 signed.applets.codebase_principal_support 值该为true");
			}
		}
		var prefs=Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
		prefs.setCharPref('browser.startup.homepage','http://www.baidu.com');
	}
}