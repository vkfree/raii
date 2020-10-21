var qty = -1;
function productQty(e){
    var op = jQuery(e).attr("class");
    var target = jQuery(e).attr("data-target");
    qty = jQuery(target).attr('data-value');
        if(op == 'minus'){
            if(qty>1){
                qty--;
            }
        }
        else{
            qty++;
        }
    jQuery(target).attr('data-value',qty);
    jQuery(target).text(qty);
}
