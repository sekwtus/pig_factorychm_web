@extends('layouts.master')
@section('style')
<style type="text/css">
.input{
        height: 50%;
        background-color: aqua;
}
th,td{
    padding: 0px;
}
</style>
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css') }}" type="text/css" />
<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                      <div class="row">
                        <div class="col-3"><h4>รายการสุกรเข้าโรงงาน</h4></div>
                         <div class="col-2">
                            <a class="btn btn-success btn-fw" data-toggle="modal" data-target="#ADD" >
                                <i class="mdi mdi-plus"></i>รับสุกรเข้าโรงงาน
                           </a>
                        </div>
                      </div>
                        <div class="table-responsive">
                                <table class="table table-striped table-bordered nowrap" width="100%" id="recieveTable">
                                  <thead class="text-center">
                                    <tr>
                                      <th style="padding: 0px;">เลขที่</th>
                                      <th style="padding: 0px;">เลขที่รับสุกร</th>
                                      <th style="padding: 0px;">ลูกค้า</th>
                                      <th style="padding: 0px;">รอบที่</th>
                                      <th style="padding: 0px;">จำนวนสุกร</th>
                                      <th style="padding: 0px;">stock</th>
                                      <th style="padding: 0px;">ประจำวันที่</th>
                                      <th style="padding: 0px;">หมายเหตุ</th>
                                      <th style="padding: 0px;">น้ำหนักรถ + สุกร</th>
                                      {{-- <th style="padding: 0px;">น้ำหนักรถ</th>
                                      <th style="padding: 0px;">น้ำหนักสุกร</th> --}}
                                      <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                                    </tr>
                                  </thead>
                                </table>
                        </div>
                      </div>
                   </div>
                </div>

    {{-- ADDข้อมูล --}}
    <div class="modal fade" id="ADD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="#" id="submit">
                    <div class="forms-sample form-control" style="height: auto;padding-right: 20px;">
                        <div class=" text-center alert alert-fill-danger " style="margin-bottom: 10px;">ใบรับสุกรเข้าโรงงาน</div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-6 pr-md-0">
                                <label for="orderDate">ประจำวันที่</label>
                                <input class="form-control form-control-sm" placeholder="วว/ดด/ปปปป" id="recieve_time" type="text" name="datepicker" required>
                            </div>
                            <div class="col-md-6 pr-md-0">
                                <label for="customer">ลูกค้า/สาขา</label>
                                <select class="form-control form-control-sm" id="customer" name="customer" style=" height: 30px; " required>
                                    <option value=""></option>
                                    @foreach ($customer as $cust)
                                        <option value="{{ $cust->id }}">{{ $cust->customer_name }}</option> 
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-3 pr-md-0">
                                <label for="pig_number">จำนวน(ตัว)</label>
                                <input type="number" class="form-control form-control-sm" id="pig_number" placeholder="จำนวน" required> 
                            </div>
                            <div class="col-md-3 pr-md-0">
                                <label for="round">รอบที่</label>
                                <input type="number" class="form-control form-control-sm" id="round" placeholder="รอบที่" value="1" required> 
                            </div>
                            <div class="col-md-6 pr-md-0">
                                <label for="storage">ที่จัดเก็บ (stock)</label>
                                <select class="form-control form-control-sm " id="storage" name="storage" style=" height: 30px; " required>
                                    <option value=""></option>
                                    @foreach ($storage as $store)
                                        <option value="{{ $store->id_storage }}">{{ $store->name_storage }} - {{ $store->description }}</option> 
                                    @endforeach
                                </select> 
                            </div>
                        </div>

                        <div class="row" style="margin-bottom: 10px;">
                            <div class="col-md-12 pr-md-0">
                                <label for="note">หมายเหตุ</label>
                                <textarea class="form-control form-control-sm" id="note" rows="3" placeholder="หมายเหตุ"></textarea> 
                            </div>
                        </div>

                        <div class="text-center" style="padding-top: 10px;">
                            <button type="submit" class="btn btn-success mr-2" id="comfirmAdd" value="comfirmAdd">ยืนยัน</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>


<script >
    $("#comfirmAdd").on('click', function() {
        $('#comfirmAdd').prop('disabled', true);
        var customer = $('#customer').val();
        var recieve_time = $('#recieve_time').val();
        var orderTerm = $('#round').val();
        var pig_number = $('#pig_number').val();
        var note = $('#note').val();
        var storage = $('#storage').val();
        var customer_name = $('#customer option:selected').text();

        $.ajax({
            type: 'GET',
            url: '{{ url('/add_order') }}',
            data: {customer:customer,recieve_time:recieve_time,storage:storage,
                    orderTerm:orderTerm,pig_number:pig_number,note:note,customer_name:customer_name},
            success: function (msg) {
                // alert(msg);
                location.reload();
            }
        });
        $('#close').click();

    });
