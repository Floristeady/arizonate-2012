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

<div id="detalle_3">
	
    <!--col_IZ-->
	<div class="col_IZ">
    	
       <div class="titulo_pedido"></div>
        <p>Aquí encontrarás nuestros packs de productos AriZona. </p>
      	<p>&nbsp;</p>
        <p>Todos los packs se venden en <span class="destacado">bandejas de 12 unidades</span> y vienen configurados en paquetes de un sabor o mix de 2 sabores. </p>
        
        <div class="modulo_precio">
        	<h6><strong>Unidad mínima de venta:</strong> </h6>
        	<p>Bandeja de 12 unidades. </p>
            <br />
            
            <h6>Listado de Valores:</h6>
             <br />
            
            <h5><strong>Bandeja Línea Clásica y DIET</strong></h5>
            <div class="precio">
            <p> $17.000 c/IVA</p>
            </div>
            <br />

            <h5><strong>Bandeja Té Negro Premium</strong></h5>
            <div class="precio">
            <p> $12.000 c/IVA</p>
            </div>
            <br />
            
            <h5><strong>Bandeja Bebida RX Energy</strong></h5>
            <div class="precio">
            <p> $17.000 c/IVA</p>
            </div>
            <br />
            
      </div>
</div>
<!--/col_IZ-->

    
    
    
    
    
    
    
    
<!--col_DE-->
  <div class="col_DE">
	  		<? if (count($errors) > 0) { ?>
        <div class="errors">
        <ul>
	  			<? foreach ($errors as $error) {?>
	  			<li><?=$error?></li>
	  			<? } ?>
	  	</ul>
        </div>
        <? } ?>
        
	  	<!--modulos-->
	  	<div class="modulos">
	    	<div class="title titleimg01"></div>
           
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/botella_01_small.png" />
	        	<p>Té Verde con <br />
Ginseng y Miel. </p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[1]", range(0,9), "", $_POST["productos"][1]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/botella_03_small.png" />
	        	<p>Té Verde con Ginseng<br />
 y jugo de Granada.</p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[3]", range(0,9), "", $_POST["productos"][3]);?>
	
	    	</div>
	        <!--/modulo_producto-->
            
             <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/botella_02_small.png" />
	        	<p>Té Blanco con Ginseng<br />
 y jugo de Arándano. </p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[2]", range(0,9), "", $_POST["productos"][2]);?>
		    </div>
	        <!--/modulo_producto-->
	        
	    </div>
	    <!--/modulos-->
	    
        
	    <!--modulos-->
	  	<div class="modulos">
	    	<div class="title titleimg02"></div>
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/botella_04_small.png" />

	        	<p>Té Verde DIET<br />
 con Ginseng.</p>

	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[4]", range(0,9), "", $_POST["productos"][4]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/botella_05_small.png" />
	        	<p>Té Verde DIET con Ar&aacute;ndano Blanco<br />
 y Manzana.</p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[5]", range(0,9), "", $_POST["productos"][5]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	        
	           <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/botella_06_small.png" />
	        	<p> Té Verde DIET<br />
 con jugo de Arándano.</p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[6]", range(0,9), "", $_POST["productos"][6]);?>
	
	    	</div>
	        <!--/modulo_producto-->
	 
	    </div>
	    <!--/modulos-->
	    
        
        
        
	    <!--modulos-->
	  	<div class="modulos">
	    	<div class="title titleimg03"></div>

	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/lata_01_small.png" />
	        	<p>Té Negro Helado con<br />
 sabor de Frambuesa.</p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[7]", range(0,9), "", $_POST["productos"][7]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/lata_02_small.png" />
	        	<p>Té Negro Helado con<br />
 sabor de Limón.</p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[8]", range(0,9), "", $_POST["productos"][8]);?>
	    	</div>
	        <!--/modulo_producto-->
	        
	    </div>
	    <!--/modulos-->
	    
	    <!--modulos-->
	  	<div class="modulos">
	    	<div class="title titleimg04"></div>

	        
	        <!--modulo_producto-->
			<div class="modulo_producto">
	    		<img src="/img/test/lata_03_small.png" />
	        	<p>Bebida Energética RX Herbal Tonic. </p>
	        	<p><strong>Pack 12 unidades.</strong></p>
	        	<h6>Cantidad packs</h6>
	        	<?=FormHelper::select("productos[9]", range(0,9), "", $_POST["productos"][9]);?>
	    	</div>
	        <!--/modulo_producto-->
            
       
	 
	    </div>
	    <!--/modulos-->
        
        
           <!--modulos-->
	  	<div class="modulos">
	    	<div class="title titleimg05"></div>
            <div class="destacado">
     		<p>Arma tu <strong>pack de 12 unidades</strong> con los dos sabores que prefieras. Elige <strong>6 unidades</strong> de cada sabor. </p>
</div>
            
            <div id="Mixs" class="cerrar">
		</div>

        <input class="agregar F-left"  name="Agregar" type="button" onclick="addmix()" value="AGREGAR MIX" />
        
       
       </div>
       
       
  	
  </div>
    <!--/col_DE-->
   
   <div class="bottom">
  
      <div class="title titleimg06"></div>
      
    	<div class="formulario">
        
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
               <input class="boton" type="submit" value="ENVIAR">
               </div>
				
                
            </div>
            
            <!--col_DE-->
  <div class="col_DE">
  		<p><strong>Condiciones:</strong></p>
    	<p>Unidad mínima de venta:</p>
    	<p>Bandeja de 12 unidades.</p>
        <p>&nbsp;</p>
    	<p><strong>Contacto:</strong></p>
    	<p>Teléfono: (+56 2) 224 37 23</p>    	
    	<p>Av. Apoquindo 7850, Torre 3, Local 7 </p>
    	<p>Las Condes. Santiago, Chile.</p>
        
  <div class="bajada"></div>

</div>
    <!--/col_DE-->
    
    </div>



</div>
<!--/index-->

</form>
