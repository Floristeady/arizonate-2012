<?

	function get_opciones() {
		$opciones[1] = "T� Verde con Miel y Ginseng";
		$opciones[2] = "T� Blanco con Ginseng y jugo de Arandano";
		$opciones[3] = "T� Verde con Ginseng y jugo de Granada";
		$opciones[4] = "T� Verde DIET con Ginseng y Miel";
		$opciones[5] = "T� Negro DIET sabor Frambuesa";
		$opciones[6] = "T� Helado con sabor de Mango";
		$opciones[7] = "T� Helado con sabor de Frambuesa";
		$opciones[8] = "T� Helado con sabor de Limon";
		$opciones[9] = "Bebida Energ�tica RX Herbal Tonic";
		$opciones[10] = "Nectar sabor Mango";
		$opciones[11] = "Nectar sabor Sandia";
		$opciones[12] = "Nectar sabor Uva";
		$opciones[13] = "Nectar sabor Naranja";
		return $opciones;
	}
	function get_opcion($i) {
		$opciones = get_opciones();
		return $opciones[$i];	
	}