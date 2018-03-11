<?php

/*
 * @file Allow to put some content in gridview filer column.
 * @author Nick Denry
 */

namespace nickdenry\grid;

use Yii;
use yii\helpers\Html;
use yii\grid\ActionColumn;
use yii\helpers\ArrayHelper;

/**
 * Render GridView yii\grid\ActionColumn with some content filter cell.
 *
 * @author Nick Denry
 */
class FilterContentActionColumn extends ActionColumn
{
    public $filterContent;

    public $buttonAdditionalOptions = [
        'view' => ['class' => ''],
        'update' => ['class' => ''],
        'delete' => ['class' => ''],
    ];

    public $deleteConfirmText = 'Are you sure you want to delete this item?';

    /**
     * Get button additional options by name.
     * @param string $name Button name as it's written in template
     * @return array button options array
     */
    protected function getButtonAdditionalOptions($name)
    {
        return isset($this->buttonAdditionalOptions[$name]) ? $this->buttonAdditionalOptions[$name] : [];
    }

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
        $this->initDefaultButton('view', 'eye-open');
        $this->initDefaultButton('update', 'pencil');
        $this->initDefaultButton('delete', 'trash', [
            'data-method' => 'post',
        ]);
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
                $additionalOptions = ArrayHelper::merge($additionalOptions, $this->getButtonAdditionalOptions($name));
                $options = array_merge($basicOptions, $deleteConfirmation, $additionalOptions, $this->buttonOptions);
                $icon = Html::tag('span', '', ['class' => "glyphicon glyphicon-$iconName"]);
                return Html::a($icon, $url, $options);
            };
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function renderDataCellContent($model, $key, $index)
    {
        return preg_replace_callback('/\\{([\w\-\/]+)\\}/', function ($matches) use ($model, $key, $index) {
            $name = $matches[1];
            if (isset($this->visibleButtons[$name])) {
                $isVisible = $this->visibleButtons[$name] instanceof \Closure
                    ? call_user_func($this->visibleButtons[$name], $model, $key, $index)
                    : $this->visibleButtons[$name];
            } else {
                $isVisible = true;
            }
            if ($isVisible && isset($this->buttons[$name])) {
                $url = $this->createUrl($name, $model, $key, $index);
                $additionalOptions = $this->getButtonAdditionalOptions($name);
                return call_user_func($this->buttons[$name], $url, $model, $key, $additionalOptions);
            }
            return '';
        }, $this->template);
    }
}
