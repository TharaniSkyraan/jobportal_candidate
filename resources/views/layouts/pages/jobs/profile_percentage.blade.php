
<div class="myprofile_sec">
    <!--alert profile-->
    @if(Auth::check())
        @if(Auth::user()->getProfilePercentage() < 80)
            <div class="alert_prnt">
                <div class="alert pfcmpletalert alert-dismissible fade show" role="alert">
                    <div class="row">
                        <div class="col-2 wrning text-center">
                            <img draggable="false" src="{{ asset('images/warning.png')}}">
                        </div>
                        <div class="col-9 align-self-center">
                            <span>Increase your profile visibility to recruiters by completing your profile</span>
                        </div>
                        <div class="col-1 align-self-center">
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </div> 
        @endif
    @endif
</div>