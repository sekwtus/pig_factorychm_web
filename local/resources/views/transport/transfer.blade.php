<table id="transfer_out" class="tbl table-hover" width="100%" border="1">
    <thead>
        <tr class="bg-secondary text-center" ><th colspan="25" style=" padding: 0px;"><h3> รายงานการโอนออก
            <span style="color:red;">{{ $select_cutting_number[0]->id_user_customer =='' ? '' : $select_cutting_number[0]->id_user_customer }}</span>
            วันที่ <span style="color:red;">{{ $select_cutting_number[0]->date_transport == '' ? '' : substr($select_cutting_number[0]->date_transport,3,2).'/'.substr($select_cutting_number[0]->date_transport,0,2).'/'.substr($select_cutting_number[0]->date_transport,6,4) }} </span>
            เลขที่บิล <span style="color:red;">{{ $select_cutting_number[0]->order_number }}
                <input type="text" hidden name="tr_number" value="{{ $select_cutting_number[0]->order_number }}">
            </span></h3></th>
        </tr>
        <tr class="bg-secondary">
            <th class="text-center" style="padding: 0px;">No.</th>
            <th class="text-center" style="padding: 0px;">ชื่อ item </th>
            <th class="text-center" style="padding: 0px;">โอนไปสาขา</th>
            <th class="text-center" style="padding: 0px;">1</th>
            <th class="text-center" style="padding: 0px;">2</th>
            <th class="text-center" style="padding: 0px;">3</th>
            <th class="text-center" style="padding: 0px;">4</th>
            <th class="text-center" style="padding: 0px;">5</th>
            <th class="text-center" style="padding: 0px;">6</th>
            <th class="text-center" style="padding: 0px;">7</th>
            <th class="text-center" style="padding: 0px;">8</th>
            <th class="text-center" style="padding: 0px;">9</th>
            <th class="text-center" style="padding: 0px;">10</th>
            <th class="text-center" style="padding: 0px;">11</th>
            <th class="text-center" style="padding: 0px;">12</th>
            <th class="text-center" style="padding: 0px;">13</th>
            <th class="text-center" style="padding: 0px;">14</th>
            <th class="text-center" style="padding: 0px;">15</th>
            <th class="text-center" style="padding: 0px;">น้ำหนัก</th>
            <th class="text-center" style="padding: 0px;">จำนวน</th>
            <th class="text-center" style="padding: 0px;">ตรวจสอบ</th>
        </tr>
    </thead>
    <tbody>
        @php $sum_weight = 0;
             $sum_unit   = 0;
        @endphp

        @foreach ($select_weight_transfer_group as $result)
            @php
                // $span = (int)($result->count_unit/20);
                // if ( ($result->count_unit % 20) != 0 || $result->count_unit == 0) {
                //     $span = $span +1;
                // }
            @endphp
            <tr>
                    <td class="text-center bg-secondary" style="padding: 0px;width: 80px;" rowspan="{{ $span }}">{{ $result->item_code }}</td>
                    <td class="text-center" style="padding: 0px;width: 200px;" rowspan="{{ $span }}">{{ $result->item_name }}</td>
                    <td class="text-center" style="padding: 0px;width: 200px;" rowspan="{{ $span }}">{{ $result->location_scale }}</td>
                        @php $i = 15; @endphp
                        @foreach ($select_weight_transfer as $in_order)
                                @if ($in_order->item_code == $result->item_code && $i > 0  && $in_order->weighing_place == $result->weighing_place )
                                    <td class="text-center" style="padding: 0px; width: 50px;"><a href="#"  data-toggle="modal" data-target="#edit" onclick="editRecord('{{ $in_order->id }}')" >{{ $in_order->sku_weight }}</a></td>
                                    @php $i = $i-1; @endphp
                                @endif
                        @endforeach
                        @for ($j= 0; $j < $i; $j++)
                    <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                        @endfor
                    <td class="text-center" style="padding: 0px; width: 80px;" rowspan="{{ $span }}">
                        {{ ($result->sum_weight != 0 ? $result->sum_weight : 0) }}
                        @php
                            $sum_weight = $sum_weight + ($result->sum_weight != 0 ? $result->sum_weight : 0);
                        @endphp
                    </td>
                    <td class="text-center" style="padding: 0px; width: 80px;" rowspan="{{ $span }}">
                        {{ $result->count_unit }}
                        @php
                            $sum_unit = $sum_unit + $result->count_unit;
                        @endphp
                    </td>
                    <td class="text-center" style="padding: 0px; width: 40px;" rowspan="{{ $span }}">
                        {{-- @foreach ($report_transport_check as $transport_check)
                            @if ($transport_check->item_code == $result->item_code)
                                <input type="number" hidden id="code_check[]" name="code_check[]" value="{{ $result->item_code }}" style=" padding: 0px; width: 45px; height: auto;">
                                <input type="number" id="unit_check[]" name="unit_check[]" value="{{ $transport_check->check_unit }}" style=" padding: 0px; width: 45px; height: auto;">
                            @endif
                        @endforeach --}}
                    </td>
            </tr>

            {{-- @for ($row = 1; $row < $span; $row++)
            <tr>
                <td hidden class="text-center bg-secondary" style="padding: 0px;"></td>
                <td hidden class="text-center" style="padding: 0px;"></td>
                    @php $i = 20*($row+1); @endphp
                    @foreach ($select_weight_in_order as $in_order)

                        @if ($in_order->sku_code == $result->item_code && $i >= 20 )
                            @php $i = $i-1;@endphp
                        @endif

                        @if($in_order->sku_code == $result->item_code && $i >= 0 && $i < 20)
                            <td class="text-center" style="padding: 0px; width: 50px;"><a href="#" data-toggle="modal" data-target="#edit" onclick="editRecord('{{ $in_order->id }}')" > {{ $in_order->sku_weight }} </a></td>
                            @php $i = $i-1; @endphp
                        @endif
                            
                    @endforeach
                    @for ($j= 0; $j < $i+1; $j++)
                        <td class="text-center" style="padding: 0px; width: 50px;"></td>  
                    @endfor
                <td hidden class="text-center" style="padding: 0px;"></td>
                <td hidden class="text-center" style="padding: 0px;"></td>
                <td hidden class="text-center" style="padding: 0px;"></td>
            </tr>
            @endfor --}}
        @endforeach

        {{-- สรุปรวม --}}
        <tr style="background-color:#ffbeba;">
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>

            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ></td>
            <td class="text-center" style="padding: 0px;" ><b> รวม </b></td>
            
            <td class="text-center" style="padding: 0px;" ><b>{{ $sum_weight }}</b></td>
            <td class="text-center" style="padding: 0px;" ><b>{{ $sum_unit }}</b></td>
            <td class="text-center" style="padding: 0px;" ><b></b></td>
        </tr>
      
    </tbody>
</table>

