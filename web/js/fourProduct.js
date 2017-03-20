var counterForNewItems = 0;
			var amountOfPopularItems = parseInt(document.getElementById('amountPopularItems').innerHTML);
			var amountOfNewItems = parseInt(document.getElementById('amountNewItems').innerHTML);
			var counterForPopularItems = amountOfNewItems;
			function arrowRight(divAmountItems, size)
			{
				var amountId = document.getElementById(divAmountItems).innerHTML;
				var ourCounter = 0;
				
				//choose counter
				if (amountId == amountOfNewItems)
					ourCounter = counterForNewItems;
				else 
				{
					ourCounter = counterForPopularItems;
					amountId = amountOfPopularItems + amountOfNewItems;
				}
				
				
				//for change items
				for (var i = 1; i <= size; i++)
				{
					if (ourCounter + size + 1 > amountId) break;
					
					ourCounter++;
					var idOpen = ourCounter + size;
					
					document.getElementById(ourCounter).style.display="none";
					document.getElementById(idOpen).style.display="block";

				}
				//return counter
				if (amountId == amountOfNewItems)
					counterForNewItems = ourCounter;
				else 
					counterForPopularItems = ourCounter;
			}
			
			function arrowLeft(divAmountItems, size)
			{
				var amountId = document.getElementById(divAmountItems).innerHTML;
				var ourCounter = 0;
				
				//choose counter
				if (amountId == amountOfNewItems)
					ourCounter = counterForNewItems;
				else 
				{
					ourCounter = counterForPopularItems;
					amountId = amountOfPopularItems + amountOfNewItems;
				}
				
				var idClose = ourCounter + size;
				for (var i = 1; i <= size; i++)
				{	
					if (ourCounter == 0 || ourCounter == amountOfNewItems)break;
					
					document.getElementById(idClose).style.display="none";
					document.getElementById(ourCounter).style.display="block";
					idClose--;
					ourCounter--;
				}
				
				//return counter
				if (amountId == amountOfNewItems)
					counterForNewItems = ourCounter;
				else 
					counterForPopularItems = ourCounter;
			}
			
			function showItem(id)
			{
				document.getElementById(id).submit();
			}
			