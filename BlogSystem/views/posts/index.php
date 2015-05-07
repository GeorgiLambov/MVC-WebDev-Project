<?php if(!empty($this->posts)): ?>
    <ul class="list-group col-lg-offset-1 col-lg-6 col-sm-6 col-xs-6">
        <?php foreach ($this->posts as $post) :?>
            <li class="list-group-item">
                <span class="badge">#<?= $post['id']?></span>
                <a href="/posts/view/<?= $post['id'] ?>">
                    <span class="post-title"><?= htmlspecialchars($post['title'])?></span>
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
