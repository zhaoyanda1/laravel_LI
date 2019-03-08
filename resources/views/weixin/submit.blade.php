@extends('layout.goods')

@section('title') {{$title}}    @endsection

@section('nav')
    @parent
@endsection

@section('content')
    <div class="top_menu" style="margin-bottom: 20px;">
        <p>
            <button>一级菜单按钮</button>
            名称：<input type="text" class="top_name">
            <button class="top_btn">克隆</button>
        </p >
        <div style="margin-left: 20px;margin-bottom: 5px;" class="two_menu">
            <button>二级菜单按钮</button>&nbsp;&nbsp;<button class="two_btn">克隆</button>
            <div>
                按钮类型：<select class="two_btn_type">
                    <option value="view">VIEW</option>
                    <option value="click">CLICK</option>
                </select></br>
                二级按钮名称：<input type="text" class="two_btn_name"></br>
                二级按钮url：<input type="text" class="two_btn_url"></br>
                二级按钮key：<input type="text" class="two_btn_key">
            </div>
        </div>
    </div>
    <div>
        <button id="sub_btn">发布</button>
    </div>
@endsection'

@section('footer')
    @parent
    <script>
        $(function () {
            //克隆二级菜单
            $(document).on('click','.two_btn',function () {
                var _this = $(this);
                //二级
                var _div_two = _this.parents('.two_menu');
                //二级个数
                var two_length = _this.parents('.top_menu').find('.two_menu').length;
                console.log(two_length);
                if(two_length<3){
                    _div_two.after(_div_two.clone());
                }

            })

            //克隆一级菜单
            $(document).on('click','.top_btn',function () {
                var _this = $(this);
                var _div = _this.parents('.top_menu');
                //console.log(_div.length);
                if($('.top_menu').length<3){
                    _div.after(_div.clone());
                }
            });
                //处理数组
                $('#sub_btn').click(function(){
                    top_info = {};
                    $('.top_menu').each(function (i) {
                        info = {};
                        info['name']  = $(this).find('p').find('.top_name').val();
                        data = {};
                        $(this).find('.two_menu').each(function (e) {
                            two_data = {};
                            //console.log($(this).find('div').find('.two_btn_type').val());
                            two_data['type'] = $(this).find('div').find('.two_btn_type').val();
                            two_data['name'] = $(this).find('.two_btn_name').val();

                            if($(this).find('div').find('.two_btn_type').val() == 'view'){
                                two_data['url'] = $(this).find('.two_btn_url').val();
                            }else{
                                two_data['key'] = $(this).find('.two_btn_key').val();
                            }

                            data[e] = two_data;
                        });
                        info['sub_button'] = data;
                        top_info[i] = info;
                    })
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        url:     '/weixin/createMenu',
                        type:    'post',
                        data:    top_info,
                        dataType: 'json',
                        success:   function (a) {
                            if(a.errcode == 0){
                                alert('发布成功')
                            }
                        }
                    });
                });
            })
    </script>
@endsection

