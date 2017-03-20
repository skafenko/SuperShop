

function changeDisplay(id)
{
	var doc = "";
	var doc = document.getElementById(id);
	
	if(doc.className != "hidden") 
	{
		doc.className = 'hidden';
	}
	else
	{
		doc.className = "";
	}
}