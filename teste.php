<label for="ice-cream-choice">Escolha:</label>

<form action="" method="GET">
<input list="goiabinha" id="ice-cream-choice" name="goiabinha" />

<datalist id="goiabinha">
  <option value="1">Azor</option>
  <option value="2">Zedek</option>
</datalist>
<button type="submit">Enviar</button>


$valor=$_POST['valor'];
$valor = explode("-", $valor);
echo $valor=$valor[0]; 
