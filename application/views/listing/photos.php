<?php
	$albumDetails = $data['albumDetails'];
	unset($data['albumDetails']);
	$archiveType = $viewHelper->getArchiveType($data[0]->albumID);
?>
<script>
$(document).ready(function(){
        $('.post.no-border').prepend('<div class="albumTitle <?=$archiveType?>"><span><?=$archiveType?></span></div>');
    });
</script>
<div class="container">
    <div class="row first-row">
        <!-- Column 1 -->
            <div class="col-md-12 text-center">
                <ul class="list-inline sub-nav">
                    <li><a href="<?=BASE_URL?>listing/albums/<?=NEWSPAPERS?>">CLIPPINGS</a></li>
                    <li><a>·</a></li>
                    <li><a href="<?=BASE_URL?>listing/albums/<?=BROCHURES?>">Brochures</a></li>
<!--
                    <li><a>·</a></li>
                    <li><a href="#">Books</a></li>
-->
                    <li><a>·</a></li>
                    <li><a href="<?=BASE_URL?>listing/photoAlbums/<?=PHOTOS?>">Photographs</a></li>
<!--
                    <li><a>·</a></li>
                    <li><a href="#">Multimedia</a></li>
                    <li><a>·</a></li>
                    <li><a href="#">Journals</a></li>
                    <li><a>·</a></li>
                    <li><a href="#">Miscellaneous</a></li>
-->
                    <li><a>·</a></li>
                    <li><a>Search</a></li>
                    <li id="searchForm">
                        <form class="navbar-form" role="search" action="<?=BASE_URL?>search/field/" method="get">
                            <div class="input-group add-on">
                                <input type="text" class="form-control" placeholder="Keywords" name="description" id="description">
                                <div class="input-group-btn">
                                    <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </li>
                </ul>
            </div>
    </div>
</div>
<div id="grid" class="container-fluid">
    <div id="posts">
        <div class="post no-border">
            <div class="image-desc-full">
                <?=$viewHelper->displayFieldData($albumDetails->description)?>
                <?php if(isset($_SESSION['login'])) {?>
                <ul class="list-unstyled">
                    <li>
                        <a href="<?=BASE_URL?>edit/album/<?=$data[0]->albumID?>" class="btn btn-primary" role="button">Contribute</a>
                    </li>    
                </ul>    
                <?php } ?>
            </div>
        </div>
<?php foreach ($data as $row) { ?>
        <div class="post">
            <?php
				$photoID = $viewHelper->getPhotoID($row->id); 
				$albumID = $viewHelper->getAlbumID($row->albumID);
                $archive = $viewHelper->getArchiveType($row->albumID);
                (file_exists(PHY_ARCHIVES_JPG_URL . $archive . '/' . $albumID . '/thumbs/' . $photoID . '.JPG')) ? $imagePath = ARCHIVES_JPG_URL . $archive . '/' . $albumID . '/thumbs/' . $photoID . '.JPG' : $imagePath = PUBLIC_URL . '/images/default-image.png';
                $caption = $viewHelper->getDetailByField($row->description, 'desc', 'misc');
			?>
            <a href="<?=BASE_URL?>describe/photo/<?=$row->albumID . '/' . $row->id?>" title="View Details">
			    <img class="img-responsive" src="<?=$imagePath?>">
            </a>
            <?php
                if($caption) echo '<p class="image-desc"><strong>' . $caption . '</strong></p>';
            ?>
        </div>
<?php } ?>
    </div>
</div>
