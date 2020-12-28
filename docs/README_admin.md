###### Turkuvaz Medya Kurumsal

# **Laravel AdminLTE Paket**


## Gereksinimler

1. Laravel 6.X
2. PHP 7.3
3. tmdcore/core Paketi

## Kurulum

### Paketin Yüklenmesi
composer.json içerisine aşağıdaki kaynağı ekleyiniz.

    "repositories": [
        {
            "type": "vcs",
            "url": "git@gitlab.tmd:kurumsal-icerik/tmdadminlte.git"
        }
    ]

Terminalden paketi yükleyiniz

#### `composer require tmdcore/adminlte`
#### `php artisan adminlte:install`



## Güncellenen Dosyalar
### 1.Spatie Rol ve Yetkiler Güncellendi
#### `app/Http/Kernel.php`

    protected $routeMiddleware = [
        // ...
        'role' => \Spatie\Permission\Middlewares\RoleMiddleware::class,
        'permission' => \Spatie\Permission\Middlewares\PermissionMiddleware::class,
        'role_or_permission' => \Spatie\Permission\Middlewares\RoleOrPermissionMiddleware::class,
    ];

### 2.Auth Driver
#### `config/auth.php`

        'providers' => [
            'users' => [
                'driver' => 'eloquent',
                'model' => \TmdCore\AdminLte\Base\Model\AdminLteUserModel::class
            ],


### 3.Telescope un yetkilendirilmesi (Sadece super_admin rolüne sahip kullanıcılar)
#### `app\Providers\TelescopeServiceProvider.php`

    protected function authorization()
    {
        Telescope::auth(function ($request) {
            $user = $request->user();
            return $user->hasRole('super_admin');
        });
    } 
### 4.Route
#### `routes\web.php`

    Auth::routes();      



## View Dosyalarının Güncellenmesi
AdminLte paketi ile hazır gelen view ve layoutlarda değişiklik yapılmak isteniyorsa aynı dosya ismi ve yoluna ait dosyayı
`resources/views/vendor/adminlte` klasörü içerisinde oluşturmak yeterli olacaktır.
## İçerdiği  Paketler

1. [AdminLTE V3](https://adminlte.io/themes/v3/index.html "AdminLTE V3")
2. [Spatie](https://docs.spatie.be/laravel-permission/v3/installation-laravel/ "Spatie")
3. [Laravel Data Table](https://yajrabox.com/docs/laravel-datatables/master/ "Data Table")
4. [Data Table Demos](https://datatables.yajrabox.com/eloquent/basic "Data Table Demos")
5. [File Manager](https://webmai.ru/projects/file-manager "File Manager")
6. [Croppie](https://foliotek.github.io/Croppie/ "Croppie")
7. [Intervention](http://image.intervention.io/ "Intervention")



### Croppie

Formatlar
https://laravel.com/docs/8.x/validation#rule-image
`jpeg, png, bmp, gif, svg, or webp`

    composer update
    php artisan vendor:publish --tag=adminlte-project
    php artisan vendor:publish --tag=tmdcore-seeds
    composer dump-autoload
    php artisan db:seed --class=CroppiePermissionSeeder

##### Form Dışına
``{!! Croppie::render('default','croppie_uploader','title_image_url') !!}``
*  default:  /config/croppie.php dosyasındaki isim
*  croppie_uploader:  croppie belirtici
*  title_image_url :  güncellenecek gizli resim input id si ve resmi

##### Form içine 
    <a href="javascript:;" class="croppie_uploader">Seçiniz</a>
    <input type="hidden" id="title_image_url" name="title_image_url" value="">
    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==" id="title_image_url" class="img-fluid" >




### UPGRADE 2 (MENU YÖNETİMİ)
    composer require tmdcore/adminlte 2.0
    php artisan vendor:publish --tag=adminlte-menu
    php artisan migrate
    composer dump-autoload
    php artisan db:seed --class=MenuSeeder
    php artisan permission:cache-reset
    
### Kullanıcı Kayıt, sifre sıfırlama ve hesap onaylama linklerinin devre dışı bırakılması
    Auth::routes([
        'register' => false, // Registration Routes...
        'reset'    => false, // Password Reset Routes...
        'verify'   => false, // Email Verification Routes...
    ]);
