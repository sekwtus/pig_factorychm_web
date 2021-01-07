@extends('layouts.master')
@section('main')
<meta name="csrf-token" content="{{csrf_token()}}">
<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>


            <div class="col-12 grid-margin d-none d-lg-block border background-col ">
              <div class="intro-banner">
                <div class="banner-image">
                  <img src="assets/images/dashboard/banner2.png" alt="banner image" width="60%" >
                </div>
                <div class="content-area align-items-center">
                  <h2 class="mb-0">dashbord</h2>
                  <h5 class="mb-0">ฝ่ายผลิต</h4>
                </div>
                {{-- <a href="#" class="btn btn-light">Subscribe Now</a> --}}
                <div class="banner-image">
                  <img src="assets/images/dashboard/banner.png" alt="banner image" width="100%">
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body pb-0">
                  <p class="text-muted">ฝ่ายขาย</p>
                  <div class="d-flex align-items-center">
                    <h4 class="font-weight-semibold">65,650 ตัว</h4>
                    <h6 class="text-success font-weight-semibold ml-2">+100</h6>
                  </div>
                  <small class="text-muted">ยอดขาย ณ {{ date('d-m-Y') }}</small>
                </div>
                <canvas class="mt-2" height="40" id="statistics-graph-1"></canvas>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body pb-0">
                  <p class="text-muted">ฝ่ายผลิต</p>
                  <div class="d-flex align-items-center">
                    <h4 class="font-weight-semibold">70000</h4>
                    <h6 class="text-danger font-weight-semibold ml-2">-43</h6>
                  </div>
                  <small class="text-muted">ยอดผลิต ณ {{ date('d-m-Y') }}</small>
                </div>
                <canvas class="mt-2" height="40" id="statistics-graph-3"></canvas>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body pb-0">
                  <p class="text-muted">คลังสินค้า</p>
                  <div class="d-flex align-items-center">
                    <h4 class="font-weight-semibold">20000 ตัว</h4>
                    <h6 class="text-success font-weight-semibold ml-2">+876</h6>
                  </div>
                  <small class="text-muted">ยอดคงคลัง ณ {{ date('d-m-Y') }}</small>
                </div>
                <canvas class="mt-2" height="40" id="statistics-graph-2"></canvas>
              </div>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
              <div class="card card-statistics">
                <div class="card-body pb-0">
                  <p class="text-muted">ฝ่ายบัญชี</p>
                  <div class="d-flex align-items-center">
                    <h4 class="font-weight-semibold">100000 บาท</h4>
                    <h6 class="text-success font-weight-semibold ml-2">+23</h6>
                  </div>
                  <small class="text-muted">ยอด ณ {{ date('d-m-Y') }}</small>
                </div>
                <canvas class="mt-2" height="40" id="statistics-graph-4"></canvas>
              </div>
            </div>
            <div class="col-md-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-8 d-flex flex-column">
                      <div class="d-flex align-items-center">
                        <h4 class="card-title mb-0">Realtime Statistics</h4>
                        <div class="badge badge-pill badge-sm badge-danger my-auto ml-3 d-none d-lg-block">New</div>
                      </div>
                      <h2>24.456%</h2>
                      <canvas class="my-4 my-md-0 mt-md-auto " id="realtime-statistics" height="200"></canvas>
                    </div>
                    <div class="col-md-4">
                      <small class="text-muted ml-auto d-none d-lg-block mb-3">Updated at 08.32pm, Aug 2018</small>
                      <div class="d-flex justify-content-between py-2 border-bottom">
                        <div class="wrapper">
                          <p class="mb-0">Marketing</p>
                          <h5 class="font-weight-medium">34%</h5>
                        </div>
                        <div class="wrapper d-flex flex-column align-items-center">
                          <small class="text-muted mb-2">2018</small>
                          <div class="badge badge-pill badge-danger">Mar</div>
                        </div>
                      </div>
                      <div class="d-flex justify-content-between py-2 border-bottom">
                        <div class="wrapper">
                          <p class="mb-0">Develpment</p>
                          <h5 class="font-weight-medium">49%</h5>
                        </div>
                        <div class="wrapper d-flex flex-column align-items-center">
                          <small class="text-muted mb-2">2018</small>
                          <div class="badge badge-pill badge-warning">DVR</div>
                        </div>
                      </div>
                      <div class="d-flex justify-content-between pt-2">
                        <div class="wrapper">
                          <p class="mb-0">Human Resources</p>
                          <h5 class="font-weight-medium">75%</h5>
                        </div>
                        <div class="wrapper d-flex flex-column align-items-center">
                          <small class="text-muted mb-2">2017</small>
                          <div class="badge badge-pill badge-success">H&R</div>
                        </div>
                      </div>
                      <div class="wrapper mt-4 d-none d-lg-block">
                        <p class="text-muted">Note: These statistics are aggregates over all of your application's users. </p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-4 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Human Resources</h4>
                  <div class="aligner-wrapper">
                    <canvas id="humanResouceDoughnutChart" height="140"></canvas>
                    <div class="wrapper d-flex flex-column justify-content-center absolute absolute-center">
                      <h4 class="text-center mb-0">8.234</h4>
                      <small class="d-block text-center text-muted mb-0">Units</small>
                    </div>
                  </div>
                  <div class="wrapper mt-4">
                    <div class="d-flex align-items-center py-3 border-bottom">
                      <span class="dot-indicator bg-danger"></span>
                      <p class="mb-0 ml-3">Human Resources</p>
                      <p class="ml-auto mb-0 text-muted">86%</p>
                    </div>
                    <div class="d-flex align-items-center py-3 border-bottom">
                      <span class="dot-indicator bg-success"></span>
                      <p class="mb-0 ml-3">Manager</p>
                      <p class="ml-auto mb-0 text-muted">28%</p>
                    </div>
                    <div class="d-flex align-items-center pt-3">
                      <span class="dot-indicator bg-primary"></span>
                      <p class="mb-0 ml-3">Other</p>
                      <p class="ml-auto mb-0 text-muted">20%</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-5 d-flex align-items-center">
                      <canvas id="UsersDoughnutChart" class="400x160 mb-4 mb-md-0" height="200"></canvas>
                    </div>
                    <div class="col-md-7">
                      <h4 class="card-title font-weight-medium mb-0 d-none d-md-block">Active Users</h4>
                      <div class="wrapper mt-4">
                        <div class="d-flex justify-content-between mb-2">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 font-weight-medium">67,550</p>
                            <small class="text-muted ml-2">Email account</small>
                          </div>
                          <p class="mb-0 font-weight-medium">80%</p>
                        </div>
                        <div class="progress">
                          <div class="progress-bar bg-success" role="progressbar" style="width: 88%" aria-valuenow="88" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                      <div class="wrapper mt-4">
                        <div class="d-flex justify-content-between mb-2">
                          <div class="d-flex align-items-center">
                            <p class="mb-0 font-weight-medium">21,435</p>
                            <small class="text-muted ml-2">Requests</small>
                          </div>
                          <p class="mb-0 font-weight-medium">34%</p>
                        </div>
                        <div class="progress">
                          <div class="progress-bar bg-info" role="progressbar" style="width: 34%" aria-valuenow="34" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-7">
                      <h4 class="card-title font-weight-medium mb-3">Amount Due</h4>
                      <h1 class="font-weight-medium mb-0">$5998</h1>
                      <p class="text-muted">Milestone Completed</p>
                      <p class="mb-0">Payment for next week</p>
                    </div>
                    <div class="col-md-5 d-flex align-items-end mt-4 mt-md-0">
                      <canvas id="conversionBarChart" height="150"></canvas>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-5 grid-margin stretch-card top-selling-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Total selling product</h4>
                  <canvas id="topSellingProducts" height="150"></canvas>
                  <div class="column-wrapper">
                    <div class="column">
                      <div class="d-flex flex-column flex-md-row">
                        <i class="mdi mdi-shield-half-full text-primary"></i>
                        <div class="d-flex flex-column ml-md-2">
                          <p class="text-muted mb-0 font-weight-medium">Total Profit</p>
                          <h4 class="font-weight-bold">$748</h4>
                        </div>
                      </div>
                    </div>
                    <div class="column">
                      <div class="d-flex flex-column flex-md-row">
                        <i class="mdi mdi-cart-outline text-success"></i>
                        <div class="d-flex flex-column ml-md-2">
                          <p class="text-muted mb-0 font-weight-medium">Total sales</p>
                          <h4 class="font-weight-bold">$1,253</h4>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="table-responsive item-wrapper">
                    <table class="table table-striped">
                      <thead>
                        <tr>
                          <th>Product Name</th>
                          <th>Quantity</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Samsung Tab</td>
                          <td>4323</td>
                          <td>
                            <div class="badge badge-success">+12.14%</div>
                          </td>
                        </tr>
                        <tr>
                          <td>Galaxy S9</td>
                          <td>11,456</td>
                          <td>
                            <div class="badge badge-danger">-04.03%</div>
                          </td>
                        </tr>
                        <tr>
                          <td>Airpod</td>
                          <td>723</td>
                          <td>
                            <div class="badge badge-success">+13.03%</div>
                          </td>
                        </tr>
                        <tr>
                          <td>Iphone X</td>
                          <td>6,527</td>
                          <td>
                            <div class="badge badge-success">+04.03%</div>
                          </td>
                        </tr>
                        <tr>
                          <td>Pixel 2XL</td>
                          <td>34,661</td>
                          <td>
                            <div class="badge badge-danger">-07.15%</div>
                          </td>
                        </tr>
                        <tr>
                          <td>Beats Headphones</td>
                          <td>754</td>
                          <td>
                            <div class="badge badge-success">+01.75%</div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-7 col-lg-7 col-md-6 col-sm-12 grid-margin stretch-card">
              <div class="card review-card">
                <div class="card-header header-sm d-flex justify-content-between align-items-center">
                  <h4 class="card-title">Reviews</h4>
                  <div class="wrapper d-flex align-items-center">
                    <p>23 New Reviews</p>
                    <div class="dropdown">
                      <button class="btn btn-transparent icon-btn dropdown-toggle arrow-disabled pr-0" type="button" id="dropdownMenuIconButton1"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="mdi mdi-dots-vertical"></i>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuIconButton1">
                        <a class="dropdown-item" href="#">Today</a>
                        <a class="dropdown-item" href="#">Yesterday</a>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body no-gutter">
                  <div class="list-item">
                    <div class="preview-image">
                      <img class="img-sm rounded-circle" src="assets/images/faces/face10.jpg" alt="profile image"> </div>
                    <div class="content">
                      <div class="d-flex align-items-center">
                        <h6 class="product-name">Air Pod</h6>
                        <small class="time ml-3 d-none d-sm-block">08.34 AM</small>
                        <div class="ml-auto">
                          <select id="review-rating-1" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <p class="user-name">Christine :</p>
                        <p class="review-text d-block">The brand apple is original !</p>
                      </div>
                    </div>
                  </div>
                  <div class="list-item">
                    <div class="preview-image">
                      <img class="img-sm rounded-circle" src="assets/images/faces/face13.jpg" alt="profile image"> </div>
                    <div class="content">
                      <div class="d-flex align-items-center">
                        <h6 class="product-name">Macbook</h6>
                        <small class="time ml-3 d-none d-sm-block">12.56 PM</small>
                        <div class="ml-auto">
                          <select id="review-rating-2" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <p class="user-name">Arthur Cole :</p>
                        <p class="review-text d-block">The brand apple is original also the iphone x.</p>
                      </div>
                    </div>
                  </div>
                  <div class="list-item">
                    <div class="preview-image">
                      <img class="img-sm rounded-circle" src="assets/images/faces/face1.jpg" alt="profile image"> </div>
                    <div class="content">
                      <div class="d-flex align-items-center">
                        <h6 class="product-name">Apple watch</h6>
                        <small class="time ml-3 d-none d-sm-block">09.24 AM</small>
                        <div class="ml-auto">
                          <select id="review-rating-3" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <p class="user-name">James Tate :</p>
                        <p class="review-text d-block">The brand apple is original.</p>
                      </div>
                    </div>
                  </div>
                  <div class="list-item">
                    <div class="preview-image">
                      <img class="img-sm rounded-circle" src="assets/images/faces/face11.jpg" alt="profile image"> </div>
                    <div class="content">
                      <div class="d-flex align-items-center">
                        <h6 class="product-name">Homepod</h6>
                        <small class="time ml-3 d-none d-sm-block">5.12 AM</small>
                        <div class="ml-auto">
                          <select id="review-rating-4" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <p class="user-name">Clyde Parker :</p>
                        <p class="review-text d-block">The brand apple is original also the iphone !!</p>
                      </div>
                    </div>
                  </div>
                  <div class="list-item">
                    <div class="preview-image">
                      <img class="img-sm rounded-circle" src="assets/images/faces/face12.jpg" alt="profile image"> </div>
                    <div class="content">
                      <div class="d-flex align-items-center">
                        <h6 class="product-name">Imac</h6>
                        <small class="time ml-3 d-none d-sm-block">10.00 AM</small>
                        <div class="ml-auto">
                          <select id="review-rating-5" name="rating" autocomplete="off">
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                          </select>
                        </div>
                      </div>
                      <div class="d-flex align-items-center">
                        <p class="user-name">James Tate :</p>
                        <p class="review-text d-block">The brand apple is original.</p>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-12 grid-margin">
              <div class="card">
                <div class="card-header header-sm">
                  <div class="d-flex align-items-center">
                    <h5 class="card-title">Recent Orders</h5>
                    <div class="wrapper ml-auto action-bar">
                      <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle btn-sm" type="button" id="dropdownMenuOutlineButton1" data-toggle="dropdown"
                          aria-haspopup="true" aria-expanded="false">Today</button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuOutlineButton1">
                          <a class="dropdown-item" href="#">Today</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">Last 7 Days</a>
                          <div class="dropdown-divider"></div>
                          <a class="dropdown-item" href="#">This week</a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card-body">
                  <table id="" class="table table-striped w-100">
                    <thead>
                      <tr>
                        <th>#</th>
                        <th>Product Name</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>QTY</th>
                        <th>Purchased On</th>
                        <th>Status</th>
                        <th>Track No</th>
                      </tr>
                    </thead>
                  </table>
                </div>
              </div>
            </div>
          
        @endsection

        
        