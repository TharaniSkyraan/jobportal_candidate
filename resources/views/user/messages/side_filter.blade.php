
  <!-- Start Side Nav Bar -->
  <div class="col-xl-3 col-lg-4 col-md-4 col-sm-5 job-filter">
      <div class="card jlsection">
        <div class="row mx-2">
          <div class="col-xl-9 col-lg-9 col-md-9 col-sm-9 col-9 align-items-center d-flex">
            <span class="me-2">Show </span>
            <div class="dropdown">
              <a class="btn dropdown-toggle w-100 text-start p-0 p-2" id="MessageStatus" data-bs-toggle="dropdown" aria-expanded="false">{{$status}}</a>
              <ul class="dropdown-menu MessageStatus" aria-labelledby="MessageStatus">
                <li class="dropdown-item inbox" id="inbox">Inbox <span class="inbox_rc"></span></li>
                <li class="dropdown-item archive" id="archive">Archive <span class="archive_rc"></span></li>
                <li class="dropdown-item not_interest" id="not_interest">Not Interest <span class="not_interest_rc"></span></li>
              </ul>
            </div> 
          </div>
          <div class="col-xl-3 col-lg-3 col-md-3 col-sm-3 col-3 align-self-center text-end asc-desc" data-value="desc">
             <span><img draggable="false" src="{{asset('images/msgs/ascending.svg')}}" alt="Img" id="asc-desc"class="img-fluid"> </span>
          </div>
        </div>
        
          <div class="input-group p-3">
            <input class="form-control border-end-0 border" type="text" placeholder="Search Candidate" name="jp_search_inp" id="jp_search_inp" required>
            <span class="input-group-append">
                <button class=" btn bg-white border-start-0 border jsrchbtni" type="button" id="jp_search_btn">
                  <i class="fa fa-search"></i>
                </button>
            </span>
          </div>
        
          <div class="jcardlist" id="tempskle2">
            <!-- Contact List -->
          </div>
      </div>
  </div>
  