/*
 * Creado con EclipseCrossword, (C) Copyright 2000-2012 Green Eclipse.  eclipsecrossword.com
 * Modificado para el proyecto PEII Nº 201200176
 * "Educación y concienciación de la comunidad “Vivienda Rural de Bárbula” 
 * en la prevención y manejo de riesgos ante desastres naturales, desde un entorno 
 * de aprendizaje mediado por las tecnologías"
 * Nota: CruciAmbiente solo admite letras en el crucigrama
 */
 
 //Modificado por EH. Proyecto PEII. Para generar crucigramas aletorios.
	MCrosswordWidth = new Array (10,11,14,10,10);
	MCrosswordHeight = new Array (11,11,8,12,16);
	MWords = new Array (6,6,6,6,5);
	MWordLength = new Array(new Array(7, 6, 8, 8, 4, 4),
							new Array(6, 6, 7, 8, 4, 6),
							new Array(6, 4, 8, 7, 8, 4),
							new Array(8, 7, 6, 6, 6, 4),
							new Array(8, 6, 9, 13, 6));
	MAnswerHash = new Array(new Array(40590, 89160, 19745, 87780, 97258, 35154),
							new Array(50692, 5826, 40590, 87780, 35154, 83388),
							new Array(89160, 97258, 87780, 40590, 19745, 35154),
							new Array(87780, 40590, 5826, 50692, 83388, 35154),
							new Array(87780, 90646, 73344, 79417, 12114));
	MWordX = new Array(new Array(0, 4, 1, 2, 8, 7),
					   new Array(5, 3, 0, 3, 7, 5),
					   new Array(4, 4, 6, 0, 6, 9),
					   new Array(0, 3, 7, 0, 5, 8),
					   new Array(2, 0, 2, 5, 0));
	MWordY = new Array(new Array(0, 4, 7, 0, 4, 7),
					   new Array(0, 2, 5, 0, 0, 5),
					   new Array(1, 4, 6, 7, 0, 1),
					   new Array(5, 8, 0, 3, 4, 8),
					   new Array(6, 11, 0, 0, 10));
	MLastHorizontalWord = new Array(2,2,3,1,1);
	
	MWord = new Array(new Array("PLANTAS", "TIERRA", "PERSONAS", "AMBIENTE", "RIOS", "AGUA"),
					  new Array("PLAYAS", "BOSQUE", "PLANTAS", "AMBIENTE", "AGUA", "ANIMAL"),
					  new Array("TIERRA", "RIOS", "AMBIENTE", "PLANTAS", "PERSONAS", "AGUA"),
					  new Array("AMBIENTE", "PLANTAS", "BOSQUE", "PLAYAS", "ANIMAL", "AGUA"),
					  new Array("AMBIENTE", "AHORRO", "RECICLAJE", "CONTAMINACION", "BASURA")); //Esta es una matriz para generar los crucigramas aleatorios
	
	MClue = new Array(new Array("Nos dan Oxígeno y realizan la fotosíntesis", "Suelo por donde caminamos", "Varios seres humanos", "Es todo lo que nos rodea", "Masas de agua dulce", "Combinación de H2O"),
					  new Array("Masas de aguas saladas. Es a donde vamos a disfrutar del mar y del sol.", "Es un lugar donde hay muchos árboles.", "Nos dan Oxígeno y realizan la fotosíntesis", "Es todo lo que nos rodea.", "Combinación de H2O", "Es un ser vivo que se puede mover, comer, puede sentir y se alimentan. Ejemplo: perros, gatos, gallinas."),
					  new Array("Suelo por donde caminamos.", "Masas de agua dulce. Pista: El R.. Orinoco.", "Es todo lo que nos rodea. Compuesto de: plantas, animales, edificios, calles, entre otros.", "Nos dan Oxígeno y realizan la fotosíntesis", "Varios seres humanos", "Es el líquido vital para la vida. No debemos contaminarla porque es importante."),
					  new Array("Es todo lo que nos rodea. No debemos contaminarlo.", "Nos dan Oxígeno y realizan la fotosíntesis.", "Es un lugar donde hay muchos árboles. Debemos prevenir la tala y la quema de este lugar.", "Masas de aguas saladas. Cuando las visitemos debemos mantenerlas limpias.", "Es un ser vivo que se puede mover, comer, puede sentir y se alimentan.", "Combinación de H2O. Debemos cuidarla ya que es el líquido vital para vivir."),
					  new Array("Es lo que nos rodea.", "Es cuando usamos las cosas solo lo necesario y no desperdiciamos.", "Consiste en tomar las cosas que hemos botado para convertirlas en nuevos materiales y reutilizarlos.", "Es cuando dañamos el ambiente botando basura.", "Son todos los desperdicios que contaminan nuestro ambiente."));
	
	indice = Math.floor(Math.random() * ((MCrosswordWidth.length-1) - 0 + 1));
	
	CrosswordWidth = MCrosswordWidth[indice];
	CrosswordHeight = MCrosswordHeight[indice];
	Words = MWords[indice];
	
	WordLength = MWordLength[indice];
	
	Word = MWord[indice];
	Clue = MClue[indice];
	AnswerHash = MAnswerHash[indice];
	WordX = MWordX[indice];
	WordY = MWordY[indice];
	LastHorizontalWord = MLastHorizontalWord[indice];
	OnlyCheckOnce = false;
