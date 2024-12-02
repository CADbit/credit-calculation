# Instrukcja

## Środowisko

- Rekomendujemy syystem operacyjny Linux Ubuntu 24.04.1 LTS
- Zainstalowany loklanie pakiet PHP w wersji 8.3
- Zainstalowane CLI 'symfony' - [link](https://symfony.com/download)
- Konfiguracja bibliotek pod framework Symfony 7.2.x zgodnie z wymaganiami dostawcy - [link](https://symfony.com/doc/current/setup.html)
- Dodana paczka do obslugi PHP SQLLite - [link](https://dev.to/nkrumahthis/how-to-install-php-sqlite3-for-php-81-on-ubuntu-2110-50fp)
- Oczywiście pamiętaj o narzędziu Composer - [link](https://getcomposer.org/download/)

## Instalacja

1. Zrób klon repozytorium do loklanej instancji.
2. Jeżeli posiadasz symfony-cli to sprawdź czy spełniasz wszystkie wymagania

> symfony check:requirements

3. Główny proces instalacji w katalogu projektu

> composer install
> 
> php bin/db
 
### Po instalacji

1. Generowanie kluczy dla JWT

> php bin/console lexik:jwt:generate-keypair

Powinny pojawić się w katalogu config/jwt

2. Uruchomienie serwera symfony - port domyślny 8080, można zmienić w pliku lub przy użyciu argumentu '-p 8080'

> php bin/start-server

3. Dokumentacja REST API pod adresem: [http://127.0.0.1:8080/api/doc](http://127.0.0.1:8080/api/doc)
4. Generowanie tokena JWT przez ukryty end-point [http://127.0.0.1:8080/api/login](http://127.0.0.1:8080/api/login).

Budowa body jako JSON:
```
{
    "username": "user",
    "password": "password"
}
```
Zwrotka:
```
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3MzMxMzE5MjAsImV4cCI6MTczMzEzNTUyMCwicm9sZXMiOlsiUk9MRV9VU0VSIl0sInVzZXJuYW1lIjoiYWRtaW4ifQ.ItCGrNVrp-muppMbKB0EOjlMMnI64A2ALgDeoMsCKsJ4Bx7UHyqNEzwkz_VmQl5Ed1sEHqM0BHg06rzy9FESTQuZkB_gZZMjIvQZqkIQLib6GeenEIIlVBFBoa69L2aPP1SDSeSA5IrAv2ET6hQRE0SbOosH_1yLR-UBkU577_E5bohHTUv1ncosjmk50ErjAWz06opBDSUny-gTQhU0a0BSPomUom2bVGCiftziQQCJpB19bdns6ztHO8o99gQaO3yGUpFBK4rMQyKn6KxK4SpfkmD9_6EF7n09F2AYflhydYjMF8pIECYROhb465lYXr91A9g7rE-XjTCN3SpEBw"
}
```

### Have Fun ;-)
