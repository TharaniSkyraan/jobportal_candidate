<!--======= Footer =======-->

<style>
   #footer .align_ftr{
      background-image: url('{{asset('images/footer_bg.webp')}}');
      background-size: cover;
      background-repeat: no-repeat;
      background-color: hsla(0,0%,100%,0.40);
      background-blend-mode: overlay;
    }

    @media(min-width: 320px) and (max-width: 767px)  {
      #footer .align_ftr{
          background-image: url('{{asset('images/footer_bg.webp')}}');
          background-repeat: no-repeat;
          background-size: contain;
          background-position: bottom;
        }
    }
      
    @media(min-width: 768px) and (max-width: 1300px)  {
      #footer .align_ftr{
        background-image: url('{{asset('images/footer_bg.webp')}}');
        background-repeat: no-repeat;
        background-size: contain;
        background-position: bottom;
      }
    }

    #footer .align_ftr li img {
        margin-right: 5px;
    }.footer_logo img{
        width: 155px;
    }#footer .align_ftr h3{
      font-size: 17px;
      font-weight: 600;
    }     

</style>




<footer id="footer" class="footer">
    <div class="footer_logo mb-4 mt-4 text-center">
      <a href="{{url('/')}}" class="href"><img draggable="false" src="{{ asset('images/footer_logo.png') }}" alt="logo"></a>
    </div>
    <div class="container-lg">
      <div class="footer_p mb-5">
        <p>
            Mugaam.com ensures that the job seekers shouldn’t go on for a second chance in landing a job, as the
            process helps to find the right career for the skill set they have achieved now. For employers, defining
            the recruitment in search of an acceptable candidate for the vacant position is accessible through the
            Mugaam.com job portal site.
        </p>
      </div>
    </div>


    <div class="align_ftr">
      <div class="container-lg">
      <div class="row mt-4">
        <div class="col-md-5 home_menu align-self-center">
          <div class="row">
            <div class="col-6">
              <ul>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('index') }}">Home</a></li>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('about-us') }}">About us</a></li>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('contact-us') }}">Contact Us</a></li>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('faq') }}">FAQ</a></li>
              </ul>
            </div>
            <div class="col-6">
              <ul>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('cookie-policy') }}">Cookie Policy</a></li>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ route('terms-of-use') }}">Terms of Use</a></li>
                <li><img src="{{asset('images/footer/arrow_1.svg')}}" alt=""><a href="{{ url('blogs') }}">Blog</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-7 system_vw home_cities">
          <div class="row">
            <div class="col-md-4">
              <h3 class="">Jobs by Cities</h3>
              <ul>
                <li class="footer-city cursor-pointer">Coimbatore</li>
                <li class="footer-city cursor-pointer">Chennai</li>
                <li class="footer-city cursor-pointer">Mumbai</li>
                <li class="footer-city cursor-pointer">Banglore</li>
              </ul>
            </div>

            <div class="col-md-4">
              <h3 class="">Jobs by Sectors</h3>
              <ul>
                <li class="footer-search cursor-pointer">Automobile</li>
                <li class="footer-search cursor-pointer">Marketing</li>
                <li class="footer-search cursor-pointer">Information Technology</li>
                <li class="footer-search cursor-pointer">Security</li>
              </ul>
            </div>

            <div class="col-md-4">
              <h3 class="">Jobs by type</h3>
              <ul>
                <li class="footer-search cursor-pointer">Shift wise jobs</li>
                <li class="footer-search cursor-pointer">Part-time</li>
                <li class="footer-search cursor-pointer">Full-time</li>
                <li class="footer-search cursor-pointer">Freelance</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class=" justify-content-end hr mt-4 mb-2">
      <!-- <div class="text-center mb-2">
        <button type="button" class="btn btn-social-icon btn-facebook btn-rounded"><i class="fa fa-facebook"></i></button>
        <button type="button" class="btn btn-social-icon btn-linkedin btn-rounded"><i class="fa fa-linkedin"></i></button>
        <button type="button" class="btn btn-social-icon btn-instagram btn-rounded"><i class="fa fa-instagram"></i></button>
      </div> -->
      
      <div class="copyright">
        © 2023 <strong><span>Mugaam</span></strong>. All Rights Reserved
      </div>
    </div>
  </div>
</div>

      

  </div>
    </div>
  </div>
    
</div>

</footer>
<script>
  

  $(".footer-search").click(function(){
      search($(this).text(), '');
  });

  $(".footer-city").click(function(){
      search('',$(this).text());
  });

  if(document.getElementById('designation')!=null || document.getElementById('mdesignation')!=null ){
    $('#designation, #mdesignation ').on('keyup', function(){
        $('#designation').tooltip({trigger: 'manual'}).tooltip('hide');
        $('#mdesignation').tooltip({trigger: 'manual'}).tooltip('hide');

    });
  }

  function search(d, l, from){
    // $('#designation').css('border','1px solid lightgray');
    $('.err_msg').html('');
    if($.trim(d) != '' || $.trim(l) !=''){      
        $.post('{{ route("job.checkkeywords") }}', {designation: d, location: l, _method: 'POST', _token: '{{ csrf_token() }}'})
            .done(function (response) {
                var l = '';
                var d = '';
            if(response.d !=''){
                d = 'd='+response.d;
            }
            if(response.l !=''){
                if(response.d !=''){
                    l += '&';
                }
                l += 'l='+response.l;
            }
            url = '{{ url("/") }}/';
            window.location = url+response.sl+'?'+d+l;
        });
    }else{
      
      if(document.getElementById('designation')!=null || document.getElementById('mdesignation')!=null ){
        // $('.designation-error').html('Please enter title, keyword or company');
        // $('#designation').css('border','1px solid #f25961');
            if(from=='mob'){
              $('#mdesignation').tooltip({trigger: 'manual'}).tooltip('show');
            }else{
              $('#designation').tooltip({trigger: 'manual'}).tooltip('show');
            }
        }
    }
  }
</script>