//Fin de las modificaciones
	
// EclipseCrossword (C) Copyright 2000-2012 Green Eclipse.
// The puzzle itself remains the property of its creator. Do not remove this copyright notice.

var BadChars = "`~!@^*()_={[}]\\|:;\"',<>/?1234567890";

var TableAcrossWord, TableDownWord;
var CurrentWord, PrevWordHorizontal, x, y, i, j;
var CrosswordFinished, Initialized;

// Check the user's browser and then initialize the puzzle.
if (document.getElementById("waitmessage") != null)
{
	document.getElementById("waitmessage").innerHTML = "Por favor espera mientras se carga el crucigrama...";
	
	// Current game variables
	CurrentWord = -1;
	PrevWordHorizontal = false;
	
	// Create the cell-to-word arrays.
	TableAcrossWord = new Array(CrosswordWidth);
	for (var x = 0; x < CrosswordWidth; x++) TableAcrossWord[x] = new Array(CrosswordHeight);
	TableDownWord = new Array(CrosswordWidth);
	for (var x = 0; x < CrosswordWidth; x++) TableDownWord[x] = new Array(CrosswordHeight);
	for (var y = 0; y < CrosswordHeight; y++)
		for (var x = 0; x < CrosswordWidth; x++)
		{
			TableAcrossWord[x][y] = -1;
			TableDownWord[x][y] = -1;
		}
	
	// First, add the horizontal words to the puzzle.
	for (var i = 0; i <= LastHorizontalWord; i++)
	{
		x = WordX[i];
		y = WordY[i];
		for (var j = 0; j < WordLength[i]; j++)
		{
			TableAcrossWord[x + j][y] = i;
		}
	}
	
	// Second, add the vertical words to the puzzle.
	for (var i = LastHorizontalWord + 1; i < Words; i++)
	{
		x = WordX[i];
		y = WordY[i];
		for (var j = 0; j < WordLength[i]; j++)
		{
			TableDownWord[x][y + j] = i;
		}
	}
	
	// Now, insert the crossword table.
	document.writeln("<table id=\"crossword\" cellpadding=\"0\" cellspacing=\"0\" style=\"display: none; border-collapse: collapse;\">");
	for (var y = 0; y < CrosswordHeight; y++)
	{
		document.writeln("<tr>");
		for (var x = 0; x < CrosswordWidth; x++)
		{
			if (TableAcrossWord[x][y] >= 0 || TableDownWord[x][y] >= 0)
				document.write("<td id=\"c" + PadNumber(x) + PadNumber(y) + "\" class=\"ecw-box ecw-boxnormal_unsel\" onclick=\"SelectThisWord(event);\">&nbsp;</td>");
			else
				document.write("<td><\/td>");
		}
		document.writeln("<\/tr>");
	}
	document.writeln("<\/table>");
	
	// Finally, show the crossword and hide the wait message.
	Initialized = true;
	document.getElementById("waitmessage").style.display = "none";
	document.getElementById("crossword").style.display = "block";
}

