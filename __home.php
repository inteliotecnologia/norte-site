
    <script type="text/javascript" src=".<?=$r;?>js/jquery.simulate.js"></script>
	<script type="text/javascript" src="<?=$r;?>js/jquery.simulate.ext.js"></script>
	
    <script type="text/javascript" src="<?=$r;?>js/jquery.simulate.drag-n-drop.js"></script>
    
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css"/>
    
    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js"></script>
    
    <script type="text/javascript" src="<?=$r;?>js/jquery.fullPage.js"></script>
	
    <div id="fullpage">
	<?
	if ($device=="smartphone") {
		$miniatura_id=6;
		
		if ($l=="pt") $artista_texto= "Artistas";
		else $artista_texto= "Artists";
	?>
	
	<script>
		var altura= $(window).height();
		var altura_anterior= altura;
		
		function checa() {
			
			var altura= $(window).height();
			
			//$("#logo").append("% "+altura+"<br/>");
			
			//if (altura!=altura_anterior) {	
				//if (mudando==0) {
					
				
					$('.slider1 .highlight').height(altura-56);
					$('.slider2 .highlight').height(altura-56);
				//}
			//}
		}
		
		$(document).ready(function() {
			
			//setTimeout(function)
			
			setInterval('checa()', 1000);
			
		});
	</script>
	
	<section id="slider_artistas" data-section-name="slider1" class="slider1">	
		<div class="out_bar_transp">
			<div class="indicacao cor1_fundo">
				<?=$artista_texto;?>
			</div>
			
			<div class="home_slider1">
	
			<?									
			$result_destaque_artistas= mysql_query("select *, pessoas.texto_site_". $l ." as texto_site from pessoas, pessoas_tipos, enderecos
													where pessoas.id_pessoa = pessoas_tipos.id_pessoa
													and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.site = '1'
													and   pessoas.id_pessoa = enderecos.id_pessoa
													and   pessoas_tipos.status_pessoa <> '2'
													$str
													order by pessoas.apelido_fantasia asc
													");
			$linhas_destaque_artistas= mysql_num_rows($result_destaque_artistas);
			
			$i=0;
			while ($rs_destaque= mysql_fetch_object($result_destaque_artistas)) {
			?>
			    <div class="highlight home-block">      
			        <?
					
					
					
					$imagem_miniatura= pega_imagem_miniatura_site('a', $rs_destaque->id_pessoa, $miniatura_id);
					
					if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
					else {
						$imagem= pega_imagem('a', $rs_destaque->id_pessoa);
						$imagem_definitiva= $imagem;
					}
					
					if ($imagem_definitiva!="") {
						
						if ($i==0) {
							$imagem_destaque_grande= BUCKET . BUCKET_SITE ."artista_". $rs_destaque->id_pessoa ."/". $imagem_definitiva;
						}
							
							/*<a href="<?=$r;?>work/<?=$rs_destaque->url?>/"><img width="940" height="380" src="<?= $r; ?>includes/phpthumb/phpThumb.php?src=/p_<?= $rs_destaque->id_projeto; ?>/<?= $imagem_definitiva; ?>&amp;w=940&amp;h=380&amp;zc=1" alt="" /></a>*/
					?> 
			        <a class="link_bg" href="<?=$r;?>artist/<?=$rs_destaque->url?>/" style="background-image: url('<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs_destaque->id_pessoa; ?>/<?= $imagem_definitiva; ?>');">
				        &nbsp;
			        </a>
			        
			        <div class="highlight-text">
			            <div class="out">
				            <a href="<?=$r;?>artist/<?=$rs_destaque->url?>/">
				                
				                <span class="highlight-text-linha">
				                    <span class="h4_tit"><?= $artista_texto; ?></span>
				                    <span class="home_sep cor1_fonte">|</span>
				                    <span class="h3_tit"><?= string_maior_que($rs_destaque->apelido_fantasia, 32); ?></span>
				    			</span>
				                
				                <span class="highlight-text-arrow">
				                    &gt;
				                </span>
				            </a>
			            </div>
			        </div>
			        <? } ?>
			    </div>
				<? $i++; } ?>
			</div>
		</div>
		
		<?
		if ( ($imagem_destaque_grande!="") && ($_SESSION["abertura"]!="1") ) {
			$_SESSION["abertura"]="1";
		?>
	    <div class="abertura" style="background-image: url(<?=$imagem_destaque_grande;?>);">
		    <div class="logonorte2">
		    </div>
	    </div>
	    
	    <script>
		    $(document).ready(function(){
			    
			    setTimeout(function() {
				    $('.abertura').fadeOut(500);
			    }, 10000);
			    
			    $(".abertura").click( function() {
				    $('.abertura').fadeOut(500);
				});
				
				$('.abertura .logonorte2').hover(
					function () {
						$('.abertura').fadeOut(500);
					}, 
					function () {
						
					}
				);
				    
			});
			    
	    </script>
	    <? } ?>
	    
	</section>
	
	<?
	if ($l=="pt") $projeto_texto= "Projetos";
	else $projeto_texto= "Projects";	
	?>
	<section id="slider_projetos" data-section-name="slider2" class="slider2">	
		<div class="out_bar_transp">
			<div class="indicacao cor1_fundo">
				<?=$projeto_texto;?>
			</div>
			
			<div class="home_slider2">
	
			<?	
			if ($l=="pt") $projeto_texto= "Projeto";
			else $projeto_texto= "Project";	
	
			$result_destaque_projetos= mysql_query("select *, projeto_". $l ." as projeto, texto_site_". $l ." as texto_site from projetos
													where site = '1'
													". $str ."
													and   status_projeto <> '0'
													and   selecionado = '1'
													and   site = '1'
													order by selecionado desc, ordem asc
													");
			$linhas_destaque_projetos= mysql_num_rows($result_destaque_projetos);
			
			$i=0;
			while ($rs_destaque= mysql_fetch_object($result_destaque_projetos)) {	
			?>
			    <div class="highlight home-block">      
			        <?
					$imagem_miniatura= pega_imagem_miniatura_site('p', $rs_destaque->id_projeto, $miniatura_id);
					
					if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
					else {
						$imagem= pega_imagem('p', $rs_destaque->id_projeto);
						$imagem_definitiva= $imagem;
					}
					
					if ($imagem_definitiva!="") {
							
						if ($i==0) {
							$imagem_destaque_grande= BUCKET . BUCKET_SITE ."projeto_". $rs_destaque->id_projeto ."/". $imagem_definitiva;
						}
						
						/*<a href="<?=$r;?>work/<?=$rs_destaque->url?>/"><img width="940" height="380" src="<?= $r; ?>includes/phpthumb/phpThumb.php?src=/p_<?= $rs_destaque->id_projeto; ?>/<?= $imagem_definitiva; ?>&amp;w=940&amp;h=380&amp;zc=1" alt="" /></a>*/
					?> 
					<a class="link_bg" href="<?=$r;?>work/<?=$rs_destaque->url?>/" style="background-image: url('<?= BUCKET . BUCKET_SITE; ?>projeto_<?= $rs_destaque->id_projeto; ?>/<?= $imagem_definitiva; ?>');">
						&nbsp;
					</a>
					
					<div class="highlight-text">
						<div class="out">
							<a href="<?=$r;?>work/<?=$rs_destaque->url?>/">
								
								<span class="highlight-text-linha">
									<span class="h4_tit"><?= $projeto_texto; ?></span>
									<span class="home_sep cor1_fonte">|</span>
									<span class="h3_tit"><?= string_maior_que($rs_destaque->projeto, 28); ?></span>
								</span>
								
								<span class="highlight-text-arrow">
									&gt;
								</span>
							</a>
						</div>
					</div>    
				<? } ?>
			        
			    </div>
			<? $i++; } ?>
			</div>
		</div>
		
		<?
		/* if ( ($imagem_destaque_grande!="") && ($_SESSION["abertura"]!="1") ) {
			$_SESSION["abertura"]="1";
		?>
	    <div class="abertura" style="background-image: url(<?=$imagem_destaque_grande;?>);">
		    <div class="logonorte2">
		    </div>
	    </div>
	    
	    <script>
		    $(document).ready(function(){
			    
			    setTimeout(function() {
				    $('.abertura').fadeOut(500);
			    }, 10000);
			    
			    $(".abertura").click( function() {
				    $('.abertura').fadeOut(500);
				});
				    
			});
			    
	    </script>
	    <? } */ ?>
	    
	    <script>
		$(document).ready(function(){
			
			var altura= $(window).height();
			
			
			
			$('.home_slider1').slick({
				autoplay: false,
				accessibility: true,
				infinite: true,
				arrows: true,
				autoplaySpeed: 6000,
				speed: 200,
				dots: true
			});
			
			$('.home_slider2').slick({
				autoplay: false,
				accessibility: true,
				infinite: true,
				arrows: true,
				autoplaySpeed: 6000,
				speed: 200,
				dots: true
			});
			
			//alert(altura);
			
			$('.slider1 .highlight').height(altura-56);
			$('.slider2 .highlight').height(altura-56);
			
		});
	    </script>
	    
	</section>
	
    
	
	
    <?
	}
	//desktop
	else {
	    $miniatura_id=5;
    ?>
    
    
	
    <section data-section-name="slider">	
		<div class="out_bar_transp">
			<div class="home_slider">
				
				
				
			<?
			//echo "abc: ". $_SERVER['REQUEST_URI'];
			
			$itens_a_mostrar=8;
			$itens_mostrados=0;
			
			$str_projeto= "";
			$str_artista= "";
			
			$result_destaque_projetos= mysql_query("select *, projeto_". $l ." as projeto from projetos
													where status_projeto <> '0'
													and   site = '1'
													and   destaque = '1'
													order by RAND()
													limit 4
													");
			$linhas_destaque_projetos= mysql_num_rows($result_destaque_projetos);
			
			$result_destaque_artistas= mysql_query("select *, texto_site_". $l ." as texto_site from pessoas, pessoas_tipos
													where pessoas.id_pessoa = pessoas_tipos.id_pessoa
													and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas_tipos.status_pessoa <> '2'
													and   pessoas.site = '1'
													and   pessoas.destaque = '1'
													order by RAND()
													limit 4
													");
			$linhas_destaque_artistas= mysql_num_rows($result_destaque_artistas);
			
			$total_destaques= $linhas_destaque_projetos+$linhas_destaque_artistas;
			
			$percent_projetos= ($linhas_destaque_projetos*100)/$total_destaques;
			$percent_artistas= ($linhas_destaque_artistas*100)/$total_destaques;
			
			$rand_pre= rand(0, 100);
			
			for ($i=0; $i<=15; $i++) {
				
				if ($itens_mostrados<$itens_a_mostrar) {
					
					if (($rand_pre%2)==0) {
						$opcao1= "projetos";
						$opcao2= "artistas";
					}
					else {
						$opcao1= "artistas";
						$opcao2= "projetos";
					}
					
					switch ($itens_mostrados) {
						case 0:
						case 2:
						case 4:
						case 6:
							$mostra= $opcao1;
						break;
						
						default:
							$mostra= $opcao2;
						break;
					}
					
					//$rand= rand(0, 100);
					
					//echo $percent_projetos ." | ". $percent_artistas;
					/*
					
					if (($linhas_destaque_projetos>0) && ($percent_projetos<=$percent_artistas)) {
						if ($rand<=$percent_projetos) $mostra= "projetos";
						else $mostra= "artistas";
					}
					elseif ($linhas_destaque_artistas>0) {
						if ($rand<=$percent_artistas) $mostra= "artistas";
						else $mostra= "projetos";
					}
					else {
						$mostra= "projetos";
					}
					*/
					
					?>
				    
				        <?
						if ($mostra=="projetos") {
							
							
							
							if ($l=="pt") $projeto_texto= "Projeto";
							else $projeto_texto= "Project";
							
							$result_destaque= mysql_query("select *, projeto_". $l ." as projeto from projetos
															where status_projeto <> '0'
															and   site = '1'
															and   destaque = '1'
															". $str_projeto ."
															order by RAND() desc limit 1
															");
							$linhas_destaque= mysql_num_rows($result_destaque);
							
							if ($linhas_destaque>0) {
								$itens_mostrados++;
							$rs_destaque= mysql_fetch_object($result_destaque);
							
							$str_projeto .= " and   id_projeto <> '". $rs_destaque->id_projeto ."' ";
							
							$imagem_miniatura= pega_imagem_miniatura_site('p', $rs_destaque->id_projeto, $miniatura_id);
							
							if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
							else {
								$imagem= pega_imagem('p', $rs_destaque->id_projeto);
								$imagem_definitiva= $imagem;
							}
							
							if ($imagem_definitiva!="") {
									
									if ($i==0) {
										$imagem_destaque_grande= BUCKET . BUCKET_SITE ."projeto_". $rs_destaque->id_projeto ."/". $imagem_definitiva;
									}
									
									/*<a href="<?=$r;?>work/<?=$rs_destaque->url?>/"><img width="940" height="380" src="<?= $r; ?>includes/phpthumb/phpThumb.php?src=/p_<?= $rs_destaque->id_projeto; ?>/<?= $imagem_definitiva; ?>&amp;w=940&amp;h=380&amp;zc=1" alt="" /></a>*/
							?> 
						<div class="highlight home-block aa_<?=$itens_mostrados;?>"> 
							<a class="link_bg" href="<?=$r;?>work/<?=$rs_destaque->url?>/" style="background-image: url('<?= BUCKET . BUCKET_SITE; ?>projeto_<?= $rs_destaque->id_projeto; ?>/<?= $imagem_definitiva; ?>');">
								&nbsp;
							</a>
							
							<div class="highlight-text">
								<div class="out">
									<a href="<?=$r;?>work/<?=$rs_destaque->url?>/">
										
										<span class="highlight-text-linha">
											<span class="h4_tit"><?= $projeto_texto; ?></span>
											<span class="home_sep cor1_fonte">|</span>
											<span class="h3_tit"><?= $rs_destaque->projeto; ?></span>
										</span>
										
										<span class="highlight-text-arrow">
											&gt;
										</span>
									</a>
								</div>
							</div>
						</div> 
						<? } } } ?>
				        
				        <?
						if ($mostra=="artistas") {
							
							if ($l=="pt") $artista_texto= "Artista";
							else $artista_texto= "Artist";
							
							$result_destaque= mysql_query("select *, texto_site_". $l ." as texto_site from pessoas, pessoas_tipos
															where pessoas.id_pessoa = pessoas_tipos.id_pessoa
															and   pessoas_tipos.tipo_pessoa = 'r'
															and   pessoas_tipos.status_pessoa <> '2'
															and   pessoas.site = '1'
															". $str_artista ."
															and   pessoas.destaque = '1'
															order by RAND() desc limit 1
															");
							$linhas_destaque= mysql_num_rows($result_destaque);
							
							if ($linhas_destaque>0) {
								$itens_mostrados++;
								
							$rs_destaque= mysql_fetch_object($result_destaque);
							
							$str_artista .= " and   pessoas.id_pessoa <> '". $rs_destaque->id_pessoa ."' ";
							
							$imagem_miniatura= pega_imagem_miniatura_site('a', $rs_destaque->id_pessoa, $miniatura_id);
							
							if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
							else {
								$imagem= pega_imagem('a', $rs_destaque->id_pessoa);
								$imagem_definitiva= $imagem;
							}
							
							if ($imagem_definitiva!="") {
								
								if ($i==0) {
									$imagem_destaque_grande= BUCKET . BUCKET_SITE ."artista_". $rs_destaque->id_pessoa ."/". $imagem_definitiva;
								}
								
								/*<a href="<?=$r;?>work/<?=$rs_destaque->url?>/"><img width="940" height="380" src="<?= $r; ?>includes/phpthumb/phpThumb.php?src=/p_<?= $rs_destaque->id_projeto; ?>/<?= $imagem_definitiva; ?>&amp;w=940&amp;h=380&amp;zc=1" alt="" /></a>*/
						?> 
					    <div class="highlight home-block aa_<?=$itens_mostrados;?>"> 
					        <a class="link_bg" href="<?=$r;?>artist/<?=$rs_destaque->url?>/" style="background-image: url('<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs_destaque->id_pessoa; ?>/<?= $imagem_definitiva; ?>');">
						        &nbsp;
					        </a>
					        
					        <div class="highlight-text">
					            <div class="out">
						            <a href="<?=$r;?>artist/<?=$rs_destaque->url?>/">
						                
						                <span class="highlight-text-linha">
						                    <span class="h4_tit"><?= $artista_texto; ?></span>
						                    <span class="home_sep cor1_fonte">|</span>
						                    <span class="h3_tit"><?= $rs_destaque->apelido_fantasia; ?></span>
						    			</span>
						                
						                <span class="highlight-text-arrow">
						                    &gt;
						                </span>
						            </a>
					            </div>
					        </div>
					    </div>
				        <? } } } ?>
			    
			<? } } ?>
			</div>
			
			<script type="text/javascript">
				var hash = window.location.hash;
				var hash = hash.substring(hash.indexOf('#')); // '#foo'
				
				//if (hash!="") {
					//$(".home_slider, .highlight-text").css("opacity", "0");
					
					$(document).ready(function() {
						
						setTimeout(function() {
						
							$(".home_slider").css("opacity", "1");
							
							console.log("mostrando...");
							
						}, 250);
						
					});
					
					
				//}
			</script>
			
			
			
		</div>
		
		<?
		if ( ($imagem_destaque_grande!="") && ($_SESSION["abertura"]!="1") ) {
			$_SESSION["abertura"]="1";
		?>
	    <div class="abertura" style="background-image: url(<?=$imagem_destaque_grande;?>);">
		    <div class="logonorte2">
		    </div>
	    </div>
	    
	    <script>
		    $(document).ready(function(){
			    
			    setTimeout(function() {
				    $('.abertura').fadeOut(500);
			    }, 10000);
			    
			    $(".abertura").click( function() {
				    $('.abertura').fadeOut(500);
				});
				    
			});
			    
	    </script>
	    <? } ?>
	    
	    <script>
		$(document).ready(function(){
			
			var altura= $(window).height();
			
			$('.highlight').height(altura);
			
			$('.home_slider').slick({
				autoplay: false,
				accessibility: true,
				infinite: true,
				arrows: true,
				autoplaySpeed: 6000,
				speed: 250,
				dots: true
			});
			
			//alert($(this.hash));
			
			if (hash=="") {
			
				setTimeout(function() {
					
					$('.slick-current .highlight-text a').focus();
					
				}, 800);
			
			}
			
		});
	    </script>
	    
	</section>
    
    
    
    <? } //fim else computador ?>
    
    
    <section id="about" data-section-name="about" class="cor1_fundo">
	    <a name="about"></a>
	    <div class="out_bar_flat">
			<div class="out">
				<?
				$id_pagina=15;
				
				$result= mysql_query("select pagina_". $l ." as pagina,
							destaque_". $l ." as destaque,
							conteudo_". $l ." as conteudo
							from paginas
							where id_pagina = '". $id_pagina ."'
							");
				$rs= mysql_fetch_object($result);
				?>
				
				
				<div class="entry">
					<? if ($rs->pagina!="") { ?>
					<h2 class="pagetit"><?=$rs->pagina;?></h2>
					<? } ?>
					
				    
				    
				    
				    <? if ($rs->destaque!="") { ?>
				    <?
					$conteudo= explode("____", $rs->destaque);
					$conteudo_count= count($conteudo);
					
					switch ($conteudo_count) {
						case 2: $classe= "parte50"; break;
						case 3: $classe= "parte33"; break;
					}
					
					for ($i=0; $i<$conteudo_count; $i++) {
						echo "<div class='". $classe ." i". $i ." l0'>";
						echo formata_texto_saida($conteudo[$i]);
						echo "</div>";
					}
					
				    //echo nl2br($rs->conteudo);
				    ?>
				    <br class="clear"/><br class="clear"/>
				    <? } ?>
				    
				    
				    
				    
				    <? if ($rs->conteudo!="") { ?>
				    <?
					$conteudo= explode("____", $rs->conteudo);
					$conteudo_count= count($conteudo);
					
					switch ($conteudo_count) {
						case 2: $classe= "parte50"; break;
						case 3: $classe= "parte33"; break;
					}
					
					for ($i=0; $i<$conteudo_count; $i++) {
						echo "<div class='". $classe ." i". $i ." l1'>";
						echo formata_texto_saida($conteudo[$i]);
						echo "</div>";
					}
					
				    //echo nl2br($rs->conteudo);
				    ?>
				    <br class="clear"/>
				    <? } ?>
				</div>
			</div>
	    </div>
    </section>
    
    <? if ($device!="smartphone") { ?>
    <section id="highlight" data-section-name="highlight">
	    <div class="link_next">
	    	<a href="javascript:void(0);">Next</a>
	    </div>
	    
	    <div class="out_bar_transp obp">
		    
		    <div class="out">
			    <div class="list-thumb list-thumb-home home-block home-block-hide">
			        
			        
			        <?
					$result= mysql_query("select *, projeto_". $l ." as projeto from projetos
											where site = '1'
											and   selecionado = '1'
											and   status_projeto <> '0'
											and   id_projeto <> '". $rs_destaque->id_projeto ."'
											order by RAND() asc limit 2 ") or die(mysql_error());
					$i=1;
					while ($rs= mysql_fetch_object($result)) {
						
						$imagem_miniatura= pega_imagem_miniatura_site('p', $rs->id_projeto, 2);
						
						if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
						else {
							$imagem= pega_imagem('p', $rs->id_projeto);
							$imagem_definitiva= $imagem;
						}
						
						if ($rs->cidade_uf!="") $cidade_uf= $rs->cidade_uf;
						else $cidade_uf= pega_cidade($rs->id_cidade);
						
						if (($i%3)==0) $classe= "nope";
					?>            
					<div class="list-thumb">
						<div class="post">
							<a href="<?=$r;?>work/<?= $rs->url; ?>/" title="<?= $rs->apelido_fantasia; ?>">
								<? if ($imagem_definitiva!="") { ?>
			                    
			                    <?php
						        if ($rs->selo_cor!="") {
									$svg= pega_svg("Selo_". $l, $rs->selo_cor);
								?>
					            
					            <div class="selo">
						            <?= $svg; ?>
					            </div>
					            <? } ?>
					            
			                    <img src="<?= BUCKET . BUCKET_SITE; ?>projeto_<?= $rs->id_projeto; ?>/<?= $imagem_definitiva; ?>" alt=""/>
			                    <? } ?>
								<span class="h3"><?= $rs->projeto; ?></span>
					
								<span class="h4"><?= pega_pessoa($rs->id_agencia); ?></span>
							</a>
						</div>
									
					</div>
					<? $i++; } ?>
			                    
			        <div class="nope">
			        	<?
						$result= mysql_query("select pagina_". $l ." as pagina,
												destaque_". $l ." as destaque,
												conteudo_". $l ." as conteudo
												from paginas
												where id_pagina = '4'
												");
						$rs= mysql_fetch_object($result);
						?>
			            
			            <h2 class="sectiontitle"><a class="link-tit" href="<?=$r;?>works/selected/"><?= $rs->pagina; ?></a></h2>
			            
						<?= $rs->conteudo; ?><br /><br />
			            
			            
			        </div>
			        
			        <br class="clear" />
			    </div>
			    
			    
			    
			    
			    
			    
			    
			    
			    <div class="list-thumb list-thumb-home home-block home-block-hide home-block-noline">
			        
			        <?
					$result= mysql_query("select * from pessoas, pessoas_tipos, enderecos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.tipo_pessoa = 'r'
												and   pessoas.id_pessoa = enderecos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												and   pessoas.site = '1'
												order by RAND() asc limit 2") or die(mysql_error());
					$i=1;
					while ($rs= mysql_fetch_object($result)) {
						
						$imagem_miniatura= pega_imagem_miniatura_site('a', $rs->id_pessoa, 2);
						
						if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
						else {
							$imagem= pega_imagem('a', $rs->id_pessoa);
							$imagem_definitiva= $imagem;
						}
						
						//if ($rs->cidade_uf!="")
						$cidade_uf= $rs->cidade_uf;
						//else $cidade_uf= pega_cidade($rs->id_cidade);
						
						if (($i%3)==0) $classe= "nope";
					?>            
					<div class="list-thumb">
						<div class="post <?=$classe;?>">
							<a href="<?=$r;?>artist/<?= $rs->url; ?>/" title="<?= $rs->apelido_fantasia; ?>">
								<? if ($imagem_definitiva!="") { ?>
			                    
			                    <?php
						        if ($rs->selo_cor!="") {
									$svg= pega_svg("Selo_". $l, $rs->selo_cor);
								?>
					            
					            <div class="selo">
						            <?= $svg; ?>
					            </div>
					            <? } ?>
					            
			                    <img width="300" height="160" src="<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs->id_pessoa; ?>/<?= $imagem_definitiva; ?>" alt=""/>
			                    <? } ?>
			                    
								<span class="h3"><?= $rs->apelido_fantasia; ?></span>
					
								<span class="h4"><?= $cidade_uf; ?></span>
							</a>
						</div>
									
					</div>
					<? $i++; } ?>
			                    
			        <div class="nope">
			            
			            <?
						$result= mysql_query("select pagina_". $l ." as pagina,
												destaque_". $l ." as destaque,
												conteudo_". $l ." as conteudo
												from paginas
												where id_pagina = '5'
												");
						$rs= mysql_fetch_object($result);
						?>
			            
			            <h2 class="sectiontitle"><a class="link-tit" href="<?=$r;?>artists/"><?= $rs->pagina; ?></a></h2>
			
			            <?= $rs->conteudo; ?><br /><br />
			            
			        </div>
			        
			        <br class="clear" />
			    </div>
			    
			    <script>
					mixpanel.track("Acessou Home", {
						"Língua": "<?=$_SESSION["l"];?>"
					});
				</script>
		    </div>
	    </div>
    </section>
    <? } ?>
    
    <section id="contact" data-section-name="contact" class="cor1_fundo">
	    <a name="contact"></a>
		
		<div class="link_next">
	    	<a href="javascript:void(0);">Next</a>
	    </div>
	    
		<div class="out_bar_flat">
			
			<div class="out">
				<?
				$id_pagina=16;
				
				$result= mysql_query("select pagina_". $l ." as pagina,
							destaque_". $l ." as destaque,
							conteudo_". $l ." as conteudo
							from paginas
							where id_pagina = '". $id_pagina ."'
							");
				$rs= mysql_fetch_object($result);
				?>
				
				<div class="entry">
					<? if ($rs->pagina!="") { ?>
					<h2 class="pagetit"><?=$rs->pagina;?></h2>
					<? } ?>
					
					<? if ($rs->destaque!="") { ?>
				    <blockquote><p><?= $rs->destaque; ?></p></blockquote>
				    <br />
				    <? } ?>
				    
				    <? if ($rs->conteudo!="") { ?>
				    <?
					$conteudo= explode("____", $rs->conteudo);
					$conteudo_count= count($conteudo);
					
					switch ($conteudo_count) {
						case 2: $classe= "parte50"; break;
						case 3: $classe= "parte33"; break;
					}
					
					for ($i=0; $i<$conteudo_count; $i++) {
						echo "<div class='". $classe ." i". $i ."'>";
						
						//if ($i==0)
							//echo '<h2 class="pagetitle">'. $rs->pagina .'</h2>';
							
						echo formata_texto_saida($conteudo[$i]);
						echo "</div>";
					}
					
				    //echo nl2br($rs->conteudo);
				    ?>
				    <br class="clear"/>
				    <? } ?>
				</div>
			</div>
	    </div>
    </section>
    </div>
    <? /*
    <div id="debug" style="z-index:99999;display:fixed;background:#fff;color:#333;font-family:Courier New;font-size:12px;width:100px;height:35px;">
	    oi
    </div>
    */ ?>
    <script type="text/javascript">
		$(document).ready(function() {
			
			var altura_janela= $(window).height();
			var largura_janela= $(window).width();
			
			//alert(altura_janela);
			
			if ((altura_janela>459) || (largura_janela>altura_janela)) {
			
				$('#fullpage').fullpage({
					
					fixedElements: '.out_bar_topo, #footer',
					lockAnchors: true,
	//				anchors:['firstPage', 'secondPage'],
					sectionSelector: 'section',
					
					scrollBar: true,
					scrollingSpeed: 600,
					fitToSectionDelay: 900,
					
					onLeave: function(index, nextIndex, direction){
			            var leavingSection = $(this);
						
						//setTimeout(function() {
							
							if (mudando==0) {
								current_home_section= nextIndex;
								//alert("rolando para "+current_home_section);
							
								//$("#logo").append("~ "+current_home_section+"<br/>");
							}
							
						//}, 500);
						
						<? if ($device!="smartphone") { ?>
			            //after leaving section 2
			            if ((index == 2) && (direction == 'up')) {
			                
			                setTimeout(function() {
					
								$('.slick-current .highlight-text a').focus();
								
							}, 800);
							
			            }
			            <? } ?>
			
			            //else if(index == 2 && direction == 'up'){
			            //    alert("Going to section 1!");
			           // }
			        },
					
					<? if ($device=="smartphone") { ?>
					navigation: true,
					//navigationPosition: 'right',
					//responsiveHeight: 450
					touchSensitivity: 30
					<? } ?>
					
					
			        
					
					//autoScrolling: true,
					
					//keyboardScrolling: false,
			        //animateAnchor: true,
			        //recordHistory: true,
			        
			        //normalScrollElements: '#contact, #about',
					
				});
			}
			else {
				$("body").addClass("jp");
			}
			
			if (hash!="") {
				
				
			}
			
		});
	</script>
    
	    