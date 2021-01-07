<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>replaceWith demo</title>
  <style>
  button {
    display: block;
    margin: 3px;
    color: red;
    width: 200px;
  }
  div {
    color: red;
    border: 2px solid blue;
    width: 200px;
    margin: 3px;
    text-align: center;
  }
  </style>
  <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<body>
 
<button onclick="mySet()">First</button>
<button>Second</button>
<button>Third</button>
 
<script>
$( "button" ).click(function() {
  $( this ).replaceWith( "<div>" + $( this ).text() + "</div>" );
});
</script>

<script>
    function mySet() {
        alert("Hello");
    }
</script>

{{-- --------------------------------- --}}



<button onclick="myFunction()">Try it</button>
<script>
function myFunction() {
  alert("Hello! I am an alert box!");
}
</script>


{{-- --------------------------------- --}}

<input type="text" name="name" id="nameq" >
<button onclick="mymo()">ok</button>
<script>
    function mymo(){
        value = $("#nameq").val().; 
        alert(value);
    }
</script>


<br>
{{-- --------------------------------- --}}

<script type="text/javascript" src="http://code.jquery.com/jquery-1.4.3.min.js" ></script>
<script type="text/javascript">
    $(document).ready(function(){
        $("#txt_name").keyup(function(){
            alert($(this).val());
        });
    })
</script>





<br><p>========================</p>
{{-- --------------------------------- --}}

<p>woww</p>
<p>Hi</p>

<ol>
  <li>1</li>
  <li>2</li>
  <li>3</li>
</ol>

<button id="b1">WoWW</button>
<button id="b2">Hi</button>

<script>
        $(document).ready(function(){
          $("#b1").click(function(){
            $("p").append(" <b>wow</b>.");
          });
          $("#b2").click(function(){
            $("ol").append("<li>Hi</li>");
            
          });
        });
        </script>



<br><p>========================</p>

{{-- 

<script type='text/javascript'>
    function addFields(){
        // Number of inputs to create
        var number = document.getElementById("member").value;
        // Container <div> where dynamic content will be placed
        var container = document.getElementById("container");
        // Clear previous contents of the container
        while (container.hasChildNodes()) {
            container.removeChild(container.lastChild);
        }
        for (i=0;i<number;i++){
            // Append a node with a random text
            container.appendChild(document.createTextNode("Member " + (i+1)));
            // Create an <input> element, set its type and name attributes
            var input = document.createElement("input");
            input.type = "text";
            input.name = "member" + i;
            container.appendChild(input);
            // Append a line break 
            container.appendChild(document.createElement("br"));
        }
    }
</script>
</head>
<body>
<input type="text" id="member" name="member" value="">max 10<br />
<a href="#" id="filldetails" onclick="addFields()">Details</a>
<div id="container">
</body>
 --}}




<p>===========================</p>
<br>

{{-- $(this).append(
    $('<input>', {
        type: 'text',
        val: $('#div1').text()
    })
); --}}





  <button onclick="add()">Add</button>
  {{-- <button onclick="remove()">remove</button> --}}
  <div id="new_chq"></div>
  <input type="hidden" value="0" id="total_chq">

{{-- <button onclick="add()" >Try </button>
<input type="hidden" value="1" id="total_chq"> --}}
<script>
  var a= 0;
  function add(){
      //var new_chq_no = parseInt($('#total_chq').val())+1;
      a +=1;
      var new_chq_no = parseInt(a);
      console.log(new_chq_no);
      var new_input="<input type='text' id='new_"+new_chq_no+"' value='"+new_chq_no+"'>";
      $('#new_chq').append(new_input);
      //$('#total_chq').val(new_chq_no)
      
    }
    // function remove(){
    //   var last_chq_no = $('#total_chq').val();
    //   if(last_chq_no>1){
    //     $('#new_'+last_chq_no).remove();
    //     $('#total_chq').val(last_chq_no-1);
    //   }
    // }
// function myFunc() {
//   $(document).ready(function(){
//             $("#IN").append(" <input type="text">.");
//           });
   
// }
</script>


