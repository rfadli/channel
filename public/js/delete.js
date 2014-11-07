$(document).ready(function($) {
	

	$( "body" ).delegate( ".hapus", "click", function(e) {
	        e.preventDefault();
	        var id = $(this).attr('link');
	        var con = $(this).attr('controller');
	        var title = $(this).attr('name'); 
	        bootbox.confirm('Apakah anda yakin akan menghapus data '+con.toUpperCase()+' "'+title.italics()+'" ?', function(result) {
	            if(result)
	            {
	                $('<form action="'+id+'" method="post" ><input name="id" type="hidden" value="'+id+'"/></form>').appendTo('body').submit();
	                return false;
	            }
	        }); 
	        return false;
	    });
	    
});