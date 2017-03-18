<script type="text/javascript" language="javascript" src="//code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript" src="//cdn.datatables.net/responsive/1.0.0/js/dataTables.responsive.min.js"></script>
<script type="text/javascript" class="init">
$(document).ready(function(){
 $("head link[rel='stylesheet']").last().after("<style>.dataTables_wrapper{position: static !important;}</style><link rel='stylesheet' href='//cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css' type='text/css' media='screen'><link rel='stylesheet' href='//cdn.datatables.net/responsive/1.0.0/css/dataTables.responsive.css' type='text/css' media='screen'>");
 var table = $('#myShop-table').DataTable({// DataTable
  "language":{
   "url": "//cdn.datatables.net/plug-ins/1.10.13/i18n/French.json"
  }
 });
 
 table.columns().every(function(){// Apply the search
 //console.log('table.columns.every',this.value);
  if($(this).text()!=''){
   var that = this;
   $('input',this.footer()).on('keyup change',function(){
    if(that.search() !== this.value){
     that
      .search(this.value)
      .draw();
    }
   });
  }
 });
});
</script>