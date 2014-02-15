<!--
var resultString = new Array(' ','Tr&egrave;s faible','Faible','Moyen','Elev&eacute;','Tr&egrave;s &eacute;lev&eacute;');
var resultColors = new Array('#CC0000',      '#FF6600',       '#FF9900',  '#FFFF00', '#CCFF00', '#66FF00');
var bigLists   = new Array('azertyuiopqsdfghjklmwxcvbn','nbvcxwmlkjhgfdsqpoiuytreza','qwertyuiopasdfghjklzxcvbnm','mnbvcxzlkjhgfdsapoiuytrewq','0123456789','abcdefghijklmnopqrstuvwxyz','zyxwvutsrqponmlkjihgfedcba');

var indiceMoyen = 4;
var splitSuites = 4;

var suite="", incre = 0;

function testMdp(id_champs, id_afficher) {
	var field = $("#"+id_champs).val();
	
	if(field.length < 4) {
		if(field.length == 0) {
			displayResults(null, id_afficher);
		}
		else {
			displayResults(1, id_afficher);
		}
	}
	else {
		var letters = false;
		var numbers = false;
		
		// Longueur
		if(field.length <= 8) {
			incre++;
		}
		else {
			incre++; incre++;
		}
		
		// Lettres
		if(field.search('[\w]') == -1) {
			incre++; letters = true;
		}
		
		// Chiffres
		if(field.search('[0-9]') != -1) {
			incre++;incre++; numbers = true;
		}	
		
		// Majuscules et minuscules	
		if(letters) {
			var fieldlow = field.toLowerCase();
			if(field != fieldlow) {
				incre++;
			}
		}

		// Caractères spéciaux
		var spechar = 0, char;
		var specialCahrs = "&é'(-è_çà)[€]@~°=*#*\ù!:;,?./§-+<>$£µ%"+'"';
		for(i=0;i<field.length;i++) {
			char = field.charAt(i)
			if(specialCahrs.indexOf(char) != -1) {
				spechar++;
			}
		}
		if(spechar != 0) {
			if(spechar >= 2) {
				incre++; incre++;
			}
			else {
				incre++;
			}
		}
		
		// Suites 
		var parts = new Array;
		for(i=0;i<field.length;i++) {
			if(i+splitSuites < field.length) {
				parts.push(field.substring(i,i+splitSuites));
				//i = i + (splitSuites - 1);
			}
			else {
				parts.push(field.substring(field.length-splitSuites,field.length));
				break;
			}
		}
		var k = 0, l = 0, char = new Array;
		for(i=0;i<parts.length;i++) {
			for(j=0;j<bigLists.length;j++) {
				if(bigLists[j].indexOf(parts[i]) != -1) {
					k = 1;
				}
			}
			if(splitSuites == 2) {
				char[0] = parts[i].charAt(0);
				char[1] = parts[i].charAt(1);
				if(char[0] == char[1]) {
					l = 1;
				}	
			}
			else if(splitSuites == 3) {
				char[0] = parts[i].charAt(0);
				char[1] = parts[i].charAt(1);
				char[2] = parts[i].charAt(2);
				if( (char[0] == char[1]) && (char[1] == char[2]) && (char[0] == char[2]) ) {
					l = 1;
				}	
			}
			else {
				char[0] = parts[i].charAt(0);
				char[1] = parts[i].charAt(1);
				char[2] = parts[i].charAt(2);
				char[3] = parts[i].charAt(3);
				if( (char[0] == char[1]) && (char[2] == char[3]) && (char[1] == char[3]) && (char[0] == char[3]) ) {
					l = 1;
				}				
			}
		}
		if(k == 1 && l == 1) {
			incre--; 
		}
		else if(l == 1 && k == 0) {
			incre--; 
		}
		else if(l == 0 && k == 1) {
			incre--; 
		}	
		
		displayResults(incre, id_afficher);
	}}

function displayResults(nb, id_afficher) {
	var result = document.getElementById(id_afficher);
	if(!nb) {
		result.style.backgroundColor = resultColors[0];
		result.innerHTML = resultString[0];		
	}
	else {
		if(nb == indiceMoyen) {
			// Moyen
			result.style.backgroundColor = resultColors[3];
			result.innerHTML = resultString[3];	
		}
		else if(nb < indiceMoyen-1) {
			// Très faible
			result.style.backgroundColor = resultColors[1];
			result.innerHTML = resultString[1];			
		}		
		else if(nb >= indiceMoyen-1 && nb < indiceMoyen) {
			// Faible
			result.style.backgroundColor = resultColors[2];
			result.innerHTML = resultString[2];			
		}
		else if(nb > indiceMoyen && nb <= indiceMoyen+1) {
			// Fort
			result.style.backgroundColor = resultColors[4];
			result.innerHTML = resultString[4];			
		}		
		
		else {
			// Très fort
			result.style.backgroundColor = resultColors[5];
			result.innerHTML = resultString[5];		
			
		}
		incre = 0;
	}
}
//-->