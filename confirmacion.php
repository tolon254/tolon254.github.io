<?php 
function form_mail($Para, $Asunto, $Texto, $De)
{ 
$HayFicheros = 0; 
$CabeceraTexto = ""; 
$Adjuntos = "";

if ($De)$Cabeceras = "From:".$De."\n"; 
else $Cabeceras = ""; 
$Cabeceras .= "MIME-version: 1.0\n"; 
foreach ($_POST as $Nombre => $Valor) 
$Texto = $Texto."\n".$Nombre." = ".$Valor;

foreach ($_FILES as $Adjunto)
{ 
if ($HayFicheros == 0)
{ 
$HayFicheros = 1; 
$Cabeceras .= "Content-type: multipart/mixed;"; 
$Cabeceras .= "boundary=\"--_Separador-de-mensajes_--\"\n";

$CabeceraTexto = "----_Separador-de-mensajes_--\n"; 
$CabeceraTexto .= "Content-type: text/plain;charset=iso-8859-1\n"; 
$CabeceraTexto .= "Content-transfer-encoding: 7BIT\n";

$Texto = $CabeceraTexto.$Texto; 
} 
if ($Adjunto["size"] > 0) 
{ 
$Adjuntos .= "\n\n----_Separador-de-mensajes_--\n"; 
$Adjuntos .= "Content-type: ".$Adjunto["type"].";name=\"".$Adjunto["name"]."\"\n";; 
$Adjuntos .= "Content-Transfer-Encoding: BASE64\n"; 
$Adjuntos .= "Content-disposition: attachment;filename=\"".$Adjunto["name"]."\"\n\n";

$Fichero = fopen($Adjunto["tmp_name"], 'r'); 
$Contenido = fread($Fichero, filesize($Adjunto["tmp_name"])); 
$Adjuntos .= chunk_split(base64_encode($Contenido)); 
fclose($Fichero); 
} 
}

if ($HayFicheros) 
$Texto .= $Adjuntos."\n\n----_Separador-de-mensajes_----\n"; 
return(mail($Para, $Asunto, $Texto, $Cabeceras)); 
}

//cambiar aqui el email 
if (form_mail("hefaveal2@gmail.com", $_POST[asunto], 
"Los datos introducidos en el formulario son:\n\n", $_POST[email])) 
echo "
 <h1>Su formulario fue enviado con exito </h1>
<form>   
<p>Muchas gracias <br>
O lo que tu quieras poner los que sea!<br>
Solo realiza el cambiio en este texto!<br>
<br>
Saludos el equipo de ..lo que seas..
</p>
</form>

"; 
?>

