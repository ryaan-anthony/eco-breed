//PAGE HANDLERS
var savedHeight;
var account_redirect = "user.php";
var account_modify_redirect = "editval.php";
var account_breed_div = "";
var account_species_div = "";
$(document).ready(function(){
	page_Nav();
	eco_stare();
	//$('.ui-loader').remove();
});

function fixHeight(){
	var rHeight = $('#content-data').height();
	var sHeight = $('#content-sidebar div:first-child').height();
	if(sHeight>rHeight){
		rHeight = sHeight-15;
		$('#content-right').css("height",rHeight);
	}
	else{
		$('#content-right').css("height","");
	}
	savedHeight=rHeight;
	$('#page').css("height",rHeight+190);
	if($('#page').height()<1048){$('#page').css("height",1048);}
}
function showPopup(show,title,desc){
	var show;
	$('#bugerror').text('');
	$('#emailerror').text('');
	$('#content-data').html("Loading..");//<span style='font-size:0.6em;'> &nbsp;by "+creator+"</span>
	$('#content-title').html(title+"<a style='font-size:0.6em;font-weight:normal;color:#0F67A1;cursor:pointer;text-decoration: underline;float:right;' show='plugins'>&#9668; GO BACK</a>");
	$.ajax({
	type:'GET',
	url: 'plugins/'+show+'.php',
	success: function(data){$('#content-data').html("<p><strong>Plugin Description: </strong><br/>"+desc+"</p>"+data);},
	complete: function(){collapse();fixHeight();}
	});
	$('body').scrollTop(0);
}
function showPage(obj,page){
	var title;
	var show=$(obj).attr('show');
	var findtitle=$(obj).attr('show');
	$('#bugerror').text('');
	$('#emailerror').text('');
	$('#content-data').html("Loading..");
	if(page.length){show=page;findtitle=page;}
	if(show==undefined){show='about';}
	$('#content-left a').each(function() {
		if($(this).attr('show')==show){
			title=$(this).text();
			$(this).parent().css("background-color","#f4f4f4");
		}
		else{
			$(this).parent().css("background-color","none");
		}
	});
	if(title==undefined){
		title='eco breeds by dev khaos';
	}
	else{
		title='eco : '+title;
	}
	//$('#content-title').html(title);
	if(obj!=null){
		window.location='http://eco.takecopy.com?e='+show;
		return;
	}
	else{
		$.ajax({
			type:'GET',
			url: 'content/'+show+'.php',
			statusCode: {
				404: function() {window.location ='http://eco.takecopy.com/?e=about';}
			},
			success: function(data){
				if((show=='myaccount'||show=='legacy') && data==''){show_login();}
				else if(show=='user'){$('#content-data').html(data);if(!$('#login-form').length){show_login();}}
				else{$('#content-data').html(data);}$('#page-title').text(title);},
			complete: function(){collapse();fixHeight();}
		});
		$('body').scrollTop(0);
	}
}
function collapse(){
	$('.expand').each(function(){
		if($(this).hasClass('expanded')){
			$(this).find('.alt-span').show();
			$(this).removeClass('expanded');
			$(this).find('img:not(.bullet-icon)').attr('src','/img/expand.gif');
			if($(this).find('span.video').length){
				$(this).find('span.video').html('');
			}
		}
		$(this).find('span').hide();
	});
	$('#alt-skin').parent().show();
	$('#alt-anim').parent().show();
	fixHeight();
}
function expand(obj){
	collapse();
	var expanded = obj.hasClass('expanded');
	if(!expanded){
		obj.find('.alt-span').hide();
		$(obj).find('span').show();
		obj.find('img:not(.bullet-icon)').attr('src','/img/collapse.gif');
		obj.addClass('expanded');
		if(obj.find('span.video').length){
			obj.find('span.video').html('<iframe class="video" width="420" height="310" src="http://www.youtube.com/embed/'+obj.find('span.video').attr('video')+'?hd=1" frameborder="0" allowfullscreen></iframe>');
		}
	}
	fixHeight();
}
function start(){
	var obj;
	$('#content-left a').each(function() {
	var attribute = $(this).attr('show');
	if(attribute=='about'){obj = $(this);}
	});
	return obj;
}
function jumpPage(attr){
	var obj;
	$('h4').each(function() { 
	var jumpto = $(this).attr('jump');
	if(jumpto==attr){obj = $(this);}
	});
	var position = obj.position();
	$('body').scrollTop(position.top);
}

//NAVIGATION
$('#content-left a, .safe-link a, .sub-content a, .my-species a, .all-breed a, .new-species a, #header a, #header img').live('click',function(){
	if($(this).attr('s')){
		$('.content-tabs').hide();
		$('#content-temp'+account_species_div).html("Loading..");
		$('#content-temp'+account_species_div).show();
		fixHeight();
		$.ajax({
		type:'POST',
		data:'s='+$(this).attr('s'),
			url: 'content/data/'+account_redirect,
			success: function(data){$('#content-temp'+account_species_div).html(data);},
			complete: function(){fixHeight();$('body').scrollTop(0);}
		});
	}
	if($(this).attr('a')){
		$('.content-tabs').hide();
		$('#content-temp'+account_breed_div).html("Loading..");
		$('#content-temp'+account_breed_div).show();
		fixHeight();
		$.ajax({
		type:'POST',
		data:'a='+$(this).attr('a'),
			url: 'content/data/'+account_redirect,
			success: function(data){$('#content-temp'+account_breed_div).html(data);},
			complete: function(){fixHeight();$('body').scrollTop(0);}
		});
	}
	if($(this).attr('popup')){showPopup($(this).attr('popup'),$(this).text(),$(this).parent().next().text());}
	if($(this).attr('show')){showPage($(this),"","");}
	if($(this).attr('jump')){jumpPage($(this).attr('jump'));}
});

$('.expand').live('click',function(e){
	if($(e.target).hasClass('title')||$(e.target).hasClass('icon')){
		expand($(this));
	}
});

//EMAIL SUBMIT
$('#bugsubmit').live('click',function(){
$('#bugerror').text('');
var text = safe_url($('#buginfo').val());
var user = $('#bugname').val();
if(!user.length){user="Unknown";}
if(!text.length){$('#bugerror').text('You must supply a description to submit this form.');}
else{
$.ajax({
type:'POST',
data:'user='+safe_url('ECO Bug Report from: '+user)+'&text='+text,
url: 'func/submit.php',
complete: function(){showPage(start(),"","");alert("Thank you for your feedback!");}
});
}
});



$('#emailsubmit').live('click',function(){
$('#emailerror').text('');
var text = $('#emailinfo').val();
var user = $('#emailname').val();
var email = $('#emailreply').val();
if(!user.length){user="Unknown";}
if(!email.length){email="Unknown";}
if(!text.length){$('#emailerror').text('You must supply a description to submit this form.');}
else{
$.ajax({
type:'POST',
data:'user='+safe_url('ECO Request from: '+user)+'&text='+safe_url('Email: '+email+'\n'+text),
url: 'func/submit.php',
complete: function(){showPage(start(),"","");alert("Thank you for your feedback!");}
});
}
});

//SEARCH
//function searchThis(text){
//if(!text.length){return;}
//$('#search-input').val('');
//$('#bugerror').text('');
//$('#emailerror').text('');
//$('#content-data').html("Loading..");
//$('#content-title').html('Search results');
//$.ajax({
//type:'POST',
//data:'',
//url: 'func/search.php?q='+safe_url(text),
//success: function(data){$('#content-data').html(data);},
//complete: function(){collapse();fixHeight();}
//});
//$('body').scrollTop(0);
//}
//
//$('#search-input').live('keypress',function(e){if(e.which == 13){$('#search-input').blur();e.preventDefault();searchThis($('#search-input').val());return false;}});
//
//$('#search img').live('click',function(){$('#search-input').blur();searchThis($('#search-input').val());});

//FORMATTING
function safe_url(str){
	return encodeURIComponent(str.replace(new RegExp( "\\n", "g" ),"\\n").split('"').join('').split("'").join('').trim().split('  ').join(' '));
}

function compress(params){
	var compressed="";
	var current="";
	var raw="";
	var dec=0;
	var INNER=false;
	for(i=0;i<params.length;i++){
		var char = params[i];
		if(INNER==false && char!="("){current+=char;compressed+=char;}
		if(char=="("){compressed+=char;INNER=true;}
		else if(char==")"){compressed+=raw+char;INNER=false;raw="";dec=0;current="";}
		else if(INNER==true){
			if(char==">"||char==","){dec=0;}
			if(char=="."||dec>0){dec++;}
			if(dec<5){raw+=char;}
		}	
	}
	
	while(compressed.indexOf(' (')!=-1){
		compressed = compressed.split(' (').join('(');
	}
	return compressed;
}

//LOGIN SHOW UI
function show_login(){
$('#content-data').html("Loading..");
$.ajax({
type:'GET',
url: 'content/data/'+account_redirect,
success: function(data){$('#content-data').html(data);},
complete: function(){fixHeight();$('body').scrollTop(0);$('#e-user').css('background','white');}
});
 }
 
//OLD LOGIN FORM 
function eco_logout(){
$.ajax({
type:'GET',
url: 'content/data/unsetcookie.php',
success: function(data){showPage(null,"legacy");}
});
 }
function eco_login(){
$('input').blur();
$('#eco_error').text('');
var name = $('#eco_name').val();
var pw = $('#eco_pw').val();
if(name==undefined||!name.length||!pw.length){$('#eco_error').text('Invalid Login');}
else{
$.ajax({
type:'GET',
url: 'content/data/login.php?name='+safe_url(name)+'&pw='+safe_url(pw),
success: function(data){if(data==="true"){show_login();}else{$('#eco_error').text('Invalid Login');}},
complete: function(){$('#eco_name').val('');$('#eco_pw').val('');}
});
}
 }
