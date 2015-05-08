<br>
<?php if(!empty($this->posts)): ?>
    <ul class="list-group  col-lg-8 col-sm-8 col-xs-8">
        <?php foreach ($this->posts as $post) :?>
            <li class="list-group-item">
                 <span class="badge">
                    <?= htmlspecialchars($this->makeDateInFormat( $post['date']))?>
                 </span>
                <a href="/posts/view/<?= $post['id'] ?>">
                    <h4 class="post-title"><?= htmlspecialchars($post['title'])?></h4>
                </a>
                <p class="right">
                    <?php foreach ($post['tags'] as $tag):  ?>
                        <span class="label label-info tag-right"><?php echo htmlspecialchars($tag['text'])?></span>&nbsp;
                    <?php endforeach; ?>
                </p>
            </li>
            <br/>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>
