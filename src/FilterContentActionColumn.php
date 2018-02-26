<?php

/*
 * @file Allow to put some content in gridview filer column.
 * @author nickdenry.
 */

namespace nickdenry\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;

/**
 * Render GridView yii\grid\ActionColumn with some content filter cell.
 *
 * @author nickdenry
 */
class FilterContentActionColumn extends ActionColumn
{
    public $filterContent;

    public $buttonAdditionalOptions = [
        'view' => ['class' => 'btn btn-default btn-sm'],
        'update' => ['class' => 'btn btn-default btn-sm'],
        'delete' => ['class' => 'btn btn-danger btn-sm'],
    ];

    public $deleteConfirmText = 'Are you sure you want to delete this item?';
    /**
     * Renders the filter cell content.
     * The default implementation simply renders a space.
     * This method may be overridden to customize the rendering of the filter cell (if any).
     * @return string the rendering result
     */

    protected function renderFilterCellContent()
    {
        return $this->filterContent instanceof \Closure ? call_user_func($this->filterContent) : $this->filterContent;
    }

    /**
     * Initializes the default button rendering callbacks.
     */
    protected function initDefaultButtons()
    {
        $this->initDefaultButton('view', 'eye-open', $this->buttonAdditionalOptions['view']);
        $this->initDefaultButton('update', 'pencil', $this->buttonAdditionalOptions['update']);

        $this->initDefaultButton('delete', 'trash', ArrayHelper::merge([
            'data-method' => 'post',
        ],
        $this->buttonAdditionalOptions['delete']));
    }

    /**
     * Initializes the default button rendering callback for single button.
     * @param string $name Button name as it's written in template
     * @param string $iconName The part of Bootstrap glyphicon class that makes it unique
     * @param array $additionalOptions Array of additional options
     * @since 2.0.11
     */
    protected function initDefaultButton($name, $iconName, $additionalOptions = [])
    {
        if (!isset($this->buttons[$name]) && strpos($this->template, '{' . $name . '}') !== false) {
            $this->buttons[$name] = function ($url, $model, $key) use ($name, $iconName, $additionalOptions) {
                $deleteConfirmation = [];
                switch ($name) {
                    case 'view':
                        $title = Yii::t('yii', 'View');
                        break;
                    case 'update':
                        $title = Yii::t('yii', 'Update');
                        break;
                    case 'delete':
                        $title = Yii::t('yii', 'Delete');
                        $deleteConfirmation = [
                            'data-confirm' => $this->deleteConfirmText instanceof \Closure ?
                                call_user_func($this->deleteConfirmText, $model) : Yii::t('yii', $this->deleteConfirmText),
                        ];
                        break;
                    default:
                        $title = ucfirst($name);
                }

                $basicOptions = [
                    'title' => $title,
                    'aria-label' => $title,
                    'data-pjax' => '0',
                ];

                $options = array_merge($basicOptions, $deleteConfirmation, $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }
}
