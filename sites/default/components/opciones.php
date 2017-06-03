<?

	function get_opciones() {
		$opciones[1] = "Té Verde con Miel y Ginseng";
		$opciones[2] = "Té Verde ZERO calorias con Ginseng y Miel Botella 500ml";
		$opciones[3] = "Té Negro ZERO calorias sabor Limon";
		$opciones[4] = "Té Helado con sabor de Frambuesa";
		$opciones[5] = "Té Helado con sabor de Limon Lata";
		$opciones[6] = "Té Helado con sabor de Limon Botella";
		$opciones[7] = "Té Negro Helado con sabor de Mango";
		$opciones[8] = "Mix Zanahoria con Frutas";
		$opciones[9] = "Bebida Energética RX Herbal Tonic";
		$opciones[10] = "Nectar sabor Mango Lata";
		$opciones[11] = "Nectar sabor Sandia Lata";
		$opciones[12] = "Nectar sabor Uva";
		$opciones[13] = "Nectar sabor Naranja";
		$opciones[14] = "Nectar sabor Limonada Original";		
		$opciones[15] = "Nectar sabor Mango Botella";
		$opciones[16] = "Nectar sabor Sandia Botella";
		$opciones[17] = "Sparkling Rickey Cherry Lime";
		$opciones[18] = "Sparkling Rickey Mango Lime";
		$opciones[19] = "Té Verde ZERO calorias con Ginseng y Miel Botella 1.24l";
		$opciones[20] = "Té verde DIET sabor Arándano";
		$opciones[21] = "Té helado DIET sabor Durazno";
		$opciones[22] = "Nectar sabor Kiwi Frutilla";
		return $opciones;
	}
	function get_opcion($i) {
		$opciones = get_opciones();
		return $opciones[$i];	
	}
	
	function get_opciones2() {
		$opciones[3] = "Té Negro ZERO calorias sabor Limon";
		$opciones[4] = "Té Helado con sabor de Frambuesa";
		$opciones[5] = "Té Helado con sabor de Limon Lata";
		$opciones[7] = "Té Negro Helado con sabor de Mango";
		$opciones[9] = "Bebida Energética RX Herbal Tonic";
		$opciones[10] = "Nectar sabor Mango Lata";
		$opciones[11] = "Nectar sabor Sandia Lata";
		$opciones[12] = "Nectar sabor Uva";
		$opciones[13] = "Nectar sabor Naranja";
		$opciones[14] = "Nectar sabor Limonada Original";		
		$opciones[17] = "Sparkling Rickey Cherry Lime";
		$opciones[18] = "Sparkling Rickey Mango Lime";
		return $opciones;
	}
	function get_opcion2($i) {
		$opciones = get_opciones2();
		return $opciones[$i];	
	}
	
	function get_opciones3() {
		$opciones[1] = "Té Verde con Miel y Ginseng";
		$opciones[2] = "Té Verde ZERO calorias Ginseng y Miel 500ml";
		$opciones[6] = "Té Helado con sabor de Limon Botella";
		$opciones[8] = "Mix Zanahoria con Frutas";
		$opciones[15] = "Nectar sabor Mango Botella";
		$opciones[16] = "Nectar sabor Sandia Botella";

		return $opciones;
	}
	function get_opcion3($i) {
		$opciones = get_opciones3();
		return $opciones[$i];	
	}