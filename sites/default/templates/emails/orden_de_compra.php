<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<body>

<div style=" margin-left:25px; padding: 10px; width: 620px; font-family: Arial,Helvetica,Times,Verdana,sans-serif; font-size: 12px;">

<img style="margin:0px; padding:0px; margin-bottom:10px;" alt="Arizona" title="Arizona" src="http://<?=$_SERVER["SERVER_NAME"]?>/img/test/contacto_fondo.gif">

<img style="margin:0px; padding:0px; margin-bottom:20px; display:none;" alt="Carro de Compras Arizona" title="Carro de Compras Arizona" src="http://<?=$_SERVER["SERVER_NAME"]?>/img/test/titulo_compra.png">

<form name="form1" method="post" action="">







<table width="480" border="0" cellpadding="0" cellspacing="0" style="padding-left:5px;">
    <tr>
        <td width="480" height="29">
        <h1 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:20px;color: #00aba2; padding:0px; margin:0px;"><strong>Datos del Cliente</strong></h1>
        </td>
    </tr>
    
<tr>
<td>


<table width="480" border="0" cellpadding="0" cellspacing="0">

<tr>
    <td height="1" colspan="2" bgcolor="#999999"></td>
</tr>

<tr>
<td width="79" height="27">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Nombre</strong></h1>    </td>

<td width="401">
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$nombre?></p></td>
</tr>

<tr>
<td height="27" bgcolor="#f5f5f5">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>E-mail</strong></h1></td>
<td bgcolor="#f5f5f5">
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$email?></p></td>
</tr>

<tr>
<td height="27">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Tel&eacute;fono</strong></h1>    </td>
<td>
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$telefono?></p></td>
</tr>

<tr>
<td height="27" bgcolor="#f5f5f5">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong> Direcci&oacute;n</strong></h1></td>
<td bgcolor="#f5f5f5">
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$direccion?></p></td>
</tr>

<tr>
<td height="27">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Comuna</strong></h1>    </td>
<td>
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$comuna?></p></td>
</tr>

<tr>
<td height="27" bgcolor="#f5f5f5">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:13px; line-height:20px;color: #7F3536; padding:0px; margin:0px;"><strong>Ciudad</strong></h1>
</td>
<td bgcolor="#f5f5f5">
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$ciudad?></p></td>
</tr>

</table>
</td>



</tr>
<tr>
<td height="30"></td>
</tr>
<tr>
<td height="30"><table width="480" border="0" cellspacing="0" cellpadding="0">
<tr>
<td width="312" height="25">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:20px;color: #00aba2; padding:0px; margin:0px;"><strong>Pedidos</strong></h1>
</td>
<td width="168" align="center">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:20px;color: #00aba2; padding:0px; margin:0px;"><strong>Cantidad</strong></h1>
</td>
</tr>

<tr>
    <td height="1" colspan="2" bgcolor="#999999"></td>
    <td height="1" colspan="2" bgcolor="#999999"></td>
</tr>


<? if (is_array ($productos)) {?>
<? foreach ($productos as $key => $cantidad) { ?>
<? if (!$cantidad == '0') {?>
<tr>
<td height="27" bgcolor="#f5f5f5" style="border-bottom: 1px solid #ccc;">
    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=get_opcion($key)?></p>
</td>
<td align="center" bgcolor="#f5f5f5"  style="border-bottom: 1px solid #ccc;">
    <p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><?=$cantidad?></p>
</td>
</tr>
<? } ?>
<? } ?>
<? } ?>


<tr>
<td height="30">&nbsp;</td>
<td height="30" align="center">&nbsp;</td>
</tr>
<tr>
<td height="27">
<h1 style="font-family:Arial, Helvetica, sans-serif; font-size:15px; line-height:20px;color: #00aba2; padding:0px; margin:0px;"><strong>Mix de Botellas</strong></h1>
</td>
<td align="center">&nbsp;</td>
</tr>

<tr>
    <td height="1" colspan="2" bgcolor="#999999"></td>
    <td height="1" colspan="2" bgcolor="#999999"></td>
</tr>


<? if (is_array ($mixes)) {?>
<? foreach ($mixes as $key => $mix) { ?>
<tr>
<td height="27" colspan="2" bgcolor="#f5f5f5">
<p style="font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:20px;color: #55555; padding:0px; margin:0px;"><strong>Mix <?=$key?></strong>: <?=get_opcion($mix[1])?> + <?=get_opcion($mix[2])?></p>
</td>
</tr>
<? } ?>
<? } ?>


</table></td>
</tr>
</table>

</form>

</div>

</body>
</html>
