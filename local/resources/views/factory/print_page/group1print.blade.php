{{-- group1 --}}
@foreach ($item_group_main as $key => $item_mian) 
@php
    $row_group = 0;
    $check_group = 0;
    $check_weight = 0;
if ($group_row_span[$key]->count_row == 0){
    $span = 5;
}
else{ $span = 3; }

// นน.รายวัน น้ำหนักdefualt 0 
for($i = 0; $i < count($shop_list); $i++){
    $check_exist_data[$i] = 0;
}
$sum = 0;
$weight_balance = 0;
$sum_weight_balance = 0;
$check_fill_exist = 0;
$check_fill_exist2 = 0;
$check_fill_exist2_data= 0;
$weight1005 = 0;
$unit1005 = 0;
@endphp

{{-- นน.รายวัน เก็บค่าแทน 0 --}}
@foreach ($weight_daily as $weight_)
@if ($weight_->item_code == $item_mian->item_code)
        @foreach ($shop_list as $key_ => $shop_)
            @if ($weight_->marker == $shop_->marker)
                @php
                    $check_exist_data[$key_] = $weight_->weight_number;
                    $sum = $sum + $check_exist_data[$key_];
                @endphp
            @endif
        @endforeach
    @endif 
@endforeach
 
<tr>
    <td style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">{{ $item_mian->item_code }}</td>
    <td style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span }}">{{ $item_mian->item_name }}</td>
    <td  hidden style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">{{ $item_mian->yield_main }}</td>

    @if ($item_mian->yield_main*$sum_number_of_pig != 0)
        <td hidden  style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">{{ $item_mian->yield_main*$sum_number_of_pig }} </td>
    @else
        <td  hidden style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">{{ $sum_number_of_pig }} </td>

    @endif

    {{-- <td style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">{{ $item_mian->yield_main*$sum_number_of_pig }} </td> --}}
    <td  hidden style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">{{ ($item_mian->yield_per_one == null ? '' : number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '') ) }}</td>

    @foreach ($sp_summary_weight as $summary_weight)
        @if ($item_mian->item_code2 == $summary_weight->item_code2)
        <td  hidden style="padding: 0px; height: 20px; background-color:#80ff80;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}" >
            @if ($item_mian->item_code2 == 1005)
            
                {{ $summary_weight->weight_total - ( $sum_code1075 * number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '')) }}

                @php
                    $weight_balance = $summary_weight->weight_total- ( $sum_code1075 * number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', ''));
                    $weight1005 = $summary_weight->weight_total - ( $sum_code1075 * number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', ''))
                @endphp
            @else
                {{ $summary_weight->weight_total  }}

                @php
                    $weight_balance = $summary_weight->weight_total;
                @endphp
            @endif
        

        </td>
        @endif
    @endforeach

    @foreach ($sp_summary_weight as $summary_weight)
        @if ($item_mian->item_code2 == $summary_weight->item_code2)
        <td  hidden  style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}" >

            @if ($item_mian->item_code2 == 1005)
                {{ number_format($weight1005/ ($item_mian->yield_main/$item_mian->yield_per_one),0,'.','') }}
                @php
                    $weight_balance =  number_format($weight1005/ ($item_mian->yield_main/$item_mian->yield_per_one),0,'.','');
                    $check_weight++;
                @endphp
            @else
                {{ number_format($summary_weight->weight_total/ ($item_mian->yield_main/$item_mian->yield_per_one),0,'.','') }}
                @php
                    $weight_balance = $summary_weight->weight_total;
                    $check_weight++;
                @endphp
            @endif
        </td>
        @endif
    @endforeach
    
    {{-- @foreach ($final_weight as $final_weights)
        @if ($item_mian->item_code == $final_weights->item_code_main)
        
        <td style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}"> 
            {{  ($item_mian->yield_per_one == null ? '' : number_format( ( ( $item_mian->yield_main*floatval($sum_number_of_pig) ) - 
            ( $final_weights->sum_number_of_item*$final_weights->base_yeild ) )/ ($item_mian->yield_main/$item_mian->yield_per_one)  , 0, '.', '') ) }}
        </td>
        @php
            $check_weight++;
        @endphp
        @endif
    @endforeach --}}
    
    {{-- ไม่มีในorderพิเศษ --}}
    @if ($check_weight == 0)
        
            @foreach ($shop_request_fill as $request_fill)
            @if ($request_fill->item_code == $item_mian->item_code)
            <td  hidden style="padding: 0px; height: 20px; background-color:#ff8080;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}" >{{ $request_fill->weight*$sum_number_of_pig }}</td>
                @php
                    $check_fill_exist2++;
                    $check_fill_exist2_data = $request_fill->weight*$sum_number_of_pig;
                @endphp 
            @endif
            @endforeach

            @if ($check_fill_exist2 == 0)
            <td  hidden style="padding: 0px; height: 20px; background-color:#9fff9f;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}" >{{ $item_mian->yield_main == null ? $sum_number_of_pig : $item_mian->yield_main*$sum_number_of_pig }}</td>
            @php
                $weight_balance = ( $item_mian->yield_main == null ? $sum_number_of_pig : $item_mian->yield_main*$sum_number_of_pig );
            @endphp
            @endif

        <td hidden  style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span+($group_row_span[$key]->count_row *2) }}">
            {{ ($item_mian->yield_per_one == null ? '' : number_format( $item_mian->yield_main*$sum_number_of_pig / ($item_mian->yield_main/$item_mian->yield_per_one), 2, '.', '') ) }}
        </td>
    @endif
    


    <td style="padding: 0px; height: 20px;" class="text-center" rowspan="{{ $span }}" colspan="{{ count($shop_list) }}"></td>
    
    {{-- @foreach ($shop_list as $key_shop => $shop)
        <td style="padding: 0px; height: 20px; background-color:#00ff40;" class="text-center" >{{ number_format( ($check_exist_data[$key_shop] == 0 ? 0 :($check_exist_data[$key_shop]*100)/$sum)  , 2, '.', '') }}</td>
    @endforeach --}}

    @php $percent100 = 0; @endphp
    @foreach ($shop_list as $key_shop => $shop)
        @php $shop = $shop->shop_code; @endphp
        @foreach ($base_percent as $percent)
            @if ($percent->item_code2 == $item_mian->item_code2)
                <td style="padding: 0px; height: 20px; background-color:#00ff40;" class="text-center" >
                    <input type="text" style="border-width: 0px;background-color:#00ff40; padding: 0px;width: 35px;height: 25px;"  id="setpercent[]" name="percent[{{ $shop }}][{{ $percent->item_code2 }}]" class="text-center" value="{{ $percent->$shop }}" /></td>
                    {{-- {{ ($percent->$shop == null ? 0 : $percent->$shop) }} --}}
                </td>
                @php $percent100 = $percent100 + $percent->$shop; @endphp
            @endif
        @endforeach
    @endforeach

    <td style="padding: 0px; height: 20px;" class="text-center">{{ $percent100 }}</td>
    <td style="padding: 0px; height: 20px;" class="text-center">% 
        <button hidden  type="submit" name="save_percent" value="1" class="btn btn-success mr-2" style=" padding: 0px;  height: 22px;">save</button>
    </td>
