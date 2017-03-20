//function, which work with photo
var opicanieCategory = document.getElementById('opicanieCategory').innerText;
function handleFileSelect(evt) 
{
	var files = evt.target.files; // FileList object
		// Loop through the FileList and render image files as thumbnails.
	for (var i = 0, f; f = files[i]; i++) 
	{
			// Only process image files.
		if (!f.type.match('image.*')) 
		{
			continue;
		}
			var reader = new FileReader();
			// Closure to capture the file information.
		reader.onload = (function(theFile) 
		{
			return function(e) 
			{
				var span = document.getElementById('backgroundImage');
				span.src = e.target.result;				
			};
		})(f);
			// Read in the image file as a data URL.
		reader.readAsDataURL(f);
		document.getElementById('categoryInf').submit();
	}
}
		
function reset () {
	alertify.set({
		labels : {
			ok     : "OK",
			cancel : "Cancel"
		},
		delay : 5000,
		buttonReverse : false,
		buttonFocus   : "ok"
	});
}
		
$("#prompt").on('click', function () {
	reset();
	alertify.prompt("Введите описание категории", function (e, str) {
		if (e) {
			document.getElementById('opicanie').value = str;
			document.getElementById('categoryInf').submit();
		} else {
			alertify.error("You've clicked Cancel");
		}
	}, opicanieCategory);
	return false;
});
		
document.getElementById('loadBackgroundImg').addEventListener('change', function(e){handleFileSelect(e)}, false);