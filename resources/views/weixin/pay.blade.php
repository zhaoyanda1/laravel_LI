@extends('layout.goods')
@section('title') {{$title}}    @endsection
@section('content')

<div id="qrcode"></div>


<script src="{{URL::asset('/js/jquery-1.12.4.min.js')}}"></script>
<script src="{{URL::asset('/js/qrcode.min.js')}}"></script>

<script>
    var qrcode = new QRCode('qrcode', {
        text: "{{$url}}",
        width: 256,
        height: 256,
        colorDark : '#000000',
        colorLight : '#ffffff',
        correctLevel : QRCode.CorrectLevel.H
    });


    function check(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url     :   '/payShow',
            type    :   'get',
            dataType:   'json',
            success :   function(msg) {
                if(msg.status==1000){
                    alert(msg.msg);
                    //window.location.href='';
                }else{
                    console.log(1);
                }
            }
        })
    }
    var ids=setInterval('check()',1000);



</script>
@endsection