$('#eco_logout').live('click',function(){eco_logout();});
$('#eco_login').live('click',function(){eco_login();});

//NEW LOGIN FORM
$('#eco-logout').live('click',function(){
	$.ajax({
		type:'GET',
		url: 'content/data/unsetcookie.php',
		success: function(data){showPage(null,"user");}
	});
});

$('#eco-login').live('click',function(){
	$('input').blur();
	$('#eco-error').text('');
	var name = $('#eco-name').val();
	var pw = $('#eco-pw').val();
	$('#eco-pw').val('');
	if(name==undefined||!name.length
	 ||pw==undefined||!pw.length||name.split(" ").length!=2){$('#eco-error').text('Invalid Login');return;}
	$.ajax({
		type:'GET',
		url: 'content/data/login-1.0.php?type=login&name='+safe_url(name)+'&pw='+safe_url(pw),
		success: function(data){
			if(data==="success"){
				window.location="http://eco.takecopy.com/?e=user";
			}
			else{
				$('#eco-error').text(data);
			}
		}
	});
});

$('#eco-enter').live('click',function(){
	$('input').blur();
	$('#eco-error').text('');
	var name = $('#eco-name').val();
	$('#eco-name').val('');
	var obj = $(this).parent();
	if(name==undefined||!name.length||name.split(" ").length!=2){
		$('#eco-error').text('Invalid Login');
	}
	else{
		$.ajax({
			type:'GET',
			url: 'content/data/login-1.0.php?type=enter&name='+safe_url(name),
			success: function(data){
				if(data==="authorized"){
					obj.after("<p align='center' style='font-family: monospace;font-weight: bold;color: #666;'>Enter your <span class='sub-up' style='color: orangeRed;' >eco password</span> to continue.</p><div align='center'><input  class='wide-input login-input' id='eco-name' value='"+name+"' readonly/><br><input title='Eco Password' placeholder='Eco Password' class='wide-input login-input' id='eco-pw' type='password' /></div><div style='width:450px;'><button style='font-family: monospace;padding:3px 10px;float:right;font-size:1.2em;margin-top:10px' id='eco-login'>Submit</button><a id='eco-reset' class='external'>reset password</a></div>");//insert form
					obj.prev().prev().hide('slow',function(){$(this).remove();});
					obj.prev().hide('slow',function(){$(this).remove();});
					obj.hide('slow',function(){$(this).remove();$('#eco-pw').focus();});
				}
				else if(data==="validate"){
					obj.after("<p align='center' style='font-family: monospace;font-weight: bold;color: #666;'>Enter the <span class='sub-up' style='color: orangeRed;' title='Look in second life local chat for the validation code.'>validation code</span> and <span class='sub-up' style='color: orangeRed;' title='Create a unique password and DO NOT SHARE IT.'>create</span> a password.</p><div align='center'><input  class='wide-input login-input' id='eco-name' value='"+name+"' readonly/><br><input placeholder='Validation Code' title='Validation Code' class='wide-input login-input' id='eco-temp-pw' /><br><input title='Create Password' placeholder='Create Password' class='wide-input login-input' id='eco-pw' type='password' /></div><div style='width:450px;'><button style='font-family: monospace;padding:3px 10px;float:right;font-size:1.2em;margin-top:10px' id='eco-validate'>Submit</button><a id='eco-reset' class='external'>resend validation code</a></div>");//insert form
					obj.prev().prev().hide('slow',function(){$(this).remove();});
					obj.prev().hide('slow',function(){$(this).remove();});
					obj.hide('slow',function(){$(this).remove();});			
				}
				else if(data==="not found"){
					alert("Error: Your account can not be properly validated.Please contact Dev Khaos in world for assistance.");
					window.location='http://eco.takecopy.com/?e=support';
				}
				else{
					$('#eco-error').text('Invalid Login');
				}
			}
		});
	}
});
$('#eco-validate').live('click',function(){
	$('input').blur();
	$('#eco-error').text('');
	var name = $('#eco-name').val();
	var temp = $('#eco-temp-pw').val();
	var pw = $('#eco-pw').val();
	$('#eco-temp-pw').val('');
	$('#eco-pw').val('');
	if(name==undefined||!name.length
	 ||temp==undefined||!temp.length
	 ||pw==undefined||!pw.length||name.split(" ").length!=2){	$('#eco-error').text('Invalid Login');return;}
	$.ajax({
		type:'GET',
		url: 'content/data/login-1.0.php?type=validate&name='+safe_url(name)+'&temp='+safe_url(temp)+'&pw='+safe_url(pw),
		success: function(data){
			if(data==="success"){
				window.location="http://eco.takecopy.com/?e=user";
			}
			else{
				$('#eco-error').text(data);
			}
		}
	});
});
$('#eco-reset').live('click',function(){
	var obj = $(this).parent();
	var name = $('#eco-name').val();
	$.ajax({
		type:'GET',
		url: 'content/data/login-1.0.php?type=reset&name='+safe_url($("#eco-name").val()),
		success: function(data){
			if(data=="sent"){
					alert("A validation code has been sent to you inworld.");
					obj.after("<p align='center' style='font-family: monospace;font-weight: bold;color: #666;'>Enter the <span class='sub-up' style='color: orangeRed;' title='Look in second life local chat for the validation code.'>validation code</span> and <span class='sub-up' style='color: orangeRed;' title='Create a unique password and DO NOT SHARE IT.'>create</span> a password.</p><div align='center'><input  class='wide-input login-input' id='eco-name' value='"+name+"' readonly/><br><input placeholder='Validation Code' title='Validation Code' class='wide-input login-input' id='eco-temp-pw' /><br><input title='Create Password' placeholder='Create Password' class='wide-input login-input' id='eco-pw' type='password' /></div><div style='width:450px;'><button style='font-family: monospace;padding:3px 10px;float:right;font-size:1.2em;margin-top:10px' id='eco-validate'>Submit</button><a id='eco-reset' class='external'>resend validation code</a></div>");//insert form
					obj.prev().prev().hide('slow',function(){$(this).remove();});
					obj.prev().hide('slow',function(){$(this).remove();});
					obj.hide('slow',function(){$(this).remove();});	
			}
			else{
				
					alert("Error: Your account can not be properly validated. Please contact Dev Khaos for help setting up your account.");
					window.location='http://eco.takecopy.com/?e=support';
				
			}
		}
	});
});

//CHAMBER
//$('.ch-input, .ch-sel').live('click',function(){
//	$('#ch-save').removeAttr('disabled');
//});
//$('#ch-reset').live('click',function(){
//	if(!confirm("Are you sure you want to reset these values?")){return;}
//	var ch = $(this).attr('ch'); 
//	$.ajax({
//	type:'GET',
//	url: 'content/data/'+account_modify_redirect+'?chamber_reset='+ch,
//	complete: function(){loadSkin(0,$(this).attr('s'));}
//	});
//});
//$('#ch-save').live('click',function(){
//	$('#ch-save').attr('disabled','disabled');
//	var i;
//	var result = new Array();
//	var ch = $(this).attr('ch'); 
//	for(i=0;i<36;i++){
//		var val = $('#ch-setting-'+(i.toString())).val();
//		if(val=="TRUE"){val="1";}
//		if(val=="FALSE"){val="0";}
//		result.push(val);
//	}
//	$.ajax({
//	type:'GET',
//	url: 'content/data/'+account_modify_redirect+'?chamber_index='+ch+'&result='+safe_url(clean(result.join(',')))
//	});
//});

//SPECIES
//$('#create_species_name').live('keyup',function(){
//	$('#create_species_name_save').removeAttr('disabled');
//});
//
//$('#create_species_name_save').live('click',function(){
//	var s = $(this).attr('s');
//	var name = clean($('#create_species_name').val());
//	$('#create_species_name').val('').blur();
//	//insert record
//	$.ajax({
//		type:'GET',
//		url: 'content/data/'+account_modify_redirect+'?create_species_name='+safe_url(name),
//		success: function(data){
//			if(data=="error"){alert("Unable to create new species!");return;}
//			//loadAnim(0,s);
//			alert("done");
//		}
//	});
//});

$('#species_name').live('keyup',function(){
$('#species_name_save').removeAttr('disabled');
});

$('#species_name_save').live('click',function(){
	var s = $(this).attr('s');
	var name = $('#species_name').val();
	$('#species_name_temp').remove();
	$.ajax({
		type:'POST',
		data:'species_name='+safe_url(name)+'&species_index='+s,
	url: 'content/data/'+account_modify_redirect,
	success: function(data){
		if(data.indexOf("error") != -1){
			$('#species_name_save').parent().after('<p id="species_name_temp" style="color:orangered;" align="center">'+data+'</p>');
			return;
		}
		//page = "e-species";
		$('#content-temp'+account_species_div).html("Loading..");
		fixHeight();
		if(s=="" || s==undefined){s=data;}		
		$.ajax({
		type:'POST',
		data:'s='+s,
			url: 'content/data/'+account_redirect,//fix (universal show species)
			success: function(data){$('#content-temp'+account_species_div).html(data);/*$('#'+page).css('background','white');*/},
			complete: function(){
				$('body').scrollTop(0);
				$('.content-tabs').hide();
				$('#content-temp'+account_species_div).show();
				fixHeight();
			}
		});
	}
	});
});

