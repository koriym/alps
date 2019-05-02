# PHP ALPS

A utility for [ALPS](http://alps.io/spec/) (Application-Level Profile Semantics)

## Install


```bash
composer require koriym/alps
```

## Usage

```php
$alps = new Alps(__DIR__ . '/profile.json');

var_dmp($alps->descriptors);
var_dmp($alps->rels);

```