</script>


<script>
        var table = $('#recieveTable').DataTable({
            // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
            "scrollX": false,
            orderCellsTop: true,
            fixedHeader: true,
            // processing: true,
            // serverSide: true,
            ajax: '{{ url('/data_recieve') }}',
            columns: [
                { data: 'id', name: 'id' },
                { data: 'order_number', name: 'order_number' },
                { data: 'id_user_customer', name: 'cusid_user_customertomer_name' },
                { data: 'round', name: 'round' },
                { data: 'total_pig', name: 'total_pig' },
                { data: 'name_storage', name: 'name_storage' },
                { data: 'date', name: 'date' },
                { data: 'note', name: 'note' },
                { data: 'id', name: 'id' },
            ],
            columnDefs: [
            {
                "targets": 0,
                "className": "text-center",
            },
            {
                "targets": 1,
                "className": "text-center",
            },
            {
                "targets": 2,
                "className": "text-center",
            },
            {
                "targets": 3,
                "className": "text-center",
            },
            {
                "targets": 4,
                "className": "text-center",
            },
            {
                "targets": 5,
                "className": "text-center",
                render(data,type,row){
                    return data +'-'+row['description'];
                }
            },
            {
                "targets": 6,
                "className": "text-center",
            },
            {
                "targets": 7,
                "className": "text-center",
            },
            {
                "targets": 8,
                "className": "text-center",
                render(data,type,row){
                    return '..... กิโลกรัม';
                }
            },
            {
                "targets": 9,render(data,type,row){

                    var id = row['id'];
                    var order_number = row['order_number'];
                    var sign = "'";

                    if (row['check_order'] == 0) {
                        return '<button style="padding: 7px;" type="button" class="btn btn-warning" onclick="checkOrder('+sign+id+sign+')" title="ตรวจสอบการรับสุกร ?" href="#">\
                                <i class="fa fa-check"></i></button>\
                                <button  style="padding: 7px;" type="button" onclick="deleteRecord('+sign+id+sign+','+sign+order_number+sign+')" class="btn btn-danger" >\
                                <i class="mdi mdi-delete"></i></button></td>';
                    }
                    else{
                        return '<button disabled style="padding: 7px;" type="button" class="btn btn-success"  title="รับสุกรแล้ว" href="#">\
                                <i class="fa fa-check"></i></button>\
                                <button  style="padding: 7px;" type="button" onclick="deleteRecord('+sign+id+sign+','+sign+order_number+sign+')" class="btn btn-danger" >\
                                <i class="mdi mdi-delete"></i></button></td>';
                    }
                    
                            // <button disabled style="padding: 7px;" type="button" class="btn btn-warning" href="{{ url("shop/scale/1") }}">\
                            //     <i class="mdi mdi-pencil"></i></button>\
                            
                }
            },
            ],
            "order": [],
        });
        
        table.on( 'order.dt search.dt', function () {
            table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
        
</script>

    
{{-- datepicker --}}
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    $('#recieve_time').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
        singleDatePicker: true,
        todayBtn: true,
        language: 'th',
        thaiyear: true,
        locale: {
            format: 'DD/MM/YYYY',
            daysOfWeek : [
                            "อา.",
                            "จ.",
                            "อ.",
                            "พ.",
                            "พฤ.",
                            "ศ.",
                            "ส."
                        ],
            monthNames : [
                            "มกราคม",
                            "กุมภาพันธ์",
                            "มีนาคม",
                            "เมษายน",
                            "พฤษภาคม",
                            "มิถุนายน",
                            "กรกฎาคม",
                            "สิงหาคม",
                            "กันยายน",
                            "ตุลาคม",
                            "พฤศจิกายน",
                            "ธันวาคม"
                        ],
            firstDay : 0
        }
    });
</script>

<script>
    function checkOrder(id){
        $.ajax({
            type: 'GET',
            url: '{{ url('/checking_recieve_order') }}',
            data: {id:id},
            success: function (msg) {
                alert(msg);
                location.reload();
            }
        });
    }
</script>

<script>
    function deleteRecord(id,order_number){
        if(confirm('ต้องการลบ : '+order_number+' ?')){
            $.ajax({
                type: 'GET',
                url: '{{ url('delete_pig_to_fac') }}',
                data: {id:id},
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

@endsection


