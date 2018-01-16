# Ramen Elastic Query

Fluent Pseudo-SQL query builder for Elasticsearch


# Installation

# Usage

## Simple select

```php
$result = Elastic::select('id', 'description')
			->from('recipe')
			->where('id', $id)
			->get();
```


```php
$result = Elastic::from('person') // select * by default
			->where('name', 'like', 'smith')
			->orderBy('age', 'desc')
			->get();
```
