<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Branch;
use App\Models\LaboratoryService;
use App\Models\CustomData;
class PageController extends Controller
{
    public function aboutUs($locale) {
      $page = json_decode(Settings::where('slug', 'about-us')->first(), true);
      $title = $page['title'][$locale];
      $top_description = $page['settings']["top_description_" . $locale];
      $bottom_description = $page['settings']["bottom_description_" . $locale];
      $counters = collect($page['settings']["counters_" . $locale]);
      
      //Get quantity from DB
        $customData = CustomData::whereIn('title', ['ResearchQuantitySum', 'PatientCount'])->get();
        
        $researchQuantitySum = $customData->where('title', 'ResearchQuantitySum')->first()->value;
        $patientQuantitySum = $customData->where('title', 'PatientCount')->first()->value;
        
        $counters = $counters->map(function($item) use($researchQuantitySum, $patientQuantitySum) {
            switch ($item['layout']) {
                case 'studies_item':
                    $item['attributes']['quantity'] = $researchQuantitySum;
                    break;
                case 'patients_item':
                    $item['attributes']['quantity'] = $patientQuantitySum;
                    break;
            }
            return $item;
        });
      $advantages_title = $page['settings']["advantages_title_" . $locale];
      $advantages = $page['settings']["advantages_" . $locale];
      
      //meta Tags
      $meta_title = $page['settings']['meta_title_' . $locale] ?? null;
      $meta_description = $page['settings']['meta_description_' . $locale] ?? null;
      
      
      $result = array('page_title' => $title, 'top_description' => $top_description, 'bottom_description' => $bottom_description, 
      'counters' => $counters , 'advantages_title' => $advantages_title , 'advantages' => $advantages, 'cover_image' => $page['settings']['cover_image'], 'meta' => ['title' => $meta_title, 'description' => $meta_description]);
      return response($result, 200);
    }
    

    public function medicalTourism($locale) {
      $page = json_decode(Settings::where('slug', 'medical-tourism')->first(), true);
      $title = $page['title'][$locale];
      $cover_image = $page['settings']["cover_image"];
      $section_title = $page['settings']["section_title_" . $locale];
      $section_description = $page['settings']["section_content_" . $locale];
    
      //meta Tags
      $meta_title = $page['settings']['meta_title_' . $locale] ?? null;
      $meta_description = $page['settings']['meta_description_' . $locale] ?? null;
      
      $result = array('page_title' => $title, 'section_title' => $section_title, 'section_description' => $section_description, 'cover_image' => '/app/public/' . $cover_image, 'meta' => ['title' => $meta_title, 'description' => $meta_description]);
      return response($result, 200);
    }

    public function afterGraduate($locale) {
      $page = json_decode(Settings::where('slug', 'post-graduate-studies')->first(), true);
      
      $title = $page['title'][$locale] ?? null;

      $cover_image = $page['settings']["cover_image"] ?? null;
      
      $sections = $page['settings']["sections_" . $locale] ?? null;
      
      //meta Tags
      $meta_title = $page['settings']['meta_title_' . $locale] ?? null;
      $meta_description = $page['settings']['meta_description_' . $locale] ?? null;
      
      return response(array('page_title' => $title, 'sections' => $sections, 'cover_image' => $cover_image, 'meta' => ['title' => $meta_title, 'description' => $meta_description]), 200);
    }

    public function covid($locale) {
      $page = json_decode(Settings::where('slug', 'covid')->first(), true);
      $title = $page['title'][$locale] ?? null;
      $faqs = $page['settings']['data_' . $locale] ?? null;
      //meta Tags
      $meta_title = $page['settings']['meta_title_' . $locale] ?? null;
      $meta_description = $page['settings']['meta_description_' . $locale] ?? null;
      
      return response(array('page_title' => $title, 'faqs' => $faqs, 'meta' => ['title' => $meta_title, 'description' => $meta_description]), 200);
    }

    public function services($locale) {
        // Get page settings for 'services'
        $page = Settings::where('slug', 'services')->first();
    
        if (!$page) {
            // Handle the case when there are no 'services' settings
            return response()->json(['error' => 'Page not found'], 404);
        }
    
        $settings = $page->settings;
        $title = $page->getTranslations('title')[$locale] ?? null;    
        // Get slides
	$slides = $settings['slides_' . $locale] ?? null;
    
        // Construct meta tags
        $meta = [
            'title' => $settings['meta_title_' . $locale] ?? null, 
            'description' => $settings['meta_description_' . $locale] ?? null
        ];
    
        // Prepare the result
        $result = [
            'page_title' => $title,
            'slides' => $slides,
            'meta' => $meta
        ];
    
        return response()->json($result);
    }


    public function laboratory($locale) {
        // Get page settings for 'laboratory'
        $page = Settings::where('slug', 'laboratory')->first();
    
        if (!$page) {
            // Handle the case when there is no 'laboratory' settings
            return response()->json(['error' => 'Page not found'], 404);
        }
    
        $settings = $page->settings;
        $title = $page->getTranslations('title')[$locale] ?? null;
    
        // Get content and image
        $content = $settings['content_' . $locale] ?? null;
        $image = $settings['cover_image'] ?? null;
    
        // Construct meta tags
        $meta = [
            'title' => $settings['meta_title_' . $locale] ?? null, 
            'description' => $settings['meta_description_' . $locale] ?? null
        ];
    
        // Prepare the result
        $result = [
            'page_title' => $title,
            'slug' => 'laboratory',
            'content' => $content,
            'cover_image' => $image,
            'meta' => $meta
        ];
        return response()->json($result);
    }


