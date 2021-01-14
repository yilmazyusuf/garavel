###### Garavel

# **Kaynakların Filitrelenmesi**


TmdCore Filitre ile Laravel Eloquent Collection ları otomatik filitreleyebilir,QueryBuilder ı filitreler ile genişletebilirsiniz.

Filitreleme yapılırken laravel query string baz alınır.

Örn : /users?name=er&last_name=&company_id=2&roles[]=1&roles[]=4&roles[]=7&industry=5



#### Kurulum
    composer update tmdcore/core
   
#### Konsoldan Filitre Oluşturmak İçin
` App/Http/Filters Klasörüne oluşturacaktır.`  


    php artisan tmdcore:make-filter {FilitreAdı}

    örn : php artisan tmdcore:make-filter TestFilter

##### 4 Farklı Kaynak Tipi Filitrelenebilir

1. Collections (https://laravel.com/docs/6.x/collections)
2. Eloquent Collections (https://laravel.com/docs/6.x/eloquent-collections)
3. Query Builder (https://laravel.com/docs/6.x/queries)
4. Eloquent Query Builder (https://laravel.com/docs/6.x/eloquent)


#### Bazı Örnekler
###### 1. Collections
    DB::table('users')->get();
    DB::table('roles')->pluck('title', 'name');
    
###### 2. Eloquent Collections
    User::all();
    User::where('status',1)->get();  
      
###### 3. Query Builder
    DB::table('users')->where('name', 'John');
    DB::table('users')->select('name', 'email as user_email') 
          
###### 4. Eloquent Query Builder
    App\Flight::where('active', 1)
                   ->orderBy('name', 'desc')
                   ->take(10)
                   
    App\Flight::where('number', 'FR 900')                   

###### 5. Eloquent Relationlal Query Builder
    FILTER::PARAM_METHOD => function ($query, $daily_date) {
        return $query->whereHas('publication_daily' , function ($query) use($daily_date) {
            $query->where('daily_date', $daily_date);
        });
        
        $publications = Publication::with(['publication_daily', 'distribution_company']);
        $filter = new DailyPublicationFilter($publications);
        $publications = $filter->getEloquentBuilder()->get();
                            
#### Filitreyi Çağırma

###### Collection
    $users = Users::all();
    $filter = new TestFilter($users);
    $filtered = $filter->getCollection();

###### Eloquent Builder

    $users = Users::where('status',1);
    $filter = new TestFilter($users);
    $filtered = $filter->getEloquentBuilder()->get();
    
###### Query Builder

    $users = DB::table('users')->where('status',1);
    $filter = new TestFilter($users);
    $filtered = $filter->getQueryBuilder()->get();    
    
#### Örn. Filitre
```php
<?php

namespace App\Http\Filters;

use TmdCore\Filter\Filter;

class TestFilter extends Filter
{
    /**
     * @return array
     */
    public function filters():array
    {

        $params = [
            [
                FILTER::PARAM_NAME => 'user_id',
                FILTER::PARAM_RULES => 'required|numeric',
                FILTER::PARAM_METHOD => function ($query, $parameterValue) {
                    return $query->where('status', 3);
                },
                //FILTER::PARAM_METHOD => FILTER::METHOD_EQUAL,
                FILTER::PARAM_FORMAT_VALUE => function($value){
                    return $value * 3;
                },
                FILTER::PARAM_PREFIX            => 'id',
                FILTER::PARAM_DEFAULT_VALUE     => 2,
            ],
            [
                FILTER::PARAM_NAME => 'status',
                FILTER::PARAM_METHOD => FILTER::METHOD_EQUAL,
                FILTER::PARAM_RULES => 'min:5',
                FILTER::PARAM_DEFAULT_VALUE     => 2,
            ]
        ];

        return $params;
      


    }
}
```