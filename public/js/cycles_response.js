 $(window).resize(function(){
    var cycles = document.getElementsByClassName('cycle_card');
    //windowの幅をxに代入
    var winsize = $(window).width();
    for (var i = 0; i<cycles.length; i++) {
        if (991 < winsize){
            $('#'+cycles[i].id).addClass('col-sm-4').removeClass('col-sm-3 col-sm-6');
        }else if(768 < winsize && winsize <= 991){
            $('#'+cycles[i].id).addClass('col-sm-6').removeClass('col-sm-3 col-sm-4');
        }else if(575< winsize && winsize <= 768){
            $('#'+cycles[i].id).addClass('col-sm-6').removeClass('col-sm-4 col-sm-3');
        }else{
            $('#'+cycles[i].id).addClass('col-sm-3').removeClass('col-sm-6 col-sm-4');
        }
    }
});