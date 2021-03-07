function postDeletedata(id){
    $.ajax({
        url: '/cyclings/'+id,
        type: 'POST',
        headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
        data: {'id': id,'_method': 'DELETE'} 
    })
    .done(function() {
        $('.cycling-body-'+ id).remove();
        $('#vertical'+ id).remove();
    })
    .fail(function() {
    cycle('通信に失敗しました。');
    });
}