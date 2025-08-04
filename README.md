# gendiff

Утилита для сравнения двух JSON-файлов.

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

## Демо (аскинема)
 
[https://asciinema.org/a/GHxlaF9pqT4cP9QVafOnPiy7r](https://asciinema.org/a/GHxlaF9pqT4cP9QVafOnPiy7r)

### Hexlet tests and linter status:
[![Actions Status](https://github.com/Shangrion/php-project-48/actions/workflows/hexlet-check.yml/badge.svg)](https://github.com/Shangrion/php-project-48/actions)