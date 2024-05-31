

<div id="page">
    <div id="content" class="content_artist">
		
		
		<div class="pagetitle-top">
			<?
			if ($device=="smartphone") {
			?>
			<? /*<a href="<?=$r;?>">&laquo; <?= $_MENU_ARTISTS[$l]; ?></a>*/ ?>
			<? } else { ?>
			<a href="<?=$r;?>artists/">&laquo; <?= $_MENU_ARTISTS[$l]; ?></a>
			<? } ?>
		</div>
		
		<?						
		$result= mysql_query("select *, texto_site_". $l ." as texto_site from pessoas, pessoas_tipos, enderecos
									where pessoas.id_pessoa = pessoas_tipos.id_pessoa
									and   pessoas_tipos.tipo_pessoa = 'r'
									and   pessoas_tipos.status_pessoa = '1'
									and   pessoas.id_pessoa = enderecos.id_pessoa
									and   pessoas.url = '". $url[1] ."'
									and   pessoas.site = '1'
									order by pessoas.apelido_fantasia asc");
									
		$linhas= mysql_num_rows($result);
		if ($linhas==0) {
		?>

		<h2 class="pagetitle posttitle">Ops!</h2>
		
		<p>Conteúdo não encontrado.</p>
		<br /><br /><br />
		<?
		}
		else {
			$rs= mysql_fetch_object($result);
		
			if ($l=="pt") $cidade_uf= $rs->cidade_uf;
			else $cidade_uf= $rs->cidade_uf_en;
		?>
		
			<script>
				mixpanel.track("Acessou Artista", {
					"Língua": "<?=$_SESSION["l"];?>",
					"ID Artista": "<?= $rs->id_pessoa; ?>",
					"Artista": "<?= $rs->apelido_fantasia; ?>",
					<? if ($cidade_uf!="") { ?>
					"Local": "<?= $cidade_uf; ?>",
					<? } ?>
					
				});
			</script>
			
			
			
			
			
			
			
			
			<?
			if ($device=="smartphone") {
			?>
			
			
			
			<script type="text/javascript" src="<?=$r;?>js/jquery.fullPage.js"></script>
	    
		    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css"/>
		    
		    <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js"></script>
			
			
			<div id="fullpage">	
				
				<section>
			
				<div class="indicacao cor1_fundo">
					<?= $rs->apelido_fantasia; ?>
				</div>
				
				<div class="home_slider2">
		
				<?	
				$result_enviados= mysql_query("select * from imagens
		                                        where id_externo = '". $rs->id_pessoa ."'
		                                        and   tipo_imagem = 'a'
												and   site = '1'
												and   ( miniatura_destaque is NULL or miniatura_destaque = '0')
		                                        order by ordem asc
		                                        ") or die(mysql_error());
				$linhas_enviados= mysql_num_rows($result_enviados);
				
				while ($rs_enviados= mysql_fetch_object($result_enviados)) {
					
					if ($rs_enviados->altura>=$rs_enviados->largura) {
						$classe_add="retrato";
					}
					else
						$classe_add="paisagem";
						
				?>
				    <div class="highlight home-block">      
				        
				        <? /*
				        <img class="<?= $classe_imagem; ?>" src="<?= BUCKET . BUCKET_SITE; ?>projeto_<?= $rs->id_projeto; ?>/<?= $rs_enviados->nome_arquivo_site; ?>" width="<?= $rs_enviados->largura_site;?>" height="<?= $rs_enviados->altura_site;?>" border="0" alt="" />
				        */ ?>
				        
				        
				        
				        
						<div class="imagem_bg <?=$classe_add;?>" style="background-image: url('<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs->id_pessoa; ?>/<?= $rs_enviados->nome_arquivo_site; ?>');">
							&nbsp;
						</div>
						
						<? /*
						<div class="highlight-text">
							<div class="out">
								<a href="<?=$r;?>work/<?=$rs_destaque->url?>/">
									
									<span class="highlight-text-linha">
										<span class="h4_tit"><?= pega_pessoa($rs_destaque->id_agencia); ?></span>
										<span class="home_sep cor1_fonte">|</span>
										<span class="h3_tit"><?= $rs_destaque->projeto; ?></span>
									</span>
									
									<span class="highlight-text-arrow">
										&gt;
									</span>
								</a>
							</div>
						</div> 
						*/ ?>
						   
					
				        
				    </div>
				<? } ?>
				</div>
				
				
				
				<script>
				$(document).ready(function(){
					
					var altura= $(window).height();
					
					//$('.slider1 .highlight').height(altura);
					$('.home_slider2 .highlight').height(altura);
					
					$('.home_slider2').slick({
						autoplay: false,
						infinite: true,
						arrows: true,
						autoplaySpeed: 6000,
						speed: 400,
						dots: true,
						//cssEase: 'easeInQuad'
					});
					
				});
			    </script>
			</section>
			
			<section>
			<div class="work-box">
			    <div class="list-open-thumb list-open-thumb-inner">
			        <h2 class="mobile_titulo fonte_cor1"><?= $rs->apelido_fantasia; ?></h2>
			        
			        <? //if ($rs->resumo!="") { ?>
			        <p class="work-box-highlight"><?= formata_texto($rs->resumo); ?></p>
			        <? //} ?>
			        
			        <? //if ($rs->texto_site!="") { ?>
			        <?= formata_texto($rs->texto_site); ?> <br/>
			        <? //} else echo "&nbsp;"; ?>
			        
			    </div>
			    <div class="list-open-infos inside not">
			        
			        <? if ($cidade_uf!="") { ?>
			    <h3 class="lateral-box sem_margem"><?= $_WORD_LOCAL[$l]; ?></h3>
			    
			    <div><?= $cidade_uf; ?></div>
			    <? } else $classe_tags= "sem_margem"; ?>
			    
			    <div class="area_tags_inner">
				    <h3 class="lateral-box <?= $classe_tags; ?>">Tags</h3>
				    
				    <ul class="lista-tags-lado">
						<?
				        $tags= "";
				        
				        $result_tags= mysql_query("select *, pessoas.tags_site_". $l ." as tags from pessoas, pessoas_tipos
				                                    where pessoas.id_pessoa = pessoas_tipos.id_pessoa
				                                    and   pessoas_tipos.status_pessoa <> '2'
				                                    and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.id_pessoa = '". $rs->id_pessoa ."'
				                                    and   pessoas.site = '1'
				                                    ") or die(mysql_error());
				        $i= 0;
				        while ($rs_tags= mysql_fetch_object($result_tags)) {
				            if ($rs_tags->tags!="") {
								$tags_aqui= explode(",", $rs_tags->tags);
								
								$j=0;
								while (($tags_aqui[$j]!="") && ($tags_aqui[$j]!=" ")) {
									
									$tag[$i]= trim($tags_aqui[$j]);
									
									$i++;
									$j++;
								}
							}
				        }
				        
						if ($i>0) {
							$tag= @array_unique($tag);
							@sort($tag);
							
							$tamanho= (count($tag));
							
							if ($tamanho>0) {
								$i=0;
								foreach ($tag as $chave => $valor){
									$j=$i+1;
									
									if ($j==$tamanho) $ponto= ".";
									else $ponto= ",&nbsp;";
								?>
									<? /*<li><?=$valor . $ponto;?>&nbsp;</li>*/ ?>
									<li><a href="<?=$r;?>artists/all/1/<?=retira_acentos(str_replace(" ", "_", $valor));?>/"><?=$valor;?></a><?= $ponto; ?></li>
								<?
									$i++;
								}
							}
						}
				        ?>
				    </ul>
			    </div>
			    
			    </div>
			    <br />
			</div>
			
			<div class="div-more-nav div-more-nav-2">
				    
				    
			    <?
				$result_anterior= mysql_query("select * from pessoas, pessoas_tipos, enderecos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.tipo_pessoa = 'r'
												and   pessoas.site = '1'
												and   pessoas.id_pessoa = enderecos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												and   pessoas.apelido_fantasia < '". $rs->apelido_fantasia ."'
												$str
												order by pessoas.apelido_fantasia desc
												limit 1
												");
				$linhas_anterior= mysql_num_rows($result_anterior);


				$result_proximo= mysql_query("select * from pessoas, pessoas_tipos, enderecos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.tipo_pessoa = 'r'
												and   pessoas.site = '1'
												and   pessoas.id_pessoa = enderecos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												and   pessoas.apelido_fantasia > '". $rs->apelido_fantasia ."'
												$str
												order by pessoas.apelido_fantasia asc
												limit 1
												");
				$linhas_proximo= mysql_num_rows($result_proximo);
				
				if ($linhas_anterior==0) {
					$result_anterior= mysql_query("select * from pessoas, pessoas_tipos, enderecos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.tipo_pessoa = 'r'
												and   pessoas.site = '1'
												and   pessoas.id_pessoa = enderecos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												$str
												order by pessoas.apelido_fantasia desc
												limit 1
												");
					$linhas_anterior= mysql_num_rows($result_anterior);
				}
				
				if ($linhas_proximo==0) {
					$result_proximo= mysql_query("select * from pessoas, pessoas_tipos, enderecos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.tipo_pessoa = 'r'
												and   pessoas.site = '1'
												and   pessoas.id_pessoa = enderecos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												$str
												order by pessoas.apelido_fantasia asc
												limit 1
												");
					$linhas_proximo= mysql_num_rows($result_proximo);
				}
				
				$rs_anterior= mysql_fetch_object($result_anterior);
				$rs_proximo= mysql_fetch_object($result_proximo);
				
				if ($linhas_anterior>0) {
				?>
				<div class="parte50 div_more div-more-next">
				    <a id="link_leva_0" class="link_more" href="<?=$r;?>artist/<?= $rs_anterior->url; ?>"><?= $_WORD_PREVIOUS[$l]; ?></a>
				    <br class="clear"/>
				</div>
				<? }
					
				if ($linhas_proximo>0) {
				?>
				<div class="parte50 i1 div_more div-more-next">
				    <a id="link_leva_0" class="link_more" href="<?=$r;?>artist/<?= $rs_proximo->url; ?>"><?= $_WORD_NEXT[$l]; ?></a>
				</div>
				<? } ?>
				
			    <? /*
			    <h3 class="lateral-box"><?= $_WORD_SHARE[$l]; ?></h3>
			    
			    <div id="post-networks">
			        <ul>
			            <li><a class="ico-facebook" href="http://www.facebook.com/sharer.php?u=<?= URL_SITE ?>artist/<?= $url[1]; ?>&amp;t=<?= $rs->apelido_fantasia; ?>" target="_blank">Facebook</a></li>
			            <li><a class="ico-twitter" href="http://twitter.com/?status=<?= URL_SITE ?>artist/<?= $url[1]; ?> @movebusca" target="_blank">Twitter</a></li>
			        </ul>
			    </div>
			    */ ?>
			    
		    </div>
			
			<script type="text/javascript">
				$(document).ready(function() {
					
					/*
					var altura_janela= $(window).height();
					var largura_janela= $(window).width();
					
					//alert(altura_janela);
					
					if ((altura_janela>459) || (largura_janela>altura_janela)) {
						
						
						$('#fullpage').fullpage({
							
							fixedElements: '.out_bar_topo, #footer',
							
							sectionSelector: 'section',
							
							touchSensitivity: 25
							
						});
					}*/
				
				});
			</script>
			
			
			<? } else { ?>
			
			
			
					
			
			<?
			$url_site= 'http://move.art.br/';
			
			$imagem= pega_imagem_site('a', $rs->id_pessoa);
			?>
			
			<h2 class="pagetitle pagetitle-artist posttitle fonte_cor1"><?= $rs->apelido_fantasia; ?></h2>
			<br/>
			
			<div class="work-box work-box-main work-box-main-artist">
					
				<? /*
				<div class="share">
					<div class="share1">
						<iframe src="https://www.facebook.com/plugins/like.php?href=<?= $url_site ?>work/<?= $url[1]; ?>/&amp;send=false&amp;layout=button_count&amp;width=85&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp;font=arial&amp;height=21&amp;appId=84478289311" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:85px; height:21px;" allowTransparency="true"></iframe>
					</div>
					
					<div class="share1">
						<iframe scrolling="no" frameborder="0" allowtransparency="true" src="https://platform.twitter.com/widgets/tweet_button.html#_=1322258300865&amp;count=horizontal&amp;id=twitter_tweet_button_0&amp;lang=en&amp;original_referer=<?= $url_site ?>work/<?= $url[1]; ?>/&amp;text=<?= $rs->projeto; ?>&amp;url=<?= $url_site ?>work/<?= $url[1]; ?>/&amp;via=movebusca" class="twitter-share-button twitter-count-horizontal" style="width: 110px; height: 20px;"></iframe>
					</div>
					
				</div>
				*/ ?>
				
				<? if ($imagem!="") { ?>
			        <img src="<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs->id_pessoa; ?>/<?= $imagem; ?>" border="0" alt=""/>
			        <? if ($legenda!="") { ?>
			            <span class="legenda"><?= $legenda; ?></span>
			        <? } ?>
			    <? } ?>
			    
			    <?
				$result_video= mysql_query("select * from videos
											where id_externo = '". $rs->id_pessoa ."'
											and   tipo_video = 'a'
											and   site = '1'
											order by ordem asc
											");
				$linhas_video= mysql_num_rows($result_video);
				
				if ($linhas_video>0) {
				?>
				<div class="post-images post-videos post-images-artist">
					<?
					$k=1;
					while ($rs_video= mysql_fetch_object($result_video)) {
					?>
					
					<?= faz_embed_video($rs_video->url, $rs_video->largura, $rs_video->altura); ?>
					
					<? $k++; } ?>
				</div>
				<? } ?>
			    
			    <div class="post-images post-images-artist">
					<?
			        $result_enviados= mysql_query("select * from imagens
			                                        where id_externo = '". $rs->id_pessoa ."'
			                                        and   tipo_imagem = 'a'
													and   site = '1'
													and   ( miniatura_destaque is NULL or miniatura_destaque = '0')
			                                        order by ordem asc
			                                        limit 1, 9999
			                                        ") or die(mysql_error());
			        $linhas_enviados= mysql_num_rows($result_enviados);
			        
					$i=1;
			        while ($rs_enviados= mysql_fetch_object($result_enviados)) {
						if ($i==$linhas_enviados) $classe_imagem= " last-one ";
						else $classe_imagem= " ";
						
						if ($l=="pt") $legenda_site= $rs_enviados->legenda;
						else $legenda_site= $rs_enviados->legenda_en;
						
						if ($legenda_site=="") $classe_imagem.=" espacamento";
			        ?>
			            <img class="<?= $classe_imagem; ?>" src="<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs->id_pessoa; ?>/<?= $rs_enviados->nome_arquivo_site; ?>" width="<?= $rs_enviados->largura_site;?>" height="<?= $rs_enviados->altura_site;?>" border="0" alt="" />
			            
			            <? if ($legenda_site!="") { ?>
			                <br />
			                <span class="legenda"><?= $legenda_site; ?></span>
			            <? } ?>
			        
			        <? $i++; } ?>
			    </div>
			    
			    <div class="go-top" style="display:none;">
			    	<a class="branco" href="#page">top</a>
			    </div>
			    
			    
			</div>
			
			<div class="work-box work-box-information work-box-information-artist">
				<div class="xlist-open-thumb xlist-open-thumb-inner">
				    <? if ($rs->texto_site!="") { ?>
				    <?= formata_texto($rs->texto_site); ?>
				    <br />
				    <? } ?>
				    
				    <? if ($cidade_uf!="") { ?>
				    <h3 class="lateral-box sem_margem"><?= $_WORD_LOCAL[$l]; ?></h3>
				    
				    <div><?= $cidade_uf; ?></div>
				    <? } else $classe_tags= "sem_margem"; ?>
				    
				    <h3 class="lateral-box <?= $classe_tags; ?>">Tags</h3>
				    
				    <ul class="lista-tags-lado">
						<?
				        $tags= "";
				        
				        $result_tags= mysql_query("select *, pessoas.tags_site_". $l ." as tags from pessoas, pessoas_tipos
				                                    where pessoas.id_pessoa = pessoas_tipos.id_pessoa
				                                    and   pessoas_tipos.status_pessoa <> '2'
				                                    and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.id_pessoa = '". $rs->id_pessoa ."'
				                                    and   pessoas.site = '1'
				                                    ") or die(mysql_error());
				        $i= 0;
				        while ($rs_tags= mysql_fetch_object($result_tags)) {
				            if ($rs_tags->tags!="") {
								$tags_aqui= explode(",", $rs_tags->tags);
								
								$j=0;
								while (($tags_aqui[$j]!="") && ($tags_aqui[$j]!=" ")) {
									
									$tag[$i]= trim($tags_aqui[$j]);
									
									$i++;
									$j++;
								}
							}
				        }
				        
						if ($i>0) {
							$tag= @array_unique($tag);
							@sort($tag);
							
							$tamanho= (count($tag));
							
							if ($tamanho>0) {
								$i=0;
								foreach ($tag as $chave => $valor){
									$j=$i+1;
									
									if ($j==$tamanho) $ponto= ".";
									else $ponto= ",&nbsp;";
								?>
									<? /*<li><?=$valor . $ponto;?>&nbsp;</li>*/ ?>
									<li><a href="<?=$r;?>artists/all/1/<?=retira_acentos(str_replace(" ", "_", $valor));?>/"><?=$valor;?></a><?= $ponto; ?></li>
								<?
									$i++;
								}
							}
						}
				        ?>
				    </ul>
				    <br class="clear"/>
				</div>
				<div class="div-more-nav div-more-nav-up">
				    
				    
				    <?
					$result_anterior= mysql_query("select * from pessoas, pessoas_tipos, enderecos
													where pessoas.id_pessoa = pessoas_tipos.id_pessoa
													and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.site = '1'
													and   pessoas.id_pessoa = enderecos.id_pessoa
													and   pessoas_tipos.status_pessoa <> '2'
													and   pessoas.apelido_fantasia < '". $rs->apelido_fantasia ."'
													$str
													order by pessoas.apelido_fantasia desc
													limit 1
													");
					$linhas_anterior= mysql_num_rows($result_anterior);
	
	
					$result_proximo= mysql_query("select * from pessoas, pessoas_tipos, enderecos
													where pessoas.id_pessoa = pessoas_tipos.id_pessoa
													and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.site = '1'
													and   pessoas.id_pessoa = enderecos.id_pessoa
													and   pessoas_tipos.status_pessoa <> '2'
													and   pessoas.apelido_fantasia > '". $rs->apelido_fantasia ."'
													$str
													order by pessoas.apelido_fantasia asc
													limit 1
													");
					$linhas_proximo= mysql_num_rows($result_proximo);
					
					if ($linhas_anterior==0) {
						$result_anterior= mysql_query("select * from pessoas, pessoas_tipos, enderecos
													where pessoas.id_pessoa = pessoas_tipos.id_pessoa
													and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.site = '1'
													and   pessoas.id_pessoa = enderecos.id_pessoa
													and   pessoas_tipos.status_pessoa <> '2'
													$str
													order by pessoas.apelido_fantasia desc
													limit 1
													");
						$linhas_anterior= mysql_num_rows($result_anterior);
					}
					
					if ($linhas_proximo==0) {
						$result_proximo= mysql_query("select * from pessoas, pessoas_tipos, enderecos
													where pessoas.id_pessoa = pessoas_tipos.id_pessoa
													and   pessoas_tipos.tipo_pessoa = 'r'
													and   pessoas.site = '1'
													and   pessoas.id_pessoa = enderecos.id_pessoa
													and   pessoas_tipos.status_pessoa <> '2'
													$str
													order by pessoas.apelido_fantasia asc
													limit 1
													");
						$linhas_proximo= mysql_num_rows($result_proximo);
					}
					
					$rs_anterior= mysql_fetch_object($result_anterior);
					$rs_proximo= mysql_fetch_object($result_proximo);
					
					if ($linhas_anterior>0) {
					?>
					<div class="parte50 div_more div-more-next">
					    <a id="link_leva_0" class="link_more" href="<?=$r;?>artist/<?= $rs_anterior->url; ?>"><?= $_WORD_PREVIOUS[$l]; ?></a>
					    <br class="clear"/>
					</div>
					<? }
						
					if ($linhas_proximo>0) {
					?>
					<div class="parte50 i1 div_more div-more-next">
					    <a id="link_leva_0" class="link_more" href="<?=$r;?>artist/<?= $rs_proximo->url; ?>"><?= $_WORD_NEXT[$l]; ?></a>
					</div>
					<? } ?>
					
				    <? /*
				    <h3 class="lateral-box"><?= $_WORD_SHARE[$l]; ?></h3>
				    
				    <div id="post-networks">
				        <ul>
				            <li><a class="ico-facebook" href="http://www.facebook.com/sharer.php?u=<?= URL_SITE ?>artist/<?= $url[1]; ?>&amp;t=<?= $rs->apelido_fantasia; ?>" target="_blank">Facebook</a></li>
				            <li><a class="ico-twitter" href="http://twitter.com/?status=<?= URL_SITE ?>artist/<?= $url[1]; ?> @movebusca" target="_blank">Twitter</a></li>
				        </ul>
				    </div>
				    */ ?>
				    
			    </div>
			</div>
			
			
			<script>
					var corpo= $("body").hasClass("inner");
					if (corpo) {
						
						var largura_inner= $(".work-box-information").width();
						var offset_esq = $(".work-box-information").offset().left;
						
						$(".work-box-information").width(largura_inner-3);
						
						$(".work-box-information").css("left", offset_esq+"px");
						
					}
					
					</script>
					    
		    
		    
				<div class="div-more-nav div-more-nav-down">
					<?
					if ($linhas_anterior>0) {
					?>
					<div class="parte50 div_more div-more-next">
					    <a id="link_leva_0" class="link_more" href="<?=$r;?>artist/<?= $rs_anterior->url; ?>"><?= $_WORD_PREVIOUS[$l]; ?></a>
					    <br class="clear"/>
					</div>
					<? }
					
					if ($linhas_proximo>0) {
					?>
					<div class="parte50 i1 div_more div-more-next">
					    <a id="link_leva_0" class="link_more" href="<?=$r;?>artist/<?= $rs_proximo->url; ?>"><?= $_WORD_NEXT[$l]; ?></a>
					    <br class="clear"/>
					</div>
					<? } ?>
				</div>
				
		    
			
			
			<? } //fim device ?>
			
			
			
			<? if ($device=="smartphone") { ?>
			</section>
				
			</div>
			<? } ?>
		<? } ?>
    </div>
</div>
