<?php
	function get_header()
	{
?>
	<div class="encabezado">
		<!--<div class="login_quick">
			<form>
				<label for="male">usuario</label>
				<input type="text" name="login" id="login" />
				<label for="male">contrase&ntilde;a</label>
				<input type="password" name="pass" id="pass" />
				<input type="submit" name="enviar" value="enviar" />
			</form>
		</div>
		-->
		<a href = "/2DAI/"><img class="logo" src="smalldblogo.png" alt="dbdailogo"   /></a>
	</div>
	
<?
	}

function fecha($fecha)
{
    if ($fecha)
   {
      $f=explode("-",$fecha);
      $nummes=(int)$f[1];
      $mes1="0-Enero-Febrero-Marzo-Abril-Mayo-Junio-Julio-Agosto-Septiembre-Octubre-Noviembre-Diciembre";
      $mes1=explode("-",$mes1);
      $desfecha="$f[2] de $mes1[$nummes] de $f[0]";
      return $desfecha;
   } 
}
	
function get_footer()
	{
?>
	<div class="pie">
		Base de datos la mar de friki. Gestionada por Segundo de DAI.
	</div>
<?
	}

function get_stats($str,$agi,$int)
	{
?>
	<div class='stats'>
		<div class='titulostatlista' >Fuerza</div>
			<div class='barritastatlista' >
				<?php
					$fuerza=$str*10;
					if ($str==1){
						echo "<img src='pics/statsico/F1.png'>";
					}
					else{
						echo"<img src='pics/statsico/FI.png'>";
						for($i=2;$i<$str;$i++){
							echo"<img src='pics/statsico/FM.png'>";
						}
						echo"<img src='pics/statsico/FD.png'>";
					}
				?>
			</div>
			<div class='titulostatlista' >Agilidad</div>
			<div class='barritastatlista' >
				<?php
					$fuerza=$agi*10;
					if ($agi==1){
						echo "<img src='pics/statsico/A1.png'>";
					}
					else{
						echo"<img src='pics/statsico/AI.png'>";
						for($i=2;$i<$agi;$i++){
							echo"<img src='pics/statsico/AM.png'>";
						}
						echo"<img src='pics/statsico/AD.png'>";
					}
				?>
			</div>
			<div class='titulostatlista' >Inteligencia</div>
			<div class='barritastatlista' >
				<?php
					$fuerza=$int*10;
					if ($int==1){
						echo "<img src='pics/statsico/I1.png'>";
					}
					else{
						echo"<img src='pics/statsico/II.png'>";
						for($i=2;$i<$int;$i++){
							echo"<img src='pics/statsico/IM.png'>";
						}
						echo"<img src='pics/statsico/ID.png'>";
					}
				?>
			</div>
	</div>							
<?php
	}
	function get_stats2($str,$agi,$int)
	{
?>
		<div class='stats2'>
			<div class='titulostatlista' ><img src='pics/heart.png'></div>
			<div class='barritastatlista2' >
				<?php echo ($str*12+$int*2+$agi*6); ?>
			</div>
			<div class='titulostatlista' ><img src='pics/armor2.png'></div>
			<div class='barritastatlista2' >
				<?php echo ($str*2+$int*6+$agi*12); ?> 
			</div>
			<div class='titulostatlista' ><img src='pics/mana.png'></div>
			<div class='barritastatlista2' >
				<?php echo ($str*6+$int*12+$agi*2); ?>
			</div>
		</div>					
<?php
	}

function mostrar_stat($tipo, $valor)
{
	$color = strtoupper(substr ($tipo, 0, 1));
	if (($color != 'F') and ($color != 'I') and ($color != 'A')) {
		$color = 'F';
		echo $color;
	}
	if ($valor==1){
		echo "<img src='pics/statsico/".$color."1.png'>";
	}
	else {
		echo"<img src='pics/statsico/".$color."I.png'>";
		for($i=0;$i<$valor-2;$i++){
			echo"<img src='pics/statsico/".$color."M.png'>";
		}
		echo"<img src='pics/statsico/".$color."D.png'>";
	}
}

function mostrar_nav($pag, $vueltas, $buscar)
{
echo "<div class='paginaslista'>";
	
	$i=$pag;
	
	?>
		<A style="color:#fff;font-size:small;" HREF="<?php echo $_server['php_self']?>?pag=1&buscar=<?php echo $buscar ?>"><img src="pics/BPrimero.png" border="0"></A>
		<?php
		if (($pag-1)<1){
			$i=1;
		}else{																
			$i = $pag - 1; 
		}			
		
		$anterior = $i;
		$i = $pag;
		if (($pag+1)>$vueltas){
			$i=floor($vueltas);
			
		}else{																
			$i = $pag + 1; 	
		
		}
		$posterior=$i;
		?>
		<A style="color:#fff;font-size:small;" HREF="<?php echo $_server['php_self']?>?pag=<?php echo $anterior; ?>&buscar=<?php echo $buscar ?>"> <img src="pics/BAtras.png" border="0"></A>
		<?echo " ".$pag." "?>
		<A style="color:#fff;font-size:small;" HREF="<?php echo $_server['php_self']?>?pag=<?php echo $posterior; ?>&buscar=<?php echo $buscar ?>"><img src="pics/BSiguiente.png" border="0"></A>
		<A style="color:#fff;font-size:small;" HREF="<?php echo $_server['php_self']?>?pag=<?echo floor($vueltas);?>&buscar=<?php echo $buscar ?>"> <img src="pics/BUltimo.png" border="0"></A>
	
	<?	
	
echo "</div>";
}
?>

<?php function tilde($cadena)
{
	$acambiar = array("�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�", "�");
	$cambios = array("&aacute;", "&eacute;", "&iacute;", "&oacute;", "&uacute;", "&Aacute;", "&Eactue;", "&Iactue;", "&Oacute;", "&Uactue;", "&uuml;", "ntilde;", "&Ntilde;"); 
	$salida = str_replace($acambiar, $cambios, $cadena);
	return $salida;
}
?>

<?php function msg($cadena)
{
	echo "<div class=\"general\">
		<div class=\"contenido\">
			<div class=\"detalles\"> 
				<div style='position:relative;margin-top:50px;padding-bottom:50px; padding-top: 50px; text-align:center;'>".tilde($cadena)."</div>
			</div>
		</div>
	</div>";
}