$('#species_delete').live('click',function(){
	if(!confirm("Are you sure you want to delete this species?")){return;}
	if(!confirm("This will delete all skins, animations, and configurations associated with this species. Are you REALLY sure you want to delete this species?")){return;}
	var s = $(this).attr('s'); 
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&value=DELETE',
		url: 'content/data/'+account_modify_redirect,
//		success: function(data){alert(data);},
		complete: function(){
			page = "e-species";
			$('#content-data').html("Loading..");
			fixHeight();
			$.ajax({
				type:'GET',
				url: 'content/data/'+account_redirect,
				success: function(data){$('#content-data').html(data);$('#'+page).css('background','white');},
				complete: function(){
					$('body').scrollTop(0);
					$('.content-tabs').hide();
					$('#content-'+page).show();
					fixHeight();
				}
			});
		}
	});
});

$('#species_name_cancel').live('click',function(){
	page = "e-species";
	$('#content-data').html("Loading..");
	fixHeight();
	$.ajax({
		type:'GET',
		url: 'content/data/'+account_redirect,
		success: function(data){$('#content-data').html(data);$('#'+page).css('background','white');},
		complete: function(){
			$('body').scrollTop(0);
			$('.content-tabs').hide();
			$('#content-'+page).show();
			fixHeight();
		}
	});
});
$('#species_number_new').live('click',function(){
	if(!confirm("Are you sure you want to reset the species ID?")){return;}
	if(!confirm("This will cause all existing breeds to self destruct. The purpose of this function is to keep all skins, animations, and configurations while creating a new species and wiping the old. Are you REALLY sure you want to reset the species ID?")){return;}
	var s = $(this).attr('s'); 
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&value=NUMBER',
	url: 'content/data/'+account_modify_redirect,
	success: function(data){
		if(data.indexOf("error") != -1){alert(data);return;}
		page = "e-species";
		$('#content-data').html("Loading..");
		fixHeight();
		$.ajax({
			type:'GET',
			url: 'content/data/'+account_redirect,
			success: function(data){$('#content-data').html(data);$('#'+page).css('background','white');},
			complete: function(){
				$('body').scrollTop(0);
				$('.content-tabs').hide();
				$('#content-'+page).show();
				fixHeight();
			}
		});
	}
	});
});

//SKINS
function loadSkin(num,s){
	$('.content-tabs').hide();
	$('#content-temp'+account_species_div).html("Loading..");
	$('#content-temp'+account_species_div).show();
	fixHeight();
	$.ajax({
		type:'POST',
		data:'s='+s+'&skin_index='+num,
	url: 'content/data/'+account_redirect,
	success: function(data){$('#content-temp'+account_species_div).html(data);},
	complete: function(){
		fixHeight();
		$('body').scrollTop(0);
		//if(show!=undefined){
		expand($('#alt-skin').parent().parent());
		//}
	}
	});
}

$('#skin_save').live('click',function(){
	$(this).attr('disabled','disabled');
	var num = $(this).attr('skin');
	var s = $(this).attr('s');
	var name = $('#skin-name').val();
	if(!$('#skin-name:visible').length){name=$('#skin-name-new').val();}
	if(name==""){name="None";}
	var category = $('#cat-name').val();
	if(!$('#cat-name:visible').length){category=$('#cat-name-new').val();}
	if(category=="undefined"||category==""){category="None";}
	var gen = $('#skin-gen').val();
	if(gen=="undefined"||parseInt(gen)==0||gen==""){gen="1";}
	var odds = $('#skin-odds').val();
	if(odds=="undefined"||odds==""||parseInt(odds)<-1){odds="0";}
	var limit = $('#skin-limit').val();
	if(limit=="undefined"||limit==""||parseInt(limit)<-1){limit="-1";}
	var params = $('#skin-params').val();
	//params = params.replace(new RegExp( "\\n", "g" ),"").split(' ').join('');
	params = compress(params);
	var str = safe_url(name.trim()+":;:"+category.trim()+":;:"+gen+":;:"+odds+":;:"+params.trim()+":;:"+limit);
	//alert(name+":;:"+category+":;:"+gen+":;:"+odds+":;:"+params+":;:"+limit);
	//alert(str);
	$.ajax({
		type:'POST',
		data:'skin_index='+num+'&species_index='+s+'&value='+str,
	url: 'content/data/'+account_modify_redirect,
	//success: function(data){alert(data);},
	complete: function(){loadSkin(num,s);}
	});
});

$('#skin_cancel').live('click',function(){
	var num = $(this).attr('skin');
	var s = $(this).attr('s');
	if($('#skin_save:disabled').length){collapse();return;}
	loadSkin(num,s);
});

$('#skin_delete').live('click',function(){
	if(!confirm("Are you sure you want to delete this skin?")){return;}
	var num = $(this).attr('skin');
	var s = $(this).attr('s');
	$.ajax({
		type:'POST',
		data:'skin_index='+num+'&species_index='+s+'&value=DELETE',
	url: 'content/data/'+account_modify_redirect,
	complete: function(){loadSkin(0,s);}
	});
});

$('#skin-name').live('change',function(){
	var num = $('#skin-name option:selected').attr('skin');
	var s = $(this).attr('s');
	loadSkin(num,s);
});

$('#cat-name').live('change',function(){
	var num = $('#cat-name option:selected').attr('cat');
	var c = $(this).attr('c');
	loadSkin(num,c);
});

$('#skin-name-edit').live('click',function(){
	$('#skin_save').removeAttr('disabled');
	$('#skin-name-edit').hide();
	$('#skin-name').hide();
	$('#skin-name-new').show().focus();
});

$('#cat-name-edit').live('click',function(){
	$('#skin_save').removeAttr('disabled');
	$('#cat-name-edit').hide();
	$('#cat-name').hide();
	$('#cat-name-new').show().focus();
});

$('#skins-add-new').live('click',function(){
	collapse();
	$(this).next().show();
	$(this).next().next().hide();
	$(this).prev().find('.alt-span').hide();
	$('#skin-name-show').show();
	$('#cat-name-show').show();
	$('#skin_delete').hide();
	$('#skin_save').removeAttr('disabled');
	$('#skin-name-edit,#cat-name-edit').hide();
	$('#skin-name,#cat-name').hide();
	$('#cat-name-new,#skin-name-new').val('').show();
	$('#skin-name-new').focus();
	$('#skin-params, #skin-gen, #skin-odds, #skin-limit').val('');
	$('#skin_save').attr('skin',$(this).attr('next'));
});

$('#skin-gen, #skin-odds, #skin-limit').live('click',function(){
	$('#skin_save').removeAttr('disabled');
});

$('#skin-params,#skin-gen, #skin-odds, #skin-limit').live('keyup',function(){
	$('#skin_save').removeAttr('disabled');
});

//ANIMS
function loadAnim(num,s){
	$('.content-tabs').hide();
	$('#content-temp'+account_species_div).html("Loading..");
	$('#content-temp'+account_species_div).show();
	fixHeight();
	$.ajax({
		type:'POST',
		data:'s='+s+'&anim_index='+num,
	url: 'content/data/'+account_redirect,
	success: function(data){$('#content-temp'+account_species_div).html(data);},
	complete: function(){fixHeight();$('body').scrollTop(0);expand($('#alt-anim').parent().parent());}
	});
}
$('#anim_save').live('click',function(){
	$(this).attr('disabled','disabled');
	var num = $(this).attr('anim');
	var s = $(this).attr('s');
	var name = $('#anim-name').val();
	if(!$('#anim-name:visible').length){name=$('#anim-name-new').val();}
	if(name==""){name="None";}
	var stages = $('#anim-stages').val();
	if(stages=="undefined"||parseInt(stages)<1||stages==""){stages="1";}
	var repeat = $('#anim-repeat').val();
	if(repeat=="undefined"||parseInt(repeat)<-1||repeat==""){repeat="0";}
	var delay = $('#anim-delay').val();
	if(delay=="undefined"||delay==""||parseInt(delay)<0){delay="0";}
	var params = $('#anim-params').val();
	//params = params.replace(new RegExp( "\\n", "g" ),"").split(' ').join('');
	params = compress(params);
	var str = safe_url(name.trim()+":;:"+repeat.trim()+":;:"+delay.trim()+":;:"+params.trim()+":;:"+stages.trim());
	$.ajax({
	type:'POST',
	data: 'anim_index='+num+'&species_index='+s+'&value='+str,
	url: 'content/data/'+account_modify_redirect,
//	success: function(data){alert(data);},
	complete: function(){loadAnim(num,s);}
	});
});

$('#anim_cancel').live('click',function(){
	var num = $(this).attr('anim');
	var s = $(this).attr('s');
	if($('#anim_save:disabled').length){collapse();return;}
	loadAnim(num,s);
});

$('#anim_delete').live('click',function(){
	if(!confirm("Are you sure you want to delete this anim?")){return;}
	var num = $(this).attr('anim');
	var s = $(this).attr('s');
	$.ajax({
		type:'POST',
		data:'anim_index='+num+'&species_index='+s+'&value=DELETE',
	url: 'content/data/'+account_modify_redirect,
	complete: function(){loadAnim(0,s);}
	});
});

$('#anim-name').live('change',function(){
	var num = $('#anim-name option:selected').attr('anim');
	var s = $(this).attr('s');
	loadAnim(num,s);
});

$('#anim-name-edit').live('click',function(){
	$('#anim_save').removeAttr('disabled');
	$('#anim-name-edit').hide();
	$('#anim-name').hide();
	$('#anim-name-new').show().focus();
});