// * * * * * * * * * *
// Event handlers

// Raised when a key is pressed in the word entry box.
function WordEntryKeyPress(event)
{
	if (CrosswordFinished) return;
	// Treat an Enter keypress as an OK click.
	if (CurrentWord >= 0 && event.keyCode == 13) OKClick();
}

// * * * * * * * * * *
// Helper functions

// Called when we're ready to start the crossword.
function BeginCrossword()
{
	if (Initialized)
	{
		document.getElementById("welcomemessage").style.display = "";
		document.getElementById("checkbutton").style.display = "";
	}
}

// Returns true if the string passed in contains any characters prone to evil.
function ContainsBadChars(theirWord)
{
	for (var i = 0; i < theirWord.length; i++)
		if (BadChars.indexOf(theirWord.charAt(i)) >= 0) return true;
	return false;
}

// Pads a number out to three characters.
function PadNumber(number)
{
	if (number < 10)
		return "00" + number;
	else if (number < 100)
		return "0" + number;
	else
		return "" +  number;
}

// Returns the table cell at a particular pair of coordinates.
function CellAt(x, y)
{
	return document.getElementById("c" + PadNumber(x) + PadNumber(y));
}

// Deselects the current word, if there's a word selected.  DOES not change the value of CurrentWord.
function DeselectCurrentWord()
{
	if (CurrentWord < 0) return;
	var x, y, i;
	
	document.getElementById("answerbox").style.display = "none";
	ChangeCurrentWordSelectedStyle(false);
	CurrentWord = -1;
	
}

// Changes the style of the cells in the current word.
function ChangeWordStyle(WordNumber, NewStyle)
{
	if (WordNumber< 0) return;
	var x = WordX[WordNumber];
	var y = WordY[WordNumber];
	
	if (WordNumber<= LastHorizontalWord)
		for (i = 0; i < WordLength[WordNumber]; i++)
			CellAt(x + i, y).className = NewStyle;
	else
		for (i = 0; i < WordLength[WordNumber]; i++)
			CellAt(x, y + i).className = NewStyle;
}

// Changes the style of the cells in the current word between the selected/unselected form.
function ChangeCurrentWordSelectedStyle(IsSelected)
{
	if (CurrentWord < 0) return;
	var x = WordX[CurrentWord];
	var y = WordY[CurrentWord];
	
	if (CurrentWord <= LastHorizontalWord)
		for (i = 0; i < WordLength[CurrentWord]; i++)
			CellAt(x + i, y).className = CellAt(x + i, y).className.replace(IsSelected ? "_unsel" : "_sel", IsSelected ? "_sel" : "_unsel");
	else
		for (i = 0; i < WordLength[CurrentWord]; i++)
			CellAt(x, y + i).className = CellAt(x, y + i).className.replace(IsSelected ? "_unsel" : "_sel", IsSelected ? "_sel" : "_unsel");
}

