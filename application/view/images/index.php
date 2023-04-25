<div class="container">
    <h1>Images</h1>
    <div class="box">
        <?php $this->renderFeedbackMessages(); ?>
        <form action="<?= Config::get("URL"); ?>upload/uploadImage" method="post" enctype="multipart/form-data">
            <input type="file" name="uploadFile" id='uploadedFile' />
            <input type="submit" name="submit" value="Upload" />
        </form>
    </div>
</div>
<?php
foreach ($this->images as $image) { ?>
    <div class="responsive">
        <div class="gallery">
            <img src=<?= "../uploads/" . $image->name; ?>>
        </div>
        <?php if ($image->is_public == 0) { ?>
            <form action="<?= Config::get('URL') . "images/setImagePublic/" . $image->name; ?>" method="post">
                <input type="hidden" name="id" value=<?= $image->name ?>>
                <input type="submit" name="Set public" value="Set public" />
            </form>
        <?php } else { ?>
            <form action="<?= Config::get('URL') . "images/setImagePrivate/" . $image->name; ?>" method="post">
                <input type="hidden" name="id" value=<?= $image->name ?>>
                <input type="submit" name="Set private" value="Set private" />
            </form>
            <button onclick="openModal('<?=Config::get('URL').'images/showImage/'.$image->name?>')">Open Modal</button>
        <?php } ?>
    </div>
<?php } ?>
<!-- The Modal -->
<div id="myModal" class="modal">
    <!-- Modal content -->
    <div class="modal-content">
        <span class="close">&times;</span>
        <p id="publicUrl"></p>
    </div>
</div>';

<script>
    // Get the modal
    var modal = document.getElementById("myModal");

    var publicUrl = document.getElementById("publicUrl");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal
    function openModal(url){
        publicUrl.innerText = url;
        modal.style.display = "block";
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>