    public function home($locale) {
        // Get settings data for 'home'
        $data = settings('home', null, null, config('app.env'));
    
        // Get slides and sections
        $slides = $data['slides_' . $locale] ?? null;
        $sections = $data['sections'] ?? null;
    
        // Get the title by locale
        $title = Settings::where('slug', 'home')->first()->getTranslations('title')[$locale] ?? null;
    
        // Get sections title
        $sectionTitles = array_map(function ($section) {
            return str_replace("App\Nova\Flexible\Layouts\OrderingLayout", "", $section['layout']);
        }, $sections);
    
        // Get laboratory services from ids
        $lab_ids = json_decode($data['laboratory']) ?? [];
        $labs = $this->get_laboratory_services_from_ids($lab_ids, $locale);
    
        // Construct meta tags
        $meta = [
            'title' => $data['meta_title_' . $locale] ?? null, 
            'description' => $data['meta_description_' . $locale] ?? null
        ];
    
        // Prepare the result
        $result = [
            'page_title' => $title,
            'sections_ordering' => $sectionTitles,
            'slides' => $slides,
            'labs' => $labs,
            'meta' => $meta
        ];
    
        return response()->json($result);
    }



    private function get_laboratory_services_from_ids($service_ids, $locale = 'ka'){
      $services = [];
        //Get Services by ids
        foreach($service_ids as $service_id){
          $service = LaboratoryService::find(intval($service_id));
          if($service) {
              $service = $service->toArray();
              if($service['status'] == 1){
                $service['title'] = $service['title'][$locale] ?? null;
                $service['content'] = $service['content'][$locale] ?? null;
                $services[] = $service;
              }
          }
        }

        return $services;
    }

    public function contact($locale) {
      $page = json_decode(Settings::where('slug', 'contact')->first(), true);
      $title = $page['title'][$locale] ?? null;
      $content = $page['settings'] ?? null;
      $data['phone'] = $content['phone'] ?? null;
      $data['email'] = $content['email'] ?? null;
      $data['address'] = $content['address_' . $locale] ?? null;
      $data['social_networks'] = $content['social_networks'] ?? null;
      //meta Tags
      $meta_title = $content['meta_title_' . $locale] ?? null;
      $meta_description = $content['meta_description_' . $locale] ?? null;
      return response(['page_title' => $title, 'content' => $data, 'meta' => ['title' => $meta_title, 'description' => $meta_description]], 200);
    }

    public function rules($locale) {
      $data = json_decode(Settings::where('slug', 'rules')->first(), true);
      $title = $data['title'][$locale] ?? null;
      $content = $data['settings']['content_' . $locale] ?? null;
      return response(['page_title' => $title,'content' => $content], 200);
    }
    
    public function vacancies($locale) {
      $data = json_decode(Settings::where('slug', 'vacancies')->first(), true);
      $title = $data['title'][$locale] ?? null;
      $cover_image = $data['settings']['cover_image'] ?? null;
      $email['addressee'] =  $data['settings']['vacancy_email'] ?? null;
      $email['smtp_host'] =  $data['settings']['smtp_host'] ?? null;
      $email['smtp_username'] =  $data['settings']['smtp_username'] ?? null;
      $email['smtp_password'] =  $data['settings']['smtp_password'] ?? null;
      
      //meta Tags
      $meta_title = $data['settings']['meta_title_' . $locale] ?? null;
      $meta_description = $data['settings']['meta_description_' . $locale] ?? null;
      
      return response(['page_title' => $title,'cover_image' => $cover_image, 'email' => $email, 'meta' => ['title' => $meta_title, 'description' => $meta_description]], 200);
    }
    
    public function report($locale) {
      $data = json_decode(Settings::where('slug', 'confidential-communication with-internal-audit')->first(), true);
      $title = $data['title'][$locale] ?? null;
      $content = $data['settings']['content_' . $locale] ?? null;
      $email['addressee'] =  $data['settings']['vacancy_email'] ?? null;
      $email['smtp_host'] =  $data['settings']['smtp_host'] ?? null;
      $email['smtp_username'] =  $data['settings']['smtp_username'] ?? null;
      $email['smtp_password'] =  $data['settings']['smtp_password'] ?? null;
      
      //meta Tags
      $meta_title = $data['settings']['meta_title_' . $locale] ?? null;
      $meta_description = $data['settings']['meta_description_' . $locale] ?? null;
      return response(['page_title' => $title, 'slug' => 'confidential-communication with-internal-audit', 'email' => $email, 'content' => $content, 'meta' => ['title' => $meta_title, 'description' => $meta_description]], 200);
    }
    
    public function partners($locale) {
        $page = json_decode(Settings::where('slug', 'partners')->first(), true);
        $title = $page['title'][$locale] ?? null;
        $cover_image = $page['settings']['cover_image'] ?? null;
        return response(['page_title' => $title,'cover_image' => $cover_image], 200);
    }
    
    
}


