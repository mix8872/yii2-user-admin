RBAC Manager for Yii 2
======================

This is a fork of [mdmsoft/yii2-admin](https://github.com/mdmsoft/yii2-admin)

- [Change Log](CHANGELOG.md).

Installation
------------

### Install With Composer

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require mix8872/yii2-user-admin "dev-master"
```

Or, you may add

```
"mix8872/yii2-user-admin": "dev-master"
```

to the require section of your `composer.json` file and execute `php composer.phar update`.

Usage
-----

Once the extension is installed, simply modify your application configuration as follows:

```php
return [
    'modules' => [
        'user-admin' => [
            'class' => 'mix8872\useradmin\Module',
            ...
        ]
        ...
    ],
    ...
    'as access' => [
        'class' => 'mix8872\useradmin\components\AccessControl',
        'allowActions' => [
            'site/*',
            'admin/*',
            'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
];
```
See [Yii RBAC](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html#role-based-access-control-rbac) for more detail.


If you use database (class 'yii\rbac\DbManager') to save rbac data, execute the migration here:
```
yii migrate --migrationPath=@yii/rbac/migrations
```

If you wand add to user fields: img and display_name, execute the migration here:
```
yii migrate --migrationPath=@vendor/mix8872/user-admin/src/migrations
```
