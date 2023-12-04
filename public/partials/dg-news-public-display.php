<div class="news-container">
    <?php
    foreach ($this->news_data['articles'] as $article) {
    ?>
    <div class="news-item">
        <div class="news-box" style="background: url(<?php echo $article['urlToImage']; ?>) no-repeat center center / cover;">
            <div class="news-box-overlay"><?php echo $article['source']['name']; ?></div>
        </div>
        <span class="news-title"><?php echo $article['title']; ?></span>
    </div>
    <?php
    }
    ?>
</div>