<form action="" name="step2" method="POST" id="supply" class="<?php echo $step2; ?>">
	<legend class="floatLeft" id="adress">
		<p>Адрес доставки</p>
		<label for="town">Город:</label><br><input type="text" name="town" id="town"
													placeholder="Город" 
													pattern="^[A-Za-zА-Яа-яЁё-\s]+$" 
													value="<?php echo $town; ?>"
													title="Пример : Москва" required ><br>
		<label for="street">Улица:</label><br><input type="text" name="street" id="street"
													placeholder="Улица" 
													value="<?php echo $street; ?>"
													pattern="^[A-Za-zА-Яа-яЁё0-9-.\s]+$" 
													title="Пример : ул. Московская" required ><br>
		<div class="floatLeft"><label for="house">Дом:</label><br><input type="text" name="house" id="house"
													placeholder="Дом"
													value="<?php echo $house; ?>"													
													pattern="^[A-Za-zА-Яа-яЁё0-9-\s]+$" 
													title="Пример : 14а,15, 16-а" required></div>
		<label for="flat">Квартира:</label><br><input type="text" 
													name="flat" 
													id="flat" 
													value="<?php echo $flat; ?>"
													pattern="^[0-9\s]+$" 
													placeholder="Квартира"><br>
		<input type="submit" name="continue2" value="Продолжить">
	</legend>
	<legend class="floatLeft" id="delivery">
		<p>Способ доставки</p>
		<input type="radio" class="radio" name="delivery" id="POST" value="Почта России с наложенным платежом" checked ><label class="label" for="POST" >Почта России с наложенным платежом</label><br><br>
		<input type="radio" class="radio" name="delivery" id="Courier" value="Курьерская доставка с оплатой при получении"><label class="label" for="Courier">Курьерская доставка с оплатой при получении</label><br><br>
		<input type="radio" class="radio" name="delivery" id="QIWI" value="Доставка через терминалы QIWI Post"><label class="label" for="QIWI">Доставка через терминалы QIWI Post</label>
	</legend>
	<legend class="floatLeft" id="comments">
		<p>Комментарий к заказу</p>
		<label for="yourComment">Введите ваш комментарий:</label><br>
		<textarea name="yourComment" id="yourComment" placeholder="Введите ваш комментарий"></textarea>
	</legend>
	<div class="clear"></div>
</form>