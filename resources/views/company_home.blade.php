@extends('layouts.pages.common_app')

@section('content') 

<!-- Header start --> 

@include('layouts.header.header') 

<!-- Header end --> 

<!-- Inner Page Title start --> 

@include('includes.inner_page_title', ['page_title'=>__('Dashboard')]) 

<!-- Inner Page Title end -->

<div class="listpgWraper">

    <div class="container">@include('flash::message')

        <div class="row"> @include('includes.company_dashboard_menu')

            <div class="col-md-9 col-sm-8"> @include('includes.company_dashboard_stats')

        <?php

        if((bool)config('company.is_company_package_active')){        

        $packages = App\Model\Package::where('package_for', 'like', 'employer')->get();

        $package = Auth::user()->getPackage();

        

        ?>

        

        <?php if(null !== $package){ ?>

        @include('includes.company_package_msg')

        @include('includes.company_packages_upgrade')

        <?php }elseif(null !== $packages){ ?>

        @include('includes.company_packages_new')

        <?php }} ?>

        </div>

        </div>

    </div>

</div>

@include('includes.footer.footer')

@endsection

@push('scripts')

@include('includes.immediate_available_btn')

@endpush

