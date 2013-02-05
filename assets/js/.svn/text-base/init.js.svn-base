//Make sure the document is ready before executing scripts
jQuery(function($) {
	$("#message").click(
			function() {
				var LOADING_IMG = '/assets/image/loading2.gif';
				$("#process").html(
						"<div class='loading'>加载中...<br><img src='"
								+ LOADING_IMG + "'></div>");
				$.get('/ajax/generatePhoto', function(data) {
					if (data != '') {
						var upload = "<div id='upload'>上传到相册</div>";
						$("#process").html(data + upload);
					} else {
						var ERROR_MSG = '别点了, 居然没有一个好友和你生日相同...';
						$("#process").html(
								"<div class='loading'>" + ERROR_MSG
										+ "<br><img src='" + LOADING_IMG
										+ "'></div>");
					}
				})
			})
	$("#upload").on("click", function() {
		if ($("#upload").html() != '') {
			$("#upload").html("上传中...");
			var img_src = $("#uploadimg").attr("src");
			$.post('/ajax/uploadPhoto', {
				img_src : img_src
			}, function(data) {
				alert('上传成功');
				$("#upload").html("上传到相册");
			})
		}
	})
});