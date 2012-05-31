<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<body>

<div style=" margin-left:25px; padding: 10px; width: 620px; font-family: Arial,Helvetica,Times,Verdana,sans-serif; font-size: 12px;">

<img style="margin:0px; padding:0px; margin-bottom:10px;" alt="Arizona" title="Arizona" src="http://<?=$_SERVER["SERVER_NAME"]?>/img/test/contacto_fondo.gif">

<img style="margin:0px; padding:0px; margin-bottom:20px;" alt="Informaci&oacute;n de Contacto" title="Información de Contacto" src="http://<?=$_SERVER["SERVER_NAME"]?>/img/test/titulo_contacto.png">


<form name="form2" method="post" action="">


<table style="padding:0px; margin:0px;" width="550" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="170">
    	<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Nombre</strong></h1>
    </td>
    
    <td width="380">
    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><? echo $nombre?></p>
    </td>
  </tr>
  
  <tr>
    <td>
    <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Tel&eacute;fono</strong> </h1>
    </td>
    <td>
    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><? echo $telefono?></p></td>
  </tr>
  
  <tr>
    <td>
    <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Email</strong></h1>
    </td>
    <td>
    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><? echo $email?></p>
    </td>
  </tr>
  
  <tr>
    <td>
    <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Mensaje</strong></h1>
    </td>
    <td>
    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><? echo $mensaje?></p>
    </td>
  </tr>
</table>    

	
</form>
</div>
    
</body>
</html>










