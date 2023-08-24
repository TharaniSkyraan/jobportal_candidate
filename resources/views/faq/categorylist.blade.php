
<nav class="wrapper sidenavbar sidenavbarfaq unsets">
    <div class="logo_items flex">
        <text class="">
          <a href="{{url('/')}}"><img draggable="false" src="{{ asset('/') }}site_assets_1/logo1.png" alt="logo_img" id="sidebar_logo_image" /></a>
        </text> 
        <i class="fa fa-horizontal-rule"></i>
    </div>
    <div class="menu_container">  
        <div class="menu_items">
            <ul class="menu_item" id="ctlist">
                <!-- <div class="menu_title flex">
                    <span class="title">Dashboard</span>
                    <span class="line"></span>
                </div> -->
                @foreach ($faq_categories as $key => $faqcategory)
                <li class="item ctkey" data-ckey="{{$faqcategory->slug??''}}">
                    <a href="javascript:void(0);" class="link flex @if($ckey == $faqcategory->slug) active @endif">
                        <span>{{$faqcategory->faq_category}}</span>
                    </a>
                </li>                  
                @endforeach
            </ul>

            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title"></span>
                    <span class="line"></span>
                </div>
            </ul>
            <ul class="menu_item">
                <div class="menu_title flex">
                    <span class="title"></span>
                    <span class="line"></span>
                </div>
            </ul>
        </div>
    </div>
</nav>

<div class="overlay"></div>