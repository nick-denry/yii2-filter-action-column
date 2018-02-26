<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">ActionColumn with filter content support for yii2 GridView</h1>
    <br>
</p>

Preview
-------
Width [AdminLTE] (https://github.com/dmstr/yii2-adminlte-asset)

![Preview](https://user-images.githubusercontent.com/1450983/36687251-1a90755a-1b3a-11e8-88d9-9f13ccca7b1f.png)




Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nick-denry/yii2-filter-action-column
```

or add

```
"nick-denry/yii2-filter-action-column": "^0.1.0"
```

to the require section of your `composer.json` file.

Usage
-----

1. In your GridView view

```php
use nickdenry\grid\FilterContentActionColumn;
```

2. Replace your default `ActionColumn` with

```php
[
    'class' => FilterContentActionColumn::className(),
    // Add your own filterContent
    'filterContent' => function()
    {
        return '<div class="btn-group"> '.
            Html::a('<i class="fa fa-search"></i> Search', ['#'], [
              'class' => 'btn btn-default search-filter', 'title' => 'Find page',
            ]).
            Html::a('<i class="fa fa-times"></i>', [''], [
              'class' => 'btn btn-default reset-search-filter', 'title' => 'Reset filter',
            ]).
        '</div>';
    },
    'filterOptions' => [
        'class' => 'action-column'
    ],
    'header'=> '',
    'headerOptions' => ['width' => 150],
],
```

3. Extension styles GridView default buttons with these classes by default

```php
'view' => ['class' => 'btn btn-default btn-sm'],
'update' => ['class' => 'btn btn-default btn-sm'],
'delete' => ['class' => 'btn btn-danger btn-sm'],
```
Change this via `buttonAdditionalOptions` property.

```php
[
    'class' => FilterContentActionColumn::className(),
    // Set custom classes
    'buttonAdditionalOptions' => [
        'view' => ['class' => ['btn btn-lg btn-success']],
        // Or unset
        'update' => ['class' => []],
        'delete' => ['class' => []],
    ],
    ...
    // Add your own filterContent
],

```

or via `buttons` as usual:

```php
'buttons' => [
    'view' => function($url, $model, $key) {
        return Html::a(
            Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]),
            ['some/url'],
            [
                'class' => 'btn btn-default btn-sm',
                'target' => '_blank',
        ]);
    }
],
```

4. Customise delete confirmation text with `deleteConfirmText` property

```php
[
    'class' => FilterContentActionColumn::className(),
    // Confirmation text
    'deleteConfirmText' => function($model) {
        return 'Are you sure you want to delete "'.$model->title.'" page?';
    },
    ...
    // Add your own filterContent
],
```

or simply

```php
[
    'class' => FilterContentActionColumn::className(),
    // Confirmation text
    'deleteConfirmText' => 'Custom confirmation',
    ...
    // Add your own filterContent
],
```
