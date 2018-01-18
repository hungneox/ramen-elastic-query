# Ramen Elastic Query

Fluent Pseudo-SQL query builder for Elasticsearch built on top of [Lumen Elasticsearch](https://github.com/digiaonline/lumen-elasticsearch)


# Installation

# Usage

## Simple select

```php
$result = ES::select('id', 'description')
			->from('recipe')
			->where('id', $id)
			->get();
```

```php
$result = ES::use('content')
			->from('article')
            ->find('TIYKtQX', '_id', ['id', 'title', 'description']);
```

```php
$result = ES::from('person') // select * by default
			->where('name', 'like', 'smith')
			->orderBy('age', 'desc')
			->get();
```