</tr>

<tr>
    @foreach ($shop_list as $key_shop2 => $shop)
        @php $shop = $shop->shop_code;
        $shop_weight_group[] = 0; @endphp

        @foreach ($base_percent as $percent)
            @if ($percent->item_code2 == $item_mian->item_code2 && $weight_balance != 0)
                <td style="padding: 0px; height: 20px;" class="text-center">
                    
                    @if ($item_mian->item_code2 == 1005)
                        {{ ($percent->$shop == null ? 0 : number_format( ($percent->$shop*$weight1005 ) / 100 , 0,'.','' ) ) }}</td>
                        @php 
                            $sum_weight_balance = $sum_weight_balance + ($percent->$shop*$weight1005 ) / 100 ;
                            $shop_weight_group[$key_shop2] = ($percent->$shop*$weight1005 ) / 100;
                        @endphp
                    @else
                        {{ ($percent->$shop == null ? 0 : number_format( ($percent->$shop*$weight_balance ) / 100 , 0,'.','' ) ) }}</td>
                        @php 
                            $sum_weight_balance = $sum_weight_balance + ($percent->$shop*$weight_balance ) / 100 ;
                            $shop_weight_group[$key_shop2] = ($percent->$shop*$weight_balance ) / 100;
                        @endphp
                    @endif

            @elseif ($percent->item_code2 == $item_mian->item_code2 && $weight_balance == 0)
                <td style="padding: 0px; height: 20px;" class="text-center">
                    {{ ($percent->$shop == null ? 0 : number_format( ($percent->$shop*$weight_balance ) / 100 , 0,'.','' ) ) }}</td>
                @php 
                    $sum_weight_balance = $sum_weight_balance + ($percent->$shop*$weight_balance ) / 100 ;
                    $shop_weight_group[$key_shop2] = ($percent->$shop*$weight_balance ) / 100;
                @endphp
            @endif
        @endforeach
        
    @endforeach
    <td style="padding: 0px; height: 20px;" class="text-center">{{ number_format($sum_weight_balance,0,'.','') }}</td>
    <td style="padding: 0px; height: 20px;" class="text-center">น้ำหนัก (กก.)</td>
