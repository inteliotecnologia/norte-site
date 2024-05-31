
//var $ = jQuery.noConflict();

var current_home_section=1;
var mudando=0;

(function($) {
	var imgList = [];
	$.extend({
		preload: function(imgArr, option) {
			var setting = $.extend({
				init: function(loaded, total) {},
				loaded: function(img, loaded, total) {},
				loaded_all: function(loaded, total) {}
			}, option);
			var total = imgArr.length;
			var loaded = 0;
			
			setting.init(0, total);
			for(var i in imgArr) {
				imgList.push($("<img />")
					.attr("src", imgArr[i])
					.load(function() {
						loaded++;
						setting.loaded(this, loaded, total);
						if(loaded == total) {
							setting.loaded_all(loaded, total);
						}
					})
				);
			}
			
		}
	});
})(jQuery);


/*var $nav_header    = $('.banner'),
    header_height  = $('.banner').height(),
    hero_height    = $('.hero').height(),
    offset_val     = hero_height - header_height;
*/

// Method
// =================================================


function navSlide() {
  var largura_janela = $(window).width();
  var pagina_certa= $("body").hasClass("inner");
  
  if ( (pagina_certa) && (largura_janela>=1000) ) {
  
	  var scroll_top = $(window).scrollTop();
	  
	  var tem= $("body").hasClass("inner");
	  
	  var distancia= ($(".work-box-main").offset().top-75);
	  
	  var ja= $(".work-box-information").hasClass("sticky");
	  
	  if (tem) {
		  //console.log(scroll_top+" -> "+distancia);
		  
		  if (scroll_top >= distancia) { // the detection!
		    if (!ja) {
		    	$('.work-box-information').addClass('sticky');
		    }
		  } else {
		    $('.work-box-information').removeClass('sticky');
		  }
	  }
  }
}




// Handler
// =================================================

$(window).scroll(navSlide);


function mostraBarras() {
	$(".out_bar_topo").slideDown(300);
	$("#footer").slideDown(300);
	$("body").removeClass("fs");
	
	$(".highlight-text, .slick-arrow").show();
	
	//console.log("2");
	
	//setTimeout(function() {
	//	$(".highlight-text").fadeIn(100);	
	//}, 400);
	
	var altura= $(window).height()-50;
		
	//$('.highlight').height(altura);
}

function escondeBarras() {
	$(".out_bar_topo").slideUp(300);
	$("#footer").slideUp(300);
	
	$(".highlight-text, .slick-arrow").hide();
	
	//console.log("1");
	
	//setTimeout(function() {
	//	$(".highlight-text").fadeIn(100);	
	//}, 400);
	
	$("body").addClass("fs");
	
	var altura= $(window).height();
		
	//$('.highlight').height(altura);
		
}


function hideAddressBar()
{
    if(!window.location.hash)
    { 
        if(document.height <= window.outerHeight + 10)
        {
            document.body.style.height = (window.outerHeight + 50) +'px';
            setTimeout( function(){ window.scrollTo(0, 1); }, 50 );
        }
        else
        {
            setTimeout( function(){ window.scrollTo(0, 1); }, 0 ); 
        }
    }
} 
 



