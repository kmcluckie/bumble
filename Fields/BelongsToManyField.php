<?php namespace Monarkee\Bumble\Fields;

class BelongsToManyField extends Field
{
    /**
     * Makes sure the field is set up with all
     * the options it needs before proceeding
     */
    public function setUp()
    {
        if (!isset($this->options['related_title_column']))
        {
            throw new Exception('BelongsToManyField requires option `related_title_column` to be set');
        }
    }

    public function getWidgetType()
    {
        return $this->hasOption('widget') ? $this->getOption('widget') : $this->viewPrefix . '.BelongsToManyField';
    }

    public function method()
    {
        return $this->getOption('method');
    }

    public function getRelatedTitleColumn()
    {
        return $this->hasOption('related_title_column') ? $this->getOption('related_title_column') : $this->title;
    }

    public function getRelatedTitle()
    {
        return $this->hasOption('related_title') ? ucwords($this->getOption('related_title')) : $this->getTitle();
    }

    public function process($model, $input)
    {
        $column = $this->getColumn();

        if(isset($input[$column])) {
        	$model->{$column}()->sync($input[$column]);
        }

        return $model;
    }
}