$('#anims-add-new').live('click',function(){
	collapse();
	$(this).next().show();
	$(this).next().next().hide();
	$(this).prev().find('.alt-span').hide();
	$('#anim-name-show').show();
	$('#cat-name-new').show();
	$('#anim_delete').hide();
	$('#anim_save').removeAttr('disabled');
	$('#anim-name-edit').hide();
	$('#anim-name').hide();
	$('#anim-name-new').val('').show().focus();
	$('#anim-params, #anim-repeat, #anim-delay').val('');
	$('#anim-stages').val('1');
	$('#anim_save').attr('anim',$(this).attr('next'));
});

$('#anim-repeat, #anim-delay, #anim-stages').live('click',function(){
	$('#anim_save').removeAttr('disabled');
});

$('#anim-params,#anim-repeat, #anim-delay, #anim-stages').live('keyup',function(){
	$('#anim_save').removeAttr('disabled');
});

//BREEDS
$('#all_breed_rebuild').live('click',function(){
if(!confirm("Are you sure you want to rebuild this breed? Other breeds with the same key will be destroyed.")){return;}
var a = $(this).attr('a');
$.ajax({
		type:'POST',
		data:'all_breed_index='+a+'&rebuild=TRUE',
url: 'content/data/'+account_modify_redirect
});
});

$('#all_breed_delete').live('click',function(){
	if(!confirm("Are you sure you want to delete this breed record? If the breed is still active, it will re-appear in this list.")){return;}
	var a = $(this).attr('a');
	$(this).parent().parent().remove();
	//var breed_id = $(this).attr('class');
	//$('td a').each(function(e){
	//var cur = $(this).attr('a');
	//var cur_id = $(this).attr('breed_id');
	//if(cur==a){$(this).parent().parent().remove();}
	//else if(breed_id==cur_id){$(this).parent().parent().remove();}
	////if(parseInt(cur)>a){$(this).attr('a',(parseInt(cur)-1));}
	//});
	$.ajax({
		type:'POST',
		data:'all_breed_index='+a+'&delete=TRUE',
		url: 'content/data/'+account_modify_redirect,
		complete: function(){$('.content-tabs').hide();$('#content-e-all').show();}
	});
});

$('#all_breed_name_save').live('click',function(){
	var a = $(this).attr('a');
	var breed_id = $(this).attr('class');
	var name = $('#all_breed_name').val();
	$('#all_breed_name_save').prop('disabled',true);
	$('td a').each(function(e){
		if($(this).attr('a')==a){$(this).text(name);}
		else if($(this).attr('breed_id')==breed_id){$(this).text(name);}
	});
	$.ajax({
		type:'POST',
		data:'all_breed_name='+safe_url(name)+'&all_breed_index='+a,
		url: 'content/data/'+account_modify_redirect
	});
});

$('#all_breed_name').live('keyup',function(){
$('#all_breed_name_save').removeAttr('disabled');
});

//SORTING
$('th').live('click',function(e){
if($(this).attr('class')=='pluggables'){return;}
var obj_clicked = $(this);
	var find_id = obj_clicked.attr('id');
	var list = find_id.split('-');
	var find_type = list[2];
	var find_class = obj_clicked.attr('class');
	list = find_class.split(' ');
	find_class = list[0];
	var DESC = false;
	$('th.'+find_class).each(function(e){
		if($(this).attr('id')!=find_id && $(this).hasClass('ASC')){$(this).removeClass('ASC');}				  
	});
	if(obj_clicked.hasClass('ASC')){obj_clicked.removeClass('ASC'); DESC=true;}
	else{obj_clicked.addClass('ASC');}
	var sort_data = new Array();
	var html_data = new Array();
	$('.'+find_class+'-sortable').each(function(i){
		var sort_index = $(this).attr(find_class+'-index');
		var sort_attr = $(this).attr(find_id);
		sort_data[i]=sort_attr+":;:"+sort_index;
		html_data[sort_index]=$(this).clone().wrap('<div>').parent().html();
	});
	$('.'+find_class+'-sortable').remove();
	if(find_type=='age'||find_type=='family'||find_type=='live'||find_type=='total'){sort_data.sort(numOrdA);}
	else{sort_data.sort();}
	for(i=0;i<sort_data.length;i++){
		var ind = i;
		if(DESC){ind=(sort_data.length)-1-i;}
		var cur = sort_data[ind];
		var info = cur.split(":;:");
		var index = info[1];
		$('table.'+find_class).append(html_data[index]);
	}
});

function numOrdA(a, b){
	var list = a.split(':;:');
	a=list[0];
	list = b.split(':;:');
	b=list[0];
	a=parseInt(a);
	b=parseInt(b);
	if(a > b){return 1;}
	else if(a < b){return -1;}
	else{return 0;}
}

$('.filter').live('change',function(){
	var selected_filter=$(this).find('option:selected').attr('class');
	$('.'+selected_filter).selected(true);
	var filter = selected_filter.split("-");
	var type = filter[1];
	var value = filter[2];
	$('.all-breed-sortable').each(function(){
	if($(this).hasClass(type+'-hide')){$(this).removeClass(type+'-hide');}//show all
	if(value!='all'&&$(this).attr(type)!=value){$(this).addClass(type+"-hide");}//hide if doesnt contain value
	});
	fixHeight();
});

$('.check-all').live('click',function(){
var type=$(this).attr('type');
$('.checkbox').each(function(){
var visible=$(this).is(':visible');	
if(visible){
var checkbox=$(this).attr(type);
if(checkbox.length){$(this).selected(true);}
}
});
});

$('.check-none').live('click',function(){
var type=$(this).attr('type');
$('.checkbox').each(function(){
var visible=$(this).is(':visible');	
if(visible){
var checkbox=$(this).attr(type);
if(checkbox.length){$(this).selected(false);}
}
});
});

$('.check-del').live('click',function(){
	var total = new Array();
	var keys = new Array();
	var type=$(this).attr('type');
	$('.checkbox').each(function(){
		var checked=$(this).is(':checked');
		var visible=$(this).is(':visible');
		if(checked&&visible){
		var checkbox=$(this).attr(type);
		var breed_id=$(this).next().attr('breed_id');
		if(checkbox.length){total.push(checkbox);keys.push(breed_id);}
		}
	});
	if(total.length){
		if(!confirm("Are you sure you want to delete these "+total.length+" breeds?")){return;}	
		var send = total.join('_');
		$.ajax({
			type:'POST',
			data:'delete_type='+type+'&delete_indexes='+send,
			url: 'content/data/'+account_modify_redirect,
			success: function(data){
				$('td a').each(function(){
					if($.inArray($(this).attr('breed_id'), keys)!=-1){$(this).parent().parent().remove();}
				});
	//			var my_breed_index = new Array();
	//			$('.my_breed_index').each(function(){
	//				my_breed_index[parseInt($(this).attr('b'))]=$(this).attr('breed_id');
	//			});
	//			var index = 0;
	//			for(var key in my_breed_index){
	//				$('.my_breed_index').each(function(){
	//					if($(this).attr('breed_id')==my_breed_index[key]){
	//						$(this).attr('b',index);
	//						$(this).prev().attr('b',index);
	//						$(this).parent().parent().attr('my-breed-index',index);
	//						index++;
	//					}
	//				});
	//			}
	//			var all_breed_index = new Array();
	//			$('.all_breed_index').each(function(){
	//				all_breed_index[parseInt($(this).attr('a'))]=$(this).attr('breed_id');
	//			});
	//			index = 0;
	//			for(var key in all_breed_index){
	//				$('.all_breed_index').each(function(){
	//					if($(this).attr('breed_id')==all_breed_index[key]){
	//						$(this).attr('a',index);
	//						$(this).prev().attr('a',index);
	//						$(this).parent().parent().attr('all-breed-index',index);
	//						index++;
	//					}
	//				});
	//			}
			},
			complete: function(){
				$('body').scrollTop(0);
				$('.checkbox').selected(false);	
				fixHeight();
			}
		});
	}
});

//MY ACCOUNT
$('.tabs').live('click',function(){
	$('.checkbox').selected(false);
	var page = $(this).attr('id');
	if($(this).attr('page')!=undefined){
		page = $(this).attr('page');
		$('.tabs').each(function(){if(!$(this).hasClass('sub-next')){$(this).css('background','none');$(this).css('color','#555');}});
		$('.sub-content').hide();
		$('.sub-default').show();
		$('body').scrollTop(0);
	}
	$('.tabs').each(function(){if(!$(this).hasClass('sub-next')){$(this).css('background','buttonface');}});
	$('#'+page).css("background","white");
	
	if(page!='e-all'){//show all owners
		$('.filter-owner-all').selected(true);
		$('.my-breed-sortable, .all-breed-sortable').each(function(){
		if($(this).hasClass('owner-hide')){$(this).removeClass('owner-hide');}
	});
	}
	if($('#content-'+page+":visible").length && $(this).parent().attr('id')!="howto"){	
		$('#content-data').html("Loading..");
		fixHeight();
		$.ajax({
		type:'GET',
		url: 'content/data/'+account_redirect,
		success: function(data){$('#content-data').html(data);$('#'+page).css('background','white');},
		complete: function(){
			$('body').scrollTop(0);
			$('.content-tabs').hide();
			$('#content-'+page).show();
			fixHeight();
		}
		});
		return;
	}
	else{
		$('.content-tabs').hide();
		$('#content-'+page).show();
		//setTab(page);
		fixHeight();
	}
});

$('#get_api').live('click',function(){
	$.ajax({
	type:'GET',
	url: 'content/data/getapi.php',
	success: function(data){if(data!=""){$('#api_key').html(data);}}
	});
});

$('#toggle-json').live('click',function(){
	$('#json-container').toggle();
	fixHeight();
});

