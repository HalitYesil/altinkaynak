# altinkaynak
Altınkanak exchange rate information

## Initialize

```php

use Altinkaynak\Altinkaynak;

require_once 'src/Autoload.php';

$Altinkaynak = new Altinkaynak();
```

## GetCurrency
Instant exchange rate information

```php
  var_dump($Altinkaynak->GetCurrency());
```

## GetGold
Instant gold rate information

```php
  var_dump($Altinkaynak->GetGold());
```

## GetMain
Instantly selected exchange rate, gold rate and parity information

```php
  var_dump($Altinkaynak->GetMain());
```
