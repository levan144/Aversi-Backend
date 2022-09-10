<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Settings;
use App\Models\Service;
use App\Models\Blog;
use App\Models\Branch;
class PageController extends Controller
{
    public function aboutUs($locale) {
      $data = settings('about-us', null, null, config('app.env'));
      $title = json_decode(Settings::where('slug', 'about-us')->first(), true)['title'][$locale];
      $top_description = $data["top_description_" . $locale];
      $bottom_description = $data["bottom_description_" . $locale];
      $counters = $data["counters_" . $locale];
      $advantages_title = $data["advantages_title_" . $locale];
      $advantages = $data["advantages_" . $locale];
      $result = array('page_title' => $title, 'top_description' => $top_description, 'bottom_description' => $bottom_description, 'counters' => $counters , 'advantages_title' => $advantages_title , 'advantages' => $advantages);
      return response($result, 200);
    }

    public function medicalTourism($locale) {
      $data = settings('medical-tourism', null, null, config('app.env'));
      $title = json_decode(Settings::where('slug', 'medical-tourism')->first(), true)['title'][$locale];
      $cover_image = $data["cover_image"];
      $section_title = $data["section_title_" . $locale];
      $section_description = $data["section_content_" . $locale];
      $result = array('page_title' => $title, 'section_title' => $section_title, 'section_description' => $section_description, 'cover_image' => $cover_image);
      return response($result, 200);
    }

    public function afterGraduate($locale) {
      $data = settings('post-graduate-studies', null, null, config('app.env'));
      
      $title = json_decode(Settings::where('slug', 'post-graduate-studies')->first(), true)['title'][$locale] ?? null;

      $cover_image = $data["cover_image"] ?? null;
      
      $sections = $data["sections_" . $locale] ?? null;

      $result = array('page_title' => $title, 'sections' => $sections, 'cover_image' => $cover_image);
      return response($result, 200);
    }

    public function covid($locale) {
      $data = settings('post-graduate-studies', null, null, config('app.env'));
      
      $title = json_decode(Settings::where('slug', 'covid')->first(), true)['title'][$locale] ?? null;

      $faqs = json_decode(Settings::where('slug', 'covid')->first(), true)['settings']['data_' . $locale] ?? null;

      $result = array('page_title' => $title, 'faqs' => $faqs);
      return response($result, 200);
    }

    public function services($locale) {

      $title = json_decode(Settings::where('slug', 'services')->first(), true)['title'][$locale] ?? null;

      $slides = json_decode(Settings::where('slug', 'services')->first(), true)['settings']['slides_' . $locale] ?? null;

      $result = array('page_title' => $title, 'slides' => $slides);
      return response($result, 200);
    }

    public function laboratory($locale) {

      $title = json_decode(Settings::where('slug', 'laboratory')->first(), true)['title'][$locale] ?? null;

      $content = json_decode(Settings::where('slug', 'laboratory')->first(), true)['settings']['content_' . $locale] ?? null;

      $result = array('page_title' => $title, 'content' => $content);
      return response($result, 200);
    }

    public function home($locale) {
      //Get record from Settings
      $data = settings('home', null, null, config('app.env'));
      //Define empty Arrays to fill
      $sorting = [];
      $services = [];
      //Get slides
      $slides = $data['slides_' . $locale]?? null;
      //Get Title by locale
      $title = json_decode(Settings::where('slug', 'home')->first(), true)['title'][$locale] ?? null;

      //Get Sections
      $sections = $data['sections']?? null;

      //Get only Section Title
      foreach($sections as $section){
        $sorting[] = str_replace("App\Nova\Flexible\Layouts\OrderingLayout", "",$section['layout']);
      }
      
      //Get service IDs
      $service_ids = json_decode($data['services']) ?? [];
      $services = $this->get_services_from_ids($service_ids, $locale);

      $blog_ids = json_decode($data['blogs']) ?? [];
      $blogs = $this->get_blogs_from_ids($blog_ids, $locale);

      $branch_ids = json_decode($data['branches']) ?? [];
      $branches = $this->get_branches_from_ids($branch_ids, $locale);

      $lab_ids = json_decode($data['laboratory']) ?? [];
      $labs = $this->get_branches_from_ids($branch_ids, $locale);

      $result = array('page_title' => $title, 'sections_ordering' => $sorting, 'slides' => $slides,'services' => $services, 'blogs' => $blogs, 'labs' => $labs, 'clinics' => $branches);
      return response($result, 200);
    }

    private function get_services_from_ids($service_ids, $locale){
      $services = [];
        //Get Services by ids
        foreach($service_ids as $service_id){
          $service = Service::find(intval($service_id));
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

    private function get_blogs_from_ids($blog_ids, $locale){
      $blogs = [];
        //Get Blogs by ids
        foreach($blog_ids as $blog_id){
          $blog = Blog::find(intval($blog_id));
          if($blog){
              $blog = $blog->toArray();
              if($blog['status'] == 1){
                $blog['title'] = $blog['title'][$locale] ?? null;
                $blog['content'] = $blog['content'][$locale] ?? null;
                $blog['slug'] = $blog['slug'][$locale] ?? null;
                $blogs[] = $blog;
              }
          }
        }

        return $blogs;
    }

    private function get_branches_from_ids($branch_ids, $locale = 'ka'){
      $branches = [];
        //Get Branches by ids
        foreach($branch_ids as $branch_id){
            $branch = Branch::find(intval($branch_id));
            if($branch){
                $branch_region = $branch->region;
                $branch = $branch->toArray();
                $branch['region']['id'] = $branch_region->id;
                $branch['region']['title'] = $branch_region->toArray()['title'][$locale];
                $branch['title'] = $branch['title'][$locale] ?? null;
                $branch['description'] = $branch['description'][$locale] ?? null;
                $branch['address'] = $branch['address'][$locale] ?? null;
                $branches[] = $branch;
            }
        }

        return $branches;
    }
}


