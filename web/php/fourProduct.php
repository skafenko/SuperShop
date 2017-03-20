
</script>
<?php
			$amountOfPopularItems = 0;
			$amountPopularItemsOnSite = 4;
			
			foreach ($resultArray as $array)
			{	
				$amountOfPopularItems++;
				$idPopularItems = $array['id'];
				$namePopularItem = $array['nameitem'];
				$pricePopularItem = $array['price'];
				$oldPricePopularItem = "";
				$category = $array['category'];
				$displayNone = "";
				$label = "";
				$idItem = $amountOfNewItems + $amountOfPopularItems;
				/*if ($amountOfPopularItems > $amountPopularItemsOnSite)
				{
					$displayNone = "style='display:none;'";
				}*/
				foreach ($array as $key => $value)
				{
					if ($key != '0')
					{
						if ($key == 'oldprice' && $pricePopularItem < $value) $oldPricePopularItem = $value." ".$currency;
						if ($key == 'label' && $value != 'no') $label = "<img src='images/".$value.".png' alt='".$value."'>";
					}
				}
					echo "<form method='POST' name='".$idItem."' action='product.php' class='floatLeft product_price' onClick='showItem(".$idItem.")' id='".$idItem."' ".$displayNone.">
								<div class='wrap'>
									 <div class='image'>".$label."
									 <img src='".$items."/".$category."/".$idPopularItems."/1.jpg' alt='".$category."-".$idPopularItems."' height='240px'></div>
									 <div class='namePrice'>
										<p class='floatLeft'>".$namePopularItem."</p> 
										<em>".$pricePopularItem." ".$currency."</em>
										<span>".$oldPricePopularItem."</span>
									</div>
								 </div>
								 <input type='text' name='idItem' class='hidden' value='".$idPopularItems."'>
							</form>";
				
			}
			
		?>