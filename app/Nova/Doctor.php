<?php

namespace App\Nova;
use Eminiarts\Tabs\Tab;
use Eminiarts\Tabs\Tabs;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Gravatar;
use Laravel\Nova\Fields\ID;
use Laravel\Nova\Fields\Password;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\MorphToMany;
use Laravel\Nova\Fields\BelongsToMany;
use Laravel\Nova\Fields\HasMany;
use \Itsmejoshua\Novaspatiepermissions\PermissionsBasedAuthTrait;
use \Itsmejoshua\Novaspatiepermissions\Role;
use \Itsmejoshua\Novaspatiepermissions\Permission;
use Dniccum\PhoneNumber\PhoneNumber;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Http\Requests\NovaRequest;
use Kongulov\NovaTabTranslatable\NovaTabTranslatable;
use Outl1ne\MultiselectField\Multiselect;
use Whitecube\NovaFlexibleContent\Flexible;
use Storage;
use Laravel\Nova\Panel;
use Laravel\Nova\Fields\KeyValue;
use Laravel\Nova\Fields\Image;
use App\Models\Branch;
use App\Models\Specialty;
class Doctor extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\Doctor::class;
    public static $group = 'Users';
    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'name';
    public static function label() {
        return __('Doctors');
    }

    public static function singularLabel() {
        return __('Doctor');
    }

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id','name->ka','email'
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            ID::make()->sortable(),
            
            NovaTabTranslatable::make([
                Text::make(__('Name'), 'name')
                    ->sortable()
                    ->rules('required_lang:ka', 'max:255'),
            ])->hideFromIndex(),
            Image::make(__('Avatar'), 'photo')
            ->disk('public')
            ->path('doctors')
            ->prunable()
            ->preview(function ($value, $disk) {
                return $value
                            ? Storage::disk($disk)->url($value)
                            : null;
            }),
            PhoneNumber::make(__('Phone number'), 'phone')
                ->format('###-##-##-##')
                ->disableValidation()
                ->sortable(),

            Text::make(__('Email'), 'email')
                ->sortable()
                ->rules('required', 'email', 'max:254')
                ->creationRules('unique:doctors,email')
                ->updateRules('unique:doctors,email,{{resourceId}}'),

            Select::make(__('Gender'), 'gender')
                ->options([
                'male' => __('Male'),
                'female' => __('Female'),
                ]),

            Date::make(__('Birthday'), 'birthday'),
            
           
        
            
            Number::make(__('Personal Number'), 'sid')
                ->sortable()
                ->rules('required', 'max:11'),
              
            new Panel(__('More details'), $this->moreDetailsFields()),
            new Panel(__('Index details'), $this->onlyTableFields()),
            

            // Boolean::make(__('Verified'), 'phone_verified_at')
            //     ->trueValue(1, __('Yes'))
            //     ->falseValue(0, __('No')),

            Password::make(__('Password'), 'password')
                ->onlyOnForms()
                ->creationRules('required', 'string', 'min:6')
                ->updateRules('nullable', 'string', 'min:6'),
            MorphToMany::make(__('Roles'), 'roles', Role::class),
            MorphToMany::make(__('Permissions'), 'permissions', Permission::class),
        ];
    }

    protected function moreDetailsFields()
    {
        return [
            Multiselect::make(__('Branches'), 'branch_ids')->options(
                 Branch::all()->pluck('title', 'id')
            ),

            Multiselect::make(__('Specialty'), 'specialty_ids')->options(
                 Specialty::all()->pluck('title', 'id')
            ),
            //ჩამოსაშლელი გაკეთდეს, ქართული, ინგლისური, ფრანგული, რუსული თავიდან ... დანარჩენი მივამატო
            Multiselect::make(__('Languages'), 'languages')->options(
                 $this->languageList()
            )->onlyOnForms(),


            

            Multiselect::make(__('Languages'), 'languages')->options(
                 $this->languageList()
            )->exceptOnForms(),


            new Panel(__('Content'), $this->flexibleFields()),


        ];
    }

    protected function flexibleFields()
    {
          
        return [
            new Tabs(__("Additional"), [
                new Tab(__("Georgian"), [
                    Flexible::make(__('Sections'), 'additional->ka')
                        ->button(__('Add new'))
                        ->addLayout(__('Grouped Section'), 'section', [
                             Text::make(__('Title'), 'title'),
                             Flexible::make(__('Records'), 'sections')
                                ->button(__('Add new'))
                                ->addLayout(__('Text Section'), 'section', [
                                    Text::make(__('Years'), 'years'),
                                    Text::make(__('Title'), 'title'),
                                ]),
                           
                        ]),
                        ]),
                new Tab(__("English"), [
                    Flexible::make(__('Sections'), 'additional->en')
                        ->button(__('Add new'))
                        ->addLayout(__('Grouped Section'), 'section', [
                             Text::make(__('Title'), 'title'),
                             Flexible::make(__('Records'), 'sections')
                                ->button(__('Add new'))
                                ->addLayout(__('Text Section'), 'section', [
                                    Text::make(__('Years'), 'years'),
                                    Text::make(__('Title'), 'title'),
                                ]),
                           
                        ]),
                ]),
                new Tab(__("Russian"), [
                    Flexible::make(__('Sections'), 'additional->ru')
                        ->button(__('Add new'))
                        ->addLayout(__('Grouped Section'), 'section', [
                             Text::make(__('Title'), 'title'),
                             Flexible::make(__('Records'), 'sections')
                                ->button(__('Add new'))
                                ->addLayout(__('Text Section'), 'section', [
                                    Text::make(__('Years'), 'years'),
                                    Text::make(__('Title'), 'title'),
                                ]),
                           
                        ]),
                ]),
                ]),

               
          ];

          
    }

    protected function onlyTableFields()
    {
        return [
            Text::make(__('Name'), 'name')->onlyOnIndex(),
            DateTime::make(__('Registered at'),'created_at')
                ->exceptOnForms(),
            Number::make(__('Rating'), function ($model) {
                    return $model->rating();
                })
                ->sortable(),
            DateTime::make(__('Last login'),'last_login_at')
                ->exceptOnForms(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }

    private function languageList(){
        $languages_list = array(
            'en' => 'English',
            'ka' => 'Georgian - ქართული',
            'ru' => 'Russian - русский',
            'fr' => 'French - français',
            'de' => 'German - Deutsch',
            'af' => 'Afrikaans',
            'sq' => 'Albanian - shqip',
            'am' => 'Amharic - አማርኛ',
            'ar' => 'Arabic - العربية',
            'an' => 'Aragonese - aragonés',
            'hy' => 'Armenian - հայերեն',
            'ast' => 'Asturian - asturianu',
            'az' => 'Azerbaijani - azərbaycan dili',
            'eu' => 'Basque - euskara',
            'be' => 'Belarusian - беларуская',
            'bn' => 'Bengali - বাংলা',
            'bs' => 'Bosnian - bosanski',
            'br' => 'Breton - brezhoneg',
            'bg' => 'Bulgarian - български',
            'ca' => 'Catalan - català',
            'ckb' => 'Central Kurdish - کوردی (دەستنوسی عەرەبی)',
            'zh' => 'Chinese - 中文',
            'zh-HK' => 'Chinese (Hong Kong) - 中文（香港）',
            'zh-CN' => 'Chinese (Simplified) - 中文（简体）',
            'zh-TW' => 'Chinese (Traditional) - 中文（繁體）',
            'co' => 'Corsican',
            'hr' => 'Croatian - hrvatski',
            'cs' => 'Czech - čeština',
            'da' => 'Danish - dansk',
            'nl' => 'Dutch - Nederlands',
            'en-AU' => 'English (Australia)',
            'en-CA' => 'English (Canada)',
            'en-IN' => 'English (India)',
            'en-NZ' => 'English (New Zealand)',
            'en-ZA' => 'English (South Africa)',
            'en-GB' => 'English (United Kingdom)',
            'en-US' => 'English (United States)',
            'eo' => 'Esperanto - esperanto',
            'et' => 'Estonian - eesti',
            'fo' => 'Faroese - føroyskt',
            'fil' => 'Filipino',
            'fi' => 'Finnish - suomi',
            'fr-CA' => 'French (Canada) - français (Canada)',
            'fr-FR' => 'French (France) - français (France)',
            'fr-CH' => 'French (Switzerland) - français (Suisse)',
            'gl' => 'Galician - galego',
            'de-AT' => 'German (Austria) - Deutsch (Österreich)',
            'de-DE' => 'German (Germany) - Deutsch (Deutschland)',
            'de-LI' => 'German (Liechtenstein) - Deutsch (Liechtenstein)',
            'de-CH' => 'German (Switzerland) - Deutsch (Schweiz)',
            'el' => 'Greek - Ελληνικά',
            'gn' => 'Guarani',
            'gu' => 'Gujarati - ગુજરાતી',
            'ha' => 'Hausa',
            'haw' => 'Hawaiian - ʻŌlelo Hawaiʻi',
            'he' => 'Hebrew - עברית',
            'hi' => 'Hindi - हिन्दी',
            'hu' => 'Hungarian - magyar',
            'is' => 'Icelandic - íslenska',
            'id' => 'Indonesian - Indonesia',
            'ia' => 'Interlingua',
            'ga' => 'Irish - Gaeilge',
            'it' => 'Italian - italiano',
            'it-IT' => 'Italian (Italy) - italiano (Italia)',
            'it-CH' => 'Italian (Switzerland) - italiano (Svizzera)',
            'ja' => 'Japanese - 日本語',
            'kn' => 'Kannada - ಕನ್ನಡ',
            'kk' => 'Kazakh - қазақ тілі',
            'km' => 'Khmer - ខ្មែរ',
            'ko' => 'Korean - 한국어',
            'ku' => 'Kurdish - Kurdî',
            'ky' => 'Kyrgyz - кыргызча',
            'lo' => 'Lao - ລາວ',
            'la' => 'Latin',
            'lv' => 'Latvian - latviešu',
            'ln' => 'Lingala - lingála',
            'lt' => 'Lithuanian - lietuvių',
            'mk' => 'Macedonian - македонски',
            'ms' => 'Malay - Bahasa Melayu',
            'ml' => 'Malayalam - മലയാളം',
            'mt' => 'Maltese - Malti',
            'mr' => 'Marathi - मराठी',
            'mn' => 'Mongolian - монгол',
            'ne' => 'Nepali - नेपाली',
            'no' => 'Norwegian - norsk',
            'nb' => 'Norwegian Bokmål - norsk bokmål',
            'nn' => 'Norwegian Nynorsk - nynorsk',
            'oc' => 'Occitan',
            'or' => 'Oriya - ଓଡ଼ିଆ',
            'om' => 'Oromo - Oromoo',
            'ps' => 'Pashto - پښتو',
            'fa' => 'Persian - فارسی',
            'pl' => 'Polish - polski',
            'pt' => 'Portuguese - português',
            'pt-BR' => 'Portuguese (Brazil) - português (Brasil)',
            'pt-PT' => 'Portuguese (Portugal) - português (Portugal)',
            'pa' => 'Punjabi - ਪੰਜਾਬੀ',
            'qu' => 'Quechua',
            'ro' => 'Romanian - română',
            'mo' => 'Romanian (Moldova) - română (Moldova)',
            'rm' => 'Romansh - rumantsch',
            'gd' => 'Scottish Gaelic',
            'sr' => 'Serbian - српски',
            'sh' => 'Serbo-Croatian - Srpskohrvatski',
            'sn' => 'Shona - chiShona',
            'sd' => 'Sindhi',
            'si' => 'Sinhala - සිංහල',
            'sk' => 'Slovak - slovenčina',
            'sl' => 'Slovenian - slovenščina',
            'so' => 'Somali - Soomaali',
            'st' => 'Southern Sotho',
            'es' => 'Spanish - español',
            'es-AR' => 'Spanish (Argentina) - español (Argentina)',
            'es-419' => 'Spanish (Latin America) - español (Latinoamérica)',
            'es-MX' => 'Spanish (Mexico) - español (México)',
            'es-ES' => 'Spanish (Spain) - español (España)',
            'es-US' => 'Spanish (United States) - español (Estados Unidos)',
            'su' => 'Sundanese',
            'sw' => 'Swahili - Kiswahili',
            'sv' => 'Swedish - svenska',
            'tg' => 'Tajik - тоҷикӣ',
            'ta' => 'Tamil - தமிழ்',
            'tt' => 'Tatar',
            'te' => 'Telugu - తెలుగు',
            'th' => 'Thai - ไทย',
            'ti' => 'Tigrinya - ትግርኛ',
            'to' => 'Tongan - lea fakatonga',
            'tr' => 'Turkish - Türkçe',
            'tk' => 'Turkmen',
            'tw' => 'Twi',
            'uk' => 'Ukrainian - українська',
            'ur' => 'Urdu - اردو',
            'ug' => 'Uyghur',
            'uz' => 'Uzbek - o‘zbek',
            'vi' => 'Vietnamese - Tiếng Việt',
            'wa' => 'Walloon - wa',
            'cy' => 'Welsh - Cymraeg',
            'fy' => 'Western Frisian',
            'xh' => 'Xhosa',
            'yi' => 'Yiddish',
            'yo' => 'Yoruba - Èdè Yorùbá',
            'zu' => 'Zulu - isiZulu'
        );

        return $languages_list;
    }


}
