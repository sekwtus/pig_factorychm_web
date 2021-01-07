
<div class="nav-bottom">
  <div class="container">
    <ul class="nav page-navigation">

  <li class="nav-item" id="m01">
      <a href="{{url('/')}}" class="nav-link">
          <i style="margin: 0px;" class="link-icon mdi mdi-home"></i>
          <span class="menu-title">หน้าแรก</span>
      </a>
  </li>
  
  <li class="nav-item" id="m02" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-edit"></i>
      <span class="menu-title">ฝ่ายเซล</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
          <li class="nav-item ">
            <a class="nav-link " href="{{url('order/number_of_pig')}}">จำนวนหมูส่งร้าน</a>
          </li>
          <hr>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/order/create')}}">สร้าง Order รับสุกร</a>
          </li>
          <hr>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/customer/get_all')}}">รายชื่อลูกค้าทั้งหมด</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/customer/add')}}">เพิ่มข้อมูลลูกค้า</a>
          </li>
        </ul>
    </div>
  </li>
 
  <li class="nav-item" id="m03" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-paste"></i>
      <span class="menu-title ">แผนโรงงาน</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            {{-- <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/1')}}">แผนการรับสุกร</a>
            </li> --}}
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/all_plan')}}">แผนผลิตทั้งหมด</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/2')}}">แผนการเชือด</a>
            </li> 
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/offal_order')}}">สร้าง Order เครื่องใน</a>
            </li><hr>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/overnight_order')}}">เบิกซาก Overnight</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/cutting_order')}}">สร้าง Order ตัดแต่ง</a>
            </li>
             {{-- <hr> --}}
            {{-- <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_cutting/3')}}">แผนการตัดแต่ง</a>
            </li> --}}
            {{-- <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/4')}}">แผนการจัดส่ง</a>
            </li> --}}
            {{-- <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_transport')}}">แผนการจัดส่ง</a>
            </li>  --}}
            {{-- <hr>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/lot')}}">หมายเลขการผลิต</a>
            </li> --}}
        </ul>
    </div>
  </li>

  <li class="nav-item" id="m04" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-truck"></i>
      <span class="menu-title ">จัดส่ง</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('order_transport/create_tr')}}">แผนการจัดส่ง</a>
            </li> 
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/checking_order')}}">ตรวจสอบสินค้า</a>
            </li>
        </ul>
    </div>
  </li>

  <li class="nav-item" id="m05" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-pig"></i>
      <span class="menu-title ">โรงงาน</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('factory_weighing_date_specify')}}">รายงานการชั่งน้ำหนัก</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('transform_main')}}">รายงานการแปรสภาพ</a>
            </li>
        </ul>
    </div>
  </li>

  <li class="nav-item" id="m06" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-store"></i>
      <span class="menu-title ">ร้านค้า</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/weighing/general')}}">รายงานการชั่งน้ำหนัก</a>
            </li>
            {{-- <li class="nav-item ">
              <a class="nav-link " href="{{url('/weight/transfer_product')}}">รายงานการชั่งน้ำหนัก (โอนสินค้า)</a>
            </li>

            <li class="nav-item ">
              <a class="nav-link " href="{{url('/weight/stock')}}">รายงานการชั่งน้ำหนัก (นับสต๊อก)</a>
            </li> --}}
            <hr>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('shop_transform_main')}}">รายงานการแปรสภาพ</a>
            </li>
            <hr>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/product_transfer')}}">สร้างรายการโอนสินค้า</a>
            </li>
            {{-- <li class="nav-item ">
              <a class="nav-link " href="{{url('/report_transfer/TR191219-C10')}}">ตรวจสอบรายการโอนสินค้า</a>
            </li> --}}
        </ul>
    </div>
  </li>

  <li class="nav-item" id="m07" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-exclamation-circle"></i>
      <span class="menu-title ">Order พิเศษ</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
          <li class="nav-item ">
            @php
                $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
            @endphp
            <a class="nav-link " href="{{url('shop/shop_request_all')}}">รายการ Order พิเศษ</a>
          </li>
          <li class="nav-item">
            <a class="nav-link " href="{{url('shop/daily_sales_all')}}">รายงานใบสั่งสินค้า,ใบแกะ,ใบคนงาน</a>
          </li>
          {{-- <li class="nav-item ">
            <a class="nav-link " href="{{url('shop/average_percent/'.$today)}}">เฉลี่ยเปอร์เซ็นให้ร้านค้า</a>
          </li> --}}
          
          {{-- <li class="nav-item ">
            <a class="nav-link " href="{{url('factory/receive_sp_order_1')}}">ใบสั่งสินค้า 1</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('factory/receive_sp_order_2')}}">ใบสั่งสินค้า 2</a>
          </li> --}}
        </ul>
    </div>
  </li>
    
  <li class="nav-item" id="m11" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-exclamation-circle"></i>
      <span class="menu-title ">Order พิเศษ</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
          <li class="nav-item ">   
          @php
              $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
          @endphp
          <a class="nav-link " href="{{url('/shop/special_order/'.$today)}}">สั่ง Order พิเศษ</a>
          </li>
          
        </ul>
    </div>
  </li>

  <li class="nav-item" id="m08" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-book-multiple"></i>
      <span class="menu-title ">บัญชี</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/importExportView')}}">รายงานการขายหน้าร้าน</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/importShopPurchase')}}">รายงานสรุปการซื้อของหน้าร้าน</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/importCompare')}}">รายงานเปรียบเทียบน้ำหนัก</a>
            </li>
            {{-- <li class="nav-item ">
              <a class="nav-link " href="{{url('/importCompare_daily')}}">รายงานเปรียบเทียบน้ำหนัก (รวมรายวัน)</a>
            </li> --}}
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/yield_slice_main')}}">รายงานการเชือด</a>
            </li>
        </ul>
    </div>
    
  </li>

  <li class="nav-item" id="m09" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-cubes"></i>
      <span class="menu-title ">Stock</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/stock_main')}}">คลังสินค้า</a>
            </li>
            {{-- <li class="nav-item ">
              <a class="nav-link " href="{{url('/stock/factory_daily_main')}}">รายงานสต๊อกเคลื่อนไหวโรงเชือด</a>
            </li> --}}
        </ul>
    </div>
  </li>

  <li class="nav-item" id="m10" >
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-cog"></i>
      <span class="menu-title ">ตั้งค่า</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/setting/customer_business')}}">ประเภทธุรกิจลูกค้า</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/standard_group_setting')}}">เกณฑ์น้ำหนัก</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/setting_user')}}">ตั้งค่าผู้ใช้งาน</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('setting/shop')}}">ตั้งค่าร้านค้า</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/setting_product')}}">ตั้งค่าสินค้า</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/setting_promotion')}}">ตั้งค่าโปรโมชั่น</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/setting_receipt')}}">รายการขาย</a>
          </li>
        </ul>
    </div>
  </li>