$(document).ready(function(){
	
		
	var altura_topo= $("#header").height();
	var altura_rodape= $("#footer").height();
	
	
	$(window).on('resize', function(){
	      var win = $(this); //this = window
	      var altura= win.height();
	      var largura= win.width();
	      
	      $(".slick-slide").height(altura);
	});


	setTimeout(function() {
		
		var altura= $(window).height();
		var largura= $(window).width();
		
		//console.log(largura);
		
		//mobile
		if (largura<=767) {
			$( "#busca-area" ).appendTo( "#menu" );
			
			//window.addEventListener("load", hideAddressBar );
			//window.addEventListener("orientationchange", hideAddressBar );
		}
		else {
			$('section#about, section#highlight, section#contact').height(altura);
		}
		
	}, 500);
	
	var corpo= $("body").hasClass("inner");
	if (!corpo) {
		
		window.addEventListener("orientationchange", function() {
				
			
			
			// Announce the new orientation number
			//alert(window.orientation);
			var orientacao= window.orientation;
			
			
			//alert(orientacao);
			
			if ( (orientacao==-90) || (orientacao==90) ) {
				//$(".imagem_bg").height(altura+"px");
				//$.fn.fullpage.setAllowScrolling(false);
				
				
				
			}
			else {
				//$(".imagem_bg").height("auto");
				
				//$.fn.fullpage.setAllowScrolling(false);
				
				//location.reload();
				
				
				
			}
			
			
			mudando=1;
			
			setTimeout(function() {
				var altura= $(window).height();
				//window.scrollTo(0,1);
				
				setTimeout(function() {
					
					//$.fn.fullpage.moveSectionDown();
					//$.fn.fullpage.moveSectionUp();
					
					var indo= current_home_section;
					
					$.fn.fullpage.moveTo(indo);
					//$("#logo").append("-> "+indo+"<br/>");
					//alert("forçando ir para... "+ indo);
					//var altura= $(window).height();
					
					//alert(altura);
						
					//if ( (orientacao==-90) || (orientacao==90) ) {
					
						$('.slider1 .highlight').height(altura-56);
						$('.slider2 .highlight').height(altura-56);
					//}
					//else {
						//$('.slider1 .highlight').height(altura-56);
						//$('.slider2 .highlight').height(altura-56);	
					//}
					
					mudando=0;
					
				}, 200);
				
				
			}, 200);
			
			
			
			
			
		}, false);
	}
	
	
	$(window).scroll(function() {
		
		var embaixo= $(document).height()-$(window).height();
		var embaixo2= embaixo-10;
		var embaixo3= embaixo-200;
		
		if  ($(window).scrollTop()==embaixo){
			$(".go-top").fadeIn(300);
			//alert(1);
		}
	}); 
	
	/*
	$('.highlight').hover(
		function () {
			$(".highlight-text").fadeIn(300);
		}, 
		function () {
			$(".highlight-text").fadeOut(300);
		}
	);
	*/
	
	

	$(".link_next a").click( function() {
		$.fn.fullpage.moveSectionDown();
	});
		
	$("body.push-left #menu ul li a").click( function() {
		//alert(1);
		//$("#menu_controls a").trigger("click");
		
		return(false);
	});
	
	//alert($(window).height());
	
	
	//var largura_inner= $(".work-box-information").width();
	//var offset_esq = $(".work-box-information").offset().left;
	
	//$(".work-box-information").width(largura_inner-3);
	
	//$(".work-box-information").css("left", offset_esq+"px");
	
	window.addEventListener("orientationchange", function() {
		
		var corpo= $("body").hasClass("inner");
		if (corpo) {
	
			//window.scrollTo(0,1);
			
			// Announce the new orientation number
			//alert(window.orientation);
			var orientacao= window.orientation;
			var altura= $(window).height();
			
			//alert(altura);
			
			//$(".imagem_bg").height(altura+"px");
			
			$('.home_slider2, .imagem_bg').height(altura);
			
			if ( (orientacao==-90) || (orientacao==90) ) {
				//$(".imagem_bg").height(altura+"px");
				//$(".imagem_bg").css("marginTop", "0");
				//$.fn.fullpage.setAllowScrolling(false);
				
				setTimeout(function() {
					
					//if ( (orientacao==-90) || (orientacao==90) ) {
					//var altura= $(window).height();
						
						$('.home_slider2').css("margin-top", "32px");
						
						//$('.highlight .imagem_bg.retrato').css("background-size", "50%");
						
					//}
					//else {
					//	$('.slider1 .highlight').height(altura-112);
					//	$('.slider2 .highlight').height(altura-112);
					//}
				}, 400);
				
			}
			else {
				
				$('.home_slider2').css("margin-top", "0px");
				
				//$('.highlight .imagem_bg.retrato').css("background-size", "contain");
				
				//$(".imagem_bg").height("auto");
				//$(".imagem_bg").css("marginTop", "-20px");
				//$.fn.fullpage.setAllowScrolling(true);
				
			}
		}
		
	}, false);

	
	
	$(".d_smartphone #menu_controls a.menu_controls_link").click( function(e) {
   		
   		
   		
   		var estado= $("#header").hasClass("aberto");
		//console.log("clicou!");
		
		if (!estado) {
			$("#menu").show();
			
			$('#sugestoes').fadeOut();
			
			//setTimeout(function() {
				$("body").addClass("push-left");
				$("#header").addClass("aberto");
				
				//$("#about").css("float", "none");
			//}, 300);
			
		}
		else {
			$("#header").removeClass("aberto");
			$("body").removeClass("push-left");
			$("#menu").hide(300);
		}
		
		return(false);
		
	});
	
	$(".link_tags").click( function() {
   		var estado= $(".link_tags").attr("title");
		
		if (estado=="closed") {
			$(".tags_list").slideDown(300);
			$(".link_tags").removeClass("closed");
			$(".link_tags").addClass("open");
			$(".link_tags").attr("title", "open");
			
		}
		else {
			$(".tags_list").slideUp(300);
			$(".link_tags").removeClass("open");
			$(".link_tags").addClass("closed");
			$(".link_tags").attr("title", "closed");
		}
		
		$(".link_tags").blur();
	});
	
	var key_count_global = 0;
	var timer; // Global variable
	var r= $("#r").val();
	
	$("#busca").keyup(function(e){
		
		switch(e.keyCode) {
			case 39:
			case 37:
			break;
			
			case 38:
			navigate('up');
			break;
			
			case 40:
			navigate('down');
			break;
			
			case 13:
				if((currentUrl != '') && (currentUrl != undefined)) {
					window.location = currentUrl;
				}
				return false;
			break
			
			default:
				key_count_global++;
				clearTimeout(timer);
				timer= setTimeout(function(){ sugere(r) }, 500);
			break;
		}
	});
	
	$('a[href*=#]').click(function() {
	
		$("#menu_controls a").trigger("click");
		
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'')  && location.hostname == this.hostname) {
			
			var $target = $(this.hash);
			
			
			
			$target = $target.length && $target || $('[name=' + this.hash.slice(1) +']');
			
			if ($target.length) {
			
				var targetOffset = $target.offset().top;
				
				var offset2=0;
				
				if (this.hash!="#slider_artistas") offset2=54;
				
				$('html,body').animate({scrollTop: targetOffset-offset2}, 750);
					
				return false;
				
			}
				
		}
		
	});
	
});