<p>========================================================</p>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
<script>
	$(document).ready(function(){
		first();                   // เมื่อ page ถูกโหลดจะทำฟังก์ชัน first ก่อน
		$('#btnAdd').click(first); // เมื่อ click จะสร้าง element ขึ้นมาใหม่(สร้างอินพุตใหม่)
		$('#btnSend').click(send); //เมื่อคลิกจะทำฟังก์ชัน send
	});
	
	function first(){
		var id = $('#cover div').length+1;            // นับว่ามี tag div กี่อันแล้ว แล้ว +1
		var wrapper = $("<div id=\"field"+id+"\">");  // สร้าง div
		var parag   = $("<p>เบอร์โทร\""+id+"\"</p>");   // สร้าง p
		var text    = $("<input type='text' name=\"tel"+id+"\" />"); // สร้าง input
		var btnDel  = $("<input type='button' value='del' id=\"btn"+id+"\"/>"); 
		btnDel.click(function(){
			$(this).parent().remove();			
		});
		
		wrapper.append(parag);   
		wrapper.append(text);
		wrapper.append(btnDel);
		$('#cover').append(wrapper);
	}
	
	function send(){  //นับ div ทั้งหมดก่อนส่ง
		var id= $('#cover div').length;
		var hiddens = $("<input type='hidden' name='hidden' value=\""+id+"\"/>");
		$('form').append(hiddens);
		$('form').submit(); 
	}
</script>
</head>
<body>
<form method="post" action="receive.php">
   <div id="cover"> 
   </div>
   <input type="button" id="btnAdd" value="add66" />
</form>
   <input type="button" id="btnSend" value="send"/>
</body>
</html>

<p>==============================</p>

<form name="frm_test" method="post" action="index.php" onsubmit="doSubmit(this)">
<input type="text" name="test">
<input type="submit" name="btn_submit" />
<input type="button" onclick="doTestClick()" value="Test Submit" />
</form>
<script type="text/javascript">
function doTestClick() {
    frm_test.submit(); // submit form ด้วย Javascript
};
function doSubmit(form) {
    alert(form.test.value);
};
</script>

<p>===========update===============</p>

{{-- <script language="javascript" type="text/javascript">

    function create(){
    var mySpan = document.getElementById('mySpan');

    var myElement1 = document.createElement('input');
    myElement1.setAttribute('type', 'text');
    myElement1.setAttribute('name', 'txtSiteName[]');
    myElement1.setAttribute('id',"txt1");

    mySpan.appendChild(myElement1);
    mySpan.appendChild(document.createElement('br'));
    }

    function delete(){
    var mySpan = document.getElementById('mySpan');
    var deleteEle = document.getElementById('txt1');
    mySpan.removeChild(deleteEle);
    }
    </script>
    
   
    <form action="#" method="post" name="form1">
    <input type="text" name="txtSiteName[]"><br>
    <input type="text" name="txtSiteName[]"><br>
    <input type="text" name="txtSiteName[]"><br>
    <span id="mySpan"></span>
  
    <input name="btnButton" id="btnButton" type="button" value="Createwww" onClick="JavaScript:create();">
    <input name="nButton" id="nButton" type="button" value="Deleterr" onClick="JavaScript:delete();">
    </form> --}}

<p>==================</p>

<script language="javascript" type="text/javascript">


function add($i){
var s =$i++;
var mySpan = document.getElementById('mySpan');
var myElement1 = document.createElement('input');
    myElement1.setAttribute('type', 'text');
    myElement1.setAttribute('id',"txt1[]");
    myElement1.setAttribute('value',s);
    mySpan.appendChild(myElement1);
    mySpan.appendChild(document.createElement('br'));
}

function dd(){
var mySpan = document.getElementById('mySpan');
var deleteEle = document.getElementById('txt1');
    mySpan.removeChild(deleteEle);
}

</script>

<span id="mySpan"></span>
<input name="btnButton" id="btnButton" type="button" value="add" onClick="add(1);">
<input name="nButton" id="nButton" type="button" value="Delete" onClick="JavaScript:dd();">

















</body>
</html>