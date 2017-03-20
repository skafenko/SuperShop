var lastId = 0;
var maxId = document.getElementById('maxId').innerText;
var currentId = -1;
function changeImage(id)
{
	currentId = id;
	var idAlt = document.getElementById(id).alt;
	var basicImage = document.getElementById('basicImage');
	basicImage.src = idAlt;
	id += "_1";
	document.getElementById(id).style.border = "2px solid #000000";
	
	if (lastId == 0)
		lastId = id;
	else
	{
		document.getElementById(lastId).style.border = "2px solid #fff";
		lastId = id;
	}
		
}

function changeImageByArrow(direction)
{
	switch(direction){
		case "left":
			var nextId = parseInt(currentId) + 1;
			if (nextId == 0)
				nextId = maxId;
			break;
		case "right":
			var nextId = parseInt(currentId) -1;
			if (nextId < maxId)
				nextId = -1;
			break;
	}
	
	changeImage(nextId);
}

function buyItem(id)
{
	var variants = document.getElementById('variants');
	if (variants == null)
	{
		document.getElementById(id).submit();
	}
	else
		variants.submit();
}


