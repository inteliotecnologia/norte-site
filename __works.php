<?
if ($url[1]=="selected") {
	$str= " and   selecionado = '1' ";
	$titulo= $_MENU_SELECTED[$l];
	
	$ordem= "ordem asc";
	$tipo_projeto= "selecionado";
	?>
	<script>
		mixpanel.track("Acessou Projetos", {
			"Língua": "<?=$_SESSION["l"];?>",
			"Área": "Selecionados",
			"Modo de visualização": "<?=$url[2];?>"
		});
	</script>
	<?
}
elseif ($url[1]=="archive") {
	$str= " and   selecionado <> '1' ";
	$titulo= $_MENU_ARCHIVE[$l];
	
	if ($url[1]=="") $url[1]="archive";
	
	$ordem= "ordem asc";
	$tipo_projeto= "";
	
	?>
	<script>
		mixpanel.track("Acessou Projetos", {
			"Língua": "<?=$_SESSION["l"];?>",
			"Área": "Arquivo",
			"Modo de visualização": "<?=$url[2];?>"
		});
	</script>
	<?
}
else {
	$str= "";
	$titulo= $_MENU_ARCHIVE[$l];
	$ordem= "ordem asc";
	$tipo_projeto= "";
	
	?>
	<script>
		mixpanel.track("Acessou Projetos", {
			"Língua": "<?=$_SESSION["l"];?>",
			"Área": "Todos",
			"Modo de visualização": "<?=$url[2];?>"
		});
	</script>
	<?
}

if ($url[2]=="") $url[2]=1;


?>

