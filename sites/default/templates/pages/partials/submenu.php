<div class="col_IZ">
	<div class="box_nav_2 nav_te">
		<h4>Té Arizona</h4>
		<ul id="nav_2">
			<li>Te Verde</li>
			<li><a class="<? if (get_current_action() == "teverde_miel") { echo "ON";} ?> linea" href="/main/teverde_miel">Té verde con Ginseng y Miel</a></li>
		
			<li class="mar-top-10">Té Negro</li>
			<li><a class="<? if (get_current_action() == "tehelado_fram") { echo "ON";} ?>" href="/main/tehelado_fram">Té Negro sabor Frambuesa</a></li>
			<li><a class="<? if (get_current_action() == "tehelado_limon") { echo "ON";} ?>" href="/main/tehelado_limon">Té Negro sabor Limón</a></li>
			<li><a class="<? if (get_current_action() == "tehelado_mango") { echo "ON";} ?>" href="/main/tehelado_mango">Té Negro sabor Mango</a></li>
			
			
			<li class="mar-top-10">Te Zero Calorías</li>
			<li><a class="<? if (get_current_action() == "tediet_miel") { echo "ON";} ?> linea" href="/main/tediet_miel">Té verde Zero calorías con Ginseng </a></li>
			<li><a class="<? if (get_current_action() == "tediet_limon") { echo "ON";} ?> linea" href="/main/tediet_limon">Té negro Zero calorías sabor Limón</a></li>
			<li><a class="<? if (get_current_action() == "tediet_arandano") { echo "ON";} ?> linea" href="/main/tediet_arandano">Té verde Diet sabor Arándano</a></li>
			<li><a class="<? if (get_current_action() == "tediet_durazno") { echo "ON";} ?> linea" href="/main/tediet_durazno">Té helado Diet sabor Durazno</a></li>
		</ul>
	</div>
	
	<div class="box_nav_2 nav_nectar">
		<h4>Jugos</h4>
		<ul id="nav_2">
			<li><a class="<? if (get_current_action() == "mix_zanahoria") { echo "ON";} ?> linea" href="/main/mix_zanahoria">Mix Zanahoria con Frutas</a></li>
			<li><a class="<? if (get_current_action() == "nectar_mango") { echo "ON";} ?> linea" href="/main/nectar_mango">Néctar sabor Mango</a></li>
			<li><a class="<? if (get_current_action() == "nectar_sandia") { echo "ON";} ?> linea" href="/main/nectar_sandia">Néctar sabor Sandia</a></li>
			<li><a class="<? if (get_current_action() == "nectar_uva") { echo "ON";} ?> linea" href="/main/nectar_uva">Néctar sabor Uva</a></li>
			<li><a class="<? if (get_current_action() == "nectar_naranja") { echo "ON";} ?> linea" href="/main/nectar_naranja">Néctar sabor Naranja</a></li>
			<li><a class="<? if (get_current_action() == "nectar_limonada") { echo "ON";} ?> linea" href="/main/nectar_limonada">Néctar sabor Limonada Original</a></li>
			<li><a class="<? if (get_current_action() == "nectar_kiwi") { echo "ON";} ?> linea" href="/main/nectar_kiwi">Néctar sabor Kiwi Frutilla</a></li>
	
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
		<h4>Bebida Energética</h4>
		<ul id="nav_2">
			<li><a class="<? if (get_current_action() == "energetica") { echo "ON";} ?> linea" href="<?=url_for("main", "energetica")?>">Energética RX</a></li>
		</ul>
	</div>

</div>