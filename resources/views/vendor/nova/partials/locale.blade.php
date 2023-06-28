<!-- <dropdown class="ml-auto h-9 flex items-center dropdown-right">
  <dropdown-trigger class="h-9 flex items-center" slot-scope="{toggle}" :handle-click="toggle">
    <span class="text-90">
      {{ config( 'nova.locales.' . app()->getLocale() ) }}
    </span>
  </dropdown-trigger>

  <dropdown-menu slot="menu" width="200" direction="rtl">
    <ul class="list-reset">
@foreach( ['en' => 'English', 'ka' => 'Georgian'] AS $locale_code => $locale_title )
      <li>
@if( $locale_code == app()->getLocale() )
        <a href="#" class="block no-underline text-90 hover:bg-30 p-3" onclick="return false">
          <i class="fa fa-check text-success font-bold"></i>&nbsp;{{ $locale_title }}
        </a>
@else
        <a href="{{ route( 'nova-locale', [ 'locale' => $locale_code ] ) }}" class="block no-underline text-90 hover:bg-30 p-3">
          <i class="fa fa-check text-50"></i>&nbsp;{{ $locale_title }}
        </a>
@endif
      </li>
@endforeach
    </ul>
  </dropdown-menu>
</dropdown> -->
