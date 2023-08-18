@extends('layouts.app')

@section('custom_styles')	  
<link href="{{ asset('site_assets_1/assets/vendor/select2/select2.min.css') }}" rel="stylesheet">
<link href="{{ asset('site_assets_1/assets/user@ie3e2!/js/msg2!1/css/msgg!$21.css') }}" rel="stylesheet">
@endsection
@section('content')
@php
 $status = ($message)?(($message->candidate_active_status!='')?$message->candidate_active_status:'inbox'):'inbox';
@endphp
<div class="wrapper">
  @include('layouts.dashboard_header')
  @include('layouts.side_navbar')

	<div class="main-panel main-panel-custom main-panel-customize">
		<div class="content">
      <div class="page-inner">
        <div class="container-fuild">
          <div class="row chat-frame">
            @include('user.messages.side_filter')
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12 msglistpar">   
              <div class="cand-pro">
                <!-- Candidate Profile -->
              </div>
              <div class="message-list">
                <!-- Candidate Message List -->
              </div>
              <div class="msg-send">
                <div class="row mt-3">
                  <div class="col-11">
                      <textarea class="form-control" rows="4" name="message" id="message" placeholder="Message here" required></textarea>
                  </div>
                  <div class="col-1">
                    <div class="ctbtns">
                      <div class="textCompress"><i class="fa fa-compress-alt" aria-hidden="true"></i></div>    
                      <div class="textExpend"><i class="fa fa-expand-alt" aria-hidden="true"></i></div>    
                      <div class="textClose textCloseremoved"><i class="fa fa-close" aria-hidden="true"></i></div>    
                      <div class="textSend disabled">
                        <img src="{{ asset('/images/mail/apply.svg') }}" class="fa-paper-plane">
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-9 col-lg-8 col-md-8 col-sm-7 col-12" id="nodatamsg">   
            </div>
          </div>
        </div>
      </div>
		</div>
	</div>  


@endsection

@section('footer')
<!-- action srcip starts-->
<script>
  var baseurl = '{{ url("/") }}/';
  var act_mid_from_url = "{{$message->message_id??''}}";
  var m_status = "{{$status}}";  //all- All 0-unread, 1-read, 2-archive
</script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/vendor/select2/select2.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('site_assets_1/assets/user@ie3e2!/js/msg2!1/js/msgg!$21.js') }}"></script>

@endsection
@push('scripts')
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
@endpush