$.fn.selected = function(select) {
	if (select == undefined) select = true;
		return this.each(function() {
			var t = this.type;
			if (t == 'checkbox' || t == 'radio')
				this.checked = select;
			else if (this.tagName.toLowerCase() == 'option') {
				var $sel = $(this).parent('select');
				if (select && $sel[0] && $sel[0].type == 'select-one') {
					// deselect all other options
					$sel.find('option').selected(false);
				}
				this.selected = select;
			}
		});
};

$('#alt-skin').live('change', function(){
	var val = $(this).find('option:selected').attr('skin');
	var s = $(this).find('option:selected').attr('s');
	loadSkin(val,s);
});

$('#alt-anim').live('change', function(){
	var val = $(this).find('option:selected').attr('anim');
	var s = $(this).find('option:selected').attr('s');
	loadAnim(val,s);
});

//IMAGE EFFECTS
function eco_blink(){
$('.eco-breed-object').attr('src', 'img/eco-big1.png');
setTimeout("eco_stare();",200);
}
function eco_stare(){
$('.eco-breed-object').attr('src', 'img/eco-big0.png');
setTimeout("eco_blink();",(Math.floor(Math.random()*11)+5)*500);
}

//CRON SETTINGS
$('#dead-time').live('keyup',function(){
$('#dead-set').removeAttr('disabled');								   
});
$('#inactive-time').live('keyup',function(){
$('#inactive-set').removeAttr('disabled');								   
});
$('#dead-type').live('click',function(){
$('#dead-set').removeAttr('disabled');								   
});
$('#inactive-type').live('click',function(){
$('#inactive-set').removeAttr('disabled');								   
});

$('#inactive-set').live('click',function(){
var type = $('#inactive-type').val();
var time = $('#inactive-time').val();
$('#inactive-set').attr('disabled','disabled');
if(time=="0"){type="never";$('#inactive-time').val('');}
var message = "Records will never be removed for inactive breeds.";
if(type!='never'){message = "Records will be removed after "+time+" "+type+" for inactive breeds.";}
else{time="0";$('#inactive-time').val('');}
time=parseInt(time);
if(!confirm(message)){return;}
$.ajax({
		type:'POST',
		data:'inactive_type='+safe_url(type)+'&inactive_time='+time,
url: 'content/data/'+account_modify_redirect//,
//success: function(data){alert(data);}
});
});

$('#dead-set').live('click',function(){
var type = $('#dead-type').val();
var time = $('#dead-time').val();
$('#dead-set').attr('disabled','disabled');
if(time=="0"){type="never";$('#dead-time').val('');}
var message = "Records will never be removed for dead breeds.";
if(type!='never'){message = "Records will be removed after "+time+" "+type+" for dead breeds.";}
else{time="0";$('#dead-time').val('');}
time=parseInt(time);
if(!confirm(message)){return;}
$.ajax({
		type:'POST',
		data:'dead_type='+safe_url(type)+'&dead_time='+time,
url: 'content/data/'+account_modify_redirect
});
});

//TABB'D NAVIGATION
//tabs
//$('.howto-btn').live('click', function(){
//	$('.sub-tab').each(function(){if(!$(this).hasClass('sub-next')){$(this).css('background','none');$(this).css('color','#555');}});
//	$('.sub-content').hide();
//	$('.sub-default').show();
//	fixHeight();
//	$('body').scrollTop(0);
//	var id = $(this).attr('id');
//	if(id=="e-all" || id=="e-species" || id=="e-api"){return;}
//	setSub("");
//});
//sub tabs
$('.sub-tab, .sub-info li').live('click', function(){
	var num = $(this).attr('num');
	setSub(num);
	$('.frame-'+num).each(function(){
		if($(this).attr('num') !== undefined){$(this).hide();}
		else{$(this).show();}
	});		
	$('.sub-content').hide();
	$('.sub-tab').each(function(){if(!$(this).hasClass('sub-next')){$(this).css('background','none');$(this).css('color','#555');}});
	if(!$(this).hasClass('sub-next')&&!$(this).parent().parent().hasClass('sub-info')){
		$(this).css('background', '#eee');
		$(this).css('color', 'black');
	}
	else{
		$('.sub-tab').each(function(){
			if($(this).attr('num')==num && !$(this).hasClass('sub-next')){
				$(this).css('background', '#eee');
				$(this).css('color', 'black');
			}
		});
	}
	$('.sub-content').each(function(){
		if($(this).attr('num')==num){$(this).show();fixHeight();$('body').scrollTop(0);}
	});
});
//try it
$('.sub-in-btn').live('click',function(){
	var num = $(this).attr('num');
	var Class = $(this).parent().parent().parent().attr('class');
	$('.'+Class).each(function(){
		if($(this).attr('num') == num){$(this).show();}
		else{$(this).hide();}
	});
	fixHeight();
	$('body').scrollTop(0);	
});
//try it (back)
$('.sub-back').live('click',function(){
	var Class = $(this).parent().attr('class');
	$('.'+Class).each(function(){
		if($(this).attr('num') !== undefined){$(this).hide();}
		else{$(this).show();}
	});			
	fixHeight();
	$('body').scrollTop(0);				   
});

//function setSub(num){
//$.ajax({
//		type:'GET',
//		url: 'content/howto/session.php?num='+num
//	});	
//}
//function setTab(id){
//if(id=="e-all" || id=="e-species" || id=="e-api" || id=="e-user" || id == "e-action"){return;}
//	$.ajax({
//		type:'GET',
//		url: 'content/howto/session.php?id='+id
//	});	
//}
function wtSession(id, num){
	$('.content-tabs').hide();
	$('#content-'+id).show();
	$('.tabs').each(function(){if(!$(this).hasClass('sub-next')){$(this).css('background','buttonface');$(this).css('color','#555');}});
	$('#'+id).css("background","white");
	$('.sub-content').hide();
	if(num==""){$('.sub-default').show();}
	else{
		$('.sub-tab').each(function(){
			if($(this).attr('num')==num && !$(this).hasClass('sub-next')){
				$(this).css('background', '#eee');
				$(this).css('color', 'black');
			}
		});
		$('.sub-content').each(function(){if($(this).attr('num')==num){$(this).show();}});
	}
	fixHeight();
	$('body').scrollTop(0);
}

$('.codeblock').live('dblclick',function(){
	SelectText($(this).find('pre').attr('id'));
});

//$('#hello-eco').live('click',function(){
//	if($(this).attr('show')=='about'){window.location='http://eco.takecopy.com';}
//})

$('.wthide').live('click',function(){
	$(this).next().toggle();
	fixHeight();
});
function eco_wave0(){
	$('#wave-object').attr('src', 'img/howto/wave0.png');
	setTimeout("eco_wave1();",500);
}
function eco_wave1(){
	$('#wave-object').attr('src', 'img/howto/wave1.png');
	setTimeout("eco_wave0();",500);
}

