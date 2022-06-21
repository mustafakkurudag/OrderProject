# PathProject
Path için geliştirdiğim symfony restful servis projesi.

## Sipariş takip sistemi
- localhost:8000/api/login_check adresinden sisteme kullanıcı girişi yapılır. Başarılı giriş sonucunda **jwt token** sonuç olarak döner. Bu token ile işlemleri yapmadan önce doğrulama yapmanız gerekmektedir. Doğrulama tipi **Bearer**'dır. Token'ın geçerlilik süresi 1 saattir.

## 3 adet kullanıcı vardır.
>1. kullanıcı:<br>
>username: customer1@abc.com <br>password: 12345
<br>

>2. kullanıcı:<br>
>username: customer2@abc.com <br>password: 54321

>3. kullanıcı:<br>
>username: customer3@abc.com <br>password: 15243

- Kullanıcı parolaları veritabanında şifrelenmiş olarak saklanmaktadır.

> localhost:8000/api/order adresinden **GET** yöntemiyle kullanıcı "kendi yapmış olduğu" siparişleri listeleyebilir.

> localhost:8000/api/order/new adresinden **POST** yöntemiyle kullanıcı yeni sipariş oluşturabilir. Postman'de JSON şeklinde aşağıdaki gibi sipariş oluşturabilir.<br>
>{
    "orderCode": "234qwe567asd", //elle oluşturuluyor.
    "product": 2,
    "quantity":3,
    "address":"Sivas"
}<br>
>- Sipariş detay bilgilerinden id, user, shippingDate otomatik olarak oluşmaktadır. shippingDate sipariş verilen günden 3 gün sonrasıdır.

> localhost:8000/api/order/edit/{id} adresinden **POST** yöntemiyle **id** değerine göre, kullanıcı daha önce yapmış olduğu siparişi eğer teslimat günü geçmemişse güncelleyebilir. Postman'de JSON şeklinde aşağıdaki gibi sipariş bilgileri güncellenebilir.<br>
>{
    "product": 2,
    "quantity":3,
    "address":"Sivas"
}<br>
>- id, orderCode, user, shippingDate sipariş için sabit bilgilerdir.

> localhost:8000/api/order/show/{id} adresinden **GET** yöntemiyle **id** değerine göre, kullanıcı daha önce yapmış olduğu sipariş detayını görüntüleyebilir.

- Veritabanı dosyasını proje klasörü içinde bulabilirsiniz.
- Json formatlı Postman collection dosyasını proje klasörü içinde bulabilirsiniz.
