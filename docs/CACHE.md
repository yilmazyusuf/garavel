## Cache Kullanımı
1. [Laravel Eloquent Query Cache](https://github.com/renoki-co/laravel-eloquent-query-cache "Laravel Eloquent Query Cache")
2. [Medium Doc](https://medium.com/swlh/cache-eloquent-queries-in-laravel-6-af722c09a6f7 "Medium Doc")


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
 ##### Full Automatic Invalidation
    protected static $flushCacheOnUpdate = true; //created, updated, deleted, forceDeleted or restored   
    
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


