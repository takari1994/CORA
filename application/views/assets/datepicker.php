<script type="text/javascript">
    var nowTemp = new Date();
    var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
 
    var x = $('.datepicker-input').datepicker({
        onRender: function(date) {
            return date.valueOf() < now.valueOf() ? 'disabled' : '';
        }
    }).on('changeDate',function(e) {
        x.hide();    
    }).data('datepicker');
    
    var y = $('.datepicker-input-normal').datepicker().on('changeDate',function(e) {
        y.hide();    
    }).data('datepicker'); 
</script>