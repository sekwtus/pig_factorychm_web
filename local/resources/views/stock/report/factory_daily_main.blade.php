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

@endsection
@section('main')

              <div class="col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">

                      <div class="row">
                        <div class="col-4"><h4>รายงานสต๊อกเคลื่อนไหวโรงเชือด</h4></div>
                      </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered nowrap" width="100%" id="table">
                                <thead class="text-center">
                                    <tr>
                                        <th style="padding: 0px;">ลำดับ</th>
                                        <th style="padding: 0px;">รายการ</th>
                                        <th style="text-align:center; padding: 0px;"> ดำเนินการ </th>
                                        <th style="padding: 0px;" class="text-center" hidden></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($daily as $item)
                                    <tr>
                                        <td></td>
                                        <td class="text-center">รายงานสต๊อกเคลื่อนไหวโรงเชือด / ตัดแต่ง ประจำวันที่  <b>{{ $item->plan_carcade }} </b> </td>
                                        <td class="text-center">
                                            <a target="_blank" href="factory_daily/customer/{{ substr($item->plan_carcade ,6,4).'-'.substr($item->plan_carcade ,3,2).'-'.substr($item->plan_carcade ,0,2) }}">
                                            <button title="โรงเชือด สุกรลูกค้า(ส่งแบบซาก)" style="padding: 5px; background-color:#1fe49f; " type="button" class="btn btn-secondary ">โรงเชือด สุกรลูกค้า(ส่งแบบซาก)</button></a>

                                            <a target="blank_" href="factory_daily/branch/{{ substr($item->plan_carcade ,6,4).'-'.substr($item->plan_carcade ,3,2).'-'.substr($item->plan_carcade ,0,2) }}">
                                            <button title="โรงเชือด  สุกรสาขา" style="padding: 5px;  background-color:#1fe49f; " type="button" class="btn btn-secondary ">โรงเชือด  สุกรสาขา</button></a>

                                            <a target="blank_" href="factory_daily_trim/branch/{{ substr($item->plan_carcade ,6,4).'-'.substr($item->plan_carcade ,3,2).'-'.substr($item->plan_carcade ,0,2) }}">
                                                <button title="ตัดแต่ง สุกรสาขา" style="padding: 5px;  background-color:#42a0ff; " type="button" class="btn btn-secondary">ตัดแต่ง สุกรสาขา</button></a>
                                        </td>
                                        <td style="padding: 0px;" class="text-center" hidden>{{  substr($item->plan_carcade ,6,4).substr($item->plan_carcade ,3,2).substr($item->plan_carcade ,0,2) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                      </div>
                   </div>
                </div>

@endsection

@section('script')
<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="{{ asset('https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js') }}"></script>

<script>
    var table = $('#table').DataTable({
        // lengthMenu: [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "scrollX": false,
        orderCellsTop: true,
        fixedHeader: true,
        // processing: true,
        // serverSide: true,
        "order": [[ 3, "desc" ]],
    });
    
    table.on( 'order.dt search.dt', function () {
      table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
    } ).draw();
  
  </script>

@endsection


