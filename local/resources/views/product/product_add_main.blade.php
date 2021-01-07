@extends('layouts.master')
@section('style')

@endsection
@section('main')
  <div class="col-12 grid-margin">
    <form action="{{ url('/product_add') }}" method="post">
    {{ csrf_field() }}
      <div class="card">
        <div class="card-body">
          <h4>เพิ่มแผนผลิตโรงงานเชือดชำแหละ</h4>
          <div class="collapse show" role="tabpanel" data-parent="#accordion">
            <div class="form-group">
                <label for="exampleInputNo" name="no">เลขที่</label>
                <input type="text" name="no" class="form-control txtNo" placeholder="กรอกเลขที่" onfocusout="validate1(this.name)">
            </div>

              <div class="card">
                <div class="collapse show" role="tabpanel" data-parent="#accordion">
                  <div class="card-body">
                    <div class="div-tbl-detail table-responsive">
                      <table class="table table-bordered">
                        <thead class="text-center thead-light">
                          <tr>
                            <th>ลำดับ</th>
                            <th>ชื่อลูกค้า/Group</th>
                            <th>จำนวนตัว</th>
                            <th>เลือกประเภทการผ่า</th>
                            <th>หมายเหตุ</th>
                            <th>ลบ</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr class="tr-btn">
                            <td colspan="6" class="text-center">
                              <h5 class="text-danger remark" style="display:none;">กรุณากรอกข้อมูลให้ครบทุกช่อง</h5>
                              <button type="button" class="btn btn-lg btn-outline-primary w-50" onclick="add_row()"><i class="fa fa-plus"></i> เพิ่ม Product</button>
                            </td>
                          </tr>
                        </tbody>
                      </table>
                  </div>
                </div>
              </div>
            </div><br>
              <div class="text-center">
                <button type="submit" class="btn btn-success mr-2 btn-add" >บันทึก</button>
                <a class="btn btn-danger" href="{{url('/product')}}">ยกเลิก</a>
              </div>
        </div>
        </div>
      </div>
    </form>
  </div>
@endsection


@section('script')
<script>

  function validate1(name){
    if($('input[name="'+name+'"]').val() == '' || $('select[name="'+name+'"]').val() == '0' ) {
      $('input[name="'+name+'"]').css('border-color', '#FF0000');
      $('select[name="'+name+'"]').css('border-color', '#FF0000');
      $('.btn-add').attr('disabled',true);
    }else{
      $('input[name="'+name+'"]').css('border-color', '#2eb82e');
      $('select[name="'+name+'"]').css('border-color', '#2eb82e');
      $('.btn-add').attr('disabled',false)
    }
  }

  function runnumber(){
      var row = $('.tr-detail').length; //console.log(row);
      if(row==0){
        $('.remark').hide();
        $('.btn-add').attr('disabled',true);
      }else{
        for(i=0; i<row; i++){
          var n = (i+1);
          $('.no').eq(i).text(i+1);
          $('.tr-detail').eq(i).addClass('tr-'+n);
          $('.txtCustomer').eq(i).attr({name:'txtCustomer['+n+']', onfocusout:'validate1(this.name)'});
          $('.txtAmount').eq(i).attr({name:'txtAmount['+n+']', onfocusout:'validate1(this.name)'});
          $('.ddlType').eq(i).attr({name:'ddlType['+n+']', onfocusout:'validate1(this.name)'});
          $('.txtNote').eq(i).attr({name:'txtNote['+n+']', onfocusout:'validate1(this.name)'});
          $('.del').eq(i).attr('onclick','delete_row('+n+')');
        }
        $('.remark').show();
        $('.btn-add').attr('disabled',false);
      }
  }

  function add_row(){
      var row;
      row = '<tr class="tr-detail">';
      row += '<td class="text-center no"></td>';
      row += '<td><input type="text" class="form-control txtCustomer" name="txtCustomer[]" placeholder="ชื่อลูกค้า/Group"></td>';
      row += '<td><input type="text" class="form-control txtAmount" name="txtAmount[] placeholder="จำนวนตัว"></td>';
      row += '<td><select class="form-control ddlType" name="ddlType[]"><option value="0">เลือกประเภทการผ่า</option> <option value="C1">C1</option><option value="C2">C2</option><option value="C3">C3</option> <option value="อื่นๆ">อื่นๆ</option>  </select></td>';
      row += '<td><input type="text" class="form-control txtNote" name="txtNote[] placeholder="หมายเหตุ"></td>';
      row += '<td class="text-center w60"><a style="cursor:pointer; color:red;" class="del" title="ลบข้อมูล"><i class="mdi mdi-36px mdi-close-outline"></i></a></td>';
      row += '</tr>';
      $('.tr-btn:first').before(row); console.log($('.tr-detail').length);
      // if($('.tr-detail').length < $('.txtInvAmt').val()){
      // }else{
      //   console.log($('.tr-detail').length+' เกินจำนวน')
      // }
      runnumber(); //console.log($('.div-tbl-insert').height());
      if($('.div-tbl-detail').height() >= 600){
        $('.div-tbl-detail').css({height:'600'});
      }
  }

  function delete_row(i){
      $('.tr-'+i).remove();
      runnumber();
      if($('.div-tbl-detail').height() <= 600){
        $('.div-tbl-detail').css({height:'auto'});
      }
  }

  $('.btn-add').click(function() {
    var row = $('.tr-detail').length;
    if(row == 0){
      alert('ยังไม่ได้เพิ่มข้อมูล');
      $(this).attr('disabled',true);
    }
    if($('.txtNo').val()==''){
      $(this).attr('disabled',true);
      $('.txtNo').css('border-color','red');
    }

    for(i=0; i < row; i++){
      if($('.txtCustomer').eq(i).val()==''){
        $(this).attr('disabled',true);
        $('.txtCustomer').eq(i).css('border-color','red');
      }
      if($('.txtAmount').eq(i).val()==''){
        $(this).attr('disabled',true);
        $('.txtAmount').eq(i).css('border-color','red');
      }
      if($('.ddlType').eq(i).val()=='0'){
        $(this).attr('disabled',true);
        $('.ddlType').eq(i).css('border-color','red');
      }
      if($('.txtNote').eq(i).val()==''){
        $(this).attr('disabled',true);
        $('.txtNote').eq(i).css('border-color','red');
      }
    }
  });


</script>
@endsection
