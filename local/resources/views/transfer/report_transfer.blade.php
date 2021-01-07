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
    .bodyzoom{
    zoom: 0.9;
}
</style>

<link rel="stylesheet" href="{{ url('https://cdn.datatables.net/1.10.18/css/dataTables.semanticui.min.css') }}" type="text/css" />
{{-- <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" /> --}}
<link rel="stylesheet" href="{{ asset('assets/css/daterangepicker.css')}}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" />

@endsection
@section('main')
              <div class="col-lg-12 grid-margin bodyzoom">
                <div class="card">
                  <div class="card-body">
                    {{-- <h2 class="text-center" style="margin-bottom: 0px;height: 0px;">รายงานตรวจสอบน้ำหนักชิ้นส่วนสุกรในกระบวนการผลิต <span style="color:red;">
                         สาขา {{ $select_order_result[0]->shop_name=='' ? '' : $select_order_result[0]->shop_name }}</span></h2><br><br> --}}
                        <div class="row">
                                <div class="col-12 px-0">
                                    
                                <table id="tbl-3" class="tbl " width="100%" border="1">
                                    <thead>
                                        <tr class="bg-secondary text-center" ><th colspan="9" style=" padding: 0px;"><h3> รายงานเปรียบเทียบน้ำหนักชิ้นส่วนสุกร โรงงาน-ร้านค้า 
                                            <span style="color:red;">สาขา {{ $select_order_result[0]->shop_name=='' ? '' : $select_order_result[0]->shop_name }}
                                            ประจำวันที่ {{ $select_order_result[0]->date == '' ? '' : substr($select_order_result[0]->date,3,2).'/'.substr($select_order_result[0]->date,0,2).'/'.substr($select_order_result[0]->date,6,4) }} </span> </h3></th>
                                        </tr>
                                        <tr class="bg-secondary text-center">
                                            <th width="60%" style=" padding: 0px;" colspan="5">น้ำหนักชิ้นส่วน (โรงงาน)</th>
                                            <th width="20%" style=" padding: 0px;" colspan="2">น้ำหนักชิ้นส่วน (ร้านค้า)</th>
                                            <th width="20%" style=" padding: 0px;" colspan="2">ผลต่าง (dift)</th>
                                        </tr>
                                        <tr>
                                            <th class="text-center" style="padding: 0px;">No.</th>
                                            <th class="text-center" style="padding: 0px;">รหัส item </th>
                                            <th class="text-center" style="padding: 0px;">ชื่อ item </th>
                                            <th class="text-center" style="padding: 0px;">น้ำหนัก(โรงงาน)</th>
                                            <th class="text-center" style="padding: 0px;">จำนวน(โรงงาน)</th>
                                            <th class="text-center" style="padding: 0px;">น้ำหนัก(ร้านค้า)</th>
                                            <th class="text-center" style="padding: 0px;">จำนวน(ร้านค้า)</th>
                                            <th class="text-center" style="padding: 0px;background-color:#ffbeba;">น้ำหนัก(dift)</th>
                                            <th class="text-center" style="padding: 0px;background-color:#ffbeba;">จำนวน(dift)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sum_weight_factory = 0;
                                            $sum_unit_factory = 0; 
                                            $sum_yiled_factory =0;
                                            $count = 1;
                                            $total_=100;
                                        @endphp 
                                        @php $sum_weight_shop = 0;
                                            $sum_unit_shop = 0; 
                                            $sum_yiled_shop =0;
                                            $count = 1;
                                            $sum_weight_factory != 0 ? $sum_weight_factory = $sum_weight_factory : $sum_weight_factory = 1;
                                        @endphp 
                                        @php $sum_weight_dift = 0;
                                            $sum_unit_dift = 0; 
                                            $sum_yiled_dift =0;
                                            $count = 1;
                                        @endphp 

                                        @foreach ($select_order_result as $result)
                                            <tr>
                                                <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ empty($result->total_weight) ? 0 : $result->total_weight }}
                                                    @php
                                                        $sum_weight_factory = $sum_weight_factory + $result->total_weight;
                                                    @endphp
                                                </td>
                                                <td class="text-center" style="padding: 0px;">{{ empty($result->unit) ? 0 : $result->unit }}
                                                    @php
                                                        $sum_unit_factory = $sum_unit_factory + $result->unit;
                                                    @endphp
                                                </td>

                                            {{-- shop --}}
                                            @foreach ($select_shop_result as $result2)
                                                @if ($result2->item_code == $result->item_code)
                                                <td class="text-center" style="padding: 0px;">{{ empty($result2->total_weight) ? 0 : $result2->total_weight }}
                                                    @php
                                                        $sum_weight_shop = $sum_weight_shop + $result2->total_weight;
                                                    @endphp
                                                </td>
                                                <td class="text-center" style="padding: 0px;">{{ empty($result2->unit) ? 0 : $result2->unit }}
                                                    @php
                                                        $sum_unit_shop = $sum_unit_shop + $result2->unit;
                                                    @endphp
                                                </td>
                                                
                                                {{-- compare --}}
                                                <td class="text-center" style="padding: 0px;background-color:#ffbeba;color:red;">{{ number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '') }}
                                                    @php
                                                        $sum_weight_dift = $sum_weight_dift + number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '');
                                                    @endphp
                                                </td>
                                                <td class="text-center" style="padding: 0px;background-color:#ffbeba;color:red;">{{ $result2->unit - $result->unit }}
                                                    @php
                                                        $sum_unit_dift = $sum_unit_dift + ($result2->unit - $result->unit);
                                                    @endphp
                                                </td>

                                                @endif
                                            @endforeach
                                            </tr>
                                        @endforeach

                                        {{-- แปรรูป --}}

                                        @foreach ($select_order_result_transform as $result)
                                            <tr>
                                                <td class="text-center" style="padding: 0px;">{{ $count++ }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $result->item_code }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ $result->item_name }}</td>
                                                <td class="text-center" style="padding: 0px;">{{ empty($result->total_weight) ? 0 : $result->total_weight }}
                                                    @php
                                                        $sum_weight_factory = $sum_weight_factory + $result->total_weight;
                                                    @endphp
                                                </td>
                                                <td class="text-center" style="padding: 0px;">{{ empty($result->unit) ? 0 : $result->unit }}
                                                    @php
                                                        $sum_unit_factory = $sum_unit_factory + $result->unit;
                                                    @endphp
                                                </td>
                                                
                                            {{-- shop --}}
                                            @foreach ($select_shop_result_transform as $result2)
                                                @if ($result2->item_code == $result->item_code)
                                                <td class="text-center" style="padding: 0px;">{{ empty($result2->total_weight) ? 0 : $result2->total_weight }}
                                                    @php
                                                        $sum_weight_shop = $sum_weight_shop + $result2->total_weight;
                                                    @endphp
                                                </td>
                                                <td class="text-center" style="padding: 0px;">{{ empty($result2->unit) ? 0 : $result2->unit }}
                                                    @php
                                                        $sum_unit_shop = $sum_unit_shop + $result2->unit;
                                                    @endphp
                                                </td>

                                                {{-- compare --}}
                                                <td class="text-center" style="padding: 0px;background-color:#ffbeba;color:red;"> {{ number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '') }}
                                                    @php
                                                      $sum_weight_dift =  $sum_weight_dift + number_format( (float)($result2->total_weight)-($result->total_weight), 2, '.', '');
                                                    @endphp
                                                </td>
                                                <td class="text-center" style="padding: 0px;background-color:#ffbeba;color:red;">{{ $result2->unit - $result->unit }}
                                                    @php
                                                        $sum_unit_dift = $sum_unit_dift + ($result2->unit - $result->unit);
                                                    @endphp
                                                </td>

                                                @endif
                                            @endforeach
                                            </tr>
                                        @endforeach

                                        {{-- สรุปรวม --}}
                                            <tr style="background-color:#ffbeba;">
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ></td>
                                                <td class="text-center" style="padding: 0px;" ><b>รวม</b></td>
                                                <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight_factory }}</b></td>
                                                <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit_factory }}</b></td>

                                                
                                                <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight_shop }}</b></td>
                                                <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit_shop }}</b></td>

                                                
                                                <td class="text-center" style="padding: 0px;color:red;"><b>{{ number_format( $sum_weight_dift, 2, '.', '') }}</b></td>
                                                <td class="text-center" style="padding: 0px;color:red;" ><b>{{ $sum_unit_dift }}</b></td>

                                            </tr>
                                    </tbody>
                                </table>
                                </div>
                              </div>

                      <hr>
                        

                    
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
{{-- <script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js') }}"></script> --}}
<script src="{{ asset('/js/buttons.html5.js') }}"></script>

<script src="{{ asset('https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js') }}"></script>

    <script>
            var table = $('#tbl-3').DataTable({
                lengthMenu: [[200, -1], [200, "All"]],
                "scrollX": false,
                orderCellsTop: true,
                fixedHeader: true,
                rowReorder: true,
                dom: 'lBfrtip',
                buttons: [
                    // 'excel',
                    {
                        extend: 'excel',
                        messageTop: " รายงานเปรียบเทียบน้ำหนักชิ้นส่วนสุกร โรงงาน-ร้านค้า สาขา {{ $select_order_result[0]->shop_name=='' ? '' : $select_order_result[0]->shop_name }}\
                         ประจำวันที่ {{ $select_order_result[0]->date=='' ? '' : substr($select_order_result[0]->date,3,2).'/'.substr($select_order_result[0]->date,0,2).'/'.substr($select_order_result[0]->date,6,4) }}",
                        customize: function( xlsx ) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            $('row c[r^="H"]', sheet).each( function () {
                                    $(this).attr( 's', '60' );
                            });
                            $('row c[r^="I"]', sheet).each( function () {
                                    $(this).attr( 's', '12' );
                            });
                        },
                    },
                    //  'pdf', 'print'
                ],
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['Sheet1.xml'];
                    $('row c*', sheet).attr( 's', '25' );
                },
                // processing: true,
                // serverSide: true,
                "order": [],
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


