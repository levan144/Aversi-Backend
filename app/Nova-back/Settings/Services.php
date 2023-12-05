<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Trix;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasMany;
use Outl1ne\MultiselectField\Multiselect;
use App\Models\Service;
use App\Models\Blog;
class Services extends AbstractType
{
    public function fields(): array
    {
        return [
            // Boolean::make('Param 1', 'param_1'),
            // Boolean::make('Param 2', 'param_2'),
            // Boolean::make('Param 3', 'param_3'),
            new Panel(__('Content'), $this->generalFields()),
            new Panel(__('Resources'), $this->modelFields()),
            new Panel(__('Meta Tags'), $this->metaFields()),

        ];
    }

    protected function generalFields()
    {
          
         

        return [
            new Tabs(__("Content"), [
                new Tab(__("Georgian"), [
                    Flexible::make(__('Slides'), 'slides_ka')
                        ->button(__('Add new'))
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                           
                        ]),
                    
                    ]),

                new Tab(__("English"), [
                    Flexible::make(__('Slides'), 'slides_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                           
                        ]),
                    ]),
                
                new Tab(__("Russian"), [
                    Flexible::make(__('Slides'), 'slides_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            
                        
                    ]),
                ]),

            ]),
        ];
    }

    protected function modelFields()
    {
        return [
           // Multiselect::make(__('Services'), 'services')->options(
           //               Service::all()->pluck('title')
           // ),
           // Multiselect::make(__('Blogs'), 'services')->options(
           //               Blog::all()->pluck('title')
           // ),
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