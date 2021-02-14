Örnek olarak gönderilen ekran görüntüsünden yola çıkarak istenen case'i Laravel ile hazırlamaya çalıştım. Öncelikle belirtmek isterim ki; başlangıçta yapmayı planladığım pek çok şeyi zaman kısıtı sebebiyle kırpmak zorunda kaldım. Bunları tek tek açıklayacağım. Neleri nasıl yaptığımı anlatarak başlamak istiyorum.

## Demo

http://ce7in.com

## API Bot

Lokasyon: packages/ce7in/laravel-openweather

Package içerisinde bir obje olarak tasarlamamın sebebi geliştirilebilir ve yönetilebilir olmasıydı. Bu case'de çok fazla gerek olmadığının farkındayım ancak API'leri paketler halinde hazırlama ve kullanma alışkanlığım var. Daha modüler ve sürdürülebilir oluyor.

Obje içerisindeki metodlara statik olarak erişebilmek için Laravel'in Facade yapısından faydalandım.

Başlangıçta daha performanslı bir çağırım olması açısından şehirlerin ilk çağırımı tamamlandıktan ve city id ilgili tabloya kaydedildikten sonra city id'yi çağırım metodu olarak kullanmak amacındaydım. Sadece ilk çağırım city name ve country code ile olacaktı, ancak bunun zaman alacağını gördüğüm için bunu kırpmam gerekti. Sınıfın yapısı da ilk hazırladığım gibi kaldı.

Anlık hava durumu her 5 dakikada bir kontrol ediliyor, saatlik olan da her saat başı. Bunun için Laravel'in Jobs yapısını kullandım. Forge ile deploy ettiğim için yine Forge'a ait bir özellik olan schedular ile her 5 dakikada bir Job Queue'yu kontrol ettiriyorum.

cd /ce7in.com && php artisan schedule:run >> /dev/null 2>&1

Forge üzerinde yukarıdaki talimat bu işi gerçekleştiriyor.

Jobs Location: app/Jobs

Aynı zamanda admin panel üzerinden yeni bir şehir eklendiğinde yine Jobs özelliği ile şehre ait veriler otomatik olarak anında çekiliyor.

## Database Yapısı

Normal şartlarda Laravel bu iş için Model yapısını kullanıyor ancak ben veritabanı işlemlerinin ayrı bir Repository katmanı ile gerçekleştirilmesi taraftarıyım. Çünkü Laravel her bir veriye bir Model objesi olarak yaklaşıyor. Hem verinin bir model objesi olması, hem de tüm verilerin yönetiminin yine model üzerinden yapılması çok temiz bir yöntem gibi gelmiyor. O yüzden genel yönetimin Repository ile yapılmasının daha uygun olduğunu düşünüyorum. Bunun bir diğer avantajı da olası driver değişikliklerinde ortaya çıkıyor. Model katmanına hiç dokunmadan, sadece Repository katmanı üzerinden tüm işlemler gerektiği gibi düzenlenebiliyor.

Lokasyon: app/Repositories

## Admin

Laravel'in mevcut Auth yapısını kullandım. Oldukça kullanışlı ve güvenli olduğunu düşünüyorum. Aslına bakarsanız kapsamlı fakat çok özel ihtiyaçları olmayan admin panellere ihtiyacım olduğunda Laravel Nova'yı kullanıyorum. İşleri inanılmaz hızlandırıyor. Pek çok şeyi otomatik olarak çözüyor. CRUD işlemleri zaten çoğu zaman farklı ihtiyaçlara sahip olmuyor. Bunları tekrar tekrar sıfırdan yazmanın bir anlamı olmadığını düşünüyorum. Olsa bile Nova ile gayet başarılı bir şekilde yürüyebiliyorum. Onunla bir SaaS projesi bile geliştirilebilir.

## Logolar ve İkonlar

Bunları tamamen rastgele seçtim. Sonuçta sıfırdan tasarlayacak vaktim yoktu.

## Yapmaya Zaman Bulamadıklarım

Her ne kadar bir case projesi olsa da çok daha iyi bir sonuç ortaya koymayı isterdim. Gerek front-endde gerekse de back-endde. Ancak bunlar için yeterli zamana sahip olmak gerekiyor.

- Test caseler yazmak.
- Front-endde css, js, font ve image kullanımının performansa dönük optimizasyonu (Progressive loading, deferring etc.)
- Daha optimize bir Api istek yapısı oluşturmak ve performans testlerine tabi tutmak.
- Admin panelin daha işlevsel olması. En azından düzenleme - silme - ana sayfada görülecek şehirlerin sıralanması gibi temel işlevleri ekleyebilmek.
- Kod sayfalarına detaylı yorum satırları eklemek.
- Exception yapıları ve hataların yakalanarak sistemin çalışmasına engel olmamasını sağlamak.
