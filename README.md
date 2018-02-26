<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">ActionColumn with filter content support for yii2 gridview</h1>
    <br>
</p>

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

2. Replace your default action column with

```php
[
    'class' => FilterContentActionColumn::className(),
    // Add your own filterContent
    'filterContent' => function()
        {
            return '<div class="btn-group"> '.
                Html::a('<i class="fa fa-search"></i> Найти', ['#'], ['class' => 'btn btn-default search-filter', 'title' => 'Find page',]).
                Html::a('<i class="fa fa-times"></i>', [''], ['class' => 'btn btn-default reset-search-filter', 'title' => 'Reset filter',]).
            '</div>';
        },
    'filterOptions' => [
        'class' => 'action-column'
    ],
    'header'=> '',
    'headerOptions' => ['width' => 150],
],
```
