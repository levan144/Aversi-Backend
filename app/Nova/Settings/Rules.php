<?php

namespace App\Nova\Settings;
use Whitecube\NovaFlexibleContent\Flexible;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Panel;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Murdercode\TinymceEditor\TinymceEditor;

class Rules extends AbstractType
{
    public function fields(): array
    {
        return [
            new Panel(__('Content'), $this->generalFields()),
            new Panel(__('Meta Tags'), $this->metaFields()),
           
        ];
    }

    protected function generalFields()
    {
        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    TinymceEditor::make(__('Content'), 'content_ka'),
                    // Trix::make(__('Content'), 'content_ka'),
                ]),
                new Tab(__("English"), [
                    TinymceEditor::make(__('Content'), 'content_en'),
                    // Trix::make(__('Content'), 'content_en'),
                    
                ]),
                new Tab(__("Russian"), [
                    TinymceEditor::make(__('Content'), 'content_ru'),
                    // Trix::make(__('Content'), 'content_ru'),
                   
                ]),
            ]),
        ];
    }
    
    protected function metaFields()
    {
        return [
           new Tabs(__("Meta Tags"), [
               new Tab(__("Georgian"), [
                   Text::make(__('Meta Title'), 'meta_title_ka'),
                   Text::make(__('Meta Description'), 'meta_description_ka'),
               ]),
               new Tab(__("English"), [
                   Text::make(__('Meta Title'), 'meta_title_en'),
                   Text::make(__('Meta Description'), 'meta_description_en'),
               ]),
               new Tab(__("Russian"), [
                   Text::make(__('Meta Title'), 'meta_title_ru'),
                   Text::make(__('Meta Description'), 'meta_description_ru'),
               ]),
           ]),
        ];
        
    }
}
