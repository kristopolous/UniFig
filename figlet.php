<?
$text = escapeshellarg(stripslashes($_GET['text']));
$width = escapeshellarg($_GET['width']);
$font = escapeshellarg($_GET['font']);
$output = array();
$newout = array();
exec("/usr/bin/figlet -w $width -f $font $text", $output);
$maxwidth = 0;
// This truncates the trailing newlines
for($ix = count($output) - 1; $ix >= 0; $ix --) {
  $line = $output[$ix];
  $maxwidth = max($maxwidth, strlen($line));

  if (!$firstChar && preg_match('/[^\s]/', $line) == 0) {
    array_pop($output);
  } else {
    $firstChar = true;
  }
}
$firstChar = false;
// This truncates the preceding newlines
foreach($output as $line) {
  if (!$firstChar && preg_match('/[^\s]/', $line) == 0) {
    continue; 
  } else {
    $firstChar = true;
  }
  $newout[] = sprintf("%-" . $maxwidth . "s", $line);
} 
echo implode("\n",$newout);