// Selects the new word by parsing the name of the TD element referenced by the 
// event object, and then applying styles as necessary.
function SelectThisWord(event)
{
	if (CrosswordFinished) return;
	var x, y, i, TheirWord, TableCell;
	
	// Deselect the previous word if one was selected.
	document.getElementById("welcomemessage").style.display = "none";
	if (CurrentWord >= 0) OKClick();
	DeselectCurrentWord();
	
	// Determine the coordinates of the cell they clicked, and then the word that
	// they clicked.
	var target = (event.srcElement ? event.srcElement: event.target);
	x = parseInt(target.id.substring(1, 4), 10);
	y = parseInt(target.id.substring(4, 7), 10);
	
	// If they clicked an intersection, choose the type of word that was NOT selected last time.
	if (TableAcrossWord[x][y] >= 0 && TableDownWord[x][y] >= 0)
		CurrentWord = PrevWordHorizontal ? TableDownWord[x][y] : TableAcrossWord[x][y];
	else if (TableAcrossWord[x][y] >= 0)
		CurrentWord = TableAcrossWord[x][y];
	else if (TableDownWord[x][y] >= 0)
		CurrentWord = TableDownWord[x][y];

	PrevWordHorizontal = (CurrentWord <= LastHorizontalWord);
	
	// Now, change the style of the cells in this word.
	ChangeCurrentWordSelectedStyle(true);
	
	// Then, prepare the answer box.
	x = WordX[CurrentWord];
	y = WordY[CurrentWord];
	TheirWord = "";
	var TheirWordLength = 0;
	for (i = 0; i < WordLength[CurrentWord]; i++)
	{
		// Find the appropriate table cell.
		if (CurrentWord <= LastHorizontalWord)
			TableCell = CellAt(x + i, y);
		else
			TableCell = CellAt(x, y + i);
		// Add its contents to the word we're building.
		if (TableCell.innerHTML != null && TableCell.innerHTML.length > 0 && TableCell.innerHTML != " " && TableCell.innerHTML.toLowerCase() != "&nbsp;")
		{
			TheirWord += TableCell.innerHTML.toUpperCase();
			TheirWordLength++;
		}
		else
		{
			TheirWord += "&bull;";
		}
	}
	
	document.getElementById("wordlabel").innerHTML = "Pista: "+TheirWord;
	document.getElementById("wordinfo").innerHTML = ((CurrentWord <= LastHorizontalWord) ? "Horizontal, " : "Vertical, ") + WordLength[CurrentWord] + " letras.";
	document.getElementById("wordclue").innerHTML = Clue[CurrentWord];
	document.getElementById("worderror").style.display = "none";
	document.getElementById("cheatbutton").style.display = (Word.length == 0) ? "none" : "";
	if (TheirWordLength == WordLength[CurrentWord])
		document.getElementById("wordentry").value = TheirWord.replace(/&AMP;/g, '&');
	else
		document.getElementById("wordentry").value = "";
	
	// Finally, show the answer box.
	document.getElementById("answerbox").style.display = "block";
	try
	{
		document.getElementById("wordentry").focus();
		document.getElementById("wordentry").select();
	}
	catch (e)
	{
	}
	
}

// Called when the user clicks the OK link.
function OKClick()
{
	var TheirWord, x, y, i, TableCell;
	if (CrosswordFinished) return;
	if (document.getElementById("okbutton").disabled) return;
	
	// First, validate the entry.
	TheirWord = document.getElementById("wordentry").value.toUpperCase();
	if (TheirWord.length == 0)
	{
		DeselectCurrentWord();
		return;
	}
	if (ContainsBadChars(TheirWord))
	{
		document.getElementById("worderror").innerHTML = "Debes escribir solo letras.";
		document.getElementById("worderror").style.display = "block";
		return;
	}
	if (TheirWord.length < WordLength[CurrentWord])
	{
		document.getElementById("worderror").innerHTML  = "Te faltan algunas letras.  Esta palabra tiene " + WordLength[CurrentWord] + " letras.";
		document.getElementById("worderror").style.display = "block";
		return;
	}
	if (TheirWord.length > WordLength[CurrentWord])
	{
		document.getElementById("worderror").innerHTML = "Esta palabra solo tiene " + WordLength[CurrentWord] + " letras.";
		document.getElementById("worderror").style.display = "block";
		return;
	}
	
	// If we made it this far, they typed an acceptable word, so add these letters to the puzzle and hide the entry box.
	x = WordX[CurrentWord];
	y = WordY[CurrentWord];
	for (i = 0; i < TheirWord.length; i++)
	{
		TableCell = CellAt(x + (CurrentWord <= LastHorizontalWord ? i : 0), y + (CurrentWord > LastHorizontalWord ? i : 0));
		TableCell.innerHTML = TheirWord.substring(i, i + 1);
	}
	DeselectCurrentWord();
}

