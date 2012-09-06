
var fontDB = [
"roman", 
"univers", 
"standard", 
"georgi16", 
"Georgia11", 

"fender", 
"computer", 
"script", 

"konto", 
"madrid", 
"basic", 
"bolger", 
"kban", 
"rozzo", 

"4max", 
"big",  
"3x5", 

"whimsy",
"rowancap", 
"varsity", 
"oldbanner", 
"cyberlarge", 
"rounded", 
"crazy",
"amcrazo2", 
"stforek", 
"amcrazor", 
"cybermedium", 
"amcslder", 
"amcthin", 
"amctubes", 
"amcun1", 
"arrows", 
"avatar", 
"weird", 
"banner3", 
"banner4", 
"bell", 
"block", 
"bright", 

"catwalk", 
"thin", 
"chunky", 
"colossal", 
"crawford", 
"diamond", 
"dietcola", 
"doom", 
"double", 
"doubleshorts", 
"banner3-D", 
"3-d", 
"drpepper", 
"epic", 
"filter", 
"fire_font-s",  
"fuzzy", 
"glenyn", 
"gothic",
"gradient", 
"graffiti", 
"henry3d",
"hollywood", 
"jacky", 
"jazmine", 
"lean", 
"lineblocks", 
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

"rectangles", 
"amc3line", 
"contessa",  
"small", 
"invita", 

"santaclara", 
"shadow", 
"shimrod", 
"slant", 
"slide", 
"slscript", 

"smscript", 
"smslant", 
"soft", 
"speed", 
"spliff", 
"stacey", 
"stampate", 
"starwars", 
"5lineoblique", 
"stop", 
"sub-zero", 
"swan", 
"thick", 
"tiles", 
"tinker-toy", 
"trek", 
"tubular",  
"s-relief", 
"impossible", 

"dotmatrix", 
"amcneko", 
"amcaaa01", 
"caligraphy", 
"defleppard", 
"doh", 
"broadway", 
"acrobatic", 
"3d_diagonal", 
"fraktur", 
"nvscript", 
"sweet", 
"alpha", 
"isometric1", 
"smisome1", 
"blocks", 

"alligator2", 
"cosmic", 
"sblood", 
"alligator"
];

var 
  currentFont = 0,
  init = false,
  divLookup = {}, 
  itimeout, 
  lastval;

function gen() {
  if(!copy.value.length) {
    return;
  }
  $.get("figlet.php", {
    text: copy.value,
    font: fontDB[currentFont],
    width: 50
  }, function(payload) {
    preview.innerHTML = encode(payload.split('\n'));
    if(!init) {
      init = true;
      $(".after-text").fadeIn();
    }
  });
}

function shuffle(inArray) {
  var out = [],
      index;
  while(inArray.length) {
    index = Math.floor(Math.random() * inArray.length);
    out.push(inArray.splice(index, 1)[0]);
  }
  return out;
}

var preview, copy, fontStack = [];

fontDB = shuffle(fontDB);

function prevFont() {
  if(fontStack.length) {
    currentFont = fontStack.pop();
    gen();
  }
  if(!fontStack.length) {
    $("#prev-font").addClass("disabled");
  }
}

function nextFont() {
  fontStack.push(currentFont);
  currentFont += 1;
  currentFont %= fontDB.length;
  $("#prev-font").removeClass("disabled");
  gen();
}

window.onload = function(){
  preview = document.getElementById("preview");
  copy = document.getElementById("copy");
  copy.focus();

  copy.onkeyup = function(){
    clearTimeout(itimeout);
    itimeout = setTimeout(function(){
      if(lastval != copy.value) {
        lastval = copy.value;
        gen();
      }
    }, 200);

	  copy.focus();
	}
}
