
    <li class="nav-item">
      <a href="#" tyle="padding: 2px;" class="nav-link">
        <i style="margin: 0px;" class="link-icon fa fa-edit"></i>
        <span class="menu-title ">ฝ่ายเซล</span>
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
      <span class="menu-title ">Stock</span>
      <i style="margin: 0px;" class="menu-arrow "></i>
    </a>
    <div class="submenu ">
        <ul class="submenu-item ">
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
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/customer/get_all')}}">รายชื่อลูกค้าทั้งหมด</a>
            </li>
            <li class="nav-item ">
              <a class="nav-link " href="{{url('/customer/add')}}">เพิ่มข้อมูลลูกค้า</a>
            </li>
          </ul>
      </div>
  </li>