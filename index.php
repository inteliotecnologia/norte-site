<?
$vstatic=4;

@ini_set("url_rewriter.tags","");

require_once("includes/funcoes.php");
require_once("includes/conexao.php");
require_once("language.inc");

require_once 'includes/mobile-detect/Mobile_Detect.php';
$detect = new Mobile_Detect;
$device = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'smartphone') : 'computador');

$cor1= pega_cor(1);
$cor2= pega_cor(2);

$cor_topo= pega_cor(3);
$cor_rodape= pega_cor(4);

$cor_fundo_galerias= pega_cor(5);
$cor_botoes= pega_cor(6);
$cor_barra_titulos1= pega_cor(7);
$cor_barra_titulos2= pega_cor(8);
$cor_modo1= pega_cor(9);
$cor_modo2= pega_cor(10);

$mostrar_online= 1;

if ($pagina=="") $pagina= "home";

if ($pagina=="c") {
	header("location: https://norte.art.br/curador/index2.php?pagina=curadoria&segredo=". $url[1]);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" dir="ltr" lang="pt-BR">

<head profile="http://gmpg.org/xfn/11">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
    <?
	if ($_SESSION["l"]=="") {
		$user_agent= $_SERVER['HTTP_USER_AGENT'];	
		$teste_pt= strpos($user_agent, "pt");
		
		if ($teste_pt===false) {
			$_SESSION["l"]= "en";
		}
		else {
			$_SESSION["l"]= "pt";
		}
	}
	
	$l= $_SESSION["l"];
	
	$title= "Norte";
	
    if (($pagina!="work") && ($pagina!="artist")) {
		if ($l=="pt") {
			$keywords= "norte,move,artistas,ilustração,arte";
			$description= "Norte é uma agência de artistas com raízes na produção executiva, que ao longo dos anos se tornou especialista em gestão de licenças de direito autoral.";
		}
		else {
			$keywords= "norte,move,artist,projects,illustration";
			$description= "Norte is an artists agency rooted in executive production. Throughout the years we have become experts in copyright management. ";
		}
	}
	else {
		if ($pagina=="work") {
			$result= mysql_query("select *, projeto_". $l ." as projeto,
									resumo_". $l ." as resumo,
									texto_site_". $l ." as texto_site,
									tags_site_". $l ." as tags_site
									from projetos
									where url = '". $url[1] ."'
									and   status_projeto <> '0'
									order by id_projeto asc limit 1");
			$rs= mysql_fetch_object($result);
			
			$title.= " :: ". $rs->projeto;
			
			$keywords= $rs->tags_site;
			if ($rs->resumo!="") $description= $rs->resumo;
			else $description= substr(strip_tags($rs->texto_site), 0, 300) ."...";
		}
		else {
			$result= mysql_query("select *, pessoas.release_". $l ." as resumo,
									pessoas.tags_site_". $l ." as tags_site,
									pessoas.texto_site_". $l ." as texto_site
									from pessoas, pessoas_tipos
									where pessoas.id_pessoa = pessoas_tipos.id_pessoa
									and   pessoas_tipos.tipo_pessoa = 'r'
									and   pessoas.site = '1'
									and   pessoas.url = '". $url[1] ."'
									order by pessoas.apelido_fantasia asc") or die(mysql_error());
									
			$rs= mysql_fetch_object($result);
			
			$title.= " :: ". $rs->apelido_fantasia;
			
			$keywords= $rs->tags_site;
			//if ($rs->resumo!="") $description= $rs->resumo;
			//else
			$description= substr(strip_tags($rs->texto_site), 0, 300) ."...";
		}
		
	}
	
	?>
    
    <title><?= $title; ?></title>
    
    <meta name="keywords" content="<?=$keywords;?>" />
	<meta name="description" content="<?=$description;?>" />
	
	
	<meta name="mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="translucent-black" />
	<meta name="apple-mobile-web-app-title" content="Norte">
	
	<? if ( ($pagina!="artist") && ($pagina!="work") ) { ?>
	<meta name="viewport" content="initial-scale=1.0,user-scalable=no">
	<? } else { ?>
	<meta name="viewport" content="initial-scale=1.0,user-scalable=yes">
	<? } ?>
    
  <link rel="apple-touch-icon" href="<?=$r;?>images/apple-touch-icon.png" />
  <link rel="apple-touch-icon" sizes="57x57" href="<?=$r;?>images/apple-touch-icon-57x57.png" />
  <link rel="apple-touch-icon" sizes="72x72" href="<?=$r;?>images/apple-touch-icon-72x72.png" />
  <link rel="apple-touch-icon" sizes="76x76" href="<?=$r;?>images/apple-touch-icon-76x76.png" />
  <link rel="apple-touch-icon" sizes="114x114" href="<?=$r;?>images/apple-touch-icon-114x114.png" />
  <link rel="apple-touch-icon" sizes="120x120" href="<?=$r;?>images/apple-touch-icon-120x120.png" />
  <link rel="apple-touch-icon" sizes="144x144" href="<?=$r;?>images/apple-touch-icon-144x144.png" />
  <link rel="apple-touch-icon" sizes="152x152" href="<?=$r;?>images/apple-touch-icon-152x152.png" />
  <link rel="apple-touch-icon" sizes="180x180" href="<?=$r;?>images/apple-touch-icon-180x180.png" />
  
  <link href="<?=$r;?>images/apple-touch-icon-180x180.png"
              rel="apple-touch-startup-image" />
  
    <? /*<link href="//fonts.googleapis.com/css?family=Droid+Serif:regular,italic" rel="stylesheet" type="text/css" />
    <link href='//fonts.googleapis.com/css?family=Droid+Serif:400,400italic' rel='stylesheet' type='text/css'>*/ ?>
    
    <link rel="shortcut icon" href="<?=$r;?>images/Norte_Favicon.png" />
    
    <link rel="alternate" type="application/rss+xml" title="Norte &raquo; <?= $_MENU_SELECTED[$l]; ?>" href="<?=$r;?>rss_projects/<?=$l;?>/" />
    <link rel="alternate" type="application/rss+xml" title="Norte &raquo; <?= $_MENU_ARTISTS[$l]; ?>" href="<?=$r;?>rss_artists/<?=$l;?>/" />
    
    <link rel="stylesheet" href="<?=$r;?>style.css?v=<?=$vstatic;?>" type="text/css" media="screen" />
    <link rel="stylesheet" href="<?=$r;?>slick-theme.css?v=<?=$vstatic;?>" type="text/css" media="screen" />
    
    <link rel="stylesheet" href="<?=$r;?>style_responsive.css?v=<?=$vstatic;?>" type="text/css" />
    
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">

	
	<style>
		
		
		blockquote span {
			color: <?=$cor1;?> !important;
		}
		
		.cor1_fonte, #content a, .work-box-highlight, h3.lateral-box {
			color: <?=$cor1;?> !important;
		}
		h3.lateral-box {
			border-top: 1px solid <?=$cor1;?>;
		}
		.work-box-information {
			/*border-bottom: 1px solid <?=$cor1;?>;*/
		}
		.cor1_fundo {
			background-color: <?=$cor1;?> !important;
		}
		
		.cor2_fonte {
			color: <?=$cor2;?> !important;
		}
		.cor2_fundo {
			background-color: <?=$cor2;?> !important;
		}
		<?
		$rgb= hex2rgb($cor1);	
		?>
		section#contact:before {
			border-color: rgba(<?=$rgb[0];?>,<?=$rgb[1];?>,<?=$rgb[2];?>, 0);
			border-top-color: <?=$cor1;?>;
		}
		
		.list-open, .div-more-nav {
			border-top: 1px solid <?=$cor1;?>;
		}
		
		h3.subtitle {
			border-bottom: 1px solid <?=$cor1;?>;
		}
		
		@media only screen and (max-width : 767px) {
			h2.pagetit {
				color: <?=$cor1;?> !important;
			}
			
			ul.lista-tags-lado {
				border-bottom-color: <?=$cor1;?> !important;
			}
		}
		
		.out_bar_topo {
			background-color: <?=$cor_topo;?> !important;
		}
		
		#footer {
			background-color: <?=$cor_rodape;?> !important;
		}
		
		#menu ul li a.current, #menu ul li a:hover {
			color: <?=$cor1;?> !important;
			background: none !important;
		}
		
		.list-open-infos h3:first-child {
			border-top: 1px solid <?=$cor1;?>;
		}
		
		#content ul.lista-tags-lado li a:hover,
		#content .div_more a.link_more:hover {
			color: <?=$cor1;?> !important;
		}
		
		p.work-box-highlight {
			color: <?=$cor1;?> !important;
		}
		/*
		.list-thumb div.post a:hover .h3, .list-thumb div.post a:hover .h4 {
			color: <?=$cor1;?> !important;
		}*/
		
		<? if (($pagina=="works") || ($pagina=="work") || ($pagina=="artists") || ($pagina=="artist") ) { ?>
		body {
			background-color: <?=$cor_fundo_galerias;?> !important;
		}
		<? } ?>
		
		#content .div_more a.link_more,
		.go-top a.branco,
		#content .div_more a.link_more {
			background-color: <?=$cor_botoes;?> !important;
		}
		
		.list-thumb div.post a {
			background-color: <?=$cor_barra_titulos1;?> !important;
		}
		.list-thumb div.post a:hover {
			background-color: <?=$cor_barra_titulos2;?> !important;
		}
		
		.view_tags a.closed,
		.view_options ul li.view_options_1 a.on, .view_options ul li.view_options_1 a.on:hover, .view_options ul li.view_options_1 a:active {
			background-color: <?=$cor_modo1;?> !important;
		}
		
		.view_options ul li.view_options_2 a:hover {
			
		}
		
	</style>
	
    <? /*
    <link media="screen and (min-width:721px) and (max-width: 950px)" href="<?=$r;?>css/750.css" rel="stylesheet" />
	
	<link media="screen and (min-width:451px) and (max-width: 720px), screen and (max-device-width: 480px) and (orientation: landscape)" rel="stylesheet" type="text/css" href="<?=$r;?>css/480.css" />
	
	<link media="screen and (min-width:1px) and (max-width: 450px), screen and (max-device-width: 320px)  and (orientation: portrait)" rel="stylesheet" type="text/css" href="<?=$r;?>css/320.css" />
	*/ ?>
	
	<? /*<script type="text/javascript" src="<?=$r;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?=$r;?>js/jquery.lazyload.js"></script>
    */ ?>
    
    <script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
	
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.9.1/jquery-ui.min.js"></script>
	
    <script type="text/javascript" src="<?=$r;?>js/functions.js?v=<?=$vstatic;?>"></script>
    
    <script type="text/javascript" charset="utf-8">
      /*$(function() {
          $("img").lazyload({
             placeholder : "<?=$r;?>img/grey.gif",
             effect      : "fadeIn"
          });
      });*/
	  
	  $.preload([
			"<?=$r;?>images/branco20-bg.png",
			"<?=$r;?>images/branco30-bg.png",
			"<?=$r;?>images/branco45-bg.png",
			"<?=$r;?>images/preto60-bg.png",
			"<?=$r;?>images/preto85-bg.png",
			"<?=$r;?>images/mais_h.png",
			"<?=$r;?>images/volta_h.png",
			"<?=$r;?>images/top2.png",
			"<?=$r;?>images/loading_grey2.gif",
			"<?=$r;?>images/view_1_on.png",
			"<?=$r;?>images/view_2_on.png",
			"<?=$r;?>images/view_3_on.png",
			"<?=$r;?>images/arrow_down.png",
			"<?=$r;?>images/loading.gif",
			"<?=$r;?>images/loading_busca.gif",
			"<?=$r;?>images/ico-rss_2.png",
			"<?=$r;?>images/ico-facebook_2.png",
			"<?=$r;?>images/ico-behance_2.png",
			"<?=$r;?>images/ico-vimeo_2.png",
			"<?=$r;?>images/ico-flickr_2.png",
			"<?=$r;?>images/ico-twitter_2.png",
			"<?=$r;?>images/ico-pinterest_2.png",
			"<?=$r;?>images/ico-gplus_2.png",
			"<?=$r;?>images/ico-linkedin_2.png"
		]);
  </script>
  
  

  <!-- start Mixpanel --><script type="text/javascript">(function(f,b){if(!b.__SV){var a,e,i,g;window.mixpanel=b;b._i=[];b.init=function(a,e,d){function f(b,h){var a=h.split(".");2==a.length&&(b=b[a[0]],h=a[1]);b[h]=function(){b.push([h].concat(Array.prototype.slice.call(arguments,0)))}}var c=b;"undefined"!==typeof d?c=b[d]=[]:d="mixpanel";c.people=c.people||[];c.toString=function(b){var a="mixpanel";"mixpanel"!==d&&(a+="."+d);b||(a+=" (stub)");return a};c.people.toString=function(){return c.toString(1)+".people (stub)"};i="disable track track_pageview track_links track_forms register register_once alias unregister identify name_tag set_config people.set people.set_once people.increment people.append people.track_charge people.clear_charges people.delete_user".split(" ");
for(g=0;g<i.length;g++)f(c,i[g]);b._i.push([a,e,d])};b.__SV=1.2;a=f.createElement("script");a.type="text/javascript";a.async=!0;a.src="//cdn.mxpnl.com/libs/mixpanel-2.2.min.js";e=f.getElementsByTagName("script")[0];e.parentNode.insertBefore(a,e)}})(document,window.mixpanel||[]);
mixpanel.init("210a70db2a481d5466472b94063a7ed0");</script><!-- end Mixpanel -->
  
  <script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-801754-33']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body class="d_<?=$device;?> <? if ($pagina=="home") echo "home"; elseif (($pagina=="artist") || ($pagina=="work")) echo "inner"; elseif (($pagina=="about") || ($pagina=="contact")) echo "inner-2"; elseif (($pagina=="works") || ($pagina=="artists")) echo "inner-3"; ?>">
    <div class="out_bar out_bar_topo">
	    <div class="out">
		    <a name="top" id="top"></a>
		    
		    <div id="header">
	    
	            <div id="logo">
	                <h1><a href="<?=$r;?>">Norte</a></h1>
	                <? //echo $l; ?>
	            </div>
	            
	            <?
	            $ws=0;
	            if ($url[0]=="work") {
	                $result_work= mysql_query("select * from projetos
	                                            where url = '". $url[1] ."'
	                                            and   status_projeto <> '0'
	                                            ");
	                $rs_work= mysql_fetch_object($result_work);
	                
	                if ($rs_work->selecionado=="1") $ws=1;
	            }
	            ?>
	            
	            <div id="menu_controls">
	            	<a class="menu_controls_link" href="javascript:void(0);"><i class="fa fa-bars"></i></a>
	            </div>
	            
	            <div id="menu">
	                <div id="lingua">
		                <?
			            for ($i=0; $i<3; $i++) if ($url[$i]!="") $redir .= $url[$i] ."/";
			            ?>
			                            
			            <ul class="lang">
			                <li><a <? if ($l=="en") echo "class=\"atual\""; ?> href="<?=$r;?>set/en/<?=$redir;?>">EN</a></li>
			                <? /*<li class="chave chave<? if ($l=="en") echo "1"; else echo "2"; ?>"><a href="<?=$r;?>set/<? if ($l=="en") echo "pt"; else echo "en"; ?>/<?=$redir;?>">&nbsp;</a></li>*/ ?>
			                <li class="menu_lang_sepp">|</li>
			                <li class="last"><a <? if ($l=="pt") echo "class=\"atual\""; ?> href="<?=$r;?>set/pt/<?=$redir;?>">PT</a></li>
			            </ul>
			            
	                </div>
	                
	                <? if ($device=="smartphone") { ?>
	                <ul class="principal">
	                    
	                    <li class="menu_artistas"><a href="<?=$r;?>#slider_artistas" <? if (($url[0]=="artists") || ($url[0]=="artist")) echo "class=\"current\""; ?>><?= $_MENU_ARTISTS[$l]; ?></a></li>
	                    
	                    <li class="menu_projetos"><a href="<?=$r;?>#slider_projetos" <? if (($url[1]=="selected") || (($url[0]=="work") && ($ws))) echo "class=\"current\""; ?>><?= $_MENU_SELECTED[$l]; ?></a></li>
	                    
	                    <li class="menu_arquivo"><a href="<?=$r;?>works/archive" <? if (($url[1]=="archive") || (($url[0]=="work") && (!$ws))) echo "class=\"current\""; ?>><?= $_MENU_ARCHIVE[$l]; ?></a></li>
	                    
	                    <li class="menu_sobre"><a href="<?=$r;?>#about" <? if ($url[0]=="about") echo "class=\"current\""; ?>><?= $_MENU_ABOUT[$l]; ?></a></li>
	                    <li class="menu_contato"><a href="<?=$r;?>#contact" <? if ($url[0]=="contact") echo "class=\"current\""; ?>><?= $_MENU_CONTACT[$l]; ?></a></li>
	                </ul>
	                <? } else { ?>
	                
	                <ul class="principal">
	                    
	                    <li class="menu_artistas"><a href="<?=$r;?>artists" <? if (($url[0]=="artists") || ($url[0]=="artist")) echo "class=\"current\""; ?>><?= $_MENU_ARTISTS[$l]; ?></a></li>
	                    
	                    <li class="menu_projetos"><a href="<?=$r;?>works/selected" <? if (($url[1]=="selected") || (($url[0]=="work") && ($ws))) echo "class=\"current\""; ?>><?= $_MENU_SELECTED[$l]; ?></a></li>
	                    
	                    <li class="menu_arquivo"><a href="<?=$r;?>works/archive" <? if (($url[1]=="archive") || (($url[0]=="work") && (!$ws))) echo "class=\"current\""; ?>><?= $_MENU_ARCHIVE[$l]; ?></a></li>
	                    
	                    <li class="menu_sobre"><a href="<?=$r;?>#about" <? if ($url[0]=="about") echo "class=\"current\""; ?>><?= $_MENU_ABOUT[$l]; ?></a></li>
	                    <li class="menu_contato"><a href="<?=$r;?>#contact" <? if ($url[0]=="contact") echo "class=\"current\""; ?>><?= $_MENU_CONTACT[$l]; ?></a></li>
	                </ul>
	                
	                <? } ?>
	            </div>
				
	            <div id="busca-area">
	            	<input type="hidden" name="r" id="r" value="<?=$r;?>" />
	            	<input type="text" autocomplete="off" name="busca" id="busca" />
	                
	                <div id="sugestoes"></div>
	            </div>
	        </div>
	        
	    </div>
    </div>
    
    <?
    if (file_exists("__". $pagina .".php")) include("__". $pagina .".php");
    else include("__erro.php");
    ?>
	
    <hr />
    
    <div id="footer">
	    <div class="out">
	        <div class="parte25">
	            <?
		        /*if ($url[0]=="works") {
			        $redir = $url[0] ."/". $url[1] ."/". $url[2];
		        }
		        elseif ($url[0]=="artists") {
			        $redir = $url[0] ."/". $url[1] ."/". $url[2];
			    }
			    else {*/
			    $redir="";
            	for ($i=0; $i<3; $i++) if ($url[$i]!="") $redir .= $url[$i] ."/";
	            //}
	            ?>
	                            
	            <ul class="lang">
	                <li><a <? if ($l=="en") echo "class=\"atual\""; ?> href="<?=$r;?>set/en/<?=$redir;?>">English</a></li>
	                <li>|</li>
	                <li><a <? if ($l=="pt") echo "class=\"atual\""; ?> href="<?=$r;?>set/pt/<?=$redir;?>">Português</a></li>
	            </ul>
	        </div>
	        
	        <div class="parte50 footer_text">
	            <?
				$result= mysql_query("select pagina_". $l ." as pagina,
										destaque_". $l ." as destaque,
										conteudo_". $l ." as conteudo
										from paginas
										where id_pagina = '3'
										");
				$rs= mysql_fetch_object($result);
				
				echo strip_tags($rs->conteudo);
				?>
	            |
	            
	            Site by <a target="_blank" href="http://intelio.com.br/?utm_source=norte&utm_media=footer&utm_campaing=by">intelio</a>.
	            
	        </div>
	        
	        <div class="parte25" id="footer-networks">
		        <ul>
			        <?
				    $svg= pega_svg("Ins", $cor1);
				    ?>
	                <li><a href="https://instagram.com/norte_art" target="_blank"><?=$svg;?></a></li>
	                
			        <?
				    $svg= pega_svg("Rss", $cor1);
				    ?>
	                <li><a href="<?=$r;?>rss_projects/<?=$l;?>"><?=$svg;?></a></li>
	                
	                <?
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '7'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					
					$svg= pega_svg("Fac", $cor1);
					?>
	                <li><a href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank"><?=$svg;?></a></li>
	                
	                <?
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '8'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					
					$svg= pega_svg("Beh", $cor1);
					?>
	                <li><a href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank"><?=$svg;?></a></li>
					
	                <?
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '9'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					
					$svg= pega_svg("Vim", $cor1);
					?>
	                <li><a href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank"><?=$svg;?></a></li>
	                
	                <?
		                /*
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '10'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					
					$svg= pega_svg("Fli", $cor1);
					?>
	                <li><a href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank"><?=$svg;?></a></li>
	                
	                <?
	                */
	                /*
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '12'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					?>
	                <li><a class="ico-pinterest" href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank">Pinterest</a></li>
	                <?
	                
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '13'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					?>
	                <li><a class="ico-gplus" href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank" rel="publisher">G+</a></li>
	                
	                
	                <?
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '11'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					?>
	                <li><a class="ico-twitter" href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank">Twitter</a></li>
	                <? */ ?>
	                
	                <?
					$result_rede= mysql_query("select *, pagina_". $l ." as pagina,
											destaque_". $l ." as destaque,
											conteudo_". $l ." as conteudo
											from paginas
											where id_pagina = '14'
											");
					$rs_rede= mysql_fetch_object($result_rede);
					
					$svg= pega_svg("Lin", $cor1);
					?>
	                <li><a href="<?= strip_tags($rs_rede->conteudo_pt); ?>" target="_blank"><?=$svg;?></a></li>
	            </ul>
	            
	            <br style="clear:both;"/>
	        </div>
	    </div>
    </div>
    
    <? if ($device=="smartphone") { ?>
    <script type="text/javascript">
		(function(document,navigator,standalone) {
			// prevents links from apps from oppening in mobile safari
			// this javascript must be the first script in your <head>
			if ((standalone in navigator) && navigator[standalone]) {
				
				$(".login_social").remove();
				$("form").removeClass("confirma");
				
				var curnode, location=document.location, stop=/^(a|html)$/i;
				document.addEventListener('click', function(e) {
					curnode=e.target;
					while (!(stop).test(curnode.nodeName)) {
						curnode=curnode.parentNode;
					}
					// Condidions to do this only on links to your own app
					// if you want all links, use if('href' in curnode) instead.
					if(
						'href' in curnode && // is a link
						(chref=curnode.href).replace(location.href,'').indexOf('#') && // is not an anchor
						(	!(/^[a-z\+\.\-]+:/i).test(chref) ||                       // either does not have a proper scheme (relative links)
							chref.indexOf(location.protocol+'//'+location.host)===0 ) // or is in the same protocol and domain
					) {
						e.preventDefault();
						location.href = curnode.href;
					}
				},false);
			}
		})(document,window.navigator,'standalone');
		
		//alert(window.navigator);
	</script>
	
	<script src="<?=$r;?>js/standalone_compressed.js" type="text/javascript" charset="utf-8"></script>

    <? } ?>
    
</body>
</html>