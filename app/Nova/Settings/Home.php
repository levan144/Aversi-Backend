<?php

namespace App\Nova\Settings;

use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Laravel\Nova\Fields\Boolean;
use Stepanenko3\NovaSettings\Types\AbstractType;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Image;
use Laravel\Nova\Fields\Select;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\Textarea;
use Whitecube\NovaFlexibleContent\Flexible;
// use Whitecube_lj\NovaFlexibleContent\Flexible as FlexibleLJ;
use Illuminate\Support\Facades\Storage;
use Laravel\Nova\Fields\HasMany;
use Outl1ne\MultiselectField\Multiselect;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Branch;
use App\Models\LaboratoryService;
class Home extends AbstractType
{
    public function fields(): array
    {
        return [
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
                            Textarea::make(__('Description'), 'description'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->help(
    '1920 x 1080'
)
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ]),
                        
                    ]),

                new Tab(__("English"), [
                    Flexible::make(__('Slides'), 'slides_en')
                        ->button(__('Add new'))
                        ->addLayout(__('Video Slide'), 'video', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Text::make(__('Youtube URL'), 'video')->hideFromIndex(),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ])
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->path('slides')
                                ->help(
    '1920 x 1080'
)
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ]),
                    ]),
                
                new Tab(__("Russian"), [
                    Flexible::make(__('Slides'), 'slides_ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Video Slide'), 'video', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Text::make(__('Youtube URL'), 'video')->hideFromIndex(),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        ])
                        ->addLayout(__('Photo Slide'), 'photo', [
                            Text::make(__('Title'), 'title'),
                            Textarea::make(__('Description'), 'description'),
                            Image::make(__('Image'), 'image_url')
                                ->disk('public')
                                ->prunable()
                                ->help(
    '1920 x 1080'
)
                                ->path('slides')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
                            Text::make(__('Link'), 'link'),
                            Select::make(__('Text Position'), 'text_position')->options([
                                'left' => __('Left'),
                                'center' => __('Center'),
                                'right' => __('Right'),
                            ])->rules('required')->hideFromIndex(),
                        
                    ]),
                ]),


               


            ]),
            

        ];
    }
    
    protected function modelFields()
    {
        return [
        
           Flexible::make(__('Sections'), 'sections')
           ->button(__('Add new'))
           ->addLayout(__('About us'), \App\Nova\Flexible\Layouts\OrderingLayoutAbout::class)
           ->addLayout(__('Services'), \App\Nova\Flexible\Layouts\OrderingLayoutService::class)
           ->addLayout(__('Laboratory'), \App\Nova\Flexible\Layouts\OrderingLayoutLab::class)
           ->addLayout(__('Blogs'), \App\Nova\Flexible\Layouts\OrderingLayoutBlog::class)
           ->addLayout(__('Branches'), \App\Nova\Flexible\Layouts\OrderingLayoutBranch::class)->limit(5),
            Image::make(__('Lab Cover'), 'cover_image')
                                ->disk('public')
                                ->prunable()
                                ->help(
    '1920 x 1080'
)
                                ->path('pages')
                                ->preview(function ($value, $disk) {
                                    return $value
                                                ? Storage::disk($disk)->url($value)
                                                : null;
                                })
                                ->creationRules('required'),
            Multiselect::make(__('Laboratory'), 'laboratory')->options(
                LaboratoryService::query()->pluck('title', 'id')
                ),
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