function SelectText(element) {
    var doc = document;
    var text = doc.getElementById(element);    
    if (doc.body.createTextRange) {
        var range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        var selection = window.getSelection();        
        var range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

//CONFIGURATIONS : GLOBAL
$('.disabled-input').live('click', function(){
	$(this).select();
});
function hide_child(val,id){
	if(val){$('.child-'+id).show('slow',function(){fixHeight();});}
	else{$('.child-'+id).hide('slow',function(){fixHeight();});}
}
$('.hide-show').live('change',function(){
	hide_child(($(this).val()=="SHOW"),$(this).attr('id'));
});
$('.hide-false').live('change',function(){
	hide_child(($(this).val()!="NO"),$(this).attr('id'));
});
$('.hide-zero').live('change click',function(){
	hide_child((parseInt($(this).val())>0),$(this).attr('id'));
});
$('.number-child').live('click',function(){
	var dir = parseFloat($(this).attr('dir'));
	var input = $(this).parent().find('.number-input');
	var value = parseFloat(input.val())+dir;
	var percent ='';
	if(input.hasClass('percent')){percent='%';}
	if(input.hasClass('hide-zero')){hide_child((value>0),input.attr('id'));}
	var half = value.toString().split('.');
	if(half[1]!=undefined){value = half[0]+"."+half[1].substr(0,2);}
	if(parseFloat(value)<0){value=0;}
	input.val(value+percent);	
});

//CONFIGURATIONS : BREED-RULE

$('#Preferred_Skins').live('change',function(){
	var selection = $(this).val();
	var data = selection.split('(');
	var skin = data[0];
	var category = data[1];
	category = category.split(')').join('');
	$(this).find("option:selected").remove();
	var randomNum = Math.floor(Math.random() * 999999) + 2;
	$(this).parent().next().prepend("<p id='focus-"+randomNum+"' style='display:none;'><label><input key='"+skin.trim()+";"+category.trim()+"' type='checkbox' class='skin-val' checked/> "+selection+"</label></p>");
	$('#focus-'+randomNum).show('slow',function(){fixHeight();});
});
$('#Activation_Param').live('click change', function(){
	if($(this).val()=="Custom" && $('#Activation_Param_Custom').length){return;}
	$('#Activation_Param_Custom').parent().parent().hide('slow',function(){$(this).remove();});
	if($(this).val()=="Custom"){
		var randomNum = Math.floor(Math.random() * 999999) + 2;
		$(this).parent().parent().after('<div id="focus-'+randomNum+'" style="display:none;" class="sub-block">\'Parent\' with secure rez start_param: <div style="position: absolute;top: 0;right: 20px;"><input id="Activation_Param_Custom" class="wide-input number-input" value="0" style="width:90px;font-family: monospace;"><button class="number-child" dir="-1" style="margin-left: 7px;">&#x25be;</button><button class="number-child" dir="1" style="margin-left: 7px;">&#x25b4;</button></div></div>');	
		$('#focus-'+randomNum).show('slow',function(){fixHeight();});	
	}
});
$('.remove-global').live('click',function(){
	if(!confirm("Are you sure you want to delete this global value?")){return;}
	$(this).parent().hide('slow',function(){
		$(this).remove();
		if($('#Globals p').length==0){
			$('#Globals-Header').hide();
			$('#Lineage_Selection').parent().parent().hide();
		}
	});
});
$('#new-global').live('click',function(){
var gVal = $('#new-global-value').val();
$('#new-global-value').val('');
if(gVal=="" || gVal==undefined){return;}
if($("#prop-"+gVal.split(' ').join('-')).val()!=undefined){alert("A global values called \""+gVal+"\" is already defined!");return;}
$('#Globals-Header').show();
$('#Globals-Header').after("<p style='display:none;'><input id='line-"+gVal.split(' ').join('-')+"' type='checkbox' style='margin: 0 35px;'/><input  class='Globals-keyval' style='margin-left: 10px;' value='"+gVal+"' readonly /><input style='margin-left: 10px;' id='prop-"+gVal.split(' ').join('-')+"' /><a style='margin-left: 23px;color:orangered;' class='remove-global'>remove</a></p>");
$('#Globals-Header').next().show('slow',function(){
	$('#Lineage_Selection').parent().parent().show();
	fixHeight();
});
});
function update_library(){
	var data = ["Prefix", "Middle", "Female_Suffix", "Male_Suffix"];
	for(i=0;i<data.length;i++){
		var result = new Array();
		$('#'+data[i]+' input').each(function(){
			if($(this).attr('for')==data[i]){
				result.push($(this).val());
			}
		});
		$('#'+data[i]).attr('value',result.join(','));
	}
}
$('.add-library').live('click',function(){
	var randomNum = Math.floor(Math.random() * 999999) + 2;
	$(this).parent().parent().append("<div style='margin-right:10px;width:35px;position:relative;display:inline-block;'><input id='focus-"+randomNum+"'  class='library' for='"+$(this).parent().parent().attr('id')+"' style='height: 9px;width:35px;font-size: 0.9em;font-family: monospace;' value=''/><a title='remove' style='color: black;font-weight: bold;font-family: sans-serif;font-size: 0.6em;'class='remove-library'>&#x58;</a></div>");
$('#focus-'+randomNum).focus();
	update_library();
});
$('.remove-library').live('click',function(){
	$(this).parent().hide('slow',function(){$(this).remove();});
	update_library();
});
$('.library').live('change',function(){
	update_library();
});
$('#Allowed_Types').live('change',function(){
	var selection = $(this).val();
	$(this).find("option:selected").remove();
	var randomNum = Math.floor(Math.random() * 999999) + 2;
	$(this).parent().next().prepend("<p id='focus-"+randomNum+"' style='display:none;'><label><input class='sync-val wide-input' style='width:150px;font-family: monospace;' value='"+selection+"'/></label></p>");
	$('#focus-'+randomNum).show('slow',function(){fixHeight();});
});

//CONFIGURATIONS : BREED
function loadBreedRules(num,s){
	//collapse();
	$('.content-tabs').hide();
	$('#content-temp'+account_species_div).html("Loading..");
	$('#content-temp'+account_species_div).show();
	fixHeight();
	$.ajax({
		type:'POST',
		data:'s='+s+'&breed_rules_index='+num,
	url: 'content/data/'+account_redirect,
	success: function(data){$('#content-temp'+account_species_div).html(data);},
	complete: function(){fixHeight();$('body').scrollTop(0);}//expand($('#alt-breed-rules').parent().parent());}
	});
}
$('.advanced-breed-rules').live('click',function(){
	$('#advanced-breed-rules-toggle, .advanced-breed-rules').toggle('slow',function(){fixHeight();});	
});

$('#cancel-breed-rules').live('click',function(){collapse();});

$('#breed-rules-add-new').live('click',function(){
	loadBreedRules($(this).attr('next'),$(this).attr('s'));
});

$('#breed-rules input, #breed-rules select, #breed-rules button').live('click change',function(){
	$('#save-breed-rules').removeAttr('disabled');
});

$('#delete-breed-rules').live('click',function(){
	if(!confirm("Are you sure you want to DELETE this configuration?")){return;}
	if(!confirm("Are you REALLY sure you want to DELETE this configuration?")){return;}
	var s = $(this).attr('s');
	var num = $(this).attr('this');
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&breed_rule_index='+num+'&value=delete',
	url: 'content/data/'+account_modify_redirect,
	success: function(data){
		collapse();
		var found = false;
		$("#alt-breed-rules option").each(function(){
			if($(this).attr('breed-rule') == num){$(this).remove();found = true;}
			else if(found){$(this).attr('breed-rule',(parseInt($(this).attr('breed-rule'))-1));}
		});
		$('#breed-rules-add-new').attr('next',(parseInt($('#breed-rules-add-new').attr('next'))-1));
	}
	});		
});

$('#reset-breed-rules').live('click',function(){
	if(!confirm("Are you sure you want to RESET this configuration?")){return;}
	var s = $(this).attr('s');
	var num = $(this).attr('this');
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&breed_rule_index='+num+'&value=reset',
	url: 'content/data/'+account_modify_redirect,
	success: function(data){loadBreedRules(data,s);}
	});		
});

$('#save-breed-rules').live('click',function(){
	$(this).attr('disabled','disabled');
	var name = $('#Configuration_Name').val();
	if(name=="" || name==undefined){
		alert('Configuration name must be defined.');
		return;
	}
	var s = $(this).attr('s');
	var num = $(this).attr('this');
	var send_array = new Array();
	$('.breed-rules-input').each(function(){
		var value = $(this).val();
		var id = $(this).attr('id');
		var alt_id = '';
		var alt_value = '';
		if(id!=undefined){
			if(id=="Activation_Param"){
				if(value=="child"){value='0';}
				else if(value=="Parent"){value='1';}
				else{value = $('#Activation_Param_Custom').val();}
			}
			else if(id=="Globals"){
				alt_id = 'Lineage_Globals';
				var g_result = new Array();
				var l_result = new Array();
				$('.Globals-keyval').each(function(){
					var ID = $(this).val();
					var VAL = $('#prop-'+ID).val().trim();
					if(typeof ID !== 'undefined'){ID=ID.trim();}
					if(typeof VAL !== 'undefined'){VAL=VAL.trim();}
					g_result.push(ID+";"+VAL);
					if($('#line-'+ID+":checked").length){l_result.push(ID);}
				});
				if(g_result.length){value = g_result.join(';');}
				else{value='';}
				if(l_result.length){alt_value = l_result.join(';');}
			}
			else if(id=="Allowed_Types"){
				var result = new Array();
				$('.sync-val').each(function(){
					var Val = $(this).val();
					if(Val!=undefined){
						result.push(Val);
					}
				});
				value = result.join(';');
			}
			else if(id=="Preferred_Skins"){
				var result = new Array();
				$('.skin-val'+':checked').each(function(){
					var Val = $(this).attr('key');
					if(Val!=undefined){
						result.push(Val);
					}
				});
				value = result.join(';');
			}
			else if(id=="Prim_Material"){
				var Options = {"stone" : "0","metal" : "1","glass" : "2","wood" : "3","flesh" : "4","plastic" : "5","rubber" : "6"};
				value=Options[value];
			}
			else if(id=="Lineage_Selection"){
				var Options = {"Random" : "0","From Mom" : "1","From Dad" : "2","Gender Based" : "3"};
				value=Options[value];
			}
			else if($(this).hasClass('odds-input')){
				var Options = {"Never" : "-1","Always" : "0","Common" : "1","Seldom" : "3","Rare" : "5","Very Rare" : "10","Almost Never" : "20"};
				value=Options[value];
			}
			else if($(this).hasClass('ratio-input')){
				var Options = {"Always Female"  :  "0","Always Male"  :  "-1","Even"  :  "1","Male: Common"  :  "2","Male: Seldom"  :  "-5","Male: Rare"  :  "-10","Male: Very Rare"  :  "-25","Female: Common"  :  "-2","Female: Seldom"  :  "5","Female: Rare"  :  "10","Female: Very Rare"  :  "25"};
				value=Options[value];
			}
			if($(this).hasClass('percent')){value=value.split('%').join('');}
			if($(this).hasClass('hide-false')){if(value=="YES"){value="1";}else{value="0";}}
			
			if(typeof id !== 'undefined'){id=id.trim();}
			if(typeof value !== 'undefined'){value=value.trim();}
			send_array.push(id+"$:"+value);
			if(alt_id.length){send_array.push(alt_id+"$:"+alt_value);}
		}
	});
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&breed_rule_index='+num+'&value='+send_array.join('$;'),
		url: 'content/data/'+account_modify_redirect,
		success: function(data){loadBreedRules(data,s);}
	});		
});
$('#alt-breed-rules').live('change', function(){
	var val = $(this).find('option:selected').attr('breed-rule');
	var s = $(this).find('option:selected').attr('s');
	loadBreedRules(val,s);
});