{{-- @can('IsEmployee_fac')
  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-edit"></i>
      <span class="menu-title ">ฝ่ายเซล</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/order/create')}}">สร้าง Order</a>
          </li>
          <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/all_plan')}}">แผนผลิตทั้งหมด</a>
          </li>
          <hr>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/customer/get_all')}}">รายชื่อลูกค้าทั้งหมด</a>
          </li>
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/customer/add')}}">เพิ่มข้อมูลลูกค้า</a>
          </li>
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-pig"></i>
      <span class="menu-title ">โรงงาน</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            <li class="nav-item ">
                <a class="nav-link " href="{{url('factory_weighing_report')}}">รายงานการชั่งน้ำหนัก</a>
            </li>
            @can('IsAdmin')
            <li class="nav-item ">
              <a class="nav-link " href="{{url('factory_weighing_date_specify')}}">รายงานการชั่งน้ำหนัก (ระบุวัน)</a>
            </li>
            @endcan
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/1')}}">แผนการรับสุกร</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/2')}}">แผนการเชือด</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_cutting/3')}}">แผนการตัดแต่ง</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/4')}}">แผนการจัดส่ง</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/lot')}}">หมายเลขการผลิต</a>
            </li>
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-book-multiple"></i>
      <span class="menu-title ">จัดส่ง</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/checking_order')}}">ตรวจสอบสินค้า</a>
            </li>
        </ul>
    </div>
  </li>

