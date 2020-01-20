<?php
$parfums = [
  'Fraise' => 4,
  'Chocolat' => 5,
  'Vanille' => 3
];
// RADIO
$cornets = [
  'Pot' => 2,
  'Cornet' => 3
];
// CHECKBOX
$supplements = [
  'Pépites de chocolat' => 1,
  'Chantilly' => 0.5
];

function checkbox(string $name, string $value, array $data): string
{
  $attribute = '';
  if (isset($data[$name]) && in_array($value, $data[$name])) {
    $attribute .= 'checked';
  }
  return <<<HTML
          <input type="checkbox" name="{$name}[]" value="$value" $attribute> $value
HTML;
}
function radio(string $name, string $value, array $data): string
{
  $attribute = '';
  if (isset($data[$name]) && $value === $data[$name]) {
    $attribute .= 'checked';
  }
  return <<<HTML
          <input type="radio" name="$name" value="$value" $attribute> $value
HTML;
}


function calculate_price()
{

  global $parfums, $cornets, $supplements;
  $sum = 0;

  if (isset($_GET['parfums'])) {
    foreach ($_GET['parfums'] as $key => $value) {
      $sum += $parfums[$value];
    }
  }



  if (isset($_GET['cornets'])) {
    $sum += $cornets[$_GET['cornets']];
  }




  if (isset($_GET['supplements'])) {
    foreach ($_GET['supplements'] as $key => $value) {
      $sum += $supplements[$value];
    }
  }
  return ($sum === 0) ? '' : $sum;
}
