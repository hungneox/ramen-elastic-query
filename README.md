# Ramen Elastic Query (In development)

[![Build Status](https://travis-ci.org/hungneox/ramen-elastic-query.svg?branch=master)](https://travis-ci.org/hungneox/ramen-elastic-query)

Fluent Pseudo-SQL query builder for Elasticsearch built on top of [Lumen Elasticsearch](https://github.com/digiaonline/lumen-elasticsearch)


# Installation

Run the following command to install the package through Composer:

```
composer require hungneox/ramen-elastic-query
```

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
			->where('_id', '=', $id)
			->get();
```

### Fulltext match

```php
$result = $builder
            ->use('content')
            ->select('id', 'title', 'description', 'featured')
            ->from('article')
            ->where('title', 'like', 'Auringonkukan')
            ->orderBy('featured', 'desc')
            ->get();
```

### Deletion

```php
ES::use('content')->from('article')->delete($id);
```

## License

See [LICENSE](LICENSE).
