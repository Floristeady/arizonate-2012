<?

	function get_opciones() {
		$opciones[1] = "T� Verde con Miel y Ginseng";
		$opciones[2] = "T� Blanco con Ginseng y jugo de Ar�ndano";
		$opciones[3] = "T� Verde con Ginseng y jugo de Granada";
		$opciones[4] = "T� Verde DIET con Ginseng y Miel";
		$opciones[5] = "T� Verde DIET con Cranberry y Manzana";
		$opciones[6] = "T� Verde DIET con jugo de Ar�ndano";
		$opciones[7] = "T� Helado con sabor de Frambuesa";
		$opciones[8] = "T� Helado con sabor de Lim�n";
		$opciones[9] = "Bebida Energ�tica RX Herbal Tonic";
		return $opciones;
	}
	function get_opcion($i) {
		$opciones = get_opciones();
		return $opciones[$i];	
	}