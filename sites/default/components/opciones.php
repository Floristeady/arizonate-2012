<?

	function get_opciones() {
		$opciones[1] = "Té Verde con Miel y Ginseng";
		$opciones[2] = "Té Blanco con Ginseng y jugo de Arándano";
		$opciones[3] = "Té Verde con Ginseng y jugo de Granada";
		$opciones[4] = "Té Verde DIET con Ginseng y Miel";
		$opciones[5] = "Té Verde DIET con Cranberry y Manzana";
		$opciones[6] = "Té Verde DIET con jugo de Arándano";
		$opciones[7] = "Té Helado con sabor de Frambuesa";
		$opciones[8] = "Té Helado con sabor de Limón";
		$opciones[9] = "Bebida Energética RX Herbal Tonic";
		return $opciones;
	}
	function get_opcion($i) {
		$opciones = get_opciones();
		return $opciones[$i];	
	}