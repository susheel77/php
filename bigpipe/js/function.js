function viewer(data){
	var domid	= data.domid;
	var html	= data.html;
	$('#'+domid).html(html);
}