//CONFIGURATIONS : ACTION
function loadActionRules(num,s){
	//collapse();
	$('.content-tabs').hide();
	$('#content-temp'+account_species_div).html("Loading..");
	$('#content-temp'+account_species_div).show();
	fixHeight();
	$.ajax({
		type:'POST',
		data:'s='+s+'&action_rules_index='+num,
	url: 'content/data/'+account_redirect,
	success: function(data){$('#content-temp'+account_species_div).html(data);},
	complete: function(){//alert($('.dev_only').length);
		$('.eco-codemirror').each(function(){
			var val  = $(this).val();
			var obj = $(this).get(0);
			var id = $(this).attr('id');
			var editor = CodeMirror.fromTextArea(obj, {
				lineNumbers: true,
				matchBrackets: true,
				lineWrapping: true,
				value: val
			});
		});
		$( ".draggable" ).sortable({revert: true, delay: 100,  cancel: '.CodeMirror, input,a', cursor: 'move'});

		fixHeight();
		$('body').scrollTop(0);
	}
	});
}
$('.advanced-action-rules').live('click',function(){
	$('#advanced-action-rules-toggle, .advanced-action-rules').toggle('slow',function(){fixHeight();});	
});

$('#cancel-action-rules').live('click',function(){collapse();});

$('#action-rules-add-new').live('click',function(){
	loadActionRules($(this).attr('next'),$(this).attr('s'));
});

$('#action-rules input, #action-rules select, #action-rules button, #action-rules textarea, .CodeMirror-scroll, .CodeMirror pre, .CodeMirror span, .CodeMirror, .CodeMirror div div').live('click change',function(){
	$('#save-action-rules').removeAttr('disabled');
});

$('#delete-action-rules').live('click',function(){
	if(!confirm("Are you sure you want to DELETE this configuration?")){return;}
	if(!confirm("Are you REALLY sure you want to DELETE this configuration?")){return;}
	var s = $(this).attr('s');
	var num = $(this).attr('this');
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&action_rule_index='+num+'&value=delete',
	url: 'content/data/'+account_modify_redirect,
	success: function(data){
		collapse();
		var found = false;
		$("#alt-action-rules option").each(function(){
			if($(this).attr('action-rule') == num){$(this).remove();found = true;}
			else if(found){$(this).attr('action-rule',(parseInt($(this).attr('action-rule'))-1));}
		});
		$('#action-rules-add-new').attr('next',(parseInt($('#action-rules-add-new').attr('next'))-1));
	}
	});		
});

$('#reset-action-rules').live('click',function(){
	if(!confirm("Are you sure you want to RESET this configuration?")){return;}
	var s = $(this).attr('s');
	var num = $(this).attr('this');
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&action_rule_index='+num+'&value=reset',
		url: 'content/data/'+account_modify_redirect,
		success: function(data){loadActionRules(data,s);}
	});		
});

$('#save-action-rules').live('click',function(){
	var error = '';
	var s = $(this).attr('s');
	var num = $(this).attr('this');
	var send_array = new Array();
	var name = $('#Configuration_Name').val();
	$(this).attr('disabled','disabled');
	if(name=="" || name==undefined){
		alert('Configuration name must be defined.');
		return;
	}
	$('.eco-codemirror').each(function(){
		//$(this).val($(this).next().find('.CodeMirror-cursor').next().next().text());
		var info = new Array();
		$(this).next().find('.CodeMirror-cursor').next().next().find('pre').each(function(){
			var Actions = $(this).text().trim();
			while(Actions.indexOf(' (')!=-1){
				Actions = Actions.split(' (').join('(');
			}
			info.push(Actions);
		});
		$(this).val(info.join("\n"));
	});
	$('.action-rules-input').each(function(){
		var value = $(this).val();
		var id = $(this).attr('id');
		var alt_id = '';
		var alt_value = '';
		if(id!=undefined){
			if(id=="Touch_Events"){
				var Options = {"None" : "0","Object Name" : "1","Object Desc" : "2","Link Number" : "3"};
				value=Options[value];
			}
			else if(id=="Actions"){
				var events = new Array();
				var methods = new Array();
				var Actions = new Array();
				$('input.Actions').each(function(){
					if($(this).val()!="" && $(this).val()!=undefined){
						if(jQuery.inArray($(this).val(), events)==-1){events.push($(this).val());}
						else{error = $(this).val()+" is declared more than once in your Actions list."; return;}
					}
				});//get events
				$('textarea.Actions').each(function(){					
					var methodstring = format_spacing($(this).val());//.replace(new RegExp( "\\n", "g" ),"");
					methods.push(methodstring.split("+").join("0x43"));//.split("\n").join("\\n"));	
				});//get methods
				for(i=0;i<events.length;i++){
					Actions.push(events[i]+"/:"+methods[i]);					
				}
				value = Actions.join("/;");		
				if(!value.trim().length){value='';}//format value
			}
			else if(id=="Status"){
				var Options = {"Active" : "0","Not Responding" : "1","Both" : "2"};
				value=Options[value];
			}
			else if($(this).hasClass('textarea-input')){
				//value = value.replace(new RegExp( "\\n", "g" ),"\\n");
				//value =value.replace(/\r?\n|\r/g, "\n");
			}
			if($(this).hasClass('percent')){value=value.split('%').join('');}
			if($(this).hasClass('hide-false')){if(value=="YES"){value="1";}else if(value=="RESERVE"){value="2";}else{value="0";}}
			send_array.push(id+"$:"+value.trim());
			if(alt_id.length){send_array.push(alt_id+"$:"+alt_value.trim());}
		}
	});
	if(error.length){alert(error);return;}
	//alert(safe_url(send_array.join('$;').split("%").join("0xSl")));
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&action_rule_index='+num+'&value='+safe_url(send_array.join('$;').split("%").join("0xSl")),
		url: 'content/data/'+account_modify_redirect,
		success: function(data){loadActionRules(data,s);}
	});	
});

$('#alt-action-rules').live('change', function(){
	var val = $(this).find('option:selected').attr('action-rule');
	var s = $(this).find('option:selected').attr('s');
	loadActionRules(val,s);
});

//CONFIGURATIONS : ACTION-RULE
function format_spacing(str){
	//return str.replace(new RegExp( "\\n", "g" ),"").split(' ').join('');
	return str.split('  ').join(' ').trim();//.split(")\n\n").join(")\n").split('\n ').join('\n')
}

$('.actions-chk').live('click',function(){
	$('.eco-codemirror').each(function(){
		//$(this).val($(this).next().find('.CodeMirror-cursor').next().next().text());
		var info = new Array();
		$(this).next().find('.CodeMirror-cursor').next().next().find('pre').each(function(){
			info.push($(this).text().trim());
		});
		$(this).val(info.join("\n"));
	});
	var native_methods = ["die","revive","move","sethome","menu","message","ownersay","say","shout","text","textbox","whisper","attach","anim","give","rez","sound","bind","filter","rfilter","off","on","pause","toggle","unbind","prop","val","cache","uncache","set","unset"];
	$('.temp').html('');//clear error box
	var Event = $(this).parent().find('input').val();//get event
	var par_id = $(this).parent().attr('id');//get parent id
	var value = $(this).parent().find('textarea').val();//get methods
	var feedback = $(this).parent().find('.temp');//get error box
	var error = false;
	$('input.Actions').each(function(){
		if($(this).val()==Event && $(this).parent().attr('id')!=par_id){
			feedback.html('The event '+Event+' has already been declared.');
			error=true;
			return;
		}
	});
	if(error){return;}//validate event
	if(value == "" || value == undefined){feedback.html('No methods defined.');return;}
	var beg = value.split("(").length;
	var end = value.split(")").length;
	if(!beg||!end||beg!=end){feedback.html('Syntax error: Unclosed method.');return;}
	value =format_spacing(value);//clean up spacing
	$(this).parent().find('textarea').val(value);//set cleaned up methods
	//value = value.replace(new RegExp( "\\n", "g" ),"");//clean up for db insertion
	var data = value.split("(").join(")").split(")");//parse method hack to strided list
	for(i=0;i<data.length;i+=2){
		var val = data[i].trim();
		if(val!="" && jQuery.inArray(val, native_methods)==-1){
			if(val.substr(0,1) != "@" && val.substr(0,1) != "#"){
				feedback.html('Syntax error: "'+val+'" is an unrecognized method.');
				return;
			}
		}
		else if(val=="prop" && Event == "start"){
			if(confirm('The "'+val+'()" method should not be used in the "'+Event+'" event. Create breed Globals instead. Select "Cancel" to skip this warning.')){
				feedback.html('Event error: "'+val+'()" should not be used in the "'+Event+'" event. Create breed Globals instead.');
				return;
			}
		}
	}//validate methods
	feedback.html('<span>Compile successful!</span>');
});

$('.actions-del').live('click',function(){
	if(!confirm("Are you sure you want to delete this event?")){return;}
	var obj = $(this).parent().find('input');
	if(obj.attr('readonly')!=undefined){
		$(this).parent().parent().prev().find('select option:first-child').after("<option>"+obj.val()+"</option>");		
	}
	$(this).parent().hide('slow',function(){$(this).remove();fixHeight();});
});
	
$('a.actions-toggle').live('click',function(){
	$('.actions-toggle').toggle("slow",function(){fixHeight();});
});

$('#actions-new').live('change',function(){
	var selection = $(this).val();
	var readonly = "readonly";
	var value = "";
	if(selection == "Custom"){
		readonly = "";
		$(this).find("option:selected").removeAttr('selected');
		$(this).find("option:first-child").attr('selected','selected');
	}
	else{
		value = selection;
		$(this).find("option:selected").remove();	
	}
	if(!$('div.actions-toggle:visible').length){$('.actions-toggle').toggle('slow');}//show if hidden
	var randomNum = Math.floor(Math.random() * 999999) + 2;
	$(this).parent().parent().next().append("<div id='"+randomNum+"' style='display:none;'><input placeholder='Event' class='Actions wide-input' value='"+value+"' "+readonly+"/><a class='actions-del'>delete</a> | <a class='actions-chk'>check</a><textarea placeholder='Methods..' class='Actions wide-input eco-codemirror'></textarea><div class='temp'></div></div>");
	$('#'+randomNum).show('slow',function(){	
		var editor = CodeMirror.fromTextArea($(this).find('textarea').get(0), {
			lineNumbers: true,
			matchBrackets: true,
			lineWrapping: true
		}).focus();
		fixHeight();
	});	
		$( ".draggable" ).sortable({revert: true, delay: 100,  cancel: '.CodeMirror, input,a', cursor: 'move'});
});