@endcan 

@can('IsEmployee_shop')
  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-store"></i>
      <span class="menu-title ">ร้านค้า</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/weighing/general')}}">รายงานการชั่งน้ำหนัก (ทั่วไป)</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/weight/transfer_product')}}">รายงานการชั่งน้ำหนัก (โอนสินค้า)</a>
            </li>

            <li class="nav-item ">
              <a class="nav-link " href="{{url('/weight/stock')}}">รายงานการชั่งน้ำหนัก (นับสต๊อก)</a>
            </li>
          <hr>
          @php
              $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
              $shop_code = Auth::user()->branch_name;
          @endphp
          <li class="nav-item ">
            <a class="nav-link " href="{{url('/transform/transform_compare/'.$today.'/'.$shop_code)}}">รายงานการแปรสภาพ</a>
          </li>
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-exclamation-circle"></i>
      <span class="menu-title ">Order พิเศษ</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
          <li class="nav-item ">   
          @php
              $today = substr(now(),8,2).substr(now(),5,2).substr(now(),0,4);
          @endphp
          <a class="nav-link " href="{{url('/shop/special_order/'.$today)}}">สั่ง Order พิเศษ</a>
          </li>
          
        </ul>
    </div>
  </li>
@endcan

@can('IsSale')
    @include('layouts.sale_menu')
@endcan

@can('IsOffal')
    @include('layouts.offal_menu')
@endcan

@can('IsCut')
    @include('layouts.cut_menu')
@endcan

@can('IsAdminFac')

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-paste"></i>
      <span class="menu-title ">แผนโรงงาน</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/order/all_plan')}}">แผนผลิตทั้งหมด</a>
            </li>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_daily/2')}}">แผนการเชือด</a>
            </li> <hr>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/offal_order')}}">สร้าง Order เครื่องใน</a>
            </li> <hr>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/cutting_order')}}">สร้าง Order ตัดแต่ง</a>
            </li> <hr>
            <li class="nav-item ">
                <a class="nav-link " href="{{url('/order/plan_transport')}}">แผนการจัดส่ง</a>
            </li> 
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon mdi mdi-pig"></i>
      <span class="menu-title ">โรงงาน</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            <li class="nav-item ">
                <a class="nav-link " href="{{url('factory_weighing_report')}}">รายงานการชั่งน้ำหนัก</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('factory_weighing_date_specify')}}">รายงานการชั่งน้ำหนัก (ระบุวัน)</a>
            </li>
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-truck"></i>
      <span class="menu-title ">จัดส่ง</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/checking_order')}}">ตรวจสอบสินค้า</a>
            </li>
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-cubes"></i>
      <span class="menu-title ">Stock</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/stock_main')}}">คลังสินค้า</a>
            </li>
        </ul>
    </div>
  </li>

  <li class="nav-item">
      <a href="#" tyle="padding: 2px;" class="nav-link">
        <i style="margin: 0px;" class="link-icon fa fa-cog"></i>
        <span class="menu-title ">ตั้งค่า</span>
        <i style="margin: 0px;" class="menu-arrow "></i>
      </a>
      <div class="submenu ">
          <ul class="submenu-item ">
          </ul>
      </div>
  </li>

@endcan --}}

    </ul>

  </div>
</div>


