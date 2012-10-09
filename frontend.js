
var 
  DEBUG = false,
  sites = {
  twitter: {
    width: 44
  }
} ,fontDB = [
"roman", 
"univers", 
"standard", 
"georgi16", 
"Georgia11", 

"fender", 
"computer", 
"script", 

//"konto",  FIX
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
//"arrows", 
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
//"doom", 
"double", 
"doubleshorts", 
"banner3-D", 
"3-d", 
"epic", 
"filter", 
"fire_font-s",  
"fuzzy", 
//"glenyn",  maybe
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
//"pebbles", 
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
//"smslant",  FIX
"soft", 
"speed", 
"spliff", 
"stacey", 
"stampate", 
"starwars", 
//"5lineoblique", 
"stop", 
"sub-zero", 
"swan", 
"thick", 
"tiles", 
//"tinker-toy", 
"trek", 
"tubular",  
"s-relief", 
"impossible", 

"dotmatrix", 
//"amcneko", 
"amcaaa01", 
"caligraphy", 
"defleppard", 
"doh", 
"broadway", 
"3d_diagonal", 
"fraktur", 
"nvscript", 
"sweet", 
"alpha", 
"isometric1", 
//"smisome1", 
"blocks", 

"alligator2"
//"cosmic", 
//"sblood", 
//"alligator"
];

var 
  currentFont = 0,
  init = false,
  divLookup = {}, 
  itimeout, 
  lastval,
  width = 28 + 30,
  maxWidthCurrent,
  preview, 
  copy, 
  fontStack = [];

function gen() {
  if(!copy.value.length) {
    return;
  }
  $.get("figlet.php", {
    text: copy.value,
    font: fontDB[currentFont],
    width: width,
  }, function(payload) {
    payload = payload.split('\n');
    maxWidthCurrent = payload[0].length;
    preview.innerHTML = encode(payload);
    if(!init) {
      init = true;
      $(".after-text").fadeIn();
    }
    if(DEBUG) {
      $("#debug_raw").html(payload.join("\n"));
      document.location = document.location.toString().split('#')[0] + '#' + JSON.stringify({
        font: fontDB[currentFont],
        width: width,
        text: copy.value
      });
    }
  });
}

function wider() {
  width += 15;
  gen();
  $("#narrower").removeClass("disabled");
}

function narrower() {
  if(width > 25) {
    width -= 15;
    gen();
  } else {
    $("#narrower").addClass("disabled");
  }
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
  DEBUG = document.location.search.length > 0;

  preview = document.getElementById("preview");
  copy = document.getElementById("copy");
  copy.focus();

  if(DEBUG) {
    $("#debug_raw").css("display","block");
  }

  if(window.location.hash.length) {
    var obj = JSON.parse(window.location.hash.slice(1));
    currentFont = fontDB.indexOf(obj.font);
    copy.value = obj.text;
    gen();
  }

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
