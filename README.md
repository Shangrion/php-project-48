# gendiff

Утилита для сравнения двух JSON-файлов.

## Статус

[![Actions Status](https://github.com/Shangrion/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Shangrion/php-project-48/actions)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Shangrion_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Shangrion_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Shangrion_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Shangrion_php-project-48)

## Использование

```bash
gendiff file1.json file2.json
```

**Результат:**

```text
{
  - follow: false
    host: hexlet.io
  - proxy: 123.234.53.22
  - timeout: 50
  + timeout: 20
  + verbose: true
}
```

## Использование как библиотека

```php
use function Hexlet\Code\genDiff;

$diff = genDiff('file1.json', 'file2.json');
echo $diff;
```

## Демонстрация

[Посмотреть запись терминала](https://asciinema.org/a/GHxlaF9pqT4cP9QVafOnPiy7r)