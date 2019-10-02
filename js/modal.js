jQuery(document).ready(function($){
	setTimeout(function(){ showNewsletterPopup(); }, 2000);
	
	$('.popup-close').click(function(){
		$('.modal-overlay').hide();
		setCookie('modal-popup', 'popped', 30);
	});
  });
  
  function showNewsletterPopup(){
	if(getCookie('modal-popup') == ""){
	   $('.modal-overlay').show();
	   setCookie('modal-popup', 'popped', 30);
	}
	else{
	  console.log("Popup blocked.");
	}
  }
  
  function setCookie(cname,cvalue,exdays)
  {
	  var d = new Date();
	  d.setTime(d.getTime()+(exdays*24*60*60*1000));
	  var expires = "expires="+d.toGMTString();
	  document.cookie = cname+"="+cvalue+"; "+expires+"; path=/";
  }
  
  function getCookie(cname)
  {
	  var name = cname + "=";
	  var ca = document.cookie.split(';');
	  for(var i=0; i<ca.length; i++) 
	  {
		  var c = jQuery.trim(ca[i]);
		  if (c.indexOf(name)==0) return c.substring(name.length,c.length);
	  }
	  return "";
  }