jQuery(document).ready(function($)
{	
	
		/* Init Sub total
		--------------------*/
		function initUploadUpdate()
		{
			$('.detail').each(function()
			{
				var detail = $(this);
				$(this).find('a.delete').click(function(){detail.remove(); return false; });
			});
			$('.tk_upload').click(function() {
		
				var $this = $(this);
				window.send_to_editor = function(html) 
				
				{
					imgurl = jQuery('img',html).attr('src');
					$this.prev('input').val(imgurl);
					tb_remove();
				}
			 
			 
				tb_show('', 'media-upload.php?post_id='+$('#post_ID').attr('value')+'&type=image&TB_iframe=true');
				return false;
				
			});
		}
		initUploadUpdate();
		
		
		/* add Detail Button
		---------------------*/
		$('a.add-detail').click(function()
		{
			$('.details .detail:last').clone().appendTo('.details');
			$('.details .detail:last input[type=text]').val('');
			//$('.details .detail:last .title input[type=text]').val('');
			$('.details .detail:last textarea').html('');
			initUploadUpdate();
			return false;
		});

		/* Sortable
		--------------------*/
		if($('div.details').length > 0)
		{
			$('div.details').sortable({
				accept : 'detail',
				opacity: 	0.5,
				fit :	false,
				placeholder: 'detail-placeholder'
			});
		}
		
});