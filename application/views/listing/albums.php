<?php
	$archive = $data['Archive'];
	unset($data['Archive']);
	$archiveType = $viewHelper->getArchiveType($data[0]->albumID);
?>
<div id="grid" class="container-fluid"  data-page="1" data-go="1">
    <div id="posts">
<?php foreach ($data as $row) { ?>
        <div class="post">
            <a href="<?=BASE_URL?>listing/archives/<?=$row->albumID?>" title="View Album">
                <div class="fixOverlayDiv">
                    <img class="img-responsive" src="<?=$row->image?>">
                    <div class="OverlayText"><?=$row->brochureCount?><br /><small><?=$viewHelper->getDetailByField($row->description, 'Event')?></small> <span class="link"><i class="fa fa-link"></i></span></div>
                </div>
                <?php if($row->title) { ?><p class="image-desc"><strong><?=$row->title?></strong></p><?php } ?>
            </a>
        </div>
<?php } ?>
    </div>
</div>

<div id="loader-icon">
    <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><br />
    Loading more items
</div>


<script>
$(document).ready(function(){
	
	$('#posts').prepend('<div class="post no-border"><div class="albumTitle <?=$archiveType?>"><span><?=$archiveType?></span></div></div>');
    var archive = <?php echo  '"' . $archive . '"';  ?>;

    function getresult(url) {
        $.ajax({
            url: url,
            type: "GET",
            beforeSend: function(){
            $('#loader-icon').show();
			},
            complete: function(){
                $('#loader-icon').hide();
            },
            success: function(data){
				$('#grid').attr('data-go', '0');
                if(data == "\"noData\"") {

					$('#grid').append('<div id="no-more-icon">No more<br />items<br />to show</div>');
					$('#loader-icon').hide();
					return;
				}
                var gutter = parseInt(jQuery('.post').css('marginBottom'));
                var $grid = $('#posts').masonry({
                    gutter: gutter,
                    itemSelector: '.post',
                    columnWidth: '.post'
                });
                var obj = JSON.parse(data);
                var displayString = "";
                for(i=0;i<Object.keys(obj).length-2;i++)
                {                    
                    displayString = displayString + '<div class="post">';    
                    displayString = displayString + '<a href="' + <?php echo '"' . BASE_URL . '"'; ?> + 'listing/archives/'+ obj[i].albumID + '" title="View Details">';
                    displayString = displayString + '<div class="fixOverlayDiv">';
                    displayString = displayString + '<img class="img-responsive" src="' +  obj[i].image + '">';
                    displayString = displayString + '<div class="OverlayText">' + obj[i].brochureCount + '<br /><small>' + obj[i].event + '</small> <span class="link"><i class="fa fa-link"></i></span></div>';
                     displayString = displayString + '</div>';
                    if(obj[i].Caption){
                        displayString = displayString + '<p class="image-desc">';
                        displayString = displayString + '<strong>' + obj[i].title + '</strong>';
                        displayString = displayString + "</p>";
                    }
                    displayString = displayString + '</a>';
                    displayString = displayString + '</div>';
                }

                var $content = $(displayString);
                $content.css('display','none');
                $grid.append($content).imagesLoaded(
                    function(){
                        $content.fadeIn(500);
                        $grid.masonry('appended', $content);
                        $('#grid').attr('data-go', '1');
                    }
                );                                     

               displayString = "";
               $("#hidden-data").append(obj.hidden);
            },
            error: function(){console.log("Fail");}             
      });
    }
    $(window).scroll(function(){
        if ($(window).scrollTop() >= ($(document).height() - $(window).height()) * 0.65){
			if($('#grid').attr('data-go') == '1') 
			{
               var pagenum = parseInt($('#grid').attr('data-page')) + 1;
               $('#grid').attr('data-page', pagenum);
				getresult(base_url+'listing/albums/' + archive + '/?page='+pagenum);
			}
        }
    });
});
</script>
