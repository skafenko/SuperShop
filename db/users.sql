CREATE TABLE users(
   id       SERIAL  
  ,fio      VARCHAR(250) 
  ,phone    VARCHAR(250)
  ,mail     VARCHAR(250) unique
  ,password VARCHAR(250) 
  ,town     VARCHAR(250)
  ,street   VARCHAR(250)
  ,house    VARCHAR(250)
  ,flat     VARCHAR(250)
  ,date     VARCHAR(250)
  ,cart     TEXT [][]
);
INSERT INTO users(id,fio,phone,mail,password,town,street,house,flat,date,cart) VALUES (2,'ывкрп вар чвар','+7123456789','qaz@qaz.ru','1qazQ',NULL,NULL,NULL,NULL,'2016-07-05 09:34',NULL);
INSERT INTO users(id,fio,phone,mail,password,town,street,house,flat,date,cart) VALUES (1,'Скафенко Михайло Сергийович','380638484691','misha41192@mail.ru','Ss1','Житомир-sity','вул.Черняховського','12','2','2016-06-26 15:35','{}');
