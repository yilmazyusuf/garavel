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



    
## Cache Kullanımı
##### Cacheables
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
3. doctrine/dbal
4. [Invisible Recaptcha](https://github.com/albertcht/invisible-recaptcha "Invisible Recaptcha")
5. [Laravel Eloquent Query Cache](https://github.com/renoki-co/laravel-eloquent-query-cache "Laravel Eloquent Query Cache")
  

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
8. helper sınıfı oluşturuldu ve paket composer.json a tanımlandı
9. Package Info Trait sınıfı oluşturuldu
10. Dökümanlar sadeleştirilip güncellendi
11. Bazı küçük hatalar giderildi
12. Ayarlar linki menüye eklendi
13. setting tablosuna yeni alanlar eklendi
14



