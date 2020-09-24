Installation
============

Make sure Composer is installed globally, as explained in the
[installation chapter](https://getcomposer.org/doc/00-intro.md)
of the Composer documentation.

Applications that use Symfony Flex
----------------------------------

Open a command console, enter your project directory and execute:

```console
$ composer require coka/service-discovery-bundle
```

Applications that don't use Symfony Flex
----------------------------------------

### Step 1: Download the Bundle

Open a command console, enter your project directory and execute the
following command to download the latest stable version of this bundle:

```console
$ composer require coka/service-discovery-bundle
```

### Step 2: Enable the Bundle

Then, enable the bundle by adding it to the list of registered bundles
in the `config/bundles.php` file of your project:

```php
// config/bundles.php

return [
    // ...
    Oka\ServiceDiscoveryBundle\OkaServiceDiscoveryBundle::class => ['all' => true],
];
```

### Step 3: Configure the Bundle

Add the following configuration in the file `config/packages/oka_service_discovery.yaml`.

```yaml
# config/packages/oka_service_discovery.yaml
oka_service_discovery:
    cache_id: cache.app
    load_balancing_algorithm: round-robin
    dsn: 'php://array'
    options:
        # Put the options of PHP Array Catalog
        services:
          localhost:
            - scheme: 'http'
              host: 127.0.0.1
              port: 80
            - scheme: 'http'
              host: 127.0.0.1
              port: 8080
            - scheme: 'https'
              host: 127.0.0.1
              port: 443
```
