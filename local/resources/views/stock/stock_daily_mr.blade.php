@extends('layouts.master')
@section('style')

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

<style>
    body{
        zoom:0.8;
    }
</style>
@endsection

@section('main')

   @php
       echo $date
   @endphp
<div class="row">

  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h4 align="center" class="card-title">Bordered table</h4>
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th> # </th>
                <th> First name </th>
                <th> Progress </th>
                <th> Amount </th>
                <th> Deadline </th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td> 1 </td>
                <td> Herman Beck </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $ 77.99 </td>
                <td> May 15, 2015 </td>
              </tr>
              <tr>
                <td> 2 </td>
                <td> Messsy Adam </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $245.30 </td>
                <td> July 1, 2015 </td>
              </tr>
              <tr>
                <td> 3 </td>
                <td> John Richards </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $138.00 </td>
                <td> Apr 12, 2015 </td>
              </tr>
              <tr>
                <td> 4 </td>
                <td> Peter Meggik </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $ 77.99 </td>
                <td> May 15, 2015 </td>
              </tr>
              <tr>
                <td> 5 </td>
                <td> Edward </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $ 160.25 </td>
                <td> May 03, 2015 </td>
              </tr>
              <tr>
                <td> 6 </td>
                <td> John Doe </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $ 123.21 </td>
                <td> April 05, 2015 </td>
              </tr>
              <tr>
                <td> 7 </td>
                <td> Henry Tom </td>
                <td>
                  <div class="progress">
                    <div class="progress-bar bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td> $ 150.00 </td>
                <td> June 16, 2015 </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <h1 align="center" >รายงาน รับสุกร / Line เชือด</h1>
        
        <div class="table-responsive">
          <table  class="table table-bordered" border="1">
            <thead>
              <tr bgcolor= "#f6f6ee" >
                <th align="center" valign="middle" rowspan="2" >ขั้นตอนการทำงาน </th>
                <th align="center" valign="middle" rowspan="2" >หมายเลขใบงาน/Bill </th>
                <th align="center" valign="middle" rowspan="2" >รหัสสินค้า</th>
                <th align="center" valign="middle" rowspan="2" >รายการสินค้า</th>
                <th align="center" valign="middle" rowspan="2" >ที่จัดเก็บ</th>
                <th align="center" valign="middle" rowspan="2" >หน่วยนับ</th>
                <th align="center" valign="middle" colspan="2" >ยกมา</th>
                <th align="center" valign="middle" rowspan="2" >เฉลี่ย</th>
                <th align="center" valign="middle" colspan="2" >เข้า</th>
                <th align="center" valign="middle" rowspan="2" >เฉลี่ย</th>
                <th align="center" valign="middle" colspan="2" >ออก</th>
                <th align="center" valign="middle" rowspan="2" >เฉลี่ย</th>
                <th align="center" valign="middle" colspan="2" >ผลต่าง</th>
                <th align="center" valign="middle" rowspan="2" >% สูญเสีย</th>
              </tr>
              <tr bgcolor= "#f6f6ee">
                <th  align="center" valign="middle" >จำนวน</th>
                <th  align="center" valign="middle" >น้ำหนัก(Kg.)</th>
                <th  align="center" valign="middle" >จำนวน</th>
                <th  align="center" valign="middle" >น้ำหนัก(Kg.)</th>
                <th  align="center" valign="middle" >จำนวน</th>
                <th  align="center" valign="middle" >น้ำหนัก(Kg.)</th>
                <th  align="center" valign="middle" >จำนวน</th>
                <th  align="center" valign="middle" >น้ำหนัก(Kg.)</th>
              </tr>
            </thead>
            <tbody>
              
                <tr bgcolor= "#f6f6ee" >
                  <td align="center" valign="middle" rowspan="2" >ขั้นตอนการทำงาน </td>
                  <td align="center" valign="middle" rowspan="2" >หมายเลขใบงาน/Bill </td>
                  <td align="center" valign="middle" rowspan="2" >รหัสสินค้า</td>
                  <td align="center" valign="middle" rowspan="2" >รายการสินค้า</td>
                  <td align="center" valign="middle" rowspan="2" >ที่จัดเก็บ</td>
                  <td align="center" valign="middle" rowspan="2" >หน่วยนับ</td>
                  <td align="center" valign="middle" colspan="2" >ยกมา</td>
                  <td align="center" valign="middle" rowspan="2" >เฉลี่ย</td>
                  <td align="center" valign="middle" colspan="2" >เข้า</td>
                  <td align="center" valign="middle" rowspan="2" >เฉลี่ย</td>
                  <td align="center" valign="middle" colspan="2" >ออก</td>
                  <td align="center" valign="middle" rowspan="2" >เฉลี่ย</td>
                  <td align="center" valign="middle" colspan="2" >ผลต่าง</td>
                  <td align="center" valign="middle" rowspan="2" >% สูญเสีย</td>
                </tr>
                <tr bgcolor= "#f6f6ee">
                  <td  align="center" valign="middle" >จำนวน</td>
                  <td  align="center" valign="middle" >น้ำหนัก(Kg.)</td>
                  <td  align="center" valign="middle" >จำนวน</td>
                  <td  align="center" valign="middle" >น้ำหนัก(Kg.)</td>
                  <td  align="center" valign="middle" >จำนวน</td>
                  <td  align="center" valign="middle" >น้ำหนัก(Kg.)</td>
                  <td  align="center" valign="middle" >จำนวน</td>
                  <td  align="center" valign="middle" >น้ำหนัก(Kg.)</td>
                </tr>
  
              
            <tr>
              <td ><b>คอกสุกร</b></td>
              <td >7170/358494, 7170/358495, 7170/358496(หมูขุน)</td>
              <td >XK</td>
              <td >หมูร้าน</td>
              <td>คอกหมู</td>
              <td>ตัว</td>
              <td>140</b></td>
              <td>14117.00<</td>
              <td>100.84</td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
              <td></td>
            </tr>
            
          </tbody></table>
        </div>
        </div>
      </div>
    </div>       
</div>



@endsection
@section('script')
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

<script>
    function deleteRecord(order_number){
        if(confirm('ต้องการลบ : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_importCompare') }}',
                data: {order_number:order_number},
                success: function (msg) {
                    alert(msg);
                    location.reload();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus); alert("Error: " + errorThrown);
                }
            });
        }
    }
</script>
<script>
        var table = $('#tbl-1').DataTable({
            lengthMenu: [[-1], ["All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            "ordering": false,
            // rowReorder: true,
            dom: 'Brt',
            // "order": [[ 1, "desc" ]],
            buttons: [
                'excel','copy','print'
                //  'pdf', 'print'
            ],
            // processing: true,
            // serverSide: true,
        });
        // table.on( 'order.dt search.dt', function () {
        //     table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
        //         cell.innerHTML = i+1;
        //     } );
        // } ).draw();
</script>

@endsection