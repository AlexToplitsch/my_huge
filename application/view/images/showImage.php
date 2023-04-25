<div class="container">
    <h1>Image</h1>
    <?php $this->renderFeedbackMessages(); ?>
</div>
<div class="responsive">
    <div class="gallery">
        <img src=<?= "../../uploads/" . $this->image; ?> alt="<?= $this->image ?>">
    </div>
</div>