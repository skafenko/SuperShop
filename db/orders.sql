CREATE TABLE orders(
   id       SERIAL 
  ,userid   VARCHAR(1000)
  ,status   VARCHAR(500) 
  ,symma    REAL
  ,town     VARCHAR(50) 
  ,street   VARCHAR(250) 
  ,house    VARCHAR(250) 
  ,flat     VARCHAR(250) 
  ,delivery VARCHAR(250) 
  ,comment  VARCHAR(5000)
  ,cart     TEXT [][]
  ,date     VARCHAR(50)
);
INSERT INTO orders(id,userid,status,symma,town,street,house,flat,delivery,comment,cart,date) VALUES (1,1,'отгружен',110420,'Житомир','вул.Черняховського','12',2,'Почта России с наложенным платежом',NULL,'{{76,4,empty},{42,3,черно-синий}}','2016-06-26 15:35');
INSERT INTO orders(id,userid,status,symma,town,street,house,flat,delivery,comment,cart,date) VALUES (2,2,'у курьера',15998,'ыукп','ывкп','12',NULL,'Почта России с наложенным платежом',NULL,'{{7,2,empty}}','2016-07-05 09:35');
INSERT INTO orders(id,userid,status,symma,town,street,house,flat,delivery,comment,cart,date) VALUES (3,1,'принят',17196,'Zytomir-Житомир','вул.Черняховського-street','12abc',2,'Почта России с наложенным платежом',NULL,'{{4,4,белый}}','2016-07-05 23:54');