</tr>


    @php
        foreach ($shop_list as $ar => $shop){
            foreach ($item_group_main as $key => $item_mian1) {
                    $array1[$item_mian1->id][$ar] = 0;
            } 
        }
        
        foreach ($shop_list as $ar => $shop_data_group){
            foreach ($shop_request_data_group as $key_code => $request_data_group){
                if ( $item_mian->id == $request_data_group->group_main && $shop_data_group->shop_code == $request_data_group->shop_code){
                    $array1[$request_data_group->group_main][$ar] = $request_data_group->sum_number_of_item;
                }
            }
        }
        $sum_number_unit = 0;
    @endphp


<tr>
    @if ($item_mian->yield_per_one == null)
        
        {{-- กรณีใส้ใหญ่ ไม่มียีล --}}
        @foreach ($shop_list as $key_shop => $shop)
            @php $shop_code = $shop->shop_code; @endphp
            @foreach ($base_percent as $percent)

                @if ($percent->item_code2 == $item_mian->item_code2)
                    <td style="padding: 0px; height: 20px;background-color:#ffa6ff;" class="text-center">
                        {{ number_format( ($percent->$shop_code*$weight_balance/100) - $array1[$item_mian->id][$key_shop] , 0, '.', '') }}</td>
                    </td>
                    
                    <input type="text" name="number_item[{{ $shop->shop_code }}][{{ $item_mian->item_code2 }}]"
                        value="{{ number_format( ($percent->$shop_code*$weight_balance/100) - $array1[$item_mian->id][$key_shop] , 2, '.', '')   }}" hidden/>

                    @php
                        $sum_number_unit = $sum_number_unit + 
                        number_format( ($percent->$shop_code*$weight_balance/100) - $array1[$item_mian->id][$key_shop] , 2, '.', '') ;
                    @endphp

                @endif

            @endforeach
        @endforeach

    @else

        @foreach ($shop_list as $ar =>  $shop)
        <td style="padding: 0px; height: 20px;background-color:#ffa6ff;" class="text-center">
            {{-- save weight --}}
            <input type="text" name="number_item[{{ $shop->shop_code }}][{{ $item_mian->item_code2 }}]" 
            value="{{ number_format( $shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] , 2, '.', '')  }}" hidden/>
            {{ number_format( $shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] , 0, '.', '')  }}

            @php
                $sum_number_unit = $sum_number_unit + 
            ( number_format( $shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] , 2, '.', '')  );
            @endphp
        </td>
        @endforeach
    
    @endif

    {{-- รวมจำนวนที่ต้องผลิตได้ --}}
    @php
        $sum_shop_request1 = 0;
        foreach ($shop_request_list as $shop_request_list_group){
            for ($ar=0; $ar < count($shop_list) ; $ar++) { 
                foreach ($shop_request_data as $key_code => $request_data){
                        $shoparray[$shop_request_list_group->order_special_id][$ar] = 0;
                }
                
            }
            foreach ($shop_list as $key_shop => $shop){
                foreach ($shop_request_data as $key_code => $request_data){
                    if ($shop->shop_code == $request_data->shop_code && $shop_request_list_group->order_special_id == $request_data->order_special_id){
                        ($shoparray[$shop_request_list_group->order_special_id][$key_shop] = $request_data->number_of_item);
                    }
                }
            }
            
            if ($shop_request_list_group->group_main == $item_mian->id){
                for ($i = 0; $i < count($shop_list); $i++){
                    $sum_shop_request1 = $sum_shop_request1 + $shoparray[$shop_request_list_group->order_special_id][$i];
                }
            }
        }
    @endphp

    <td style="padding: 0px; height: 20px;" class="text-center">
        @if ($item_mian->item_code2 == 1005)
            {{ number_format($sum_shop_request1+$sum_number_unit,0,'.','') - $sum_code1075 }}
        @else
            {{ number_format($sum_shop_request1+$sum_number_unit,0,'.','') }}
        @endif
        
    </td>

    <td style="padding: 0px; height: 20px;" class="text-center">{{ $item_mian->unit }}</td>
