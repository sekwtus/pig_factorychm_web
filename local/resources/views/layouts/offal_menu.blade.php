
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
                  <a class="nav-link " href="{{url('/offal_order')}}">สร้าง Order เครื่องใน</a>
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
        </ul>
    </div>
  </li>

  <li class="nav-item">
    <a href="#" tyle="padding: 2px;" class="nav-link">
      <i style="margin: 0px;" class="link-icon fa fa-cubes"></i>
      <span class="menu-title " >Stock</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item " style=" width: 280px;">
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/stock_main')}}">คลังสินค้า</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/stock/factory_daily')}}">รายงานสต๊อกเคลื่อนไหวโรงเชือด</a>
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
