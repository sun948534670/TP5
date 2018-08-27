layui.use(['carousel'], function () {
    var carousel = layui.carousel;
    //建造轮播实例
    carousel.render({
        elem: '#index_carousel'
        ,width: '100%' //设置容器宽度
        ,height: '350px' //设置容器宽度
        ,arrow: 'none' //始终显示箭头
    });
    carousel.render({
        elem: '#hot_carousel'
        ,width: '100%' //设置容器宽度
        ,height: '335px' //设置容器宽度
        ,arrow:'always'
        ,indicator:'none'
        ,interval:5000
    });
    carousel.render({
        elem: '#catagory_carousel'
        ,width: '100%' //设置容器宽度
        ,height: '335px' //设置容器宽度
        ,arrow:'always'
        ,indicator:'none'
        ,interval:5000
    });


});