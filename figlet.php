<link rel=stylesheet href=figlet.css>
<script src=figlet.js></script>
<?
if(!empty($_GET['width'])) {
  $width=intval($_GET['width']);
} else {
  $width = 100;
}

$fontsDB = Array(
"3-d", 
"weird", 
"Georgia11", 
"4max", 
"script", 
"3x5", 
"cybermedium", 
"whimsy",
"rowancap", 
"5lineoblique", 
"oldbanner", 
"cyberlarge", 
"alligator2", 
"alphabet", 
"amc3liv1", 
"amcrazo2", 
"amcrazor", 
"amcslash", 
"amcslder", 
"amcthin", 
"amctubes", 
"amcun1", 
"arrows", 
"ascii_new_roman", 
"avatar", 
"banner3-D", 
"banner3", 
"banner4", 
"basic", 
"bell", 
"big",  
"block", 
"bolger", 
"bright", 
"catwalk", 
"chunky", 
//"cola", 
"colossal", 
"computer", 
"cosmic", 
"crawford", 
"cricket", 
"diamond", 
"dietcola", 
"doom", 
"double", 
"doubleshorts", 
"drpepper", 
"epic", 
"fender", 
"filter", 
"fire_font-s",  
"fuzzy", 
"ghoulish", 
"glenyn", 
"gothic",
"gradient", 
"graffiti", 
"henry3d",
"hollywood", 
"jacky", 
"jazmine", 
"kban", 
"larry3d", 
"lcd", 
"lean", 
"letters", 
"lineblocks", 
"lockergnome", 
//"marquee", 
"merlin1",  
"modular", 
"nancyj-improved", 
"ntgreek", 
"o8", 
"ogre", 
"pawp", 
"peaks", 
"pebbles", 
"poison", 
"puffy", 
"red_phoenix", 
"relief", 
//"relief2", 
//"reverse", 
"roman", 
"rounded", 
"rozzo", 

// single lines
"muzzle", 
"fourtops", 
"rectangles", 
"tombstone", 
"amc3line", 
"contessa",  
"konto", 
"kontoslant", 
//"maxfour", 
"madrid", 
"small", 
"varsity", 
"invita", 

"santaclara", 
"sblood", 
"shadow", 
"shimrod", 
"slant", 
"slide", 
"slscript", 
"smallcaps", 
"smisome1", 
"smscript", 
"smslant", 
"soft", 
"speed", 
"spliff", 
"stacey", 
"stampate", 
"stampatello", 
"standard", 
"starstrips", 
"starwars", 
"stforek", 
"stop", 
"sub-zero", 
"swan", 
"tanja", 
"thick", 
"thin", 
//"ticks", 
//"ticksslant", 
"tiles", 
"tinker-toy", 
"trek", 
"tubular",  
"univers", 
"s-relief", 
"impossible", 

// big
"dotmatrix", 
"amcneko", 
"amcaaa01", 
"georgi16", 
"caligraphy", 
"defleppard", 
"doh", 
"crazy", 
"broadway", 
"acrobatic", 
"3d_diagonal", 
"fraktur", 
"nvscript", 
"sweet", 
"alpha", 
"isometric1", 
"blocks", 

"alligator"
//"wetletter" 
);

function encode($str) {
  $str = preg_replace('/[\Âaa-z~]/', '~', $str); // 1st lightest grey
  $str = preg_replace('/[&,;><:\/\\\]/', '?', $str); // 2nd lightest grey
  $str = preg_replace('/[}\]]/', '!', $str); // right block
  $str = preg_replace('/[{\[]/', '^', $str); // left block
  $str = preg_replace('/[Â´\'`"]/', '@', $str); // upper block
//  $str = preg_replace('/[=]/', '=', $str); // middle block
  $str = preg_replace('/[e_=\.]/', '%', $str); // lower block
  $str = preg_replace('/[BWQGMNUPDZRWX8$#|\-]/', ')', $str); // black
  $str = preg_replace('/[()\w*+]/', 'z', $str); // darker grey
  $str = str_replace(
      Array(' ',       ')',      '=',       '~',       '?',       'z',       '!',   '@',        '%',     '^'), 
      Array('&#9617;', '&#9608;', '&#9644;', '&#9618;', '&#9618;', '&#9619;', '&#9616;', '&#9600;', '&#9604;', '&#9612;'), $str);
  return $str;
}

function sorter($a, $b) {
  return $a[1] - $b[1];
}
$text = escapeshellarg($_GET['text']);
$buffer = Array();

$start = microtime(true);
foreach($fontsDB as $font) {
  $output = array();
  $newout = array();
  exec("/usr/local/bin/figlet -w $width -f $font '$text'", $output);
  $maxwidth = 0;
  $firstChar = false;
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
  $buffer[] = Array($font, count($newout), encode(implode("\n", $newout)));
}
uasort($buffer, 'sorter');

foreach($buffer as $font) {
  list($title, $height, $text) = $font;
  echo "<div title='$title'>$text</div>";
}
echo microtime(true) - $start;
