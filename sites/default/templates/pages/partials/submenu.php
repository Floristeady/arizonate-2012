<div class="col_IZ">
	<div class="box_nav_2 nav_te">
		<h4>T� Arizona</h4>
		<ul id="nav_2">
			<li>Te Verde</li>
			<li><a class="<? if (get_current_action() == "teverde_miel") { echo "ON";} ?> linea" href="/main/teverde_miel">T� verde con Ginseng y Miel</a></li>
		
			<li class="mar-top-10">T� Negro</li>
			<li><a class="<? if (get_current_action() == "tehelado_fram") { echo "ON";} ?>" href="/main/tehelado_fram">T� Negro sabor Frambuesa</a></li>
			<li><a class="<? if (get_current_action() == "tehelado_limon") { echo "ON";} ?>" href="/main/tehelado_limon">T� Negro sabor Lim�n</a></li>
			<li><a class="<? if (get_current_action() == "tehelado_mango") { echo "ON";} ?>" href="/main/tehelado_mango">T� Negro sabor Mango</a></li>
			
			
			<li class="mar-top-10">Te Zero Calor�as</li>
			<li><a class="<? if (get_current_action() == "tediet_miel") { echo "ON";} ?> linea" href="/main/tediet_miel">T� verde Zero calor�as con Ginseng </a></li>
			<li><a class="<? if (get_current_action() == "tediet_limon") { echo "ON";} ?> linea" href="/main/tediet_limon">T� negro Zero calor�as sabor Lim�n</a></li>
		</ul>
	</div>
	
	<div class="box_nav_2 nav_nectar">
		<h4>Jugos</h4>
		<ul id="nav_2">
			<li><a class="<? if (get_current_action() == "mix_zanahoria") { echo "ON";} ?> linea" href="/main/mix_zanahoria">Mix Zanahoria con Frutas</a></li>
			<li><a class="<? if (get_current_action() == "nectar_mango") { echo "ON";} ?> linea" href="/main/nectar_mango">N�ctar sabor Mango</a></li>
			<li><a class="<? if (get_current_action() == "nectar_sandia") { echo "ON";} ?> linea" href="/main/nectar_sandia">N�ctar sabor Sandia</a></li>
			<li><a class="<? if (get_current_action() == "nectar_uva") { echo "ON";} ?> linea" href="/main/nectar_uva">N�ctar sabor Uva</a></li>
			<li><a class="<? if (get_current_action() == "nectar_naranja") { echo "ON";} ?> linea" href="/main/nectar_naranja">N�ctar sabor Naranja</a></li>
			<li><a class="<? if (get_current_action() == "nectar_limonada") { echo "ON";} ?> linea" href="/main/nectar_limonada">N�ctar sabor Limonada Original</a></li>
	
		</ul>
	</div>
	
	<div class="box_nav_2 nav_sparkling">
		<h4>Sparkling Arizona</h4>
		<ul id="nav_2">

			<li><a class="<? if (get_current_action() == "sparkling_cherrylime") { echo "ON";} ?> linea" href="<?=url_for("main", "sparkling_cherrylime")?>">Rickey Cherry Lime</a></li> 
			<li><a class="<? if (get_current_action() == "sparkling_mangolime") { echo "ON";} ?> linea" href="<?=url_for("main", "sparkling_mangolime")?>">Rickey Mango Lime</a></li>   
			
		</ul>
	</div>
	
	<div class="box_nav_2 nav_rx">
		<h4>Bebida Energ�tica</h4>
		<ul id="nav_2">
			<li><a class="<? if (get_current_action() == "energetica") { echo "ON";} ?> linea" href="<?=url_for("main", "energetica")?>">Energ�tica RX</a></li>
		</ul>
	</div>

</div>