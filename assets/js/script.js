// JavaScript Document
$(function() {  

	$("#header_banner").hover(function(){
		$("#header_banner_prev").css('display', 'block');	 
		$("#header_banner_next").css('display', 'block');	 
	}, function(){	 
		$("#header_banner_prev").css('display', 'none');
		$("#header_banner_next").css('display', 'none');	 
	}); 
	
	$("#trabalho_prev").hover(function(){
		$("#trabalho_prev").attr('src', 'assets/img/icone_prev_hover.png');	 
	}, function(){	 
		$("#trabalho_prev").attr('src', 'assets/img/icone_prev.png');	
	}); 
	
	$("#trabalho_next").hover(function(){
		$("#trabalho_next").attr('src', 'assets/img/icone_next_hover.png');	 
	}, function(){	 
		$("#trabalho_next").attr('src', 'assets/img/icone_next.png');	
	}); 
	
	
	
			
	$("#mais1").click(function () { 
		if($(".content_sobre_item1").css("height") == "50px"){
			$(".content_sobre_item1").css("height","100%");
			$(".content_sobre_item1").css("background","#FFFFFF");
			$(".content_sobre_item1 .titulo").css("color","#2065C2");
			$(".content_sobre_item1 .mais").css("color","#2065C2");
			$("#mais1").html("-");
		} else {
			$(".content_sobre_item1").css("height","50px");
			$(".content_sobre_item1").css("background","url(assets/img/fundo_sobre.png) center no-repeat");
			$(".content_sobre_item1 .titulo").css("color","#000000");
			$(".content_sobre_item1 .mais").css("color","#000000");
			$("#mais1").html("+");
		}
	});
	$("#mais2").click(function () { 
		if($(".content_sobre_item2").css("height") == "50px"){
			$(".content_sobre_item2").css("height","100%");
			$(".content_sobre_item2").css("background","#FFFFFF");
			$(".content_sobre_item2 .titulo").css("color","#2065C2");
			$(".content_sobre_item2 .mais").css("color","#2065C2");
			$("#mais2").html("-");
		} else {
			$(".content_sobre_item2").css("height","50px");
			$(".content_sobre_item2").css("background","url(assets/img/fundo_sobre.png) center no-repeat");
			$(".content_sobre_item2 .titulo").css("color","#000000");
			$(".content_sobre_item2 .mais").css("color","#000000");
			$("#mais2").html("+");
		}
	});
	$("#mais3").click(function () { 
		if($(".content_sobre_item3").css("height") == "50px"){
			$(".content_sobre_item3").css("height","100%");
			$(".content_sobre_item3").css("background","#FFFFFF");
			$(".content_sobre_item3 .titulo").css("color","#2065C2");
			$(".content_sobre_item3 .mais").css("color","#2065C2");
			$("#mais3").html("-");
		} else {
			$(".content_sobre_item3").css("height","50px");
			$(".content_sobre_item3").css("background","url(assets/img/fundo_sobre.png) center no-repeat");
			$(".content_sobre_item3 .titulo").css("color","#000000");
			$(".content_sobre_item3 .mais").css("color","#000000");
			$("#mais3").html("+");
		}
	});

});