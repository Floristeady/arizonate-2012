<form action="<?=url_for("main","submit_compra")?>" method="POST">


<script>
	i = 0;
	function addmix() {
		i++;
	$("#Mixs").append(" \
    <p id='mix_" + i + "'> \
    	<strong>Mix</strong>\
      <select name='mixes[" + i + "][1]'>\
      	<? foreach (get_opciones() as $key => $opcion) { ?>
      	<option value='<?=$key?>'><?=$opcion?></option>\
      	<? } ?>
      </select>\
       +\
      <select name='mixes[" + i + "][2]'>\
      	<? foreach (get_opciones() as $key => $opcion) { ?>
      	<option value='<?=$key?>'><?=$opcion?></option>\
      	<? } ?>
      </select>\
      \
      <a  onclick=\"$('#mix_" + i + "').remove()\">x</a>\
    </p>\
	");
}
</script>

<div id="detalle_3" class="wrapper-a">
	
    	
        <h1>Comprar ><span> Orden de Pedido</span></h1>
        
        <div class="top">
        	<div class="col_IZ">
        		<p>&nbsp;</p>
        		<p>Aquí encontrarás nuestros packs de productos AriZona. </p>
        		<p>Todos los packs se venden en <span class="destacado">bandejas de 12 unidades</span> y vienen configurados en paquetes de un sabor o mix de 2 sabores. </p>
        		<h5 class="mar-top-10">Unidad mínima de venta:</h5>
        		<h5>Bandeja de 12 unidades</h5>
	        
	        </div>
	        
	        <div class="col_DE">
	        
		        <div class="modulo_precio">
		        	<h5>Listado de valores:</h5>
		            <br/>
		            <ul class="list-price">
			            <li>Bandeja Té verde y Té diet (botellas 473ml) <span>$15.000</span> </li>
			            <li>Bandeja Té negro y Té negro diet (lata 680ml) <span>$12.000</span> </li>
			            <li>Bandeja RX Energy (lata 680ml) <span>$16.000</span> </li>
			            <li>Bandeja Néctar (lata 680ml)   <span>$12.000</span> </li>
			            <li>Bandeja Sparkling Arizona (lata 680ml)   <span>$12.000</span> </li>
		            </ul>		            
		      </div>
		   </div>
	      
	  </div><!--top-->
	


  <div class="bottom">
	  		
        
        <div class="title">
        	<h3>Selecciona los productos para tu compra</h3>
        </div>
        
	  	<!--modulos-->
	  	<div class="modulos">

	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Verde con Ginseng y Miel. </h5>
				<h5 class="mar-bottom-28">LINEA TÉ VERDE</h5>
	    		<img src="/img/products/botella_01_small.png" />
	        	<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$15.000</p>
	        	<p>Botella 473 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[1]", range(0,18), "", $_POST["productos"][1]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Verde con Ginseng y jugo de Granada.</h5>
				<h5 class="mar-bottom-10">LINEA TÉ VERDE</h5>
	    		<img src="/img/products/botella_03_small.png" />
	        	<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$15.000</p>
	        	<p>Botella 473 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[3]", range(0,18), "", $_POST["productos"][3]);?>
	
	    	</div>
	        <!--/modulo_producto-->
            
             <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Blanco con Ginseng y jugo de Arándano. </h5>
				<h5 class="mar-bottom-10">LINEA TÉ VERDE</h5>
	    		<img src="/img/products/botella_02_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$15.000</p>
	        	<p>Botella 473 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[2]", range(0,18), "", $_POST["productos"][2]);?>
		    </div>
	        <!--/modulo_producto-->
	        
	        
	         <!--modulo_producto-->
			<div class="modulo_producto">	
	        	<h5>Té Verde DIET con Ginseng.</h5>
				<h5 class="mar-bottom-28">LINEA TÉ DIET</h5>
	    		<img src="/img/products/botella_04_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$15.000</p>
	        	<p>Botella 473 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[4]", range(0,18), "", $_POST["productos"][4]);?>
	
	    	</div>
	        <!--/modulo_producto-->

	        
	    </div>
	    <!--/modulos-->
	    
        
	    <!--modulos-->
	  	<div class="modulos">
	  	
	       	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Negro DIET sabor Frambuesa</h5>
				<h5 class="mar-bottom-10">LINEA TÉ DIET</h5>
	    		<img src="/img/products/botella_06_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$15.000</p>
	        	<p>Botella 473 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[5]", range(0,18), "", $_POST["productos"][5]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	        
	        	         <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Negro DIET sabor Limón.</h5>
				<h5 class="mar-bottom-10">LINEA TÉ DIET</h5>
	    		<img src="/img/products/lata_10_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[15]", range(0,18), "", $_POST["productos"][15]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Negro Helado con sabor de Frambuesa.</h5>
				<h5 class="mar-bottom-10">LINEA TÉ NEGRO</h5>
	    		<img src="/img/products/lata_01_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[7]", range(0,18), "", $_POST["productos"][7]);?>
	    	</div>
	        <!--/modulo_producto-->
        
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Negro Helado con sabor de Limón.</h5>
				<h5 class="mar-bottom-10">LINEA TÉ NEGRO</h5>
	    		<img src="/img/products/lata_02_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[8]", range(0,18), "", $_POST["productos"][8]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	      	 
	    </div>
	    <!--/modulos-->
	    
	    
	    <!--modulos-->
	  	<div class="modulos">
	  		
	  		  <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Té Negro Helado con sabor de Mango.</h5>
				<h5 class="mar-bottom-10">LINEA TÉ NEGRO</h5>
	    		<img src="/img/products/lata_04_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[6]", range(0,18), "", $_POST["productos"][8]);?>
	    	</div>
	        <!--/modulo_producto-->


	  	
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Néctar sabor Mango</h5>
				<h5 class="mar-bottom-10">LINEA NECTAR</h5>
	    		<img src="/img/products/lata_05_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[10]", range(0,18), "", $_POST["productos"][10]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Néctar sabor Sandia</h5>
				<h5 class="mar-bottom-10">LINEA NECTAR</h5>
	    		<img src="/img/products/lata_06_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[11]", range(0,18), "", $_POST["productos"][11]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Néctar sabor Uva</h5>
				<h5 class="mar-bottom-10">LINEA NECTAR</h5>
	    		<img src="/img/products/lata_07_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[12]", range(0,18), "", $_POST["productos"][12]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	       	 
	    </div>
	    <!--/modulos-->
	    
	    
	    <!--modulos-->
	  	<div class="modulos">
	  	
	  		 <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Néctar sabor Naranja</h5>
				<h5 class="mar-bottom-10">LINEA NECTAR</h5>
	    		<img src="/img/products/lata_08_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[13]", range(0,18), "", $_POST["productos"][13]);?>
	    	</div>
	        <!--/modulo_producto-->


	  	
	  		 <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Néctar sabor Limonada Original</h5>
				<h5 class="mar-bottom-10">LINEA NECTAR</h5>
	    		<img src="/img/products/lata_09_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[14]", range(0,18), "", $_POST["productos"][14]);?>
	    	</div>
	        <!--/modulo_producto-->
	        

	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Bebida Energética RX Herbal Tonic. </h5>
				<h5 class="mar-bottom-10">BEBIDA ENERGÉTICA</h5>
	    		<img src="/img/products/lata_03_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$16.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[9]", range(0,18), "", $_POST["productos"][9]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Sparkling Arizona sabor Cereza Lima</h5>
				<h5 class="mar-bottom-10">RICKEY CHERRY LIME</h5>
	    		<img src="/img/products/lata_cherrylime_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[16]", range(0,18), "", $_POST["productos"][16]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	  	</div>
	  	<div class="modulos">
	        
	         <!--modulo_producto-->
			<div class="modulo_producto">
				<h5>Sparkling Arizona sabor Mango Lima</h5>
				<h5 class="mar-bottom-10">RICKEY MANGO LIME</h5>
	    		<img src="/img/products/lata_mangolime_small.png" />
	    		<p class="mar-top-10">Pack 12 unidades.</p>
	        	<p>$12.000</p>
	        	<p>Lata 680 ml.</p>
	        	<small>Cantidad packs</small>
	        	<?=FormHelper::select("productos[17]", range(0,18), "", $_POST["productos"][17]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	  	  </div>

           <!--modulos-->
           <div class="modulo_mix" style="margin-top:20px;">
           	
           		<div class="title">
           			<h3><span>Mix de Sabores</span> / COMBINA DOS SABORES A TU ELECCIÓN</h3>
           		</div>
           		
           		<div class="text">
           			<p>Arma tu <strong>pack de 12 unidades</strong> con los dos sabores que prefieras. Elige <strong>6 unidades</strong> de cada sabor. </p>
           		</div>
            
            <div id="Mixs" class="cerrar">
		    </div>

        	<input class="agregar boton F-left"  name="Agregar" type="button" onclick="addmix()" value="AGREGAR MIX" />
       
        	</div>

	    </div>
	    <!--/modulos-->
        
	    <div class="title_2">
           	<h3  style="float:left;">Datos del pedido |</h3>
           	<p style="float:left; padding-top:2px; padding-left:5px;">Completa con tus datos para realizar el pedido</p>
        </div>

      
    	<div class="formulario">
    	
    	<? if (count($errors) > 0) { ?>
        <div class="errors">
        <ul>
	  			<? foreach ($errors as $error) {?>
	  			<li><?=$error?></li>
	  			<? } ?>
	  	</ul>
        </div>
        <? } ?>
        
             <div>
           		<label>Nombre</label>
           		<?=FormHelper::text("nombre", $_POST["nombre"], array("class" => "box-300"));?>
        	</div>
        
       	 	<div>
            	<label>Teléfono</label>
            	<?=FormHelper::text("telefono", $_POST["telefono"], array("class" => "box-300"));?>
         	</div>
            
          <div>
            	<label>Dirección</label>
            	<?=FormHelper::text("direccion", $_POST["direccion"], array("class" => "box-300"));?>
        	</div>
            
          <div>
            	<label>Comuna</label>
            	<?=FormHelper::text("comuna", $_POST["comuna"], array("class" => "box-300"));?>
        	</div>
            
          <div>
            	<label>Ciudad</label>
            	<?=FormHelper::text("ciudad", $_POST["ciudad"], array("class" => "box-300"));?>
        	</div>
        
        	<div>
            	<label>Email</label>
            	<?=FormHelper::text("email", $_POST["email"], array("class" => "box-300"));?>
        	</div>
        
            
            <div>
               <input class="enviar boton" type="submit" value="ENVIAR">
               </div>
				
                
            </div>
            
            
          
  <div class="text_info">
  
  		<p><strong>Condiciones:</strong></p>
    	<p><span>Unidad mínima de venta:</span></p>
    	<p><span class="underline">Bandeja de 12 unidades.</span></p>
        <p>&nbsp;</p>
    	<p><strong>Contacto:</strong></p>
    	<p>Teléfonos: +56 2 222 437 23 / +56 2 222 966 53 </p>
    	 <p>&nbsp;</p>    	
    	<h4>Una bebida saludable, refrescante y de gran sabor.</h4>
    	<h2>100% Natural </h2>
        

</div>
    <!--/col_DE-->
    
    </div><!--/bottom-->



</div>
<!--/index-->

</form>
