$('.flab_tab').on('click',function(e){
    e.preventDefault();
    var _this = $(this);
    // console.log(_this.attr('href'));
    $('.flab_tab-content .flab_tab-pane').hide();
    $(_this.attr('href')).show();
    _this.parent().parent().find('li').removeClass('active');
    _this.parent().addClass('active');
})

$('.flab_submit').on('click',function(){
    $('#form_data').submit();
});