setTimeout(function() {
	
	var aplica= $("body").hasClass("home");
	var aplica2= $("body").hasClass("d_computador");
		
	if ((aplica) && (aplica2)) {
		var timeout = null;
		
		$(document).on('mousemove', function() {
		    clearTimeout(timeout);
			
			var fs= $("body").hasClass("fs");
			if (fs) mostraBarras();
			
		    timeout = setTimeout(function() {
		        //console.log('Mouse idle for 3 sec');
		        
		        escondeBarras();
		        
		    }, 4000);
		});
	}
	
});


function carregaDinamico(elemento, r, area, modo, inicio, total_por_pagina, tags, excluir, tipo_projeto, ultimo_id) {
	if (area=="works") chamada= "carregaDinamicoWorks";
	else if (area=="artists") chamada= "carregaDinamicoArtists";
	
	elemento.blur();
	
	$("#link_leva_"+inicio).html("<img src=\""+r+"images/loading.gif\" border=\"0\" src=\"\" />");
	
	$.get(r+'link.php', {chamada: chamada, r: r, modo: modo, inicio: inicio, total_por_pagina: total_por_pagina, tags: tags, excluir: excluir, tipo_projeto: tipo_projeto },

	function(retorno) {
		$("#leva_"+inicio).html(retorno);
		
		if ((ultimo_id!="") && (modo=="2")) {
			setaClasse(ultimo_id, "list-open");
		}
	});
}

currentSelection = 0;
currentUrl = '';

