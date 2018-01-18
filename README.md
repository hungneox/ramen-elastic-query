# Ramen Elastic Query

Fluent Pseudo-SQL query builder for Elasticsearch built on top of [Lumen Elasticsearch](https://github.com/digiaonline/lumen-elasticsearch)


# Installation

Add the following line to bootstrap/app.php:

```php
$app->register(Neox\Ramen\Elastic\ElasticQueryServiceProvider::class);
```

# Usage

## Simple select

### Object initiation or Facade both work

```php
$builder = app(Builder::class);

$result = $builder
	->use('content') // collection
	->from('article') // type
	->find('TIYKtQX', '_id', ['id', 'title', 'description']);
            
$result = ES::use('content')
		->from('article')
		->find('TIYKtQX', '_id', ['id', 'title', 'description']);
```

### Normal where clause
```php
$result = $builder->select('id', 'description')
			->from('recipe')
			->where('id', $id)
			->get();
```

### Fulltext match

```php
$result = $builder->from('person') // select * by default
			->where('name', 'like', 'smith')
			->orderBy('age', 'desc')
			->get();
```
