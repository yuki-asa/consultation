$(function(){
    $("#button").bind("click",function(){

    var abc , def, ghi;
    abc = $("#area").val();
    def = $("#possible_date").val();
    ghi = $("#specialty").val();
    re = new RegExp(abc);
    re2 = new RegExp(def);
    re3 = new RegExp(ghi);
        $(".data").each(function(){
            var txt = $(this).find("td").text();
            if(txt.match(re) != null){
                if(txt.match(re2,re3) != null){
                  $(this).show();
                }else{
                  $(this).hide();
                }
            }else{
                $(this).hide();
            }
        });
    });

    $("#button2").bind("click",function(){
        $(".data").show();
    });
});
