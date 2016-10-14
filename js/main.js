$(document).ready(function(){
	var speed = 500;
	var menuVisible = false;
	
	$("#btnMenu").click(function(){
		//alert("Hello World");
		
		if(menuVisible == true){
			$("#titlebar").animate({left : "0px"}, speed);
			$("#ground").animate({left : "0px"}, speed);
			$("#sidemenu").animate({left : "-210px"}, speed);
			$("#btnMenu").hide(speed, function(){
				$("#btnMenu").html('<i class="fa fa-bars fa-1x"></i> K MEANS CLUSTERS');
			}).show(speed);
			
			menuVisible = false;
		}
		else{
			$("#titlebar").animate({left : "200px"}, speed);
			$("#ground").animate({left : "200px"}, speed);
			$("#sidemenu").animate({left : "0px"}, speed);
			$("#btnMenu").hide(speed, function(){
				$("#btnMenu").html('<i class="fa fa-arrow-left fa-1x"></i> BACK');
			}).show(speed);
			
			menuVisible = true;
		}

	});

	$("#messageClose").click(function(){
		$("#cover").fadeOut(speed);
		//$("#message").fadeOut(speed);
		//$("#message").css({"top" : "100%"});
		$("#message").animate({top : "100%"}, 700, function(){
			$("#message").hide();
		});

	});

	$(".btnReadme").click(function(){
		$("#recordid").val( $(this).attr('recordid') );
		$("#searchForm").submit();
	});

	//alert("Hello");
	//showMessage(speed);
});

function showMessage(s = 200){
	$("#cover").fadeIn(700);
	//$("#message").fadeIn(s);

	$("#message").show();
	$("#message").css({"top" : "100%"});
	$("#message").animate({top : "33%"}, 700);

}