</tr>

    @foreach ($shop_request_list as $shop_request_list_group)
        @php
            for ($ar=0; $ar < count($shop_list) ; $ar++) { 
                foreach ($shop_request_data as $key_code => $request_data){
                        $shoparray[$shop_request_list_group->order_special_id][$ar] = 0;
                }
                
            }
            foreach ($shop_list as $key_shop => $shop){
                foreach ($shop_request_data as $key_code => $request_data){
                    if ($shop->shop_code == $request_data->shop_code && $shop_request_list_group->order_special_id == $request_data->order_special_id){
                        $shoparray[$shop_request_list_group->order_special_id][$key_shop] = $request_data->number_of_item;
                    }
                }
            }
        @endphp
    
        @if ($shop_request_list_group->group_main == $item_mian->id)
        <tr>
            <td style="padding: 0px; height: 20px;background-color:#ffe8e8;" class="text-center" rowspan="2">{{ $shop_request_list_group->main_name.' '.$shop_request_list_group->description_item }}</td>
            @foreach ($shop_list as $ikey => $shop)
                <td style="padding: 0px; height: 20px; background-color:#ffff00;" class="text-center" >
                    {{ number_format( ($shop_request_list_group->yield_per_one == null ? 0 : $shoparray[$shop_request_list_group->order_special_id][$ikey]/$shop_request_list_group->yield_per_one),1,'.', '' ) }}</td>
            @endforeach 

            @if ($row_group == 0)
            @foreach ($shop_list as $ar =>  $shop)
                <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center">
                    {{ ($item_mian->yield_per_one == null || $shop_request_list_group->yield_per_one == null ? 0 : number_format( ($shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] )/$shop_request_list_group->yield_per_one, 1, '.', '')  ) }}
                    {{-- @php
                        $sum_number_unit = $sum_number_unit + ($item_mian->yield_per_one == null ? 0 : number_format( $shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] , 2, '.', '')  );
                    @endphp --}}
                </td>
            @endforeach
                <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center" colspan="2"> จำนวนถุง </td>
                @php $row_group++; @endphp
            @endif
        </tr>
        <tr>
            {{-- <td style="padding: 0px; height: 20px;" class="text-center" >{{ $shop_request_list_group->main_name.' '.$shop_request_list_group->description_item }}</td> --}}
        
            @php $code1075 = 0; @endphp
            @for ($i = 0; $i < count($shop_list); $i++)
                <td style="padding: 0px; height: 20px;" class="text-center"> {{ $shoparray[$shop_request_list_group->order_special_id][$i] }}</td>
                @php
                    if ( $shop_request_list_group->item_code2 == 1075){
                        $code1075 = $code1075 + $shoparray[$shop_request_list_group->order_special_id][$i];
                    }
                @endphp
            @endfor
                @php
                    if ( $shop_request_list_group->item_code2 == 1075){
                        echo '<td style="padding: 0px; height: 20px;" class="text-center" colspan="'.(count($shop_list)) .'"></td>
                        <td style="padding: 0px; height: 20px; background-color:#ff7979; " class="text-center">'.$code1075.'</td>
                        <td style="padding: 0px; height: 20px; background-color:#ff7979; " class="text-center">'.$code1075 * number_format( $item_mian->yield_main/$item_mian->yield_per_one , 2, '.', '').'</td>';
                        
                    }else{
                        echo '<td style="padding: 0px; height: 20px;" class="text-center" colspan="'.(count($shop_list)+2) .'"></td>';
                    }
                @endphp
        </tr>
        @endif
    @endforeach

    @if ($row_group == 0)
    <tr>
        {{-- @foreach ($shop_list as $shop)
            <td style="padding: 0px; height: 20px; background-color:#ffff00;" class="text-center" >{{ $item_mian->unit_contian }}</td>
        @endforeach --}}
        @php
            $number_unit_div_weight = 0;
        @endphp
        @foreach ($shop_list as $ar =>  $shop)
            <td style="padding: 0px; height: 20px; background-color:#ffff00;" class="text-center" >
                @php
                    $number_unit_div_weight = ($item_mian->yield_per_one == null ? 0 : number_format( $shop_weight_group[$ar]/( $item_mian->yield_main/$item_mian->yield_per_one)-$array1[$item_mian->id][$ar] , 1, '.', '')  );
                @endphp
                {{ number_format( ($item_mian->unit_contian == null ? 0 : $number_unit_div_weight/$item_mian->unit_contian), 1 ,'.','') }}
            </td>
        @endforeach

        <td style="padding: 0px; height: 20px;background-color:#ffff00;" class="text-center" colspan="2"> จำนวนถุง</td>
        @php $row_group++; @endphp
    </tr>
    <tr>
        <td style="padding: 0px; height: 20px;" class="text-center" colspan="{{ count($shop_list)+2 }}"> </td>
    </tr>
    @endif

@endforeach
{{-- group1 --}}