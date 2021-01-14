###### Garavel

# **Laravel Core Paket**

## Gereksinimler

1. Laravel 6.X

    ``composer create-project --prefer-dist laravel/laravel blog "6.*"``
2. PHP 7.3

## Kurulum


`production ortamı için SSL sertifikası yükleyiniz. Canlı ortamda bütün adresler https e yönlendirilecektir.`
### 1. .env Veri Tabanı Ayarları
.env dosyanızda veritabanı ayarlarınızı güncelleyiniz.

### 2. Laravel Gereksinimlerin kurulması
#### `composer require laravel/ui:"1.1"`
#### `php artisan ui bootstrap --auth`



### 3. TmdCore Paketin Yüklenmesi
composer.json içerisine aşağıdaki kaynağı ekleyiniz. 
Gitlab SSH key iniz yok ise composer.json içindeki config alanına
"secure-http":false ekleyip  repository url i

    "repositories": [
        {
            "type": "vcs",
            "url": "git@gitlab.tmd:kurumsal-icerik/tmdcore.git"
        }

    ]

Terminalden paketi yükleyiniz

#### `composer require tmdcore/core`
#### `php artisan tmdcore:install`
    
## Cache Kullanımı
##### Cacheables
None Taggable `use TmdCore\Traits\FileQueryCacheable;`
Taggable `use Rennokki\QueryCache\Traits\QueryCacheable;`

    class Book extends Model
     {
         public $cacheFor = 3600; // equivalent of ->cacheFor(3600)
     
         public $cacheTags = ['books']; // equivalent of ->cacheTags(['books'])
     
         public $cachePrefix = 'books_' // equivalent of ->cachePrefix('books_');
     
         public $cacheDriver = 'dynamodb'; // equivalent of ->cacheDriver('dynamodb');
     }
    
##### Modele ait genel Cache Silinmesi
    Kid::flushQueryCache();
##### Datatable Row Query Kullanımı
    $collection = $events->cachePrefix('albums')->get();
    return datatables()->of($collection)
                    ->setTransformer(new AlbumTransformer())
                    ->toJson();
                    
##### Datatable Eloquent Kullanımı                    
    return datatables()->eloquent($events->cachePrefix('albums'))
        ->setTransformer(new AlbumTransformer())
        ->toJson();
##### Relational Kullanım
	$user = User::with(['orders' => function ($query) {
    return $query
        ->cacheFor(60 * 60)
        ->cacheTags(['my:orders']);
    }])->get();                    
                      
    
## İçerdiği Ek Paketler

1. [Laravel Telescope](https://laravel.com/docs/6.x/telescope "Laravel Telescope")
2. TMD Authentication
3. doctrine/dbal
4. [Invisible Recaptcha](https://github.com/albertcht/invisible-recaptcha "Invisible Recaptcha")
5. [Laravel Eloquent Query Cache](https://github.com/renoki-co/laravel-eloquent-query-cache "Laravel Eloquent Query Cache")
   
#### @TODO
3. CDN entegrasyonu
4. ~~Cache Modülü (Model + Query Cache)~~
5. settingslerin cachelenmesi
6. Cache Silme modülü
7. ~~Hata mesajlarının gösterimi ve Loglanması (Telescope) a aktarılması~~
8. ~~app.css, app.js default gelmesi (upgrade 3)~~
9. ~~intended redirection after login~~
10. ~~Default Kullanıcının kullanıcı oluşturmaya zorlandıktan sonra silinmesi~~
12. ~~Docker altında Cronjob ların çalıştırılması~~
13. Personelin users tablosuna aktarılıp güncel kalmasını sağlayabilecek bir bileşen
14. 2 maddedeki gerekli paketlerin install komutu altına alınması
15. Laravel 7 ye geçiş
16. javascript ve css dosyalarının versiyonlanması


14. Menu Target Blank
15. FileManager Fixed Crop size  
16. Formların Ajax olmadan çalışması
17. Multiple Mesaj gösterimi
18. adminlte\publishes dosyalarının stubs a çekilmesi
19. Menülerde 3. kırılımdan sonra seçili gelmemesi
20. Telescope Advanced Log
21. Laravel Datatable xss
22. yeni versiyon yayınlanınca slack bildirim gönder
23. (tmdcore:api-location {country,city,}) Ülke İl İlçe Mahalle (Seeder) (tuik source) isteyen import edebilsin, güncellendiğinde tüm projelerde güncellensin
24. Rol ve yetkilerde default ayarlar değiştirilememeli
25. Ayarların gruplanarak listelenmesi (Kategori)
26. Default Dashboard düzenlemesi
27. Datatable Responsive sorunu
28. Redis Cache Container
29. Ip adreslerinde DNS name e zorla
30. Disklerde file tipine göre filesize ayarlayabilme (filemanager veya laravel trigger)
31. App Service Provider setlocale(LC_TIME, 'tr_TR.utf8'); //Carbon {{$weekDay->formatLocalized('%d %B %Y %A')}}
32 Croppie (1140px in üzerindeki tüm resimlerde boşluk sorunu var altındakilerde sorun yok)

1. ~~Ayarlar Modülü , Tmdauth un ayarlar modülüne çekilmesi~~
2. ~~Captcha Modülü (Reload sorunu csrf)~~
3. ~~Ajax Captcha Kullanımı~~
4. ~~Migration ve Seederların sadece core tarafına alınması~~
5. ~~LDAP ayarlarının Ayarlar modülüne aktarılması~~
11. ~~Linkleri production SSL force conf~~
2. ~~Settings Controller publish edilecek~~
1. ~~Common gitlab ssh test sunucusuna atalım~~

#### Önemli Notlar
1. production ortamında https e yönlendirecektir.
2. Telescope loglar yoğun kullanımda DB de fazla yer tutabilir,nelerin loglanması gerektiğini ayarlamanız tavsiye edilir.
3.   Redirect If Authenticated
    if (Auth::guard($guard)->check()) {
               //return redirect(RouteServiceProvider::HOME);
                   return redirect()->intended(RouteServiceProvider::HOME);
               }
           
           
#### CHANGELOG
###### 2.0
1. Captcha Modülü Eklendi
2. Migration ve Seed sınıfları Adminlte den core tarafına çekildi
3. Upgrade sınıfı ve komutu  oluşturuldu
4. Seed komutu oluşturuldu
5. laravel seed komutu manuel dump-auoload yapılmadan çalışması sağlandı
6. Ayarlar Modülü  geliştirildi
7. Tmd auth ayarları settings tablosuna aktarıldı
8. helper sınıfı oluşturuldu ve paket composer.json a tanımlandı
9. Package Info Trait sınıfı oluşturuldu
10. Dökümanlar sadeleştirilip güncellendi
11. Bazı küçük hatalar giderildi
12. Ayarlar linki menüye eklendi
13. setting tablosuna yeni alanlar eklendi
14. config/tmdauth dosyası silindi
15. .env dosyasından tmdauth bilgileri silindi



Datatable alertlerin kapatılması
 $.fn.dataTable.ext.errMode = 'none';

Bunlar Ayarlara alınabilir.
Auth::routes([
    'register' => false, // Registration Routes...
    'reset'    => false, // Password Reset Routes...
    'verify'   => false, // Email Verification Routes...
]);