$('#actions-new-custom').live('click',function(){
	var randomNum = Math.floor(Math.random() * 999999) + 2;
	$("#Actions").append("<div id='"+randomNum+"' style='display:none;'><input placeholder='Event' class='Actions wide-input' /><a class='actions-del'>delete</a> | <a class='actions-chk'>check</a><textarea placeholder='Methods..' class='Actions wide-input eco-codemirror'></textarea><div class='temp'></div></div>");

	$('#'+randomNum).show('slow',function(){	
		var editor = CodeMirror.fromTextArea($(this).find('textarea').get(0), {
			lineNumbers: true,
			matchBrackets: true,
			lineWrapping: true
		}).focus();
		fixHeight();
	});	
		$( ".draggable" ).sortable({revert: true, delay: 100,  cancel: '.CodeMirror, input,a', cursor: 'move'});
});

//ADD AUTHORIZED
function loadSpecies(s){
	$('.content-tabs').hide();
	$('#content-temp'+account_species_div).html("Loading..");
	$('#content-temp'+account_species_div).show();
	fixHeight();
	$.ajax({
	type:'POST',
	data:'s='+s,
	url: 'content/data/'+account_redirect,
	success: function(data){$('#content-temp'+account_species_div).html(data);},
	complete: function(){
		fixHeight();
		$('body').scrollTop(0);
	}
	});
}

$('#add-authorized-user input').live('click',function(){
	$('#add-authorized-user button').removeAttr('disabled');
});

$('#add-authorized-user button').live('click',function(){
	$('#add-authorized-user span').val('');
	var s = $('#add-authorized-user').attr('s');
	var name = $('#add-authorized-user input').val();
	$('#add-authorized-user input').val('');
	$.ajax({
		type:'POST',
		data: 'species_index='+s+'&authorized_user='+safe_url(name),
		url: 'content/data/'+account_modify_redirect,
		success: function(data){
			if(data=="success"){
				$('#auth-users').prepend("<div class='auth-user'><input class='wide-input' value='"+name.toLowerCase()+"' readonly/><a>remove</a></div>");
			}
			else{
				$('#add-authorized-user span').text(data);
			}
		},
		complete: function(){
			setTimeout(function(){loadSpecies(s);},1000);
		}
	});
});

$('.auth-user a').live('click',function(){
	var obj = $(this).parent();
	var s = $('#add-authorized-user').attr('s');
	var name = obj.find('input').val();
	$.ajax({
		type:'POST',
		data:'species_index='+s+'&rem_authorized_user='+safe_url(name),
		url: 'content/data/'+account_modify_redirect,
		success: function(data){
			if(data=="success"){
				obj.hide('slow',function(){$(this).remove();});
			}
		},
		complete: function(){setTimeout(function(){loadSpecies(s);},1000);}
	});
});

//SIDEBAR SURVEY
$('#survey button').live('click',function(){
	var result = new Array();
	$('#survey input:checked').each(function(){
		var type = $(this).val();
		if(type=="custom"){type=$(this).parent().next().val();}
		if(type.length){result.push(type);}
	});
	if(!result.length){return;}
	$.ajax({
		type:'POST',
		data:'user='+safe_url('Sidebar Survey')+'&text='+safe_url(result.join(', ')),
		url: 'func/submit.php',
		complete: function(){$('#survey').html("<p style='color:orangered;'>Thank you for your feedback!</p>");}
	});	
});

//DEBUG_THIS
$('#debug_this input').live('click change',function(){
	$('#debug_this button').removeAttr('disabled');
});
$('#debug_this button').live('click',function(){
	var result = new Array();
	$('#debug_this input:checked').each(function(){
		var type = $(this).val();
		if(type.length){result.push(type);}
	});
	$('#debug_this button').attr('disabled','disabled');
	//if(!result.length){return;}
	$.ajax({
		type:'POST',
		data:'all_breed_index='+safe_url($('#debug_this').attr('a'))+'&debug_this='+safe_url(result.join('-')),
		url: 'content/data/'+account_modify_redirect
	});	
});

//UI CODE
$('#species-selector').live('change',function(){
	var num = $('#species-selector option:selected').attr('s');
	if(num==undefined){return;}
	$('.content-tabs').hide();
	$('#content-temp-species').html("Loading..");
	$('#content-temp-species').show();
	fixHeight();
	$.ajax({
		type:'POST',
		data:'s='+num,
		url: 'content/data/'+account_redirect,
		success: function(data){
			$('#species-selector').find("option:selected").removeAttr('selected');
			$('#species-selector').find("option:first-child").attr('selected','selected');
			$('#content-temp-species').html(data);
		},
		complete: function(){$('#species-cancel').removeAttr('disabled');fixHeight();}//$('body').scrollTop(0);}
	});
});
$('#species-cancel').live('click',function(){
	$('#content-temp-species').hide('slow');
	$(this).attr('disabled','disabled');
});
$('#breed-filter select').live('change',function(){
	var result = new Array();
	$('#breed-filter select').each(function(){
		var type = $(this).find("option:selected").attr('class');
		if(type=="ignore"){return;}
		else{result.push(type);}
	});
	if(result.length==2){
		$('#breeds-display').removeAttr('disabled');
	}
});
$('#breeds-display').live('click',function(){
	var result = new Array();
	$('#breeds-display').attr('disabled','disabled');
	$('#breed-filter select').each(function(){
		var type = $(this).find("option:selected").attr('class');
		if(type=="ignore"){return;}
		else{result.push(type);}
	});
	if(result.length!=2){return;}
	$('.content-tabs').hide();
	$('#content-temp-breed').html("Loading..");
	$('#content-temp-breed').show();
	fixHeight();
	$.ajax({
		type:'POST',
		data:'b='+result.join(';;'),
		url: 'content/data/'+account_redirect,
		success: function(data){
			$('#breed-filter select').each(function(){
				$(this).find("option:selected").removeAttr('selected');
				$(this).find("option:first-child").attr('selected','selected');
			});
			$('#content-temp-breed').html(data);
		},
		complete: function(){fixHeight();}//$('body').scrollTop(0);}
	});
});
$('a.prim-methods').live('click',function(){
	$('div.prim-methods').toggle('slow',function(){fixHeight();});
});
$('a.more').live('click',function(){
	$(this).parent().attr('class','');
	$(this).remove();
});
$('a#legacy').live('click', function(){
	setTimeout(function(){
		window.location = 'http://eco.takecopy.com/?e=user';
	},2000);
});
$('.upgrade-now').live('click',function(){
	$.ajax({
		type:'POST',
		data:'upgrade_now=true',
	url: 'content/data/'+account_modify_redirect,
	success: function(data){alert(data);}
	});
});


$('.widget-line-1,.widget-line-0').live('click',function(){
	var orig = $(this);														 
	var obj = orig.next();
	if(obj.is(':visible')){return;}
	orig.css({'letter-spacing' : '-0.1em', 'font-size' : '1.3em'});
	var wrap = orig.parent();	
	if(wrap.hasClass('widget-hidden')){wrap = wrap.parent();}
	wrap.find('.search input').val('').hide();
	wrap.find('.widget-less,.widget-all').hide();
	wrap.find('h1 span').show();
	wrap.find('.widget-line-1,.widget-line-0').not(orig).hide('slow',function(){fixHeight();});	
	obj.show('slow',function(){fixHeight();});
});

$('.widget-info h1 span').live('click',function(){
	var widget = $(this).parent().parent();
	widget.find('.search input').val('').show();
	widget.find('.widget-less,.widget-all').show();
	widget.find('span').hide();
	widget.find('.widget-line-1,.widget-line-0').show('slow',function(){fixHeight();$(this).css({'letter-spacing' : 'initial', 'font-size' : '0.9em'})});
});

$('.widget-all').live('click',function(){
	var obj = $(this);
	obj.parent().find('.widget-hidden').show('slow',function(){
		fixHeight();
		obj.text("View Less");
		obj.attr("class","widget-less");
	});
});

$('.widget-less').live('click',function(){
	var obj = $(this);
	obj.parent().find('.widget-hidden').hide('slow',function(){
		fixHeight();
		obj.text("View All");
		obj.attr("class","widget-all");
	});
});


function find_keyword(inc,arr){
	for(i=0;i<arr.length;i++){
		if(inc.indexOf(arr[i])==-1){return -1;}
	}
	return true;
}

$('.search input').live('keyup',function(){
	var wrapper = $(this).parent().parent();
	if(!wrapper.find('.widget-hidden:visible').length){
		wrapper.find('.widget-all').text("View Less");
		wrapper.find('.widget-all').attr("class","widget-less");
		wrapper.find('.widget-hidden').show();
		fixHeight();
	}
	var search_for = $(this).val().toLowerCase();
	wrapper.find('.widget-line-1,.widget-line-0').each(function(){
		var includes = $(this).text().toLowerCase();
		 includes += $(this).next().text().toLowerCase();
		if($(this).is(":visible") && find_keyword(includes,search_for.trim().split(" "))==-1){			
			$(this).hide();
		}
		else if(!$(this).is(":visible") && find_keyword(includes,search_for.trim().split(" "))!=-1){
			$(this).show();
		}
	});
});