<div id="page" class="works">
    <div id="content">
	    
		
		
		<? if ($device=="smartphone") { ?>
		
		
		<script type="text/javascript" src="<?=$r;?>js/jquery.scrollify.min.js"></script>
    
	    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/jquery.slick/1.5.7/slick.css"/>
	    
	    <script type="text/javascript" src="//cdn.jsdelivr.net/jquery.slick/1.5.8/slick.min.js"></script>
		
		
		
		
		<div class="indicacao cor1_fundo">
			<?=$titulo;?>
		</div>
		
		<div class="home_slider2">

		<?
		$miniatura_id=6;
		$result_destaque_projetos= mysql_query("select *, projeto_". $l ." as projeto, texto_site_". $l ." as texto_site from projetos
												where site = '1'
												". $str ."
												and   status_projeto <> '0'
												and   selecionado <> '1'
												order by ordem asc
												");
		$linhas_destaque_projetos= mysql_num_rows($result_destaque_projetos);
		
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
								<span class="h4_tit"><?= pega_pessoa($rs_destaque->id_agencia); ?></span>
								<span class="home_sep cor1_fonte">|</span>
								<span class="h3_tit"><?= string_maior_que($rs_destaque->projeto, 27); ?></span>
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
		
		<h2 class="pagetitle"><?= $titulo; ?></h2>
		
		<div class="view_options">
			<div class="view_options_label">
		    	<?= $_VIEW_OPTIONS[$l]; ?>
		    </div>
		    
		    <ul>
		    	<li class="view_options_1"><a <? if ($url[2]==1) echo "class=\"on\""; ?> href="<?=$r;?>works/<?=$url[1];?>/1/<?=$url[3];?>">1</a></li>
		        <li class="view_options_2"><a <? if ($url[2]==2) echo "class=\"on\""; ?> href="<?=$r;?>works/<?=$url[1];?>/2/<?=$url[3];?>">2</a></li>
		        <? /*<li class="view_options_3"><a <? if ($url[2]==3) echo "class=\"on\""; ?> href="<?=$r;?>works/<?=$url[1];?>/3/<?=$url[3];?>">3</a></li>*/ ?>
		    </ul>
		</div>
		
		<div class="view_tags">
			<a class="link_tags closed" title="closed" href="javascript:void(0);"><?= $_SELECT_BY_TAGS[$l]; ?></a>
		    
		    <div class="tags_list" style="display:none;">
		    	<ul>
		        	<?
					$tags= "";
					
					$result_tags= mysql_query("select *, tags_site_". $l ." as tags from projetos
												where status_projeto <> '0'
												and   site = '1'
												/* ". $str ." */
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
							<li><a href="<?=$r;?>works//<?= $url[2]; ?>/<?=retira_acentos(str_replace(" ", "_", $valor));?>/"><?=$valor;?></a></li>
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
			$str.= "and   tags_site_". $l ." like '%". str_replace("_", " ", $url[3]) ."%' ";
			
			$subtitulo= $url[3];
		}
		
		if ($subtitulo!="") {
		?>
		<h3 class="subtitle"><?= str_replace("_", " ", gambiarra_acentos($subtitulo)); ?></h3>
		<?
		}
		
		$result= mysql_query("select *, projeto_". $l ." as projeto, texto_site_". $l ." as texto_site from projetos
								where site = '1'
								". $str ."
								and   status_projeto <> '0'
								order by $ordem
								limit 0, ". $total_por_pagina ."
								");
								
		$linhas= mysql_num_rows($result);
		
		$result_teste= mysql_query("select * from projetos
									where site = '1'
									". $str ."
									and   status_projeto <> '0'
									order by $ordem
									limit ". $total_por_pagina .", ". $total_por_pagina ."
									");
		$linhas_teste= mysql_num_rows($result_teste);
		
		/*if ($url[2]==3) {
		?>
		
		<div class="list-lines list-lines-th">
		    <span class="name">
		        <?= $_WORD_PROJECT[$l]; ?>
		    </span>
		    <span class="other">
		        <?= $_WORD_AGENCY[$l]; ?>
		    </span>
		</div>
		
		<?
		}*/
		
		$i=1;
		while ($rs= mysql_fetch_object($result)) {
			
			$imagem_miniatura= pega_imagem_miniatura_site('p', $rs->id_projeto, $url[2]);
				
			if ($imagem_miniatura!="") $imagem_definitiva= $imagem_miniatura;
			else {
				$imagem= pega_imagem('p', $rs->id_projeto);
				$imagem_definitiva= $imagem;
			}
			
			$j=$i-1;
			
			if (($i%4)==0) $classe= "nope2";
			else $classe= "";
			
			switch ($url[2]) {
				case 1:
		?>            
		<div class="list-thumb">
		    <div class="post <?=$classe;?>">
		        <a href="<?=$r;?>work/<?= $rs->url; ?>/" title="<?= $rs->projeto; ?>">
		            <? if ($imagem_definitiva!="") { ?>
		            
		            <?php
			        if ($rs->selo_cor!="") {
						$svg= pega_svg("Selo_". $l, $rs->selo_cor);
					?>
		            
		            <div class="selo">
			            <?= $svg; ?>
		            </div>
		            <? } ?>
		            
		            <img width="300" height="160" src="<?= BUCKET . BUCKET_SITE; ?>projeto_<?= $rs->id_projeto; ?>/<?= $imagem_definitiva; ?>" alt=""/>
		            <? } ?>
		            
		            <span class="h3"><?= $rs->projeto; ?></span>
		
		            <span class="h4"><?= pega_pessoa($rs->id_agencia); ?></span>
		        </a>
		    </div>         
		</div>
		<?
			break;
			
			case 2:
			
			$ultimo_id= "linha_". $rs->id_projeto;
		?>
		<div id="<?= $ultimo_id;?>" class="list-open <? if ($linhas==$i) echo " sem-bg" ?>">
			<a href="<?=$r;?>work/<?= $rs->url; ?>/" title="<?= $rs->projeto; ?>">
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
			            
		                <img width="620" height="330" src="<?= BUCKET . BUCKET_SITE; ?>projeto_<?= $rs->id_projeto; ?>/<?= $imagem_definitiva; ?>" alt=""/>
		            <? } ?>
		    	</span>
		        <span class="list-open-infos">
		            <span class="h3"><?= $rs->projeto; ?></span>
		    
		            <span class="h4"><?= pega_pessoa($rs->id_agencia); ?></span>
		            
		            <span class="p"><?= string_maior_que(strip_tags($rs->texto_site), 230); ?></span>
		        </span>
		    </a>
		</div>
		<?
			break;
		
			case 3:
		?>
		<div class="list-lines <? if (($i%2)==0) echo " sem" ?>">
		    <a href="<?=$r;?>work/<?= $rs->url; ?>/" title="<?= $rs->projeto; ?>">
		        <span class="name">
		            <?= string_maior_que($rs->projeto, 24); ?>
		        </span>
		        <span class="other">
		            <?= string_maior_que(pega_pessoa($rs->id_agencia), 20); ?>
		        </span>
		    </a>
		</div>
		<?
			break;
		}
		?>
		<? $i++; } ?>
		
		<? if (($url[1]=="selected") && ($total_por_pagina>=16)) { ?>
		<div class="div_more">
		    <a class="link_more link_more_ucfirst" href="<?=$r;?>works/archive"><?= $_MENU_ARCHIVE[$l]; ?> &raquo;</a>
		</div>
		<?
		}
		elseif ($linhas_teste>0) {
			/*
		?>
		
		<div id="leva_<?= $total_por_pagina; ?>">
			<div class="div_more">
		        <a id="link_leva_<?= $total_por_pagina; ?>" class="link_more" href="javascript:void(0);" onclick="carregaDinamico(this, '<?=$r;?>', 'works', '<?=$url[2];?>', '<?= $total_por_pagina; ?>', '<?= $total_por_pagina; ?>', '<?= $url[3]; ?>', '', '<?= $tipo_projeto; ?>', '<?=$ultimo_id;?>');"><?= $_MORE[$l]; ?></a>
		    </div>
		</div>
		
		<? */ } ?>
		
		<? } //fim device ?>
    </div>
</div>
