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
"amcrazo2", 
"amcrazor", 
"amcslash", 
"amcslder", 
"amcthin", 
"amctubes", 
"amcun1", 
"arrows", 
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
"lcd", 
"lean", 
"lineblocks", 
"merlin1",  
"modular", 
"nancyj-improved", 
"o8", 
"ogre", 
"pawp", 
"peaks", 
"pebbles", 
"poison", 
"puffy", 
"red_phoenix", 
"relief", 
"roman", 
"rounded", 
"rozzo", 

// single lines
"rectangles", 
"amc3line", 
"contessa",  
"konto", 
"kontoslant", 
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
"smisome1", 

"smscript", 
"smslant", 
"soft", 
"speed", 
"spliff", 
"stacey", 
"stampate", 
"standard", 
"starwars", 
"stforek", 
"stop", 
"sub-zero", 
"swan", 
"thick", 
"thin", 
"tiles", 
"tinker-toy", 
"trek", 
"tubular",  
"univers", 
"s-relief", 
"impossible", 

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

/*
"stampatello", 
"starstrips", 
"smallcaps", 
"maxfour", 
"alphabet", 
"relief2", 
"tombstone", 
"muzzle", 
"fourtops", 
"reverse", 
"letters", 
"lockergnome", 
"marquee", 
"larry3d", 
"cola", 
"ascii_new_roman", 
"tanja", 
"ntgreek", 
"ticks", 
"ticksslant", 
"wetletter",
*/

"alligator"

);

$twos =  Array(
    '/[A-Z][\.,b(\'`]/', Array('&#9619;','&#9612;'),
    '/[_.e,]{2}/', Array('&#9604;','&#9604;'),
    '/[\.,_][\-]/', Array('&#9604;', '&#9604;'), 
    '/_[)db]/', Array('&#9604;', '&#9619;'), 

    '/-[\.,]/',  Array('&#9604;','&#9604;'), // curve right
    '/[,._\-][\xb4\']/', Array('&#9604;','&#9600;'), // curve right up
    '/[\xb4`\'][\.,]/', Array('&#9600;','&#9604;'),

    '/[\\`][\-_]/', Array('&#9600;','&#9604;'), // curve left up
    '/[|][\-_]/', Array('&#9616;','&#9604;'), // curve left up

    '/ [\\\)(>]/', Array('&#9617;','&#9616;'),
    '/[\/] /', Array('&#9619;','&#9617;'),
    '/\|\./', Array('&#9619;','&#9604;'), 
    '/\.\|/', Array('&#9604;','&#9619;'), 
    '/\\\=/', Array('&#9616;','&#9604;'), 

    '/d8/', Array('&#9619;','&#9608;'),
    '/db/', Array('&#9616;','&#9612;'),
    '/\|\//', Array('&#9619;','&#9616;'),
    '/\'\|/', Array('&#9600;','&#9608;'),

    '/\\\\\//', Array('&#9616;','&#9612;'),
    '/\|\|/', Array('&#9619;','&#9608;')
);

$ones = Array(
    '/ /', '&#9617;',
    '/[\-_dobpvmgae]/', '&#9604;',
    '/[\/A-KM-Z|\\\0-79]/', '&#9619;',  
    '/[,.;&a-z+?!%@$]/', '&#9618;',  
    '/[:L)><\]]/', '&#9612;', 
    '/[(\[]/', '&#9616;', 
    '/[8\#]/', '&#9608;',
    '/[\xb4=~"\'`^*]/', '&#9600;' // upper
);
$encoder_time = 0;
function encode($all) {
  global $encoder_time, $twos, $ones;
  $start = microtime(true);
  $ret = Array();
  $blank_line = Array();
  $len = strlen($all[0]);
  $len_ones = count($ones);
  $len_twos = count($twos);

  for($ix = 0; $ix < $len; $ix++) {
    $blank_line[] = 0;
  }

  foreach($all as $line_in) {
    $line_out = $blank_line;

    for($ix = 0; $ix < $len; $ix++) {
      $double = substr($line_in, $ix, 2);
      $single = $line_in[$ix];

      for($iy = 0; $iy < $len_twos; $iy += 2) {
        if (preg_match($twos[$iy], $double)) {
          $repl = $twos[$iy + 1];
          if(!$line_out[$ix]) {
            $line_out[$ix] = $repl[0];
          }
          $line_out[$ix + 1] = $repl[1];
          goto loop_out;
        }
      }

      if(!$line_out[$ix]) {
        for($iy = 0; $iy < $len_ones; $iy += 2) {
          if (preg_match($ones[$iy], $single)) {
            $line_out[$ix] = $ones[$iy + 1];
            goto loop_out;
          }
        }
      }
    loop_out:
    }
    $ret[] = implode('', $line_out);
  }
  $encoder_time += microtime(true) - $start;
  return implode("\n", $ret);
}

function sorter($a, $b) {
  return $a[1] - $b[1];
}
$text = escapeshellarg($_GET['text']);
$buffer = Array();

$start = microtime(true);

if(isset($_GET['font'])) {
  $fontsDB = Array($_GET['font']);
}

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
  echo "<div title='$font'>" . encode($newout) . "</div>";
  //$buffer[] = Array($font, count($newout), encode($newout));
}
/*
uasort($buffer, 'sorter');

foreach($buffer as $font) {
  list($title, $height, $text) = $font;
  echo "<div title='$title'>$text</div>";
}
*/
echo $encoder_time. "\n";
echo microtime(true) - $start;
