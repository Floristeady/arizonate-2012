<?

	function get_opciones() {
		$opciones[1] = "Té Verde con Miel y Ginseng";
		$opciones[2] = "Té Blanco con Ginseng y jugo de Arandano";
		$opciones[3] = "Té Verde con Ginseng y jugo de Granada";
		$opciones[4] = "Té Verde DIET con Ginseng y Miel";
		$opciones[5] = "Té Negro DIET sabor Frambuesa";
		$opciones[6] = "Té Helado con sabor de Mango";
		$opciones[7] = "Té Helado con sabor de Frambuesa";
		$opciones[8] = "Té Helado con sabor de Limon";
		$opciones[9] = "Bebida Energética RX Herbal Tonic";
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