<?php
			$amountOfPopularItems = 0;
			$amountPopularItemsOnSite = 4;
			foreach ($resultArray as $index => $array)
			{
				if (is_array($array))
				{
					$amountOfPopularItems++;
					$idPopularItems = $array['id'];
					$namePopularItem = "";
					$pricePopularItem = 0;
					$oldPricePopularItem = "";
					$category = $array[0];
					$displayNone = "";
					$label = "";
					$idItem = $amountOfNewItems + $amountOfPopularItems;
					if ($amountOfPopularItems > $amountPopularItemsOnSite)
					{
						$displayNone = "style='display:none;'";
					}
					foreach ($array as $key => $value)
					{
						if ($key != '0')
						{
							if ($key == 'id') $idPopularItems = $value;
							if ($key == 'nameitem') $namePopularItem = $value;
							if ($key == 'price') $pricePopularItem = $value;
							if ($key == 'oldprice' && $pricePopularItem < $value) $oldPricePopularItem = $value." ".$currency;
							if ($key == 'label' && $value != 'no') $label = "<img src='images/".$value.".png' alt='".$value."'>";
						}
					}
					echo "<form method='POST' name='".$idItem."' action='product.php' class='floatLeft product_price' onClick='showItem(".$amountOfPopularItems.")' id='".$idItem."' ".$displayNone.">
								<div class='wrap'>
									 <div class='image'>".$label."
									 <img src='".$path."/".$category."/".$idPopularItems."/1.jpg' alt='".$category."-".$idPopularItems."' height='240px'></div>
									 <div class='namePrice'>
										<p class='floatLeft'>".$namePopularItem."</p> 
										<em>".$pricePopularItem." ".$currency."</em>
										<span>".$oldPricePopularItem."</span>
									</div>
								 </div>
								 <input type='text' name='category' class='hidden' value='".$category."'>
								 <input type='text' name='idItem' class='hidden' value='".$idPopularItems."'>
							</form>";
				}
			}
		?>