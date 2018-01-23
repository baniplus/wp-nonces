# WordPress Nonces Class
An OOP Composer package that allows using WordPress nonces

## Installation
Run `composer update` command with this requirements in  `composer.json` file

```bash
{
    "repositories": [
        {
            "type": "git",
            "url": "https://github.com/baniplus/wp-nonces.git"
        }
    ],
    "require": {
        "vitalie/wp-nonces": "dev-master"
    }
}
```

## How it works
After successful installation, you can autoload WP_Nonces class in your project

```php
require_once './vendor/autoload.php';
```

Make sure that is the right path to `vendor` directory.

> Use this class only in the WordPress environment.

```php
$optional_settings = array(
    'action' => '_your_action_name',
    'nonce_name' => '_your_nonce_name'
);

$wp_nonces = new WP_Nonces( $optional_settings );
```

When is created the class object you can provide, optionally, global `action` and `nonce` name.

The WP_Nonce object has following public methods:

### Message
Use to display a message to confirm the action being taken.

```php
$wp_nonces->message();
```
It uses the WordPress function `wp_nonce_ays`.

### Field
Retrieve nonce hidden field for forms.

```php
$wp_nonces->get_field();
```
And display it.

```php
$wp_nonces->field();
```
Optionaly, you can provide `action`, `name` and `referer` attributes to ovrewrite default values.

### URL
Retrieve URL with nonce added to URL query.

```php
$wp_nonces->url( 'your-url.com' );
```
Optionaly, you can provide `action` and `name` attributes to ovrewrite default values.

### Verify
Verify that correct nonce was used with a time limit.

```php
$wp_nonces->verify( 'nonce_hash' );
```
Optionaly, you can provide `action` attribute to ovrewrite default action value.

### Create
Creates a cryptographic token tied to a specific action, user, user session, and window of time.

```php
$wp_nonces->create();
```
Optionaly, you can provide `action` attribute to ovrewrite default action value.

### Check Admin Referer
Makes sure that a user was referred from another admin page.

```php
$wp_nonces->check_admin_referer();
```
Optionaly, you can provide `action` and `query_arg` (same as name) attributes to ovrewrite default values.

### Check Ajax Referer
Verifies the Ajax request to prevent processing requests external to the blog.

```php
$wp_nonces->check_ajax_referer();
```
Optionaly, you can provide `action`, `query_arg` (same as name) and `die` attributes to ovrewrite default values.

### Referer Field
Retrieve referer hidden field for forms.

```php
$wp_nonces->get_referer_field();
```
And display it.

```php
$wp_nonces->referer_field();
```
It uses the WordPress function `wp_referer_field`.

## Tests
Before run tests, you need to have set WordPress Test environment. For more information please check this guide.
[WordPress Test Guide](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/)

When your WordPress test envirenoment is ready, please edit `WP_TEST_PATH` from `phpunit.xml.dist`

```xml
<env name="WP_TEST_PATH" value="__Your_WordPress_Test_Path__" />
```

Run `PHPUnit` command to start all tests.

## Resources
- [WordPress Nonces](https://codex.wordpress.org/WordPress_Nonces)
- [WordPress Test Guide](https://make.wordpress.org/core/handbook/testing/automated-testing/phpunit/)