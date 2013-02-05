<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<script type="text/javascript" src="/assets/js/renren.js"></script>
</head>
<body>
<style>
body {
	background: url("/assets/image/mainbg.jpg");
}
</style>

<script type="text/javascript">
	  var style={
			  top:100,
			  left:150,
			  height:400,
			  width:500
	  };/*用于设置弹层的位置和大小*/
	  var uiOpts = {
		  url : "http://graph.renren.com/oauth/authorize",
		  display : "iframe",
		  params : {"response_type":"token","scope":"<?=$scope?>","client_id":"<?=$APIKey?>","ua":"cddc4db586e5a650d540c8724144b313"},
		  onSuccess: function(r){
		    top.location = "<?=$redirecturi?>";
		  },
		  style : style,
		  onFailure: function(r){} 
	  };
	  Renren.ui(uiOpts);
</script>
</body>
</html>