<?php
namespace Dash\Extras\Metrics\Contracts\Traits;
trait AjaxCall{

    public function prepareAjaxCall($classname,$model,$typeCalc,$sumColumn,$at,$query='',$query_format=''){
        $model = str_replace('\\','\\\\',$model);
        //dd($classname,$model);
        $selectName = 'select[name=\"'.$classname.'\"]';

        $ajax = '
        <script>
            $(document).on("change","'.$selectName.'",function(){
                var data_'.$classname.' = $("'.$selectName.' option:selected").val();
                var query_'.$classname.' = $(".query_'.$classname.'").val();
                var query_format_'.$classname.' = $(".query_format_'.$classname.'").val();
                $.ajax({
                 url:"'.dash('get/statistics').'",
                 dataType:"json",
                 type:"post",
                 data:{
                    lang:"'.request("lang").'",
                    model:"'.$model.'",
                    range:data_'.$classname.',
                    typeCalc:"'.$typeCalc.'",
                    sumColumn:"'.$sumColumn.'",
                    at:"'.$at.'",
                    query:query_'.$classname.',
                    query_format:query_format_'.$classname.',
                    _token:"'.csrf_token().'"
                },
                 beforeSend: function(){
                    var loader  = "<i class=\"fa fa-spin fa-spinner\"></i>";
                    $(".'.$classname.'").html(loader);
                },success:function(data){
                    console.log(data.result);
                     $(".'.$classname.'").html(data.result);
                 }
                })
            });
        </script>';
        $query_Data = $query?htmlspecialchars($query):'';
        $query_Data_format = $query_format?htmlspecialchars($query_format):'';
        $ajax .= "<input type='hidden' class='query_".$classname."' value='".$query_Data."'/>";
        $ajax .= "<input type='hidden' class='query_format_".$classname."' value='".$query_Data_format."'/>";
        return $ajax;
    }
}
