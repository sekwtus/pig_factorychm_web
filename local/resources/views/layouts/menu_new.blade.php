
<div class="nav-bottom">
  <div class="container">

  <ul class="nav page-navigation">

    <li class="nav-item" id="main1">
      <a href="{{url('/')}}" class="nav-link">
          <i style="margin: 0px;" class="link-icon mdi mdi-home"></i>
          <span class="menu-title">หน้าแรก</span>
      </a>
    </li>

    {{-- !!! กำหนดpermission ใช้ master.blade.php ปลด hidden --}}

    <li class="nav-item mega-menu" id="main2" hidden>
      <a href="#" class="nav-link">
        <i style="margin: 0px;" class="link-icon fa fa-edit"></i> 
        <span class="menu-title">ขาย</span>
        <i style="margin: 0px;" class="menu-arrow "></i>
      </a>
      <div class="submenu">
        <div class="col-group-wrapper row">

          <div class="col-group col-md-3" id="m21" hidden>
            <p class="category-heading">Stock คอกหมูขุน</p>
            <ul class="submenu-item" >
              <li class="nav-item" id="s211" hidden>
                <a class="nav-link" href="{{url('stock_data_pp1/คอกขาย')}}">คอกหมูขุน</a>
              </li>
            </ul>
          </div>
  {{-- <li class="nav-item mega-menu" id="m05" hidden>
    <a href="#" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-paste"></i>
      <span class="menu-title ">โรงงาน</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu">
      <div class="col-group-wrapper row">
        <div class="col-group col-md-2.5">
          <p class="category-heading">วางแผน</p>
          <ul class="submenu-item">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/all_plan')}}">กำหนดวันผลิตทั้งหมด</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/2')}}">แผนการเชือด</a>
            </li> 
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/offal_order')}}">สร้าง Order การผลิตเครื่องใน</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/overnight_order')}}">เบิกซาก Overnight</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/cutting_order')}}">สร้าง Order ตัดแต่ง</a>
            </li>
          </ul>
        </div>
        <div class="col-group col-md-2">
          <p class="category-heading">Stock</p>
          <ul class="submenu-item">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('stock_data_pp2/คอกเชือด')}}">คอกเชือด</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('stock_data_ov/Overnight')}}">Overnight</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('stock_data_of_entrails/เครื่องในขาว เครื่องในแดง + หัว')}}">เครื่องในขาว,แดง,หัว</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{url('stock_data_of_cl/ตัดแต่ง')}}">ตัดแต่ง</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{url('stock_data_of_dc/รอโหลด')}}">รอโหลด</a>
            </li>
          </ul>
        </div>
        <div class="col-group col-md-2">
          <p class="category-heading">Map Realtime</p>
          <ul class="submenu-item">
          </ul>
        </div>
        <div class="col-group col-md-2">
          <p class="category-heading">รายงานการชั่งน้ำหนัก</p>
          <ul class="submenu-item">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('factory_weighing_date_specify')}}">รายงานการชั่งน้ำหนัก</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('transform_main')}}">รายงานการแปรสภาพ</a>
            </li>
          </ul>
        </div>
        <div class="col-group col-md-2.5">
          <p class="category-heading">Order พิเศษ</p>
          <ul class="submenu-item">
            <li class="nav-item ">
              @php
                  $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
              @endphp
              <a class="nav-link " href="{{url('shop/shop_request_all')}}">รายการ Order พิเศษ</a>
            </li>
            <li class="nav-item">
              <a class="nav-link " href="{{url('shop/daily_sales_all')}}">รายงานใบสั่งสินค้า,ใบแกะ,ใบคนงาน</a>
            </li>
          </ul>
        </div>
        <div class="col-group col-md-1.5">
          <p class="category-heading">จัดส่ง</p>
          <ul class="submenu-item">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('order_transport/create_tr')}}">แผนการจัดส่ง</a>
            </li> 
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/checking_order')}}">ตรวจสอบสินค้า</a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </li> --}}

          <div class="col-group col-md-3" id="m22" hidden>
            <p class="category-heading">Order</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s221" hidden>
                <a class="nav-link " href="{{url('order/number_of_pig')}}">วางแผนจำนวนหมูส่งร้าน</a>
              </li>
              <li class="nav-item " id="s222" hidden>
                <a class="nav-link " href="{{url('/order/create')}}">สร้าง Order รับสุกร</a>
              </li>
            </ul>
          </div>

          <div class="col-group col-md-3" id="m23" hidden>
            <p class="category-heading">รายการพยากรณ์สินค้า</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s231" hidden>
                @php
                    $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
                @endphp
                <a class="nav-link " href="{{url('shop/shop_request_all')}}">รายการ Order พิเศษ</a>
              </li>
              <li class="nav-item" id="s232" hidden>
                <a class="nav-link " href="{{url('/check_sp_order/sale')}}">รายงานใบสั่งสินค้า,ใบตัดแต่ง,ใบคนงาน</a>
              </li>
            </ul>
          </div>
          
          {{-- <div class="col-group col-md-3" id="m24" hidden>
            <p class="category-heading">ข้อมูลลูกค้า</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s241" hidden>
                <a class="nav-link " href="{{url('/customer/add')}}">เพิ่มข้อมูลลูกค้า</a>
              </li>
              <li class="nav-item " id="s242" hidden>
                <a class="nav-link " href="{{url('/customer/get_all')}}">รายชื่อลูกค้าทั้งหมด</a>
              </li>
            </ul>
          </div> --}}

        </div>
      </div>
    </li>

    <li class="nav-item mega-menu" id="main3" hidden>
      <a href="#" class="nav-link">
        <i style="margin: 0px;" class="link-icon fa fa-paste"></i>
        <span class="menu-title ">โรงงาน</span>
        <i style="margin: 0px;" class="menu-arrow "></i>
      </a>
      
      <div class="submenu">
        <div class="col-group-wrapper row">
           <div class="col-group col-md-2" id="m33" hidden>
            <p class="category-heading">Map Reatime</p>
            <ul class="submenu-item">
              <li class="nav-item" id="s331" hidden>
                <a class="nav-link " href="{{url('/factory_monitor')}}">Factory Monitor</a>
              </li>
            </ul>
          </div>
          <div class="col-group col-md-2" id="m31" hidden>
            <p class="category-heading">วางแผน</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s311" hidden>
                <a class="nav-link " href="{{url('/order/all_plan')}}" title="1. กำหนดวันผลิตทั้งหมด">1. กำหนดวันผลิตทั้งหมด</a>
              </li>
              <li class="nav-item " id="s312" hidden>
                  <a class="nav-link " href="{{url('/order/plan_daily/2')}}">2. แผนการเชือด</a>
              </li> 
              <li class="nav-item " id="s313" hidden>
                  <a class="nav-link " href="{{url('/offal_order')}}">3. สร้าง Order การผลิตเครื่องใน</a>
              </li>
              <li class="nav-item " id="s314" hidden>
                <a class="nav-link " href="{{url('/overnight_order')}}">4. เบิกซาก Overnight</a>
              </li>
              <li class="nav-item " id="s315" hidden>
                  <a class="nav-link " href="{{url('/cutting_order')}}">5. สร้าง Order ตัดแต่ง</a>
              </li>
              <li class="nav-item " id="s316" hidden>
                <a class="nav-link " href="{{url('/marinade_order')}}">6. สร้าง Order Marinade</a>
            </li>
            </ul>
          </div>
          <div class="col-group col-md-2" id="m32" hidden>
            <p class="category-heading">Stock</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s321" hidden>
                <a class="nav-link " href="{{url('stock_data_pp2/คอกเชือด')}}">คอกเชือด</a>
              </li>
              <li class="nav-item " id="s322" hidden>
                <a class="nav-link " href="{{url('stock_data_ov/Overnight')}}">Overnight</a>
              </li>
              <li class="nav-item " id="s323" hidden>
                <a class="nav-link " href="{{url('stock_data_of_entrails/เครื่องในขาว เครื่องในแดง + หัว')}}">เครื่องในขาว,แดง,หัว</a>
              </li>
              <li class="nav-item " id="s326" hidden>
                <a class="nav-link " href="{{url('stock_data_of_entrails_item/เครื่องในขาว เครื่องในแดง + หัว')}}">เครื่องในขาว,แดง,หัว(ชิ้นส่วน)</a>
              </li>
              <li class="nav-item" id="s324" hidden>
                <a class="nav-link " href="{{url('stock_data_of_cl/ตัดแต่ง')}}">ตัดแต่ง</a>
              </li>
              <li class="nav-item" id="s325" hidden>
                <a class="nav-link " href="{{url('stock_data_of_dc/รอโหลด')}}">รอโหลด</a>
              </li>
            </ul>
          </div>
          <div class="col-group col-md-2" id="m34" hidden>
            <p class="category-heading">รายงานการชั่งน้ำหนัก</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s341" hidden>
                <a class="nav-link " href="{{url('factory_weighing_date_specify')}}">รายงานการชั่งน้ำหนัก</a>
              </li>
              <li class="nav-item " id="s342" hidden>
                <a class="nav-link " href="{{url('transform_main')}}">รายงานการแปรสภาพ</a>
              </li>
            </ul>
          </div>
          <div class="col-group col-md-2" id="m35" hidden>
            <p class="category-heading">Order พิเศษ</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s351" hidden>
                @php
                    $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
                @endphp
                <a class="nav-link " href="{{url('shop/shop_request_all')}}">รายการ Order พิเศษ</a>
              </li>
              <li class="nav-item" id="s352" hidden>
                <a class="nav-link " href="{{url('/check_sp_order/factory')}}">รายงานใบสั่งสินค้า,ใบตัดแต่ง,ใบคนงาน</a>
              </li>
            </ul>
          </div>
          <div class="col-group col-md-2" id="m36" hidden>
            <p class="category-heading">จัดส่ง</p>
            <ul class="submenu-item">
              <li class="nav-item " id="s361" hidden>
                <a class="nav-link " href="{{url('order_transport/create_tr')}}">แผนการจัดส่ง</a>
              </li> 
              <li class="nav-item " id="s362" hidden>
                <a class="nav-link " href="{{url('/checking_order')}}">ตรวจสอบสินค้า</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
    </li>

    <li class="nav-item mega-menu" id="main4" hidden >
        <a href="#" class="nav-link">
          <i style="margin: 0px;" class="link-icon mdi mdi-store"></i>
          <span class="menu-title ">ร้านค้า</span>
          <i style="margin: 0px;" class="menu-arrow "></i>
        </a>
        <div class="submenu">
          <div class="col-group-wrapper row">
            <div class="col-group col-md-3" id="m41" hidden>
              <p class="category-heading">รายงาน</p>
              <ul class="submenu-item">
                <li class="nav-item " id="s411" hidden>
                  @php
                      $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
                  @endphp
                  <a class="nav-link " href="{{url('shop/shop_request_all')}}">รายการ Order พิเศษ</a>
                </li>
                <li class="nav-item" id="s412" hidden>
                  <a class="nav-link " href="{{url('/check_sp_order/shop')}}">รายงานใบสั่งสินค้า,ใบตัดแต่ง,ใบคนงาน</a>
                </li>
              </ul>
            </div>
            <div class="col-group col-md-2" id="m42" hidden>
              <p class="category-heading">รายงานการรับสินค้า</p>
              <ul class="submenu-item">
                <li class="nav-item " id="s421" hidden>
                  <a class="nav-link " href="{{url('/weighing/general')}}">รายงานการชั่งน้ำหนัก</a>
                </li>
              </ul>
            </div>
            <div class="col-group col-md-2" id="m43" hidden>
              <p class="category-heading">การแปรสภาพ</p>
              <ul class="submenu-item">
                <li class="nav-item " id="s432" hidden>
                  <a class="nav-link " href="{{url('order/transfer')}}">สร้าง Order การแปรสภาพ</a>
                </li>
                <li class="nav-item " id="s431" hidden>
                  <a class="nav-link " href="{{url('shop_transform_main')}}">การแปรสภาพ</a>
                </li>
              </ul>
            </div>
            <div class="col-group col-md-2" id="m44" hidden>
              <p class="category-heading">รายงานการโอน</p>
              <ul class="submenu-item">
                <li class="nav-item "  id="s441" hidden>
                  <a class="nav-link " href="{{url('/order/product_transfer')}}">สร้างรายการโอนสินค้า</a>
                </li>
                <li class="nav-item "  id="s442" hidden>
                  <a class="nav-link " href="{{url('/order/product_transfer_all')}}" >รายงานการโอนสินค้าทั้งหมด</a>
                </li>
                <li class="nav-item "  id="s443" hidden>
                  <a class="nav-link " href="{{url('/order/product_transfer_report_all')}}" >สรุปรายงานการโอนสินค้า</a>
                </li>
                <li class="nav-item "  id="s444" hidden>
                  <a class="nav-link " href="{{url('/order/transfer_to_fac')}}" title="สร้างรายการโอนสินค้าคืนโรงงาน">สร้างรายการโอนสินค้าคืนโรงงาน</a>
                </li>
              </ul>
            </div>
            <div class="col-group col-md-2" id="m45" hidden>
              <p class="category-heading">Stock</p>
              <ul class="submenu-item">
                <li class="nav-item "  id="s451" hidden>
                  <a class="nav-link ">stock สินค้า</a>
                </li>
                <li class="nav-item " id="s452" hidden>
                  <a class="nav-link " href="{{url('/weight/stock')}}">รายงานการชั่งน้ำหนัก (นับสต๊อก)</a>
                </li>
              </ul>
            </div>
          </div>
        </div>
    </li> 

    <li class="nav-item "  id="main5" hidden >
      <a href="#" tyle="padding: 2px;" class="nav-link" id="m51" hidden >
        <i style="margin: 0px;" class="link-icon fa fa-exclamation-circle"></i>
        <span class="menu-title ">Order พิเศษ</span>
        <i style="margin: 0px;" class="menu-arrow "></i>
      </a>
      <div class="submenu ">
          <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item " id="s511" hidden >   
            @php
                $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
            @endphp
            <a class="nav-link " href="{{url('/shop/special_order/'.$today)}}">สั่ง Order พิเศษ</a>
            </li>
            
          </ul>
      </div>
    </li>

    <li class="nav-item mega-menu" id="main6" hidden >
      <a href="#" tyle="padding: 2px;" class="nav-link">
        <i style="margin: 0px;" class="link-icon mdi mdi-book-multiple"></i>
        <span class="menu-title ">บัญชี</span>
        <i style="margin: 0px;" class="menu-arrow "></i>
      </a>
      <div class="submenu">
       
        
        <div class="col-group-wrapper row">
           <div class="col-group col-md-1" id="m64" hidden>
            <p class="category-heading">รับหมู</p>
            <ul class="submenu-item" >
              <li class="nav-item" id="s641" hidden>
                <a class="nav-link" href="{{url('add_pig/คอกขาย')}}">รับหมู</a>
              </li>
            </ul>
          </div>
          
          <div class="col-group col-md-3" id="m62" hidden >
            <p class="category-heading">บิล</p>
            <ul class="submenu-item">
              <ul class="submenu-item " style=" width: 280px;">
                 <li class="nav-item " id="s621" hidden >
                    <a class="nav-link " href="{{url('/bill_iv')}}">ใบส่งของ</a>
                  </li>
                  <li class="nav-item " id="s622" hidden >
                    <a class="nav-link " href="{{url('/bill_ivsum')}}">ใบวางบิล/ใบแจ้งหนี้</a>
                  </li>
                  <li class="nav-item " id="s623" hidden >
                    <a class="nav-link " href="{{url('/bill_rvm')}}">บันทึกการรับเงิน</a>
                  </li>
                  <li class="nav-item " id="s624" hidden >
                    <a class="nav-link " href="{{url('/receipt_fully')}}">ใบเสร็จรับเงิน</a>
                  </li>
                  <li class="nav-item " id="s625" hidden >
                    <a class="nav-link " href="{{url('/report_sales')}}">รายงานยอดขาย</a>
                  </li>
            </ul>
            </ul>
          </div>

          <div class="col-group col-md-3" id="m61" hidden >
            <p class="category-heading">รายงาน</p>
            <ul class="submenu-item">
              <ul class="submenu-item " style=" width: 280px;">
                <li class="nav-item " id="s611" hidden >
                  <a class="nav-link " href="{{url('/importExportView')}}">รายงานการขายหน้าร้าน</a>
                </li>
                <li class="nav-item " id="s612" hidden >
                  <a class="nav-link " href="{{url('/importShopPurchase')}}">รายงานสรุปการซื้อของหน้าร้าน</a>
                </li>
                <li class="nav-item " id="s613" hidden >
                  <a class="nav-link " href="{{url('/importCompare')}}">รายงานเปรียบเทียบน้ำหนัก</a>
                </li>
                {{-- <li class="nav-item ">
                  <a class="nav-link " href="{{url('/importCompare_daily')}}">รายงานเปรียบเทียบน้ำหนัก (รวมรายวัน)</a>
                </li> --}}
                <li class="nav-item " id="s614" hidden >
                  <a class="nav-link " href="{{url('/yield_slice_main')}}">รายงานการเชือด</a>
                </li>
            </ul>
            </ul>
          </div>
          
          <div class="col-group col-md-2" id="m65" hidden>
            <p class="category-heading">stock</p>
            <ul class="submenu-item" >
              <li class="nav-item" id="s651" hidden>
                <a class="nav-link" href="{{url('stock_main')}}">stock รวม</a>
              </li>
            </ul>
          </div>

          <div class="col-group col-md-3" id="m63" hidden>
            <p class="category-heading">ข้อมูลลูกค้า</p>
            <ul class="submenu-item">
              <ul class="submenu-item " style=" width: 280px;">
                {{-- <p class="category" hidden id="s631x">1</p> --}}
                <li class="nav-item " id="s631" hidden>
                  <a class="nav-link " href="{{url('/customer/add')}}">เพิ่มข้อมูลลูกค้า</a>
                </li>
                <li class="nav-item " id="s632" hidden>
                  <a class="nav-link " href="{{url('/customer/get_all')}}">รายชื่อลูกค้าทั้งหมด</a>
                </li>
                {{-- <p class="category" hidden>2</p> --}}
                <li class="nav-item " id="s633" hidden>
                  <a class="nav-link " href="{{url('/customer/add_creditor')}}">เพิ่มข้อมูลเจ้าหนี้</a>
                </li>
                <li class="nav-item " id="s634" hidden>
                  <a class="nav-link " href="{{url('/customer/get_all_creditor')}}">รายชื่อเจ้าหนี้ทั้งหมด</a>
                </li>
                <li class="nav-item " id="s635" hidden>
                  <a class="nav-link " href="{{url('/customer/customer_group')}}">กำหนดกลุ่มลูกค้าและราคามาตรฐาน</a>
                </li>
            </ul>
            </ul>
          </div>

        </div>
      </div>
    </li> 

    <li class="nav-item mega-menu" id="main7" hidden >
      <a href="#" tyle="padding: 2px;" class="nav-link">
        <i style="margin: 0px;" class="link-icon fa fa-cog"></i>
        <span class="menu-title ">ตั้งค่า</span>
        <i style="margin: 0px;" class="menu-arrow "></i>
      </a>
      <div class="submenu">
        <div class="col-group-wrapper row">
          <div class="col-group col-md-3"  id="m71" hidden >
            <p class="category-heading">ตั้งค่า</p>
            <ul class="submenu-item">
              <ul class="submenu-item " style=" width: 280px;">
                <li class="nav-item " id="s711" hidden >
                  <a class="nav-link " href="{{url('/setting/customer_business')}}">ประเภทธุรกิจลูกค้า</a>
                </li>
                <li class="nav-item " id="s712" hidden >
                  <a class="nav-link " href="{{url('/standard_group_setting')}}">เกณฑ์น้ำหนัก</a>
                </li>
                <li class="nav-item " id="s713" hidden >
                  <a class="nav-link " href="{{url('/setting_user')}}">ตั้งค่าผู้ใช้งาน</a>
                </li>
                <li class="nav-item " id="s714" hidden >
                  <a class="nav-link " href="{{url('setting/shop')}}">ตั้งค่าร้านค้า</a>
                </li>
                <li class="nav-item " id="s715" hidden >
                  <a class="nav-link " href="{{url('/setting_product')}}">ตั้งค่าสินค้า</a>
                </li>
                <li class="nav-item " id="s716" hidden >
                  <a class="nav-link " href="{{url('/setting_promotion')}}">ตั้งค่าโปรโมชั่น</a>
                </li>
                <li class="nav-item " id="s717" hidden >
                  <a class="nav-link " href="{{url('/setting_receipt')}}">รายการขาย</a>
                </li>
                <li class="nav-item " id="s718" hidden >
                  <a class="nav-link " href="{{url('/factory_weighing_date_specify/log_delete')}}">log การลบน้ำหนักในโรงงาน</a>
                </li>
                <li class="nav-item " id="s719" hidden >
                  <a class="nav-link " href="{{url('/ref_order')}}">reference</a>
                </li>
            </ul>
            </ul>
          </div>
        </div>
      </div>
    </li> 

  </ul>

  </div>
</div>


