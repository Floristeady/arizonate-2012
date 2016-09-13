<?php
/*
GOTCHA. si un inlcude o modelo tiene espacios antes esto falla sin avsio
*/


// KEEP THIS FILE IN ANSI
class ImageProcessor {
		function ImageProcessor($path) {
			if (get_configuration_param("jpeg_quality")>0) {
				$this->jpeg_quality = get_configuration_param("jpeg_quality");
			}
			else {
				$this->jpeg_quality = 100;
			}
			if (strlen(get_configuration_param("img_cache_path")) > 0 ) {
				$this->img_cache_path = get_configuration_param("img_cache_path");
			}
			else {
				$this->img_cache_path = "/site/cache";
			}
			
			$this->file_name = basename($path);
			$this->full_path = $_SERVER['DOCUMENT_ROOT'].$path;
			
			if (!file_exists($this->full_path)) {
				Logger::error("ImageProcessor -> El archivo ".$this->full_path. " no existe");
				die();
			}
			if (!$this->original_image = $this->open_image($this->full_path)){
				Logger::error("ImageProcessor -> I could't open ".$this->full_path);
			}

			
		}
		function open_image ($file) {
		        $this->extension = end(explode(".", $file));
		        $this->extension = strtolower($this->extension);
		        if ($this->extension == "jpg") {
		        	return imagecreatefromjpeg($file);
		        }
		        elseif ($this->extension == "gif") {
		        	return imagecreatefromgif($file);
		        }
		        elseif ($this->extension == "png") {
		        	return imagecreatefrompng($file);
		        }
		        elseif ($this->extension == "bmp") {
		        	return imagecreatefrombmp($file);
		        }
		        else {
		        	return false;
		        }
		}

		function getFileSize() {
			if (file_exists($this->full_path))
				return round(filesize($this->full_path)/1024,0);
		}
		function getWidth(){
			if ($this->original_image)
				return imagesx($this->original_image);
		}
		function getHeight(){
			if ($this->original_image)
				return imagesy($this->original_image);
		}
		function getSize() {
			if ($this->original_image)
				return $this->getWidth()." x ".$this->getHeight();
		}
		function getRatio() {
			if ($this->original_image)
				return $this->getHeight()/$this->getWidth();
		}
		function printResized($new_width, $max_height = null) {
			$debug_me = false;
			if (!($new_width>0)) {
				$new_width = 100;
			}

			if (get_configuration_param("use_resize_cache") && $this->file_cache_exists($new_width)) {
				Logger::debug("IMG -> will use cache");
				//no funciona con max height
				if (!$debug_me) {
					header('Content-type: image/'.$this->extension);
				}
				$filename = $_SERVER['DOCUMENT_ROOT'].$this->img_cache_path."/".$new_width."/".$this->file_name;
				$handle = fopen($filename, "r");
				echo fpassthru  ($handle);
				fclose($handle);	
			}
			else {
				if ($this->getRatio() > 1) {
					if ($this->getRatio()*$new_width > $max_height && isset($max_height)){
						// el alto propuesto supera el permitido
						$new_width = $max_height/$this->getRatio();
						$new_height = $max_height;
					} 
					else {
						//no hay problemas con la limitacion en el alto
						$new_height = $this->getRatio()*$new_width;
					}
				} else {
					//es horizontal
					if ($this->getRatio()*$new_width > $max_height && isset($max_height)){
						// el alto propuesto supera el permitido
						$new_height = $max_height;
						$new_width = $max_height/$this->getRatio();
					}
					else {
						// es horizontal y cabe dentro de esta caja
						$new_height = $this->getRatio()*$new_width;
					}
				}
				

					
				$image_resized = imagecreatetruecolor($new_width, $new_height);
				
				Logger::debug("IMG -> will use imagecopyresampled() for resizing (".$this->getWidth()." x ".$this->getHeight().") =>( $new_width x $new_height)");

				imagecopyresampled($image_resized, $this->original_image, 0, 0, 0, 0, $new_width, $new_height, $this->getWidth(), $this->getHeight());
				if (!$debug_me)
					header('Content-type: image/jpeg');
				$cache_to_dir = $_SERVER['DOCUMENT_ROOT'].$this->img_cache_path."/".round($new_width)."/";
				if (get_configuration_param("use_resize_cache")) {
					if (is_dir($cache_to_dir)) {
						if(!imagejpeg($image_resized, $cache_to_dir.$this->file_name, $this->jpeg_quality)) {
							Logger::error("IMG -> I likely couldn't write to cache dir at ".$cache_to_dir);
						}
					}
					else {
						Logger::info("IMG No cache folder, will try to create");
						// Crea el directorio con permisos 777
						if (mkdir($cache_to_dir, 0777)) {
							Logger::info("IMG cache folder created");
							imagejpeg($image_resized, $cache_to_dir.$this->file_name, $this->jpeg_quality);
							if (chmod($cache_to_dir, 0777)) {
								Logger::info("IMG cache folder permissions OK");
							}
						}
						else {
							Logger::error("IMG Could not create caché folder at ".$cache_to_dir);
						}
						
					}
				}
				imagejpeg($image_resized,null,$this->jpeg_quality);
			
				
			}
			exit();
						
		}

		
		
		function file_resize_exists($width) {
			global $img_resized_path;
			return (file_exists($_SERVER['DOCUMENT_ROOT'].$img_resized_path."/".$width."/".$this->file_name))?true:false;
		}
		function file_cache_exists($width) {
			return (file_exists($_SERVER['DOCUMENT_ROOT'].$this->img_cache_path."/".$width."/".$this->file_name))?true:false;
		}
}
