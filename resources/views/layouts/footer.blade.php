<!--======= Footer =======-->
<link rel="stylesheet" href="{{asset('css/main_2.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">



<style>
   #footer .align_ftr{
        background-image: url('{{asset('images/footer_bg.png')}}');
        background-size: cover;
        background-repeat: no-repeat;
        background-color: hsla(0,0%,100%,0.40);
        background-blend-mode: overlay;
    }


    @media(min-width: 320px) and (max-width: 767px)  {
      #footer .align_ftr{
              background-image: url('{{asset('images/footer_bg.png')}}');
              background-repeat: no-repeat;
              background-size: contain;
              background-position: bottom;
          }
      }

      
    @media(min-width: 768px) and (max-width: 1300px)  {
      #footer .align_ftr{
              background-image: url('{{asset('images/footer_bg.png')}}');
              background-repeat: no-repeat;
              background-size: contain;
              background-position: bottom;
          }
      }


      

</style>




<footer id="footer" class="footer">
    <div class="footer_logo mb-4 mt-4 text-center">
      <a href="{{url('/')}}" class="href"><img src="{{ asset('images/footer_logo.png') }}" alt="logo"></a>
    </div>
    <div class="container">
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
      <div class="container">
      <div class="row mt-4">
        <div class="col-md-5 home_menu align-self-center">
          <div class="row">
            <div class="col">
              <ul>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('index') }}">Home</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('about-us') }}">About us</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('contact-us') }}">Contact Us</a></li>
              </ul>
            </div>
            <div class="col">
              <ul>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('privacy-policy') }}">Privacy Policy</a></li>
                <li><i class="bi bi-chevron-right"></i> <a href="{{ route('cookie-policy') }}">Cookie Policy</a></li>
                <li><i class="bi bi-chevron-right"></i>  <a href="{{ route('terms-of-use') }}">Terms of Use</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="col-md-7 system_vw home_cities">
          <div class="row">
            <div class="col-md-4 jobsearch">
              <h3 class="fw-bolder">Jobs by Cities</h3>
              <ul>
                <li>Coimbatore</li>
                <li>Chennai</li>
                <li>Mumbai</li>
                <li>Banglore</li>
              </ul>
            </div>

            <div class="col-md-4 jobsearch">
              <h3 class="fw-bolder">Jobs by Sectors</h3>
              <ul>
                <li>Automobile</li>
                <li>Marketting</li>
                <li>Information Technology</li>
                <li>Security</li>
              </ul>
            </div>

            <div class="col-md-4 jobsearch">
              <h3 class="fw-bolder">Jobs by type</h3>
              <ul>
                <li>Shift wise jobs</li>
                <li>Part-time</li>
                <li>Full-time</li>
                <li>Freelance</li>
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
        © 2022 <strong><span>Mugaam</span></strong>. All Rights Reserved
      </div>
    </div>
  </div>
</div>

      

  </div>
    </div>
  </div>
    
</div>

</footer>