// Called when the "check puzzle" link is clicked.
function CheckClick()
{
	var i, j, x, y, UserEntry, ErrorsFound = 0, EmptyFound = 0, TableCell;
	if (CrosswordFinished) return;
	DeselectCurrentWord();
	
	for (y = 0; y < CrosswordHeight; y++)
	for (x = 0; x < CrosswordWidth; x++)
		if (TableAcrossWord[x][y] >= 0 || TableDownWord[x][y] >= 0)
		{
			TableCell = CellAt(x, y);
			if (TableCell.className == "ecw-box ecw-boxerror_unsel") TableCell.className = "ecw-box ecw-boxnormal_unsel";
		}
		
	for (i = 0; i < Words; i++)
	{
		// Get the user's entry for this word.
		UserEntry = "";
		for (j = 0; j < WordLength[i]; j++)
		{
			if (i <= LastHorizontalWord)
				TableCell = CellAt(WordX[i] + j, WordY[i]);
			else
				TableCell = CellAt(WordX[i], WordY[i] + j);
			if (TableCell.innerHTML.length > 0 && TableCell.innerHTML.toLowerCase() != "&nbsp;")
			{
				UserEntry += TableCell.innerHTML.toUpperCase();
			}
			else
			{
				UserEntry = "";
				EmptyFound++;
				break;
			}
		}
		UserEntry = UserEntry.replace(/&AMP;/g, '&');
		// If this word doesn't match, it's an error.
		if (HashWord(UserEntry) != AnswerHash[i] && UserEntry.length > 0)
		{
			ErrorsFound++;
			ChangeWordStyle(i, "ecw-box ecw-boxerror_unsel");
		}
	}
	
	// If they can only check once, disable things prematurely.
	if ( OnlyCheckOnce )
	{
		CrosswordFinished = true;
		document.getElementById("checkbutton").style.display = "none";
	}
	
	// If errors were found, just exit now.
	if (ErrorsFound > 0 && EmptyFound > 0)
		document.getElementById("welcomemessage").innerHTML = ErrorsFound + (ErrorsFound > 1 ? " palabras incorrectas" : " palabra incorrecta") + " y " + (EmptyFound > 1 ? " faltan " : " falta")+ EmptyFound  + " palabras.";
	else if (ErrorsFound > 0)
		document.getElementById("welcomemessage").innerHTML = ErrorsFound + (ErrorsFound > 1 ? " palabras incorrectas" : " palabra incorrecta") + ".";
	else if (EmptyFound > 0)
		document.getElementById("welcomemessage").innerHTML = "&Aacute;nimo! Faltan " + EmptyFound + (EmptyFound > 1 ? " palabras" : " palabra") + ".";
	
	if (ErrorsFound + EmptyFound > 0)
	{
		document.getElementById("welcomemessage").style.display = "";
		return;
	}
			
	// They finished the puzzle!
	CrosswordFinished = true;
	document.getElementById("checkbutton").style.display = "none";
	document.getElementById("congratulations").style.display = "block";
	document.getElementById("welcomemessage").style.display = "none";
}

// Called when the "cheat" link is clicked.
function CheatClick()
{
	if (CrosswordFinished) return;
	var OldWord = CurrentWord;
	document.getElementById("wordentry").value = Word[CurrentWord];
	OKClick();
	ChangeWordStyle(OldWord, "ecw-box ecw-boxcheated_unsel");
}

// Returns a one-way hash for a word.
function HashWord(Word)
{
	var x = (Word.charCodeAt(0) * 719) % 1138;
	var Hash = 837;
	var i;
	for (i = 1; i <= Word.length; i++)
		Hash = (Hash * i + 5 + (Word.charCodeAt(i - 1) - 64) * x) % 98503;
	return Hash;
}