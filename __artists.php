<?
if ($url[2]=="") $url[1]="all";
if ($url[2]=="") $url[2]=1;
?>

<script>
	mixpanel.track("Acessou Artistas", {
		"L�ngua": "<?=$_SESSION["l"];?>",
		"Modo de visualiza��o": "<?=$url[2];?>"
	});
</script>

<div id="page" class="works">
    <div id="content">
	    
	    
	    <?
		if ($device=="smartphone") {
		    $miniatura_id=6;
	    ?>
		
		
		<script type="text/javascript" src="<?=$r;?>js/jquery.scrollify.min.js"></script>
    
	    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css"/>
	    
	    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js"></script>
		
		
		
		
		<div class="indicacao cor1_fundo">
			<?= $_MENU_ARTISTS[$l]; ?>
		</div>
		
		<div class="home_slider2">

		<?	
		$result_destaque_artistas= mysql_query("select *, pessoas.texto_site_". $l ." as texto_site from pessoas, pessoas_tipos, enderecos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.tipo_pessoa = 'r'
												and   pessoas.site = '1'
												and   pessoas.id_pessoa = enderecos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												$str
												order by pessoas.apelido_fantasia asc
												limit 0, 9999
												");
		$linhas_destaque_artistas= mysql_num_rows($result_destaque_artistas);
		
		//echo "<bR><br><br><br>asdasd<br><br>asdasdasd<br><br><br><br>". $linhas_destaque_artistas;
		
		while ($rs_destaque= mysql_fetch_object($result_destaque_artistas)) {	
		?>
		    <div class="highlight home-block">      
		        <?
				$imagem_miniatura= pega_imagem_miniatura_site('a', $rs_destaque->id_pessoa, $miniatura_id);
				
				if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
				else {
					$imagem= pega_imagem('p', $rs_destaque->id_pessoa);
					$imagem_definitiva= $imagem;
				}
				
				if ($imagem_definitiva!="") {
						
					if ($i==0) {
						$imagem_destaque_grande= BUCKET . BUCKET_SITE ."artista_". $rs_destaque->id_pessoa ."/". $imagem_definitiva;
					}
					
					/*<a href="<?=$r;?>work/<?=$rs_destaque->url?>/"><img width="940" height="380" src="<?= $r; ?>includes/phpthumb/phpThumb.php?src=/p_<?= $rs_destaque->id_artista; ?>/<?= $imagem_definitiva; ?>&amp;w=940&amp;h=380&amp;zc=1" alt="" /></a>*/
				?> 
				<a class="link_bg" href="<?=$r;?>artist/<?=$rs_destaque->url?>/" style="background-image: url('<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs_destaque->id_pessoa; ?>/<?= $imagem_definitiva; ?>');">
					&nbsp;
				</a>
				
				<div class="highlight-text">
					<div class="out">
						<a href="<?=$r;?>work/<?=$rs_destaque->url?>/">
							
							<span class="highlight-text-linha">
							
								<span class="h3_tit"><?= string_maior_que($rs_destaque->apelido_fantasia, 31); ?></span>
							</span>
							
							<span class="highlight-text-arrow">
								&gt;
							</span>
						</a>
					</div>
				</div>    
			<? } ?>
		        
		    </div>
		<? } ?>
		</div>
		
		
		
		<script>
		$(document).ready(function(){
			
			var altura= $(window).height();
			
			//$('.slider1 .highlight').height(altura);
			$('.home_slider2 .highlight').height(altura-56);
			
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
		
		
		
		
		
		
		
		<? } else { ?>
		
		
	    
		<h2 class="pagetitle"><?= $_MENU_ARTISTS[$l]; ?></h2>
		
		<div class="view_options">
			<div class="view_options_label">
		    	<?= $_VIEW_OPTIONS[$l]; ?>
		    </div>
		    
		    <ul>
		    	<li class="view_options_1"><a <? if ($url[2]==1) echo "class=\"on\""; ?> href="<?=$r;?>artists/<?=$url[1];?>/1/<?=$url[3];?>">1</a></li>
		        <li class="view_options_2"><a <? if ($url[2]==2) echo "class=\"on\""; ?> href="<?=$r;?>artists/<?=$url[1];?>/2/<?=$url[3];?>">2</a></li>
		        <? /*<li class="view_options_3"><a <? if ($url[2]==3) echo "class=\"on\""; ?> href="<?=$r;?>artists/<?=$url[1];?>/3/<?=$url[3];?>">3</a></li>*/ ?>
		    </ul>
		</div>
		
		<div class="view_tags">
			<a class="link_tags closed" title="closed" href="javascript:void(0);"><?= $_SELECT_BY_TAGS[$l]; ?></a>
		    
		    <div class="tags_list" style="display:none;">
		    	<ul>
		        	<?
					$tags= "";
					
					$result_tags= mysql_query("select *, pessoas.tags_site_". $l ." as tags from pessoas, pessoas_tipos
												where pessoas.id_pessoa = pessoas_tipos.id_pessoa
												and   pessoas_tipos.status_pessoa <> '2'
												and   pessoas_tipos.tipo_pessoa = 'r'
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
						?>
							<li><a href="<?=$r;?>artists/<?=$url[1];?>/<?= $url[2]; ?>/<?=retira_acentos(str_replace(" ", "_", $valor));?>/"><?=$valor;?></a></li>
						<?
							$i++;
						} }
					}
					?>
		        </ul>
		    </div>
		</div>
		
		<?
		switch($url[2]) {
			case 1: $total_por_pagina= 9999; break;
			case 2: $total_por_pagina= 9999; break;
			case 3: $total_por_pagina= 9999; break;
		}
		
		if ($url[3]!="") {
			$str= "and   pessoas.tags_site_". $l ." like '%". str_replace("_", " ", $url[3]) ."%' ";
			$subtitulo= $url[3];
		}
		
		if ($subtitulo!="") {
		?>
		<h3 class="subtitle"><?= str_replace("_", " ", gambiarra_acentos($subtitulo)); ?></h3>
		<?
		}
		
		$result= mysql_query("select *, pessoas.texto_site_". $l ." as texto_site from pessoas, pessoas_tipos, enderecos
								where pessoas.id_pessoa = pessoas_tipos.id_pessoa
								and   pessoas_tipos.tipo_pessoa = 'r'
								and   pessoas.site = '1'
								and   pessoas.id_pessoa = enderecos.id_pessoa
								and   pessoas_tipos.status_pessoa <> '2'
								$str
								order by pessoas.apelido_fantasia asc
								limit 0, ". $total_por_pagina ."
								");
		$linhas= mysql_num_rows($result);
		
		/*if ($url[2]==3) {
		?>
		
		<div class="list-lines list-lines-th">
		    <span class="name">
		        <?= $_WORD_ARTIST[$l]; ?>
		    </span>
		    <span class="other">
		        Local
		    </span>
		</div>
		
		<?
		}*/
		
		$excluir= "";
		$i=1;
		while ($rs= mysql_fetch_object($result)) {
			$excluir .= $rs->id_pessoa ."-";
			
			$imagem_miniatura= pega_imagem_miniatura_site('a', $rs->id_pessoa, $url[2]);
					
			if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
			else {
				$imagem= pega_imagem('a', $rs->id_pessoa);
				$imagem_definitiva= $imagem;
			}
			
			if ($l=="pt") $cidade_uf= $rs->cidade_uf;
			else $cidade_uf= $rs->cidade_uf_en;
			//else $cidade_uf= pega_cidade($rs->id_cidade);
			
			if (($i%4)==0) $classe= "nope2";
			else $classe= "";
			
			$str.= " and   pessoas.id_pessoa <> '". $rs->id_pessoa ."' ";
			
			$result_teste= mysql_query("select * from pessoas, pessoas_tipos, enderecos
										where pessoas.id_pessoa = pessoas_tipos.id_pessoa
										and   pessoas_tipos.tipo_pessoa = 'r'
										and   pessoas.site = '1'
										and   pessoas.id_pessoa = enderecos.id_pessoa
										and   pessoas_tipos.status_pessoa <> '2'
										$str
										order by RAND() asc
										limit ". $total_por_pagina ."
										");
			$linhas_teste= mysql_num_rows($result_teste);
			
			switch ($url[2]) {
				case 1:
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
		<?
			break;
			
			case 2:
				$ultimo_id= "linha_". $rs->id_pessoa;
		?>
		<div id="<?= $ultimo_id; ?>" class="list-open <? if ($linhas==$i) echo " sem-bg" ?>">
		    <a href="<?=$r;?>artist/<?= $rs->url; ?>/" title="<?= $rs->apelido_fantasia; ?>">
		        <span class="list-open-thumb">    
					<? if ($imagem_definitiva!="") { ?>
		            
		            <?php
			        if ($rs->selo_cor!="") {
						$svg= pega_svg("Selo_". $l, $rs->selo_cor);
					?>
		            
		            <div class="selo">
			            <?= $svg; ?>
		            </div>
		            <? } ?>
		            
		            
		            <img width="620" height="330" src="<?= BUCKET . BUCKET_SITE; ?>artista_<?= $rs->id_pessoa; ?>/<?= $imagem_definitiva; ?>" alt=""/>
		            <? } ?>
		        </span>
		        <span class="list-open-infos">
		            <span class="h3"><?= $rs->apelido_fantasia; ?></span>
		    
		            <span class="h4"><?= $cidade_uf; ?></span>
		            
		            <span class="p"><?= string_maior_que(strip_tags($rs->texto_site), 230); ?></span>
		        </span>
		    </a>
		</div>
		<?
			break;
		
			case 3:
		?>
		<div class="list-lines <? if (($i%2)==0) echo " sem" ?>">
			<a href="<?=$r;?>artist/<?= $rs->url; ?>/" title="<?= $rs->apelido_fantasia; ?>">
		        <span class="name">
		            <?= $rs->apelido_fantasia; ?>
		        </span>
		        <span class="other">
		            <?= $cidade_uf; ?>
		        </span>
		    </a>
		</div>
		<?
			break;
		}
		?>
		<? $i++; } ?>
		
		<?
		if ($linhas_teste>0) { /*
		?>
		<div id="leva_<?= $total_por_pagina; ?>">
			<div class="div_more">
		        <a id="link_leva_<?= $total_por_pagina; ?>" class="link_more" href="javascript:void(0);" onclick="carregaDinamico(this, '<?=$r;?>', 'artists', '<?=$url[2];?>', '<?= $total_por_pagina; ?>', '<?= $total_por_pagina; ?>', '<?= $url[3]; ?>', '<?= $excluir; ?>', '', '<?= $ultimo_id; ?>');"><?= $_MORE[$l]; ?></a>
		    </div>
		</div>
		<? */ } ?>
		
		<? } ?>
		
    </div>
</div>