function sugere(r) {
	var busca= $("#busca").val();
	
	
	/*$("#busca").blur(function(){
	 	$('#sugestoes').fadeOut();
	});
	 */
	 
	 // Safely inject CSS3 and give the search results a shadow
	//var cssObj = { 'box-shadow' : '#333 25px 5px 5px', // Added when CSS3 is standard
	//	'-webkit-box-shadow' : '#333 25px 5px 5px', // Safari
	//	'-moz-box-shadow' : '#333 25px 5px 5px'}; // Firefox 3.5+
	//$("#sugestoes").css(cssObj);
	 
	if(busca.length==0) {
		$('#sugestoes').fadeOut(); // Hide the sugestoes box
	}
	else {
		
		$('#busca-area').attr("class", "buscando");
		
		$.post(r+"link.php", {chamada: "buscaSugerida", r: r, busca: busca }, function(retorno) { // Do an AJAX call
			$('#sugestoes').html(retorno); // Fill the sugestoes box
			$('#sugestoes').fadeIn("slow"); // Show the sugestoes box
			
			$('#busca-area').attr("class", "");
			
			// Register keypress events on the whole document
			//$("#busca").keypress(function(e) {
				
				//$("#nada").html(e.keyCode);
				
				/*switch(e.keyCode) { 
					// User pressed "up" arrow
					case 38:
						navigate('up');
						
						//return false;
					break;
					// User pressed "down" arrow
					case 40:
						$("#busca").blur();
						
						navigate('down');
						
						//return false;
					break;
					// User pressed "enter"
					case 13:
						if(currentUrl != '') {
							window.location = currentUrl;
						}
						
						//return false;
					break;
				}*/
				
			//});
			
			// Add data to let the hover know which index they have
			for(var i=0; i<$("ul#resultado li.item a").size(); i++) {
				$("ul#resultado li a").eq(i).data("number", i);
			}
			
			// Simulote the "hover" effect with the mouse
			$("ul#resultado li.item a").hover(
				function () {
					currentSelection= $(this).data("number");
					setSelected(currentSelection);
					
					//$("#nada").html("2: "+currentSelection);
				}, function() {
					//$("ul#resultado li.item a").removeClass("itemhover");
					//currentUrl = '';
				}
			);
		});
	}
}

function navigate(direction) {
	
	
	
	//$("#nada").html("1: "+currentSelection);
	
	// Check if any of the menu items is selected
	if($("ul#resultado li.item .itemhover").size()==0) {
		currentSelection= -1;
		
		//$("#nada").html("nada");
	}
	
	//$("#nada").html($("ul#resultado li.item .itemhover").size());
	
	//$("#nada").html(direction);
	
	if(direction == 'up') {
		//if (currentSelection != -1) {
			//if(currentSelection != 0) {
				//currentSelection--;
			//}
		//}
		
		//$("#nada").html(currentSelection);
		var aux_var= currentSelection;
		
		//$("#nada").html(currentSelection);
		
		if ((currentSelection==-1) || (currentSelection==0)) {
			currentSelection= $("ul#resultado li.item").size()-1;
		}
		else {
			currentSelection--;
		}
		
		//$("#nada").html(aux_var+" -> "+currentSelection);
	}
	else if (direction == 'down') {
		
		var aux_var= currentSelection;
		
		if(currentSelection != $("ul#resultado li.item").size()-1) {
			currentSelection++;
		}
		else currentSelection=0;
		
		//$("#nada").html(aux_var+" -> "+currentSelection);
	}
	
	setSelected(currentSelection);
}

function setSelected(menuitem) {
	$("ul#resultado li.item a").removeClass("itemhover");
	$("ul#resultado li.item a").eq(menuitem).addClass("itemhover");
	currentUrl= $("ul#resultado li.item a").eq(menuitem).attr("href");
	
	//$("#nada").html("current: "+menuitem);
}

function g(quem) {
	return document.getElementById(quem);
}

function setaClasse(campo, classe) {
	try {
		g(campo).className= classe;
	}
	catch (eee) { }
}

/*
$("body.home").keydown(function(e) {
  if(e.keyCode == 37) { // left
    console.log("left");
  }
  else if(e.keyCode == 39) { // right
    console.log("right");
  }
});
*/

/*
if( !window.location.hash && window.addEventListener ){
    window.addEventListener( "load",function() {
        setTimeout(function(){
            window.scrollTo(0, 0);
        }, 0);
    });
    window.addEventListener( "orientationchange",function() {
        setTimeout(function(){
            window.scrollTo(0, 0);
        }, 0);
    });
    window.addEventListener( "touchstart",function() {
         setTimeout(function(){
             window.scrollTo(0, 0);
         }, 0);
     });
}*/