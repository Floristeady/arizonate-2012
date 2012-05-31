<div id="contacto">
	
    <!--col_IZ-->
	<div class="col_IZ">
    	<div class="titulo_contacto"></div>
        <p>Si quieres saber más sobre los productos AriZona, envíanos tu consulta y te responderemos a la brevedad.</p>
  
		<form action="<?=url_for("main","submit_contacto")?>" method="POST">
  		<? display_errors($vt)?>
        
        

    	<div class="formulario">
        
             <div>
           		<label>Nombre</label>
            	<input class="box-300" name="contacto[nombre]" value="<?=$_POST["contacto"]["nombre"]?>" type="text" />
        	</div>
        
       	 	<div>
            	<label>Teléfono</label>
            	<input class="box-300" name="contacto[telefono]" value="<?=$_POST["contacto"]["telefono"]?>" type="text" />
        	</div>
        
        	<div>
            	<label>Email</label>
            	<input class="box-300" name="contacto[email]" value="<?=$_POST["contacto"]["email"]?>" type="text" />
        	</div>
        
        	<div>
            	<label>Mensaje</label>
            	<textarea class="textarea" name="contacto[mensaje]" cols="" rows=""><?=$_POST["contacto"]["mensaje"]?></textarea>
        	</div>
            
            <div>
               <input class="boton" type="submit" value="ENVIAR">
               </div>
				
                
            </div>
            </form>
            
       
    	
    </div>
    <!--/col_IZ-->
    
<!--col_DE-->
<div class="col_DE">
  		<p><strong>Importa y Distribuye exclusivamente para Chile:</strong></p>
    	<p>Big Chile Ltda.</p>
    	<p>Teléfono: (+56 2) 224 37 23</p>
    	<p>Fax: (+56 2) 224 37 23</p>
     	<p>&nbsp;</p>
    	<p>Av. Apoquindo 7850, Torre 3, Local 7 </p>
    	<p>Las Condes. Santiago, Chile.</p>
                
</div>
<!--/col_DE-->


<div class="back"></div>
    
    
    
  
    


</div>
<!--/index-->