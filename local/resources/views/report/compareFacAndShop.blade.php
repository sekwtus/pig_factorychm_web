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

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                        <div class="table-responsive">
                            <h2 style="color:red;margin-bottom: 0px;height: 0px;">รายงานน้ำหนักของ Order : {{ $ref_order }}</h2><br><br>
                            <div class="row">
                                <div class="col-3">

                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">รับสุกร</h4><br><br>
                                    <table class="table table-striped table-bordered nowrap" width="100%" id="orderRecieveTable">
                                    <thead class="text-center">
                                        <tr>
                                        <th style="padding: 0px;">No.</th>
                                        <th style="padding: 0px;">เลขที่ดำเนินการ</th>
                                        <th style="padding: 0px;">น้ำหนัก</th>
                                        <th style="padding: 0px;">จำนวน</th>
                                        <th style="padding: 0px;">วันที่ชั่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($select_in_R))
                                            @foreach ($select_in_R as $in_R)
                                            <tr>
                                                <td class="text-center" style="padding: 0px;">No.</td>
                                                <td class="text-center" style="padding: 0px;">{{ $in_R->lot_number }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $in_R->sku_weight }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $in_R->sku_amount }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $in_R->date_ }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    </table>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">เชือดสุกร</h4><br><br>
                                    <table class="table table-striped table-bordered nowrap" width="100%" id="orderKillTable">
                                        <thead class="text-center">
                                            <tr>
                                            <th style="padding: 0px;">No.</th>
                                            <th style="padding: 0px;">เลขที่ดำเนินการ</th>
                                            <th style="padding: 0px;">น้ำหนัก</th>
                                            <th style="padding: 0px;">จำนวน</th>
                                            <th style="padding: 0px;">วันที่ชั่ง</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($select_in_K))
                                                @foreach ($select_in_K as $in_K)
                                                <tr>
                                                        <td class="text-center" style="padding: 0px;">No.</td>
                                                        <td class="text-center" style="padding: 0px;">{{ $in_K->lot_number }}</td>
                                                        <td class="text-center" style="padding: 0px;">{{ $in_K->sku_weight }}</td>
                                                        <td class="text-center" style="padding: 0px;">{{ $in_K->sku_amount }}</td>
                                                        <td class="text-center" style="padding: 0px;">{{ $in_K->date_ }}</td>
                                                </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-3">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">ตัดแต่ง</h4><br><br>
                                    <table class="table table-striped table-bordered nowrap" width="100%" id="orderCutTable">
                                    <thead class="text-center">
                                        <tr>
                                        <th style="padding: 0px;">No.</th>
                                        <th style="padding: 0px;">เลขที่ดำเนินการ</th>
                                        <th style="padding: 0px;">น้ำหนัก</th>
                                        <th style="padding: 0px;">จำนวน</th>
                                        <th style="padding: 0px;">วันที่ชั่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($select_in_CT))
                                            @foreach ($select_in_CT as $in_CT)
                                            <tr>
                                                    <td class="text-center" style="padding: 0px;">No.</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_CT->lot_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_CT->sku_weight }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_CT->sku_amount }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_CT->date_ }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    </table>
                                </div>

                                <div class="col-3">
                                    <h4 class="text-center" style="color:blue;margin-bottom: 0px;height: 0px;">จัดส่ง</h4><br><br>
                                    <table class="table table-striped table-bordered nowrap" width="100%" id="orderTransportTable">
                                    <thead class="text-center">
                                        <tr>
                                        <th style="padding: 0px;">No.</th>
                                        <th style="padding: 0px;">เลขที่ดำเนินการ</th>
                                        <th style="padding: 0px;">น้ำหนัก</th>
                                        <th style="padding: 0px;">จำนวน</th>
                                        <th style="padding: 0px;">วันที่ชั่ง</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($select_in_TS))
                                            @foreach ($select_in_TS as $in_TS)
                                            <tr>
                                                    <td class="text-center" style="padding: 0px;">No.</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_TS->lot_number }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_TS->sku_weight }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_TS->sku_amount }}</td>
                                                    <td class="text-center" style="padding: 0px;">{{ $in_TS->date_ }}</td>
                                            </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                    </table>
                                </div>


                            </div>
                        </div>
                      </div>
                   </div>
                </div>

                {{-- ลบข้อมูล --}}
                {{ Form::open(['method' => 'post' , 'url' => '/product/delete/']) }}
                           <div class="modal fade" id="DELETE" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                  <div class="modal-dialog">
                                      <div class="modal-content">
                                          <div class="modal-header">
                                                  <h4 class="modal-title" id="myModalLabel">ลบรายการรับสุกร-รถบรรทุก</h4>
                                          </div>
                                          <div class="modal-body">
                                                  <h5 >ยืนยันการลบ รายการรับสุกร-รถบรรทุก</h5>
                                          </div>
                                          <div class="modal-footer">
                                              <button type="submit" class="btn btn-danger" id="delete" name="delete" value="delete">ลบ</button>
                                              <button type="button" class="btn btn-default" data-dismiss="modal">ยกเลิก</button>
                                          </div>
                                      </div>
                                  </div>
                           </div>
                {{ Form::close() }}

@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js') }}"></script>
<script src="{{ asset('https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>


    <script>

            var table1 = $('#orderRecieveTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'lrtp',
            });
            var table2 = $('#orderKillTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'lrtp',
            });
            var table3 = $('#orderCutTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'lrtp',
            });
            var table3 = $('#orderTransportTable').DataTable({
                lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
                dom: 'lrtp',
            });

            
            

    </script>

{{-- daterange --}}
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
    $('#daterange').daterangepicker({
        buttonClasses: ['btn', 'btn-sm'],
        applyClass: 'btn-danger',
        cancelClass: 'btn-inverse',
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


@endsection


