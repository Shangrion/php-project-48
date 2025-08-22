# gendiff

Утилита для сравнения двух файлов: JSON и YAML.

## Статус

[![Actions Status](https://github.com/Shangrion/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Shangrion/php-project-48/actions)
[![Quality Gate Status](https://sonarcloud.io/api/project_badges/measure?project=Shangrion_php-project-48&metric=alert_status)](https://sonarcloud.io/summary/new_code?id=Shangrion_php-project-48)
[![Coverage](https://sonarcloud.io/api/project_badges/measure?project=Shangrion_php-project-48&metric=coverage)](https://sonarcloud.io/summary/new_code?id=Shangrion_php-project-48)

## Установка

```bash
git clone https://github.com/Shangrion/php-project-48.git
cd php-project-48
make install
```

## Использование

```bash
gendiff file1.json file2.json
```

## Форматы вывода

По умолчанию используется формат `stylish`.  
Доступные форматы:

- `stylish`
- `plain`
- `json`

Пример использования:

```bash
gendiff --format plain file1.json file2.json


**Результат:**

```text
{
  - follow: false
    host: hexlet.io
  - proxy: example.com
  - timeout: 50
  + timeout: 20
  + verbose: true
}
```

```bash
gendiff file1.yml file2.yml
```

**Результат:**

```text
{
  - follow: false
    host: hexlet.io
  - proxy: example.com
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

[Посмотреть запись терминала JSON](https://asciinema.org/a/GHxlaF9pqT4cP9QVafOnPiy7r)
[Посмотреть запись терминала YML](https://asciinema.org/a/cmtdsZZudUy4zLSbZwcwG8ySQ)