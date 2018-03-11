<p align="center">
    <a href="https://github.com/yiisoft" target="_blank">
        <img src="https://avatars0.githubusercontent.com/u/993323" height="100px">
    </a>
    <h1 align="center">ActionColumn with filter content support for yii2 GridView</h1>
    <br>
</p>

Preview
-------
With [AdminLTE](https://github.com/dmstr/yii2-adminlte-asset)

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


1. Setup

    1.1. In your GridView view

    ```php
    use nickdenry\grid\FilterContentActionColumn;
    ```

    1.2. Replace your default `ActionColumn` with

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
        /* Another actionColumn options */
    ],
    ```

2. Additional options per action button

    Extension provides GridView action buttons additional options by name, i.e.

    Set individual class per each button:

    ```php
    [
        'class' => FilterContentActionColumn::className(),
        // Set custom classes
        'buttonAdditionalOptions' => [
            'view' => ['class' => 'btn btn-lg btn-success'],
            'update' => ['class' => 'btn btn-default btn-sm'],
            'delete' => ['class' => 'btn btn-danger btn-sm'],
        ],
        ...
        // Add your own filterContent
    ],
    ```

    or set `buttons` as usual:

    ```php
    'buttons' => [
        'view' => function($url, $model, $key) {
            return Html::a(
                Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]),
                ['some/url'],
                [
                    'class' => 'btn btn-default btn-sm', // Here is simple string class
                    'target' => '_blank',
            ]);
        }
    ],
    ```

3. Setup buttons classes per application.

    3.1. Via DI in your app config

    ```php
    'container' => [
        'definitions' => [
            nickdenry\grid\FilterContentActionColumn::class => [
                'buttonAdditionalOptions' => [
                    'view' => ['class' => 'btn btn-default btn-sm'],
                    'update' => ['class' => 'btn btn-default btn-sm'],
                    'delete' => ['class' => 'btn btn-danger btn-sm'],
                    // You could also set your "extra" button class
                    // like you point it in "template" option
                    // i.e. 'template' => '{view} {update} {delete} {extra}',
                    'extra' => ['class' => 'btn btn-success btn-sm'],
                ],
            ],
        ],
    ],
    ```

    Additional information:
    - [Using Yii2 Configurations](http://www.yiiframework.com/doc-2.0/guide-concept-configurations.html#application-configurations)
    - [Example on stackoverflow](https://stackoverflow.com/a/27210083/5434698)

    3.2. If you want to override default button, but keep it's "global" per-application class

    ```php
    'view' => function($url, $model, $key, $additionalOptions) {
        return Html::a(
            Html::tag('span', '', ['class' => "glyphicon glyphicon-eye-open"]),
            ['some/url'],
            [
                'class' => $additionalOptions['class'],
                'target' => '_blank',
            ]
        );
    },
    ```

4. Customize delete confirmation text

    via `deleteConfirmText` property

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
